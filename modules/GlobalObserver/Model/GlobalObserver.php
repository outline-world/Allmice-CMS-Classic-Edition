<?php

class GlobalObserver {
	public $dbId;
	public $tablePrefix;
	public $ip;
	public $agentData;

	public function __construct()
	{
	}

	public function getBlockSet()
	{

		$blockSet=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_block";
		$sqlString.=" WHERE status = 1";
		$sqlString.=" AND building_module = 'GlobalObserver'";
		$sqlString.=" AND language_code = '".$GLOBALS['langCode']."'";
		$sqlString.=" ORDER BY region_code, rank";

		$resultSet=$this->dbId->query($sqlString);

		foreach ($resultSet as $row) {
			$blockSet[] = $row;
		}

		return $blockSet;

	}

	public function countFirstEvents($visitorId,$entryAmount)
	{

		$eventSet=array();

		$sqlString="SELECT v.status AS status, l.value AS location_value, l.type AS location_type, e.timestamp AS timestamp";
		$sqlString.=" FROM ".$this->tablePrefix."mod_global_observer_visitor v";
		$sqlString.=", ".$this->tablePrefix."mod_global_observer_location l";
		$sqlString.=", ".$this->tablePrefix."mod_global_observer_event e";
		$sqlString.=" WHERE e.visitor_id = v.id";
		$sqlString.=" AND e.location_id = l.id";
		$sqlString.=" AND e.visitor_id = :visitorId";
		$sqlString.=" ORDER BY e.timestamp";
		$sqlString.=" LIMIT ".$entryAmount;

		$sqlString="SELECT count(id) AS total";
		$sqlString.=" FROM ".$this->tablePrefix."mod_global_observer_event";
		$sqlString.=" WHERE visitor_id = :visitorId";
		$sqlString.=" LIMIT ".$entryAmount;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":visitorId" => $visitorId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$amount = $row['total'];
		}

