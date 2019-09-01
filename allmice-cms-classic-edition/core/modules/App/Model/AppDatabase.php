<?php

class AppDatabase
{

	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;
	public $salt;
	public $isValid;

	public function __construct($dbData)
	{
		try {

			$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
			if(isset($dbData['tablePrefix']))
				$this->tablePrefix=$dbData['tablePrefix'];
			$this->isValid=true;
		} catch (Exception $e) {
			$this->isValid=false;
		}

	}

// Other methods - start
//This class uses prepared statements with parameters

	public function getModuleSet()
	{
//For install & uninstall events

		$itemList=array();

		$sqlString="SELECT name AS module_name, type AS module_type";
		$sqlString.=", title, description";
		$sqlString.=", version, time";
		$sqlString.=", path";
		$sqlString.=", developer";
		$sqlString.=" FROM ".$this->tablePrefix."core_module";
		$sqlString.=" WHERE type > 20";
		$sqlString.=" ORDER BY module_name";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getLocalModuleSet()
	{
//For manage access event
		$itemList=array();

		$sqlString="SELECT name AS module_name, type AS module_type";
		$sqlString.=", title, description";
		$sqlString.=", version, time";
		$sqlString.=", path";
		$sqlString.=", developer";
		$sqlString.=" FROM ".$this->tablePrefix."core_module";
		$sqlString.=" WHERE path!=''";
		$sqlString.=" ORDER BY module_name";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function deleteModResource($modName)
	{
		$sqlString="DELETE FROM ".$this->tablePrefix."core_resource WHERE";
		$sqlString.=" module_name = :modName";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));

	}

