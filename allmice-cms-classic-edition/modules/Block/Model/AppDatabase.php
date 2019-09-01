<?php

class AppDatabase extends DatabaseCms
{

	public $tablePrefix;

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getBlockList()
	{
		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_block";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getBlockDetails($id)
	{
		$itemDetails=array();
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_block";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
				":id" => $id
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function insertBlock($block)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."core_block (block_code, rank, region_code";
		$sqlString.=", type, building_module, display_method, uri, status, language_code)";
		$sqlString.=" VALUES (";
		$sqlString.=":blockCode";
		$sqlString.=", :rank";
		$sqlString.=", :regionCode";
		$sqlString.=", :type";
		$sqlString.=", :buildingModule";
		$sqlString.=", :displayMethod";
		$sqlString.=", :uri";
		$sqlString.=", :status";
		$sqlString.=", :languageCode";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":blockCode" => $block->blockCode,
			":rank" => $block->rank,
			":regionCode" => $block->regionCode,
			":type" => $block->type,
			":buildingModule" => $block->buildingModule,
			":displayMethod" => $block->displayMethod,
			":uri" => $block->uri,
			":status" => $block->status,
			":languageCode" => $block->languageCode
		));

		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateBlock($block)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_block";
		$sqlString.=" SET ";
		$sqlString.=("block_code = :blockCode");
		$sqlString.=(", rank = :rank");
		$sqlString.=(", region_code = :regionCode");
		$sqlString.=(", type = :type");
		$sqlString.=(", building_module = :buildingModule");
		$sqlString.=(", display_method = :displayMethod");
		$sqlString.=(", uri = :uri");
		$sqlString.=(", status = :status");
		$sqlString.=(", language_code = :languageCode");
		$sqlString.=" WHERE id = :id";

