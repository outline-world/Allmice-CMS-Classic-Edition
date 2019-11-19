<?php

class AppDatabase extends DatabaseCms
{

	public $tablePrefix;

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
		$this->dbId->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function getThemeSet()
	{
		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_theme";
		$sqlString.=" WHERE code_path != 'core/themes/'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getWholeThemeSet()
	{
		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_theme";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function installTheme($themeData,$access)
	{

		try {
			$this->dbId->beginTransaction();

			$themePath="";

			$themeData['description']=str_replace("'","&#39;",$themeData['description']);
			$themeData['developer']=str_replace("'","&#39;",$themeData['developer']);

			$sqlString="INSERT INTO ".$this->tablePrefix."core_theme (name";
			$sqlString.=", title";
			$sqlString.=", description";
			$sqlString.=", code_path";
			$sqlString.=", version";
			$sqlString.=", time";
			$sqlString.=", developer";
			$sqlString.=")";
			$sqlString.=" VALUES (";
			$sqlString.=(":name");
			$sqlString.=(", :title");
			$sqlString.=(", :description");
			$sqlString.=(", :codePath");
			$sqlString.=(", :version");
			$sqlString.=(", :time");
			$sqlString.=(", :developer");
			$sqlString.=")";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":name" => $themeData['name'],
				":title" => $themeData['title'],
				":description" => $themeData['description'],
				":codePath" => $themeData['path'],
				":version" => $themeData['version'],
				":time" => $themeData['time'],
				":developer" => $themeData['developer']
			));
			$themeId=$this->dbId->lastInsertId();

				$sqlString="INSERT INTO ".$this->tablePrefix."core_resource (module_name";
				$sqlString.=", source_id";
				$sqlString.=", specific_name";
				$sqlString.=", uri";
				$sqlString.=", type)";
				$sqlString.=" VALUES (";
				$sqlString.=("'Theme'");
				$sqlString.=(", :sourceId");
				$sqlString.=(", :specName");
				$sqlString.=(", :uri");
				$sqlString.=(", 60");
				$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$uri="/theme/view/".$themeId;
		$stmt->execute(array(
			":sourceId" => $themeId,
			":specName" => $themeData['name'],
			":uri" => $uri
		));
		$resId=$this->dbId->lastInsertId();

				$accessLevel=0;
				$roleSet = $this->getRoleList();	

				for($j=0;$j<count($roleSet);$j++){
					$accessLevel=0;

					if ($roleSet[$j]['title']=="admin") {
						$accessLevel=0;
					}
					$access->roleId=$roleSet[$j]['id'];
					$access->accessLevel=$accessLevel;
					$access->resId=$resId;

					$this->insertAccess($access);
				}

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function uninstallTheme($themeName)
	{

		$resId = 0;

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_theme";
		$sqlString.=" WHERE name = :themeName";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":themeName" => $themeName
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$themeId = $row['id'];
		}

		$sqlString="SELECT id AS resId";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE type = 60";
		$sqlString.=" AND source_id = :themeId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":themeId" => $themeId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$resId = $row['resId'];
		}

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."core_theme WHERE";
			$sqlString.=" id = ".$themeId;
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$this->deleteThemeResource($themeId);
			$this->deleteThemeAccess($resId);

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function insertAccess($permission)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."core_access (role_id, resource_id, access_level)";
		$sqlString.=" VALUES (";
		$sqlString.=(":roleId");
		$sqlString.=(", :resId");
		$sqlString.=(", :accessLevel");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":roleId" => $permission->roleId,
			":resId" => $permission->resId,
			":accessLevel" => $permission->accessLevel
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateAccess($access)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_access";
		$sqlString.=" SET ";
		$sqlString.="access_level = :accessLevel";
		$sqlString.=" WHERE resource_id = :resId";
		$sqlString.=" AND role_id = :roleId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":accessLevel" => $access->accessLevel,
			":resId" => $access->resId,
			":roleId" => $access->roleId
		));

	}

	public function getRoleList()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getRoleOptions()
	{

		$itemList[0] = "All roles";

		$sqlString="SELECT id, title";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[($row['id'])] = $row['title'];
		}

		return $itemList;

	}

	public function deleteThemeResource($sourceId)
	{
		$sqlString="DELETE FROM ".$this->tablePrefix."core_resource WHERE";
		$sqlString.=" type = 60";
		$sqlString.=" AND source_id = ".$sourceId;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function deleteThemeAccess($resId)
	{

		$delStatus=false;

		$sqlString="DELETE FROM ".$this->tablePrefix."core_access WHERE";
		$sqlString.=" resource_id = ".$resId;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function changeActiveTheme($theme)
	{

		if($theme->roleId>0){
			$resIdSet=$this->getResIdSet();

			foreach ($resIdSet as $resId) {

				$sqlString="UPDATE ".$this->tablePrefix."core_access";
				$sqlString.=" SET ";
				$sqlString.="access_level = 0";
				$sqlString.=" WHERE resource_id = :resId";
				$sqlString.=" AND role_id = :roleId";

				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute(array(
					":resId" => $resId,
					":roleId" => $theme->roleId
				));
			}

			$resId=$this->getResId($theme->themeId);

			$sqlString="UPDATE ".$this->tablePrefix."core_access";
			$sqlString.=" SET ";
			$sqlString.="access_level = 1";
			$sqlString.=" WHERE resource_id = :resId";
			$sqlString.=" AND role_id = :roleId";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":resId" => $resId,
				":roleId" => $theme->roleId
			));
		}else{
			$resIdSet=$this->getResIdSet();

			foreach ($resIdSet as $resId) {

				$sqlString="UPDATE ".$this->tablePrefix."core_access";
				$sqlString.=" SET ";
				$sqlString.="access_level = 0";
				$sqlString.=" WHERE resource_id = :resId";

				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute(array(
					":resId" => $resId
				));
			}

			$resId=$this->getResId($theme->themeId);

			$sqlString="UPDATE ".$this->tablePrefix."core_access";
			$sqlString.=" SET ";
			$sqlString.="access_level = 1";
			$sqlString.=" WHERE resource_id = :resId";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":resId" => $resId,
			));
		}

	}

	public function getResId($id)
	{

		$resId=0;
		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE source_id = :id";
		$sqlString.=" AND type = 60";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$resId = $row['id'];
		}

		return $resId;

	}

	public function getResIdSet()
	{

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE type = 60";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$resIdSet[] = $row['id'];
		}

		return $resIdSet;

	}

	public function getDefaultTheme($roleId)
	{

		$themeId=1;
		if($roleId>0){
			$sqlString="SELECT r.source_id AS id";
			$sqlString.=" FROM ".$this->tablePrefix."core_resource r";
			$sqlString.=", ".$this->tablePrefix."core_access a";

			$sqlString.=" WHERE a.resource_id = r.id";

			$sqlString.=" AND r.type = 60";
			$sqlString.=" AND a.role_id = :roleId";
			$sqlString.=" AND a.access_level = 1";
			$sqlString.=" LIMIT 1";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":roleId" => $roleId
			));

			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$themeId = $row['id'];
			}
		}
		else{

			$themeId=1;

		}

		return $themeId;

	}

}
