<?php

class AppDatabase2 extends DatabaseCms
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

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getBotAccessDetails($id)
	{

		$sqlString="SELECT r.id AS id, r.uri AS uri, r.module_name AS modName, r.specific_name AS specName";
		$sqlString.=", r.type AS type, a.access_level AS level";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access a";
		$sqlString.=" WHERE r.id = ".$id;
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemData = $row;
		}

		return $itemData;

	}

	public function saveBotAccess($botAccess)
	{
		$sqlString="UPDATE ".$this->tablePrefix."core_access";
		$sqlString.=" SET ";
		$sqlString.=("access_level=".$botAccess['level']."");
		$sqlString.=" WHERE resource_id = ".$botAccess['id'];
		$sqlString.=" AND role_id = 2";

		$sqlString="UPDATE ".$this->tablePrefix."core_access";
		$sqlString.=" SET ";
		$sqlString.=("access_level = :accessLevel");
		$sqlString.=" WHERE resource_id = :resId";
		$sqlString.=" AND role_id = 2";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":resId" => $botAccess['id'],
			":accessLevel" => $botAccess['level']
		));

	}

	public function getConfigList($modName,$typeCode)
	{

		$itemList=array();
		$whereClause="";
		if($modName!="" && $typeCode=="")
			$whereClause=" WHERE module_name = '".$modName."'";
		elseif($modName=="" && $typeCode!="")
			$whereClause=" WHERE type = '".$typeCode."'";
		elseif($modName!="" && $typeCode!="")
			$whereClause=" WHERE module_name = '".$modName."' AND type = '".$typeCode."'";

		$sqlString="SELECT id, module_name, description, uri, type, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY module_name, type, uri";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$row=$this->decodeDbRow($row,array("description","value"));
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function saveConfig($config)
	{

		$id = (int)$config->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertConfig($config);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {

			try {
				$this->dbId->beginTransaction();
				$this->updateConfig($config);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function insertConfig($config)
	{

		$id=0;
		$sqlString="INSERT INTO ".$this->tablePrefix."core_config (module_name, description, uri, type, value";
		$sqlString.=")";
		$sqlString.=" VALUES(:modName, :description, :uri, :type, :value)";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $config->modName,
			":description" => $config->description,
			":uri" => $config->uri,
			":type" => $config->type,
			":value" => $config->value
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateConfig($config)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_config";
		$sqlString.=" SET module_name = :modName";
		$sqlString.=", description = :description";
		$sqlString.=", uri = :uri";
		$sqlString.=", type = :type";
		$sqlString.=", value = :value";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $config->modName,
			":description" => $config->description,
			":uri" => $config->uri,
			":type" => $config->type,
			":value" => $config->value,
			":id" => $config->id
		));

	}

	public function getConfigDetails($id)
	{
		$configDetails=array();

		$sqlString="SELECT id, module_name, description, uri, type, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE id = ";
		$sqlString.=$id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$row=$this->decodeDbRow($row,array("description","value"));
			$configDetails = $row;
		}

		return $configDetails;

	}

	public function deleteConfig($id)
	{

		$delStatus=false;

		$sqlString="DELETE FROM ".$this->tablePrefix."core_config WHERE id = :id";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));

		$delStatus=true;

		return $delStatus;

	}

	public function getConfigModuleSet()
	{
		$itemList=array();

		$sqlString="SELECT DISTINCT m.name AS modName, m.title AS modTitle, m.id AS modId";
		$sqlString.=" FROM ".$this->tablePrefix."core_config c";
		$sqlString.=", ".$this->tablePrefix."core_module m";
		$sqlString.=" WHERE c.module_name=m.name";
		$sqlString.=" ORDER BY m.name";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getConfigTypeSet($modId, $modName, $typeCode)
	{
		$itemList=array();

		$sqlString="SELECT DISTINCT c.type AS type";
		$sqlString.=" FROM ".$this->tablePrefix."core_config c";

		if($modId!=0){
			$sqlString.=" WHERE c.module_name='".$modName."'";
		}

		$sqlString.=" ORDER BY c.type";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

}