		if(!isset($block->uri))
			$block->uri="";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":blockCode" => $block->blockCode,
			":rank" => $block->rank,
			":regionCode" => $block->regionCode,
			":type" => $block->type,
			":buildingModule" => $block->buildingModule,
			":displayMethod" => $block->displayMethod,
			":uri" => $block->uri,
			":status" => $block->status,
			":languageCode" => $block->languageCode,
			":id" => $block->id
		));

	}

	public function saveBlock($block, $resData)
	{
		$id = (int)$block->id;
		$roleList=$this->getRoleList();
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertBlock($block);
				$resData['uri'].=$id;
				$resId=$this->insertResource($id, $resData);
				$perId=$this->insertAccess($block->roleAccess,$resId,$roleList);
				$this->setCaching($block->cachingRoles, $resId, $roleList, $block->cacheData);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateBlock($block);
				$this->updateResource($id, $resData);
				$resId=$this->getResId($id);
				$this->updateAccess($block->roleAccess,$resId,$roleList);
				$this->setCaching($block->cachingRoles,$resId,$roleList, $block->cacheData);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function deleteBlock($id)
	{

		$delStatus=false;

			try {
				$this->dbId->beginTransaction();

		$sqlString="DELETE FROM ".$this->tablePrefix."core_block WHERE id = :id";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));

		$resId=$this->getResId($id);

		$sqlString="DELETE FROM ".$this->tablePrefix."core_resource WHERE source_id = :id AND module_name = 'Block'";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));

		$sqlString="DELETE FROM ".$this->tablePrefix."core_access WHERE resource_id = :resId";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":resId" => $resId
		));

		$sqlString="DELETE FROM ".$this->tablePrefix."core_caching WHERE resource_id = :resId";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":resId" => $resId
		));

		$delStatus=true;

				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		return $delStatus;

	}

	public function insertResource($id,$resData)
	{

		$sqlString="INSERT INTO ".$this->tablePrefix."core_resource (module_name, specific_name, uri, type, source_id)";
		$sqlString.=" VALUES (";
		$sqlString.=":modName";
		$sqlString.=", :specName";
		$sqlString.=", :uri";
		$sqlString.=", :type";
		$sqlString.=", :id";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $resData['modName'],
			":specName" => $resData['specName'],
			":uri" => $resData['uri'],
			":type" => $resData['type'],
			":id" => $id
		));

		$resId=$this->dbId->lastInsertId();

		return $resId;

	}

	public function updateResource($id,$resData)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_resource";
		$sqlString.=" SET ";
		$sqlString.="specific_name = :specName";
		$sqlString.=" WHERE source_id = :id";
		$sqlString.=" AND type = 40";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":specName" => $resData['specName'],
			":id" => $id
		));

	}

	public function insertAccess($roleAccess, $resId, $roleList)
	{

		for($i=0;$i<count($roleList);$i++){
			if(in_array($roleList[$i]['id'],$roleAccess)){
				$accessRight=1;
			}else{
				$accessRight=0;
			}

			$sqlString="INSERT INTO ".$this->tablePrefix."core_access (role_id, resource_id, access_level)";
			$sqlString.=" VALUES (";
			$sqlString.=":roleId";
			$sqlString.=", :resId";
			$sqlString.=", :accessRight";
			$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":roleId" => $roleList[$i]['id'],
			":resId" => $resId,
			":accessRight" => $accessRight
		));

		}

	}

	public function updateAccess($roleAccess, $resId, $roleList)
	{

		for($i=0;$i<count($roleList);$i++){

			if(in_array($roleList[$i]['id'],$roleAccess)){
				$accessRight=1;
			}else{
				$accessRight=0;
			}

			$sqlString="UPDATE ".$this->tablePrefix."core_access";
			$sqlString.=" SET ";
			$sqlString.="access_level = :accessRight";
			$sqlString.=" WHERE resource_id = :resId";
			$sqlString.=" AND role_id = :roleId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":accessRight" => $accessRight,
			":resId" => $resId,
			":roleId" => $roleList[$i]['id']
		));

		}

	}

	public function setCaching($cachingRoles, $resId, $roleList, $cacheData)
	{

		for($i=0;$i<count($roleList);$i++){

			$sqlString="SELECT id";

			$sqlString.=" FROM ".$this->tablePrefix."core_caching c";
			$sqlString.=" WHERE c.resource_id = :resId";
			$sqlString.=" AND c.role_id = :roleId";

			$id = 0;
			$cacheExists = false;
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":resId" => $resId,
				":roleId" => $roleList[$i]['id']
			));
			$resultSet = $stmt->fetchAll();

			foreach ($resultSet as $row) {
				$id = $row['id'];
				$cacheExists = true;
			}

			if(in_array($roleList[$i]['id'],$cachingRoles)){

				if($cacheExists){

					$sqlString="UPDATE ".$this->tablePrefix."core_caching";
					$sqlString.=" SET ";
					$sqlString.="period = :period";
					$sqlString.=" WHERE resource_id = :resId";
					$sqlString.=" AND role_id = :roleId";

				}else{

					$sqlString="INSERT INTO ".$this->tablePrefix."core_caching (resource_id";
					$sqlString.=", role_id, cache_content, last_change_time, period)";
					$sqlString.=" VALUES (";
					$sqlString.=":resId";
					$sqlString.=", :roleId";
					$sqlString.=", "."''";
					$sqlString.=", 0";
					$sqlString.=", :period";
					$sqlString.=")";

				}

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":period" => $cacheData['period'],
			":resId" => $resId,
			":roleId" => $roleList[$i]['id']
		));

			}else{
				if($cacheExists){
					$sqlString="DELETE FROM ".$this->tablePrefix."core_caching WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));

				}
			}

		}

	}

	public function getRoleOptions()
	{
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {

			$itemList[($row['id'])] = $row['title'];
		}

		return $itemList;

	}

	public function getRoleList()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {

			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getLangOptions()
	{

		$itemList=array();
		$sqlString="SELECT language_code, label";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {

			$itemList[($row['language_code'])] = $row['language_code']." (".$row['label'].")";
		}

		return $itemList;

	}

	public function getResId($id)
	{

		$resId=0;
		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE source_id = :id";
		$sqlString.=" AND module_name = 'Block'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
				":id" => $id
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$resId = $row['id'];
		}

		return $resId;

	}

	public function getAccessRoleIdSet($id)
	{
		$itemDetails=array();

		$sqlString="SELECT a.role_id AS id";
		$sqlString.=" FROM ".$this->tablePrefix."core_block b, ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access a";
		$sqlString.=" WHERE b.id = :id";
		$sqlString.=" AND r.module_name = 'Block'";
		$sqlString.=" AND r.source_id = b.id";
		$sqlString.=" AND a.resource_id = r.id";
		$sqlString.=" AND a.access_level > 0";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemDetails[] = $row['id'];
		}

		return $itemDetails;

	}

	public function getCachingRoleIdSet($id)
	{
		$itemDetails=array();

		$sqlString="SELECT c.role_id AS id";
		$sqlString.=" FROM ".$this->tablePrefix."core_block b, ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_caching c";
		$sqlString.=" WHERE b.id = :id";
		$sqlString.=" AND r.module_name = 'Block'";
		$sqlString.=" AND r.source_id = b.id";
		$sqlString.=" AND c.resource_id = r.id";

		$itemDetails = array();
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll();

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
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[($row['uri'])] = $row['value'];
		}

		return $itemList;

	}

}
