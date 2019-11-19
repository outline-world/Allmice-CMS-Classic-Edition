<?php

class AppDatabase extends DatabaseCms
{

	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;
	public $salt;

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getCryptedPassword($plainPass)
	{

		$salt='$5$rounds=5000$'.$this->salt.'$';
		$cryptedPass=crypt($plainPass,$salt);
		$tempArr=explode("$",$cryptedPass);
		return $tempArr[4];

	}

	public function getUserList()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id > 0";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getUserDetails($id)
	{
		$itemDetails=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id = ";
		$sqlString.=$id;
		$sqlString.=" AND id != 0";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function insertUser($user)
	{

		$cryptedPass=$this->getCryptedPassword($user->password);

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."core_user (active_role_id, mail, password, username, status)";
		$sqlString.=" VALUES (";
		$sqlString.=("".$user->mainRole."");
		$sqlString.=(", '".$user->eMail."'");
		$sqlString.=(", '".$user->cryptedPw."'");
		$sqlString.=(", '".$user->username."'");
		$sqlString.=(", ".$user->userStatus."");

		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateUser($user)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_user";
		$sqlString.=" SET ";
		$sqlString.=("active_role_id=".$user->mainRole."");
		$sqlString.=(", mail='".$user->eMail."'");
		$sqlString.=(", password='".$user->cryptedPw."'");
		$sqlString.=(", username='".$user->username."'");
		$sqlString.=(", status='".$user->userStatus."'");
		$sqlString.=" WHERE id = ".$user->id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function insertUserRole($user,$userId)
	{

		$sqlString="INSERT INTO ".$this->tablePrefix."core_user_role (user_id, role_id)";
		$sqlString.=" VALUES (";
		$sqlString.=("".$userId);
		$sqlString.=(", ".$user->mainRole);

		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function updateUserRole($user)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_user_role";
		$sqlString.=" SET ";
		$sqlString.=("role_id=".$user->mainRole."");
		$sqlString.=" WHERE id = ".$user->id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function saveUser($user)
	{
		$id = (int)$user->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				if($user->username!="" && $user->password!=""){
					$id=$this->insertUser($user);
					$this->insertUserRole($user,$id);
				}
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();

				$this->updateUser($user);
				$this->updateUserRole($user);

				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function deleteUser($id)
	{

		$delStatus=false;

			try {
				$this->dbId->beginTransaction();

				$sqlString="DELETE FROM ".$this->tablePrefix."core_user WHERE id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
				$sqlString="DELETE FROM ".$this->tablePrefix."core_user_role WHERE user_id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		$delStatus=true;

		return $delStatus;

	}

	public function getRoleList()
	{
		$itemList=array();
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

	public function getRoleDetails($id)
	{
		$itemDetails=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";
		$sqlString.=" WHERE id = ";
		$sqlString.=$id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function insertRole($role)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."core_role (title)";
		$sqlString.=" VALUES (";
		$sqlString.=("'".$role->title."'");
		$sqlString.=")";

		$sqlString="INSERT INTO ".$this->tablePrefix."core_role (title)";
		$sqlString.=" VALUES (";
		$sqlString.=(":title");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":title" => $role->title
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateRole($role)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_role";
		$sqlString.=" SET ";
		$sqlString.=("title='".$role->title."'");
		$sqlString.=" WHERE id = ".$role->id;

		$sqlString="UPDATE ".$this->tablePrefix."core_role";
		$sqlString.=" SET ";
		$sqlString.=("title = :title");
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":title" => $role->title,
			":id" => $role->id
		));

	}

	public function addRoleAccessData($roleId)
	{

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {

			$sqlString="INSERT INTO ".$this->tablePrefix."core_access (role_id, resource_id, access_level)";
			$sqlString.=" VALUES (";
			$sqlString.=("".$roleId."");
			$sqlString.=(", ".$row['id']);
			$sqlString.=(", 0");
			$sqlString.=")";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

		}
	}

	public function saveRole($role)
	{
		$id = (int)$role->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertRole($role);
				$this->addRoleAccessData($id);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateRole($role);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function saveUserRole($formRoleValues, $userId, $mainRoleId)
	{
		try {
			$this->dbId->beginTransaction();
			$sqlString="DELETE FROM ".$this->tablePrefix."core_user_role WHERE user_id = ".$userId;
			$sqlString.=" AND role_id != ".$mainRoleId;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

			foreach ($formRoleValues as $checkRoleId) {
				$sqlString="INSERT INTO ".$this->tablePrefix."core_user_role (user_id, role_id)";
				$sqlString.=" VALUES (";
				$sqlString.=("".$userId);
				$sqlString.=(", ".$checkRoleId);
				$sqlString.=")";

				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute();
			}

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function deleteRole($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();
			$sqlString="DELETE FROM ".$this->tablePrefix."core_role WHERE id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
			$sqlString="DELETE FROM ".$this->tablePrefix."core_access WHERE role_id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		$delStatus=true;

		return $delStatus;

	}

	public function getAliasList()
	{
		$itemList=array();
		$itemList=array();
		$sqlString="SELECT id, source, alias, source_status";
		$sqlString.=" FROM ".$this->tablePrefix."core_alias";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getAliasDetails($id)
	{
		$itemDetails=array();
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_alias";
		$sqlString.=" WHERE id = ";
		$sqlString.=$id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function insertAlias($alias)
	{

		$id=0;

		$whereClause['module']="";
		$whereClause['type']="";
		$whereClause['specific']="";
		$whereClause['uri']=$alias->source;
		$resId=$this->getResId($id, $whereClause);

			$sqlString="INSERT INTO ".$this->tablePrefix."core_alias";
			$sqlString.=" (resource_id";
			$sqlString.=", source";
			$sqlString.=", alias";
			$sqlString.=", depth";
			$sqlString.=", source_status";
			$sqlString.=")";
			$sqlString.=" VALUES (";
			$sqlString.=(":source");
			$sqlString.=(", :sourceValue");
			$sqlString.=(", :alias");
			$sqlString.=(", :depth");
			$sqlString.=(", :sourceStatus");
			$sqlString.=")";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":source" => $alias->source,
				":sourceValue" => $alias->sourceValue,
				":alias" => $alias->alias,
				":depth" => $alias->depth,
				":sourceStatus" => $alias->sourceStatus
			));
			$id=$this->dbId->lastInsertId();
		return $id;

	}

	public function updateAlias($alias)
	{

		$whereClause['module']="";
		$whereClause['type']="";
		$whereClause['specific']="";
		$whereClause['uri']=$alias->source;
		$resId=$this->getResId($alias->id,$whereClause);

		$sqlString="UPDATE ".$this->tablePrefix."core_alias";
		$sqlString.=" SET ";
		$sqlString.="alias = :alias";
		$sqlString.=", depth = :depth";
		$sqlString.=", source_status = :sourceStatus";
		$sqlString.=", resource_id = :source";
		$sqlString.=", source = :sourceValue";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":alias" => $alias->alias,
			":depth" => $alias->depth,
			":sourceStatus" => $alias->sourceStatus,
			":source" => $alias->source,
			":sourceValue" => $alias->sourceValue,
			":id" => $alias->id
		));

	}

	public function saveAlias($alias)
	{
		$id = (int)$alias->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertAlias($alias);
				$this->dbId->commit();
			} catch (Exception $e) {
				$id = 0;
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateAlias($alias);
				$this->dbId->commit();
			} catch (Exception $e) {
				$id = 0;
				$this->dbId->rollback();
			}
		}
		return $id;

	}

	public function deleteAlias($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();
			$sqlString="DELETE FROM ".$this->tablePrefix."core_alias WHERE id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		$delStatus=true;

		return $delStatus;

	}

	public function getResId($id, $whereClause)
	{
		$resId = 0;
		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE source_id = ";
		$sqlString.=$id;
		if(isset($whereClause['module']) && $whereClause['module']!="")
			$sqlString.=" AND module_name = '".$whereClause['module']."'";
		if(isset($whereClause['type']) && $whereClause['type']!="")
			$sqlString.=(" AND ".$whereClause['type']);
		if(isset($whereClause['specific']) && $whereClause['specific']!="")
			$sqlString.=" AND specific_name = '".$whereClause['specific']."'";
		if(isset($whereClause['uri']) && $whereClause['uri']!="")
			$sqlString.=" AND uri = '".$whereClause['uri']."'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$resId = $row['id'];
		}

		return $resId;

	}

	public function getAliasResId($alias)
	{

		$resId = 0;
		$whereClause['module']="";
		$whereClause['type']="";
		$whereClause['specific']="";
		$whereClause['uri']=$alias->source;
		$resId=$this->getResId($alias->id, $whereClause);
		return $resId;

	}

	public function getSourceList()
	{
		$resId = 0;
		$sqlString="SELECT id, uri";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" ORDER BY uri, id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$sourceList[($row['id'])] = $row['uri'];
		}

		return $sourceList;

	}

	public function getRoleIdSet($userId, $mainRoleId)
	{

		$itemDetails=array();
		$sqlString="SELECT role_id AS id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user_role";
		$sqlString.=" WHERE user_id = ";
		$sqlString.=$userId;
		$sqlString.=" AND role_id!=".$mainRoleId;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails[] = $row['id'];
		}

		return $itemDetails;

	}

	public function getValidityPatterns($modName)
	{

		$itemList=array();

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE type = 'formValidationRegEx'";
		$sqlString.=" AND module_name = :modName";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[($row['uri'])] = $row['value'];
		}

		return $itemList;

	}

}