		return $amount;

	}

	public function setVisitor($consentMethod)
	{
		$id=0;

		$consentType=2;
		switch($consentMethod){
			case "using":
				$consentType=1;
				break;
			case "continuing":
				$consentType=2;
				break;
			case "submit":
				$consentType=3;
				break;
  		}

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_global_observer_visitor (status, consent_type, last_visit)";
		$sqlString.=" VALUES (0, :consentType, :lastVisit)";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":consentType" => $consentType,
			":lastVisit" => $GLOBALS['curTime']
		));

		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function setVisitorDetails($consentMethod)
	{
		$id=0;

		$consentType=2;
		switch($consentMethod){
			case "using":
				$consentType=1;
				break;
			case "continuing":
				$consentType=2;
				break;
			case "submit":
				$consentType=3;
				break;
  		}

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_global_observer_visitor (status, ip, device_data";
		$sqlString.=", consent_type, last_visit)";
		$sqlString.=" VALUES (0, :ip, :agentData, :consentType, :lastVisit)";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":ip" => $this->ip,
			":agentData" => $this->agentData,
			":consentType" => $consentType,
			":lastVisit" => $GLOBALS['curTime']
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function getVisitorData($visitorId)
	{
		$visitorData=array();
		$sqlString="SELECT id, sess_id, ip, device_data, status, consent_type";
		$sqlString.=" FROM ".$this->tablePrefix."mod_global_observer_visitor";
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

	public function saveConsentData($visitorData)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_global_observer_visitor";
		$sqlString.=" SET device_data = :deviceData";
		$sqlString.=", ip = :ip";
		$sqlString.=", status = :status";
		$sqlString.=" WHERE id = :visitorId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":deviceData" => $this->agentData,
			":ip" => $this->ip,
			":status" => $visitorData['status'],
			":visitorId" => $visitorData['id']
		));

	}

	public function saveSessId($visitorId,$sessId)
	{
		$id=0;

		$sqlString="UPDATE ".$this->tablePrefix."mod_global_observer_visitor";
		$sqlString.=" SET sess_id = :sessId";
		$sqlString.=" WHERE id = :visitorId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":sessId" => $sessId,
			":visitorId" => $visitorId
		));

	}

	public function saveLastVisit($visitorId)
	{
		$id=0;

		$sqlString="UPDATE ".$this->tablePrefix."mod_global_observer_visitor";
		$sqlString.=" SET last_visit = :lastVisit";
		$sqlString.=" WHERE id = :visitorId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":lastVisit" => $GLOBALS['curTime'],
			":visitorId" => $visitorId
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

	public function getLocationId()
	{
		$id=0;

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_global_observer_location";
		$sqlString.=" WHERE value LIKE '".$GLOBALS['curUrl']."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$id = $row['id'];
		}
		return $id;

	}

	public function getClientIpEnv() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	        $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;
	}

	public function getClientIpServer() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;
	}

	public function get_ip_address() {
		$ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
		foreach ($ip_keys as $key) {
		    if (array_key_exists($key, $_SERVER) === true) {
		        foreach (explode(',', $_SERVER[$key]) as $ip) {

		            $ip = trim($ip);

		            if ($this->validate_ip($ip)) {
		                return $ip;
		            }
		        }
		    }
		}

		return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
	}

	public function validate_ip($ip)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
		    return false;
		}
		return true;
	}

	public function saveVisitor($consentMethod)
	{
		if($consentMethod=="using"){
			$ip="";
			$agentData="";

			$ip=$this->getClientIpEnv();
			if($ip=='UNKNOWN')
				$ip=$this->getClientIpServer();

			if(isset($_SERVER['HTTP_USER_AGENT'])){
				$agentData=$_SERVER['HTTP_USER_AGENT'];
			}

			$visitorId=$this->getVisitorId("agentData");

			if($visitorId==0)
				$visitorId=$this->setVisitorDetails($ip,$agentData,$consentMethod);

		}
		else{
			$visitorId=$this->setVisitor($consentMethod);
		}

		return $visitorId;

	}

	public function setAgentData()
	{
		$ip="";
		$agentData="";

		$ip=$this->getClientIpEnv();
		if($ip=='UNKNOWN')
			$ip=$this->getClientIpServer();
		$this->ip=$ip;

		if(isset($_SERVER['HTTP_USER_AGENT'])){
			$this->agentData=$_SERVER['HTTP_USER_AGENT'];
		}

	}

	public function getVisitorId($type)
	{

		$id=0;

		if($type=="agentData"){
			$sqlString="SELECT id";
			$sqlString.=" FROM ".$this->tablePrefix."mod_global_observer_visitor";
			$sqlString.=" WHERE ip LIKE '".$this->ip."'";
			$sqlString.=" AND device_data LIKE '".$this->agentData."'";
			$sqlString.=" LIMIT 1";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($resultSet as $row) {
				$id = $row['id'];
			}

		}

		return $id;

	}

	public function getConfigData($whereClauseEnd)
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'GlobalObserver'";
		if($whereClauseEnd!="")
			$sqlString.=$whereClauseEnd;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$configData[($row['uri'])] = $row['value'];
		}

		return $configData;

	}

	public function getStatusData()
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_misc_data";
		$sqlString.=" WHERE module_name = 'GlobalObserver'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$statusData[($row['uri'])] = $row['value'];
		}

		return $statusData;

	}

	public function getExpiredData($exPeriod)
	{
		$archivingData=array();

		$sqlString="SELECT id FROM ".$this->tablePrefix."mod_global_observer_visitor";
		$sqlString.=" WHERE last_visit < ".($GLOBALS['curTime']-$exPeriod);

		$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":exPeriod" => $exPeriod
			));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {

			$archivingData[] = $row['id'];
		}

		return $archivingData;
	}

	public function archiveExpiredData($idList, $location, $frequency, $period)
	{

		$visitorList=array();
		$locationList=array();
		$eventList=array();

		$endTime=0;

		foreach ($idList as $id) {
			$sqlString="SELECT * FROM ".$this->tablePrefix."mod_global_observer_visitor";
			$sqlString.=" WHERE id = :id";

			$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute(array(
					":id" => $id
				));
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($resultSet as $row) {

				$visitorList[] = $row;

				$sqlString="SELECT * FROM ".$this->tablePrefix."mod_global_observer_event";
				$sqlString.=" WHERE visitor_id = :visitorId";

				$stmt = $this->dbId->prepare($sqlString);
					$stmt->execute(array(
						":visitorId" => $id
					));
				$resultSet2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($resultSet2 as $row2) {
					$eventList[] = $row2;
				}

			}

		}

		if(count($idList)>0) {
			$sqlString="SELECT * FROM ".$this->tablePrefix."mod_global_observer_location";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$locationList[] = $row;
			}
		}

		if(count($visitorList)>0 && count($eventList)>0 && count($locationList)>0){

			$startTime=$GLOBALS['curTime']-$period;

			$visitorSql="INSERT INTO `mod_visitor_archived_visitor` (`id`, `sess_id`, `ip`, `device_data`, `other`, `status`, `consent_type`, `last_visit`) VALUES ";
			for($i=0;$i<(count($visitorList)-1);$i++){
				$visitorSql.="(".$visitorList[$i]['id'].", '".$visitorList[$i]['sess_id']."', '".$visitorList[$i]['ip']."'";
				$visitorSql.=", '".$visitorList[$i]['device_data']."', '".$visitorList[$i]['other']."'";
				$visitorSql.=", ".$visitorList[$i]['status'].", ".$visitorList[$i]['consent_type'].", ".$visitorList[$i]['last_visit']."), ";

			}

			if(count($visitorList)==1)
				$i=0;
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
						if($eventList[$i]['timestamp']<$startTime)
							$startTime=$eventList[$i]['timestamp'];
						if($endTime<$eventList[$i]['timestamp'])
							$endTime=$eventList[$i]['timestamp'];
					}
				}

				if(count($eventList)==1)
					$i=0;
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

			$fileName="archive-".date('Ymd-His',($GLOBALS['curTime']-$frequency))."-since-".date('Ymd-His',($startTime)).".sql";
			$fileName="archive-".date('Ymd-His',($startTime))."-to-".date('Ymd-His',($endTime)).".sql";

			$filePath=$location."/".$fileName;

			$fp=fopen($filePath,'w');
			fwrite($fp, $fileContent);
			fclose($fp);
		}

	}

	public function deleteExpiredData($expiredData)
	{
		foreach ($expiredData as $id) {

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_global_observer_visitor WHERE id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_global_observer_event WHERE visitor_id = :visitorId";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":visitorId" => $id
			));

		}
	}

	public function setLastTime($uri)
	{
		$id=0;

		$sqlString="UPDATE ".$this->tablePrefix."core_misc_data";
		$sqlString.=" SET value = :curTime";
		$sqlString.=" WHERE module_name = 'GlobalObserver'";
		$sqlString.=" AND uri = :uri";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":curTime" => $GLOBALS['curTime'],
			":uri" => $uri
		));

	}

	public function getCoreSessId($visitorId)
	{
		$id="";

		$visitorIdStr=strval($visitorId);
		$dbSearchVal="\"visitorId\"".";s:".strlen($visitorIdStr).":\"".$visitorIdStr."\"";

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_session";
		$sqlString.=" WHERE data LIKE '%".$dbSearchVal."%'";
		$sqlString.=" ORDER BY access DESC";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$id = $row['id'];
		}
		return $id;

	}

	public function getRoleTitle($roleId)
	{
		$id="";

		$sqlString="SELECT title";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";
		$sqlString.=" WHERE id = '".$roleId."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$title = $row['title'];
		}
		return $title;

	}

	public function getLangSet($blockCode)
	{

		$itemList=array();

		$sqlString="SELECT uri, text";
		$sqlString.=" FROM ".$this->tablePrefix."core_language";
		$sqlString.=" WHERE language_code = :langCode";
		$sqlString.=" AND specific_name = :blockCode";
		$sqlString.=" AND module_name = 'GlobalObserver'";
		$sqlString.=" AND type = 11";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":langCode" => $GLOBALS['langCode'],
			":blockCode" => $blockCode
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[($row['uri'])] = $row['text'];
		}

		if(count($itemList)==0){

			$sqlString="SELECT uri, text";
			$sqlString.=" FROM ".$this->tablePrefix."core_language";
			$sqlString.=" WHERE language_code = 'en'";
			$sqlString.=" AND specific_name = :blockCode";

			$sqlString.=" AND module_name = 'GlobalObserver'";
			$sqlString.=" AND type = 11";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":blockCode" => $blockCode
			));
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($resultSet as $row) {
				$itemList[($row['uri'])] = $row['text'];
			}

		}

		return $itemList;

	}

}
