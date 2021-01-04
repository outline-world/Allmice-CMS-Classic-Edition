<?php

class AppDatabase extends DatabaseCms
{

	public $tablePrefix;

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getVisitorList($tableName)
	{
		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix.$tableName;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getVisitorDetails($id, $table)
	{
		$itemDetails=array();
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix.$table;
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
				":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function updateVisitor($visitor, $table)
	{

		$sqlString="UPDATE ".$this->tablePrefix.$table;
		$sqlString.=" SET ";
		$sqlString.=("ip = :ip");
		$sqlString.=(", device_data = :agentData");
		$sqlString.=(", status = :status");
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":ip" => $visitor->ip,
			":agentData" => $visitor->agentData,
			":status" => $visitor->status,
			":id" => $visitor->id
		));

	}

	public function saveVisitor($visitor, $table)
	{
		$id = (int)$visitor->id;
		if ($id == 0) {
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateVisitor($visitor, $table);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}
	}

	public function deleteVisitor($id, $tableFragment)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_".$tableFragment."_visitor WHERE id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_".$tableFragment."_event WHERE visitor_id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$delStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $delStatus;

	}

	public function setArchivedData($sqlSet, $fileName)
	{

		try {
			$this->dbId->beginTransaction();

			for($i=0;$i<count($sqlSet);$i++){

				$this->dbId->query($sqlSet[$i]);
			}

			$sqlString="UPDATE ".$this->tablePrefix."core_misc_data";
			$sqlString.=" SET ";
			$sqlString.=("value = :fileName");
			$sqlString.=" WHERE module_name = 'Visitor'";
			$sqlString.=" AND uri = 'openedArchiveFile'";
			$sqlString.=" AND type = 'listArchiveFilesEvent'";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":fileName" => $fileName
			));

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function getArchiveLocation()
	{

		$itemList=array();
		$sqlString="SELECT value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE type = 'dataExpiry'";
		$sqlString.=" AND module_name = 'GlobalObserver'";
		$sqlString.=" AND uri = 'archivingLocation'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {

			$location = $row['value'];
		}

		return $location;

	}

	public function getArchiveFileName()
	{

		$fileName="";
		$itemList=array();
		$sqlString="SELECT value";
		$sqlString.=" FROM ".$this->tablePrefix."core_misc_data";
		$sqlString.=" WHERE type = 'listArchiveFilesEvent'";
		$sqlString.=" AND module_name = 'Visitor'";
		$sqlString.=" AND uri = 'openedArchiveFile'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {

			$fileName = $row['value'];
		}

		return $fileName;

	}

	public function getLangOptions()
	{

		$itemList=array();
		$sqlString="SELECT language_code, label";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {

			$itemList[($row['language_code'])] = $row['language_code']." (".$row['label'].")";
		}

		return $itemList;

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

	public function clearArchiveTables()
	{

		$emptyStatus=false;

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_visitor_archived_visitor";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_visitor_archived_location";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_visitor_archived_event";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$sqlString="UPDATE ".$this->tablePrefix."core_misc_data";
			$sqlString.=" SET ";
			$sqlString.=("value = ''");
			$sqlString.=" WHERE module_name = 'Visitor'";
			$sqlString.=" AND uri = 'openedArchiveFile'";
			$sqlString.=" AND type = 'listArchiveFilesEvent'";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$emptyStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $emptyStatus;

	}

	public function optOutData($visitorId)
	{

		$visitorData=$this->getVisitorData($visitorId,'mod_global_observer_visitor');

		if($visitorData['status']==0){

			$sqlString="UPDATE ".$this->tablePrefix."mod_global_observer_visitor";
			$sqlString.=" SET ";
			$sqlString.=("ip = ''");
			$sqlString.=(", device_data = ''");
			$sqlString.=(", status = '2'");
			$sqlString.=" WHERE id = :id";
		}
		else{
			$sqlString="UPDATE ".$this->tablePrefix."mod_global_observer_visitor";
			$sqlString.=" SET ";
			$sqlString.=("status = '2'");
			$sqlString.=" WHERE id = :id";
		}	

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":id" => $visitorId
		));
		$locationId=$this->setLocation();
		$this->setEvent($visitorId,$locationId,'22');

	}

	public function setEvent($visitorId,$locationId,$type)
	{
		$id=0;

		$timestamp=time();

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_global_observer_event (visitor_id, location_id, user_id, type, timestamp)";
		$sqlString.=" VALUES (:visitorId";
		$sqlString.=", :locationId";
		$sqlString.=", :userId";
		$sqlString.=", :type";
		$sqlString.=", :timestamp";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":visitorId" => $visitorId,
			":locationId" => $locationId,
			":userId" => $_SESSION[($GLOBALS['siteId'])]['userData']['id'],
			":type" => $type,
			":timestamp" => $timestamp
		));

	}

	public function setLocation()
	{
		$id=0;

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_global_observer_location";
		$sqlString.=" WHERE value LIKE '".$GLOBALS['curUrl']."'";
		$sqlString.=" ORDER BY id DESC";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$id = $row['id'];
		}

		if($id==0){
			$sqlString="INSERT INTO ".$this->tablePrefix."mod_global_observer_location (value)";
			$sqlString.=" VALUES (:value";
			$sqlString.=")";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":value" => $GLOBALS['curUrl']
			));
			$id=$this->dbId->lastInsertId();

		}
		return $id;

	}

	public function getVisitorData($visitorId, $table)
	{
		$visitorData=array();
		$sqlString="SELECT id, sess_id, ip, device_data, status, consent_type";
		$sqlString.=" FROM ".$this->tablePrefix.$table;
		$sqlString.=" WHERE id = :visitorId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":visitorId" => $visitorId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$visitorData = $row;
		}

		return $visitorData;

	}

	public function getEventData($visitorId, $tableFragment)
	{
		$eventData=array();
		$sqlString="SELECT e.id AS eventId, e.user_id AS userId, u.username AS userName, e.type AS eventType, e.timestamp AS eventTime, l.value AS url";
		$sqlString.=" FROM ".$this->tablePrefix.$tableFragment."_event e";
		$sqlString.=", ".$this->tablePrefix.$tableFragment."_location l";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=" WHERE e.visitor_id = :visitorId";
		$sqlString.=" AND e.location_id = l.id";
		$sqlString.=" AND e.user_id = u.id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":visitorId" => $visitorId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$eventData[] = $row;
		}

		return $eventData;

	}

	public function updateArchiveData($location, $fileName)
	{

		$visitorList=array();
		$locationList=array();
		$eventList=array();

		$updateStatus=false;

		$sqlString="SELECT * FROM ".$this->tablePrefix."mod_visitor_archived_visitor";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$visitorList[] = $row;
		}

			$sqlString="SELECT * FROM ".$this->tablePrefix."mod_visitor_archived_location";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$locationList[] = $row;
			}

		$sqlString="SELECT * FROM ".$this->tablePrefix."mod_visitor_archived_event";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$eventList[] = $row;
		}

		if(count($visitorList)>0 && count($eventList)>0 && count($locationList)>0){

			$visitorSql="INSERT INTO `mod_visitor_archived_visitor` (`id`, `sess_id`, `ip`, `device_data`, `other`, `status`, `consent_type`, `last_visit`) VALUES ";
			for($i=0;$i<(count($visitorList)-1);$i++){
				$visitorSql.="(".$visitorList[$i]['id'].", '".$visitorList[$i]['sess_id']."', '".$visitorList[$i]['ip']."'";
				$visitorSql.=", '".$visitorList[$i]['device_data']."', '".$visitorList[$i]['other']."'";
				$visitorSql.=", ".$visitorList[$i]['status'].", ".$visitorList[$i]['consent_type'].", ".$visitorList[$i]['last_visit']."), ";

			}
			$visitorSql.="(".$visitorList[$i]['id'].", '".$visitorList[$i]['sess_id']."', '".$visitorList[$i]['ip']."'";
			$visitorSql.=", '".$visitorList[$i]['device_data']."', '".$visitorList[$i]['other']."'";
			$visitorSql.=", ".$visitorList[$i]['status'].", ".$visitorList[$i]['consent_type'].", ".$visitorList[$i]['last_visit'].");";

			$locationSql="INSERT INTO `mod_visitor_archived_location` (`id`, `value`) VALUES ";
			for($i=0;$i<(count($locationList)-1);$i++){
				$locationSql.="(".$locationList[$i]['id'].", '".$locationList[$i]['value']."'), ";
			}
			$locationSql.="(".$locationList[$i]['id'].", '".$locationList[$i]['value']."');";

			$eventSql="";
			if(count($eventList)>0){
				$eventSql="INSERT INTO `mod_visitor_archived_event` (`id`, `visitor_id`, `location_id`";
				$eventSql.=", `user_id`, `type`, `timestamp`) VALUES ";

				if(count($eventList)>1){
					for($i=0;$i<(count($eventList)-1);$i++){
						$eventSql.="(".$eventList[$i]['id'].", ".$eventList[$i]['visitor_id'].", ".$eventList[$i]['location_id']."";
						$eventSql.=", ".$eventList[$i]['user_id'].", ".$eventList[$i]['type'].", ".$eventList[$i]['timestamp']."), ";
					}
				}

				$eventSql.="(".$eventList[$i]['id'].", ".$eventList[$i]['visitor_id'].", ".$eventList[$i]['location_id']."";
				$eventSql.=", ".$eventList[$i]['user_id'].", ".$eventList[$i]['type'].", ".$eventList[$i]['timestamp'].");";
			}

			$fileContent="";
			$fileContent.=$visitorSql;
			$fileContent.="\n";
			$fileContent.=$locationSql;
			$fileContent.="\n";
			$fileContent.=$eventSql;
			$fileContent.="\n";

			$fp=fopen($filePath,'w');
			fwrite($fp, $fileContent);
			fclose($fp);

			$updateStatus=true;

		}

		return $updateStatus;

	}

}
