<?php

class AppDatabase extends Database
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

	public function getAccessList()
	{

		$sqlString="SELECT r.id AS id, r.uri AS uri, r.module_name AS modName, r.specific_name AS specName";
		$sqlString.=", r.type AS type, a.access_level AS level";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access a";
		$sqlString.=" WHERE a.role_id = 2";
		$sqlString.=" AND a.resource_id = r.id";
		$sqlString.=" AND a.access_level > 0";
		$sqlString.=" AND r.type <> 40";
		$sqlString.=" AND r.type <> 60";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getModuleSet()
	{
//For install & uninstall events

		$itemList=array();

		$sqlString="SELECT name AS module_name, type AS module_type";
		$sqlString.=", title, description";
		$sqlString.=", version, time";
		$sqlString.=", path";
		$sqlString.=", developer";
		$sqlString.=", required_modules AS requiredModules";
		$sqlString.=" FROM ".$this->tablePrefix."core_module";
		$sqlString.=" WHERE type > 20";
		$sqlString.=" ORDER BY module_name";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function uninstallModuleStructure($modName,$modPath)
	{

		$resId = array();

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE module_name = :modName";
		$sqlString.=" AND uri NOT LIKE '/%/%/%'";
		$sqlString.=" AND type = 1";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$resId[] = $row['id'];
		}

		try {
			$this->dbId->beginTransaction();

			$this->deleteModMethodResource($modName);

			for($i=0;$i<count($resId);$i++){
				$this->deleteModCaching($resId[$i]);
				$this->deleteModAccess($resId[$i]);
			}

//If needed add Loop to delete module specific tables

			$sqlString="DELETE FROM ".$this->tablePrefix."core_module WHERE";
			$sqlString.=" name = :modName";
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
			$sqlString.=", required_modules";
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
			$sqlString.=(", :requiredModules");
			$sqlString.=")";
//				echo "sqlString=".$sqlString."<br>";

			if($modData['requiredModules']!="")
				$modData['requiredModules']="#".str_replace(", ", "#", $modData['requiredModules'])."#";

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
				":developer" => $modData['developer'],
				":requiredModules" => $modData['requiredModules']
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
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

	public function deleteModMethodResource($modName)
	{
		$sqlString="DELETE FROM ".$this->tablePrefix."core_resource WHERE";
		$sqlString.=" module_name = :modName";
		$sqlString.=" AND type = 1";
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

	public function installModuleStructure($modData,$access,$sqlSet)
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

	public function getRoleList()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getModuleResourceSet($whereClause)
	{

		$sqlString="SELECT r.id AS id, r.module_name AS module_name, r.specific_name AS specific_name";
		$sqlString.=", r.uri AS uri";
		$sqlString.=", m.title AS title";
		$sqlString.=", p.id AS perId, p.access_level AS access_level, p.role_id AS role_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_access p";
		$sqlString.=", ".$this->tablePrefix."core_module m";
		$sqlString.=" WHERE r.type = 1";
		$sqlString.=" AND m.name = r.module_name";
		$sqlString.=" AND r.id = p.resource_id";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY r.module_name, r.specific_name";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

	public function changeTables($sqlSet)
	{

				for($i=0;$i<count($sqlSet);$i++){

					$this->dbId->query($sqlSet[$i]);

				}

	}

	public function getModuleEventSet($whereClause)
	{

		$sqlString="SELECT r.specific_name AS specific_name";
		$sqlString.=", r.uri AS uri";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE r.type = 1";
		$sqlString.=" AND r.id = p.resource_id";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY r.module_name, r.specific_name";

//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

}
