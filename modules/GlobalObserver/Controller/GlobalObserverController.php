<?php 
/*
 * Global Observer module for Allmice™ CMS
 * Version 1.8.1 (2020-12-26)
 * Copyright 2020 by Adeenas OÜ, Copyright 2017 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Global Observer module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include "modules/GlobalObserver/Model/"."GlobalObserver.php";

class GlobalObserverController {
	public $otherConfig;
	public $globalData;

	public function __construct()
	{
	}

	public function indexEvent()
	{

		$Other=$this->otherConfig;

		$consentMethod="submit";

		$consentMethod="using";

		$observingMethod="notLimited";
		$observingMethod="xTimes";
		$observingTimes=5;

		$unknownVisitLimit=1;

		$delInterval=90;
		$archivingInterval=90;
		$delInterval=$delInterval*24*60*60;
		$archivingInterval=$archivingInterval*24*60*60;

		$archivingLocation="";

		$exUrlPart[0]="/terms";

		$mesStatus="on";

		if(isset($_SESSION[($GLOBALS['siteId'])]['mesStatus']))
			$mesStatus=$_SESSION[($GLOBALS['siteId'])]['mesStatus'];

		if(!strstr($GLOBALS['curUrl'],"/themes/")){

			$GLOBALS['curTime']=(int)gmdate("U");

			$observer= new GlobalObserver();
			$observer->dbId=$GLOBALS['db']['id'];
			$observer->tablePrefix=$GLOBALS['db']['tablePrefix'];

			$lang=$observer->getLangSet("consentBlock");

			$whereClauseEnd="";

			$config = $observer->getConfigData($whereClauseEnd);

			$noOfEvents=0;
			$eventType="1";

			$roleList=explode(", ",$config['exceptionalRoles']);
			$curRoleTitle=$observer->getRoleTitle($_SESSION[($GLOBALS['siteId'])]['userData']['roleId']);

			if(!in_array($curRoleTitle, $roleList) && $config['moduleSwitch']=="on"){

				$consentMethod=$config['consentMethod'];
				$observingMethod=$config['observingMethod'];
				$observingTimes=$config['observingTimes'];

				$notExUrl=true;
				$exUrlParts=explode(";",$config['exUrlParts']);
				foreach ($exUrlParts as $row) {
					if(strstr($GLOBALS['curUrl'],$row))
						$notExUrl=false;
				}

				$submitList=explode(", ",$config['consentSubmitButtons']);

				$statusData = $observer->getStatusData();

				if(isset($_SESSION[($GLOBALS['siteId'])]['visitorId'])){

					if($consentMethod=="using"){

						$observer->setAgentData();
						$eventType="1";
						$visitorId=0;
						$visitorId1=$_SESSION[($GLOBALS['siteId'])]['visitorId'];
						$visitorData=$observer->getVisitorData($visitorId1);

						$dbSessId1=$observer->getCoreSessId($visitorId1);

						if(count($visitorData)>0 && $visitorData['sess_id']!=""){

							if($dbSessId1==$visitorData['sess_id']){
								$visitorId=$visitorId1;
							}
							else{

								$visitorId2=$observer->getVisitorId("agentData");
								if($visitorId2>0){
									$observer->saveSessId($visitorId2,$dbSessId1);
									$visitorId=$visitorId2;
									$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;
								}

							}
						}
						elseif(count($visitorData)>0 && $visitorData['sess_id']==""){

							$visitorId2=$observer->getVisitorId("agentData");
							if($visitorId1==$visitorId2)
								$visitorId=$visitorId1;
							elseif($visitorId2>0){
								$visitorId=$visitorId2;
								$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;
							}
							else{
								$visitorId=$observer->setVisitorDetails($consentMethod);
								$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;
								$visitorData=$observer->getVisitorData($visitorId);
							}
						}
						else{

							$visitorId=$observer->setVisitorDetails($consentMethod);
							$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;
							$visitorData=$observer->getVisitorData($visitorId);
						}

						$dbSessId=$observer->getCoreSessId($visitorId);
						if($visitorData['sess_id']==""){
							$observer->saveSessId($visitorId,$dbSessId);
						}

						if($visitorData['status']==0){
							$noOfEvents=$observer->countFirstEvents($_SESSION[($GLOBALS['siteId'])]['visitorId'],$observingTimes);
						}

						if(($observingTimes-1)<=$noOfEvents)
							$notExUrl=true;
						if($visitorData['status']<1 && $noOfEvents>$unknownVisitLimit-1 && $notExUrl){
							$visitorData['id']=$visitorId;
							$eventType="11";
							$visitorData['status']=1;
							$observer->saveConsentData($visitorData);
						}
						elseif($visitorData['status']==2 && $notExUrl){

							$visitorData['id']=$visitorId;
							$eventType="11";
							$visitorData['status']=1;
							$observer->saveConsentData($visitorData);

							$locationId=$observer->setLocation();

							$eventType=11;
							$observer->setEvent($visitorId,$locationId,$eventType);
						}

					}
					elseif($consentMethod=="continuing"){

						$eventType="1";
						$visitorId=0;
						$visitorId1=$_SESSION[($GLOBALS['siteId'])]['visitorId'];
						$visitorData=$observer->getVisitorData($visitorId1);

						if(count($visitorData)>0 && $visitorData['sess_id']!=""){

							$dbSessId1=$observer->getCoreSessId($visitorId1);
							if($dbSessId1==$visitorData['sess_id'])
								$visitorId=$visitorId1;
							else{
								$visitorId=$observer->setVisitor($consentMethod);
								$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;
								$visitorData=$observer->getVisitorData($visitorId);
							}
						}
						elseif(count($visitorData)>0 && $visitorData['sess_id']==""){

							$visitorId=$visitorId1;
							$dbSessId=$observer->getCoreSessId($visitorId);
							$observer->saveSessId($visitorId,$dbSessId);
							$visitorData['sess_id']=$dbSessId;
						}
						else{

							$visitorId=$observer->setVisitor($consentMethod);
							$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;
							$visitorData=$observer->getVisitorData($visitorId);
						}

						if($visitorData['status']==0){
							$noOfEvents=$observer->countFirstEvents($_SESSION[($GLOBALS['siteId'])]['visitorId'],$observingTimes);
						}
						if(($observingTimes-1)<=$noOfEvents)
							$notExUrl=true;

						if($visitorData['status']<1 && $noOfEvents>$unknownVisitLimit-1 && $notExUrl){
							$observer->setAgentData();
							$visitorData['id']=$visitorId;
							$eventType="11";
							$visitorData['status']=1;
							$observer->saveConsentData($visitorData);
						}

					}

					$submitEvent=false;
					for($i=0;$i<count($submitList);$i++){

						if(isset($_POST[($submitList[$i])])){
							$submitEvent=true;

							$eventType="".(10*10+$i);
							$locationId=$observer->setLocation();

							if(!isset($visitorId))
								$visitorId=$_SESSION[($GLOBALS['siteId'])]['visitorId'];

							$observer->setEvent($visitorId,$locationId,$eventType);

						}

					}

					if($consentMethod=="using" || $consentMethod=="continuing"){

						if($eventType=="100"){
							$mesStatus="off";
							$_SESSION[($GLOBALS['siteId'])]['mesStatus']="off";

							$observer->setAgentData();
							$visitorData['id']=$visitorId;
							$visitorData['status']=1;
							$observer->saveConsentData($visitorData);

						}

						if(!isset($noOfEvents) || $noOfEvents==0)
							$noOfEvents=$observer->countFirstEvents($_SESSION[($GLOBALS['siteId'])]['visitorId'],$observingTimes);
						if($noOfEvents<$observingTimes || $observingMethod=="notLimited"){

							if($eventType<100){
								$locationId=$observer->setLocation();

								$observer->setEvent($visitorId,$locationId,$eventType);
							}
						}
						else{
							$mesStatus="off";
						}

					}

					if($consentMethod=="submit"){
						$visitorId=$_SESSION[($GLOBALS['siteId'])]['visitorId'];
						if($eventType=="100"){
							$visitorData=$observer->getVisitorData($visitorId);

							$dbSessId=$observer->getCoreSessId($visitorId);
							$observer->saveSessId($visitorId,$dbSessId);

							$observer->setAgentData();
							$visitorData['id']=$visitorId;
							$visitorData['status']=1;
							$observer->saveConsentData($visitorData);

							$mesStatus="off";
							$_SESSION[($GLOBALS['siteId'])]['mesStatus']="off";

						}

					}

				}else{

					$_SESSION[($GLOBALS['siteId'])]['mesStatus']="on";

					if($consentMethod=="using"){
						$observer->setAgentData();
						$eventType="1";
						$visitorId=$observer->getVisitorId("agentData");
						if($visitorId==0)
							$visitorId=$observer->setVisitorDetails($consentMethod);
						$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;
					}elseif($consentMethod=="continuing"){
						$eventType="1";
						$visitorId=$observer->setVisitor($consentMethod);
						$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;

					}

					if($consentMethod=="using" || $consentMethod=="continuing"){

						if(!isset($noOfEvents) || $noOfEvents==0)
							$noOfEvents=$observer->countFirstEvents($_SESSION[($GLOBALS['siteId'])]['visitorId'],$observingTimes);

						$visitorData=$observer->getVisitorData($visitorId);
						$dbSessId=$observer->getCoreSessId($visitorId);
						if($visitorData['sess_id']==""){
							$observer->saveSessId($visitorId,$dbSessId);
						}

						if($visitorData['status']<1 && $noOfEvents>$unknownVisitLimit-1 && $notExUrl){
							$visitorData['id']=$visitorId;
							$eventType="11";
							$visitorData['status']=1;
							$observer->saveConsentData($visitorData);
						}

						if($observingMethod=="notLimited" || $noOfEvents<$observingTimes){

							$locationId=$observer->setLocation();

							$observer->setEvent($visitorId,$locationId,$eventType);

						}
						else{
							$mesStatus="off";
						}
					}

					if($consentMethod=="submit"){
						$eventType="1";
						$visitorId=$observer->setVisitor($consentMethod);
						$_SESSION[($GLOBALS['siteId'])]['visitorId']=$visitorId;
						$locationId=$observer->setLocation();

						$observer->setEvent($visitorId,$locationId,$eventType);
					}

				}

				$observer->saveLastVisit($visitorId);

				$timeUnit=1;
				switch($config['timeUnit']){
					case "days":
						$timeUnit=24*60*60;
						break;
					case "hours":
						$timeUnit=60*60;
						break;
					case "minutes":
						$timeUnit=60;
						break;
		  		}

				$config['archivingExpiringPeriod']=$config['archivingExpiringPeriod']*$timeUnit;
				$config['archivingFrequency']=$config['archivingFrequency']*$timeUnit;
				$config['deletingExpiringPeriod']=$config['deletingExpiringPeriod']*$timeUnit;
				$config['deletingFrequency']=$config['deletingFrequency']*$timeUnit;

				$configIntLimit=4294967295;
				$configIsValid=false;

				if($config['archivingExpiringPeriod']!=0 && $config['archivingFrequency']!=0 && $config['archivingLocation']!=""){

					if (file_exists($config['archivingLocation']) && is_dir($config['archivingLocation']) && 
					$config['archivingFrequency']>0 && $config['archivingFrequency']<$configIntLimit && 
					$config['archivingExpiringPeriod']>0 && $config['archivingExpiringPeriod']<$configIntLimit) 
					{
						$configIsValid=true;
					}

					if ($configIsValid) {

						if($GLOBALS['curTime']>($statusData['lastBackupTime']+$config['archivingFrequency'])){

							if($statusData['lastBackupTime']!=0){

								$expiredData=$observer->getExpiredData($config['archivingExpiringPeriod']);

								if(count($expiredData)>0){
									$observer->archiveExpiredData($expiredData, $config['archivingLocation'], $config['archivingFrequency'], $config['archivingExpiringPeriod']);
									$observer->deleteExpiredData($expiredData);
								}

							}else{

								$observer->setLastTime("lastBackupTime");
							}

						}

					}
					else{

					}

				}
				elseif($config['deletingFrequency']!=0 && $config['deletingExpiringPeriod']!=0){

					if ($config['deletingFrequency']>0 && $config['deletingFrequency']<$configIntLimit && 
					$config['deletingExpiringPeriod']>0 && $config['deletingExpiringPeriod']<$configIntLimit) 
					{
						$configIsValid=true;
					}

					if ($configIsValid) {

						if($GLOBALS['curTime']>($statusData['lastDeletingTime']+$config['deletingFrequency'])){

							if($statusData['lastDeletingTime']!=0){
								$expiredData=$observer->getExpiredData($config['deletingExpiringPeriod']);
								if(count($expiredData)>0){
									$observer->deleteExpiredData($expiredData);
								}
							}else{

								$observer->setLastTime("lastDeletingTime");
							}
						}
					}
				}

			$blockSet=$observer->getBlockSet();
			$blockView="";

			if($mesStatus=="on"){

				$blockView.="";
				$blockView.="<div id=\"consentText\" class=\"consent-text\">";
				$blockView.=$lang['consentMessage1'];
				$blockView.=$lang['consentMessage2'];
				$blockView.=" "."<a href=\"".$GLOBALS['baseUrl'].$config['readMoreUrl']."\">".$lang['consentLink1']."</a>";
				$blockView.="</div>";
				$blockView.="<div id=\"buttonArea\" class=\"consent-button\">";
				$blockView.="<form name=\"messageTerms\" action=\"".$GLOBALS['curUrl']."\" method=\"post\">\n";
				$blockView.="<button type=\"submit\" name=\"mesSubmit\" class=\"consent-signal\" target=\""."blank"."\" value=\""."mesSubmit"."\" />";
				$blockView.=$lang['consentButton1'];
				$blockView.="</button>";
				$blockView.="</form>";
				$blockView.="</div>";

			}

			$regionMap=$GLOBALS['regionMap'];

			if(is_array($blockSet)){
				foreach($blockSet as $blockArray){

					$regionArray['blockName']=$blockArray['block_code'];
					$regionArray['regionName']=$blockArray['region_code'];
					$regionArray['view']=$blockView;
					$regionArray['type']=$blockArray['type'];
					$regionArray['uri']=$blockArray['uri'];
					$regionArray['rank']=$blockArray['rank'];
					$regionMap[]=$regionArray;

				}
			}

			$GLOBALS['regionMap']=$regionMap;
			}

		}

	}

}