	public function deleteModCaching($resId)
	{

		$sqlString="DELETE FROM ".$this->tablePrefix."core_caching WHERE";
		$sqlString.=" resource_id = :resId";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":resId" => $resId
		));

	}

	public function deleteModAlias($modPath)
	{

		$sqlString="DELETE FROM ".$this->tablePrefix."core_alias WHERE";
		$sqlString.=" source LIKE = :modPath%";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modPath" => $modPath
		));

	}

	public function deleteModAccess($resId)
	{

		$delStatus=false;

		$sqlString="DELETE FROM ".$this->tablePrefix."core_access WHERE";
		$sqlString.=" resource_id = :resId";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":resId" => $resId
		));

	}

	public function installModule($modData,$access,$sqlSet)
	{

		try {
			$this->dbId->beginTransaction();

			for($i=0;$i<count($modData['eventSet']);$i++){

				$sqlString="INSERT INTO ".$this->tablePrefix."core_resource (module_name";
				$sqlString.=", specific_name";
				$sqlString.=", uri";
				$sqlString.=", type)";
				$sqlString.=" VALUES (";
				$sqlString.=(":modName");
				$sqlString.=(", :specName");
				$sqlString.=(", :uri");
				$sqlString.=(", 1");
				$sqlString.=")";
//				echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$uri="/".$modData['path']."/".$modData['eventSet'][$i]['path'];
		$stmt->execute(array(
			":modName" => $modData['name'],
			":specName" => $modData['eventSet'][$i]['name'],
			":uri" => $uri
		));
		$resId=$this->dbId->lastInsertId();

	/*
	Creating permissions and assigning default access levels					
	---					
	Module		Admin				
	event			install				
	db. table	user_role_permission				
	---				
	Module	event	role			role			role				role
						admin			anonymous	authenticated	z (other)
	Admin		y		1				0				0					0
	User		login	1				1				0					0
	User		logout	1				0				1					0
	User		y		1				0				0					0
	X			y		1				0				0					0
	*/
				$accessLevel=0;
				$roleSet = $this->getRoleList();	

				for($j=0;$j<count($roleSet);$j++){
					$accessLevel=0;

					if ($roleSet[$j]['title']=="admin") {
						$accessLevel=1;
					}
					$access->roleId=$roleSet[$j]['id'];
					$access->accessLevel=$accessLevel;
					$access->resId=$resId;

					$this->insertAccess($access);
				}

			}

			$tableList="";
			if(count($sqlSet)>0){
				$noOfTables=0;
				for($i=0;$i<count($sqlSet);$i++){
					if(strstr($sqlSet[$i], "CREATE TABLE"))
						$noOfTables++;
				}

				for($i=0;$i<count($sqlSet);$i++){

					if(strstr($sqlSet[$i], "CREATE TABLE")){

						$tempArr=explode("CREATE TABLE `",$sqlSet[$i]);
						$tempArr2=explode("` (",$tempArr[1]);
						$tabName=$tempArr2[0];

						if(strlen($tableList)>0)
							$tableList.=(", ".$tabName);
						else
							$tableList.=$tabName;
					}
				}
				for($i=0;$i<count($sqlSet);$i++){

					$this->dbId->query($sqlSet[$i]);

				}
			}

			$modPath="";

			$modData['description']=str_replace("'","&#39;",$modData['description']);
			$modData['developer']=str_replace("'","&#39;",$modData['developer']);

			$sqlString="INSERT INTO ".$this->tablePrefix."core_module (name";
			$sqlString.=", title";
			$sqlString.=", description";
			$sqlString.=", path";
			$sqlString.=", config_path, code_path, type, status";
			$sqlString.=", db_tables";
			$sqlString.=", version";
			$sqlString.=", time";
			$sqlString.=", developer";
			$sqlString.=")";
			$sqlString.=" VALUES (";
			$sqlString.=(":name");
			$sqlString.=(", :title");
			$sqlString.=(", :description");
			$sqlString.=(", :path");
			$sqlString.=(", :configPath");
			$sqlString.=(", :codePath");
			$sqlString.=(", :type");
			$sqlString.=(", 1");
			$sqlString.=(", :tableList");
			$sqlString.=(", :version");
			$sqlString.=(", :time");
			$sqlString.=(", :developer");
			$sqlString.=")";
//				echo "sqlString=".$sqlString."<br>";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":name" => $modData['name'],
				":title" => $modData['title'],
				":description" => $modData['description'],
				":path" => $modData['path'],
				":configPath" => $modData['configPath'],
				":codePath" => $modData['codePath'],
				":type" => $modData['type'],
				":tableList" => $tableList,
				":version" => $modData['version'],
				":time" => $modData['time'],
				":developer" => $modData['developer']
			));
			$modId=$this->dbId->lastInsertId();

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function uninstallModule($modName,$modPath)
	{

		$resId = array();

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE module_name = :modName";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$resId[] = $row['id'];
		}

		$sqlString="SELECT db_tables";
		$sqlString.=" FROM ".$this->tablePrefix."core_module";
		$sqlString.=" WHERE name = :modName";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$tableList = $row['db_tables'];
		}

		$dropQuery="DROP TABLE ".$tableList."";

		try {
			$this->dbId->beginTransaction();
			$this->dbId->query($dropQuery);

			$this->deleteModResource($modName);

			for($i=0;$i<count($resId);$i++){
				$this->deleteModCaching($resId[$i]);

				$this->deleteModAccess($resId[$i]);
			}

			if($modPath!="")
				$this->deleteModAlias($modPath);

//If needed add Loop to delete module specific tables

			$sqlString="DELETE FROM ".$this->tablePrefix."core_module WHERE";
			$sqlString.=" name = :modName";
	//		echo "sqlString=".$sqlString."<br>";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":modName" => $modName
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."core_language WHERE";
			$sqlString.=" module_name = :modName";
	//		echo "sqlString=".$sqlString."<br>";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":modName" => $modName
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."core_misc_data WHERE";
			$sqlString.=" module_name = :modName";
	//		echo "sqlString=".$sqlString."<br>";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":modName" => $modName
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."core_config WHERE";
			$sqlString.=" module_name = :modName";
	//		echo "sqlString=".$sqlString."<br>";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":modName" => $modName
			));

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function setDatabase($sqlSet)
	{

		try {
			$this->dbId->beginTransaction();

			for($i=0;$i<count($sqlSet);$i++){
				$stmt = $this->dbId->prepare($sqlSet[$i]);
				$stmt->execute();
			}

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function getModuleResourceSet($whereClause)
	{

		$sqlString="SELECT r.id AS id, r.module_name AS module_name, r.specific_name AS specific_name";
		$sqlString.=", r.uri AS uri";
		$sqlString.=", p.id AS perId, p.access_level AS access_level, p.role_id AS role_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE r.type = 1";
		$sqlString.=" AND r.id = p.resource_id";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY r.module_name, r.specific_name";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

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
//		echo "sqlString=".$sqlString."<br>";

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
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":accessLevel" => $access->accessLevel,
			":resId" => $access->resId,
			":roleId" => $access->roleId
		));

	}

	public function replacePassword($sqlSet, $user, $pwSalt)
	{
//Somehow other sql statements will not be executed, if executing the statements extracted from sql file (array sqlSet).
//To sove this issue, new password for admin user must be included (placeholder token replaced) to
//   such corresponding extracted statement - look for token '[replaceCryptedPassword]'.
		$replaceStatus="none";

		$salt=$GLOBALS['pwSaltData'].$pwSalt.'$';
		$cryptedPw=crypt($user->password,$salt);

		for($i=0;$i<count($sqlSet);$i++){
			if(strstr($sqlSet[$i],'[replacePassword]')){
				$sqlSet[$i]=str_replace('[replacePassword]',$cryptedPw,$sqlSet[$i]);
				$replaceStatus="found";
			}
		}

		if($replaceStatus=="none"){
			$sqlSet=array();
		}

		return $sqlSet;

	}

	public function getRoleList()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

}
