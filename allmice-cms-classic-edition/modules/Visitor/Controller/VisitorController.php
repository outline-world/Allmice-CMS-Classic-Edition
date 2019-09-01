<?php 
/*
 * Visitor module for Allmice™ CMS
 * Version 1.5.4 (2019-05-06)
 * Copyright 2018 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * Visitor module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include "core/includes/Model/"."DatabaseCms.php";
include $pathModuleModel."AppDatabase.php";
include $pathModuleModel."Visitor.php";
include $pathModuleModel."VisitorForm.php";

class VisitorController extends Controller
{

	public $dbConfig;
	public $modConfig;
	public $modLang;

	public function indexEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$roleId=1;
		$sqlWhere="";
		$sqlWhere.=" AND p.role_id = ".$roleId."";
		$sqlWhere.=" AND r.module_name = '".$GLOBALS['modName']."'";

		$eventSet = $appDb->getModuleEventSet($sqlWhere);

		return array(
			'eventSet' => $eventSet,
		);

	}

	public function listActiveVisitorsEvent()
	{

		$messages=array();
		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getVisitorList('mod_global_observer_visitor');	

		if(count($dataList)==0)
			$messages[]="No visitor data was found."; 

		return array(
			'dataList' => $dataList,
			'messages' => $messages,
		);

	}

	public function listArchivedVisitorsEvent()
	{

		$messages=array();
		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getVisitorList('mod_visitor_archived_visitor');	

		if(count($dataList)==0)
			$messages[]="No visitor data was found."; 

		return array(
			'dataList' => $dataList,
			'messages' => $messages,
		);

	}

	public function openArchiveEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new VisitorForm();
		$form->setUrl($GLOBALS['curUrl']);

		$visitor = new Visitor();

		$pathSet=array();

		$path="misc/output/GlobalObserver/test2";
		$path=$appDb->getArchiveLocation();

		$files=array();
		if(file_exists($path)){
			$files = scandir($path);

			$files = array_diff(scandir($path), array('.', '..'));
		}

		$checkedValue="";
		foreach($files as $file){
	   	if (strstr(strtolower($file),".sql")){
				$pathSet[]=$file;
			}
		}

			if(count($pathSet)>0){
				if (isset($_POST['fileName'])) {
					$form->formMap['fileName']['checked']=$_POST['fileName'];
				}else{
					$form->formMap['fileName']['checked']=$pathSet[0];
				}

			}

		if (isset($_POST['openArchive'])) {

			$form->updateForm();

					$installData['tablePrefix']=$appDb->tablePrefix;
					$installData['needle']="mod_";
					$installData['needle2']="core_";

					$installPath=$path;
					$installFile=$_POST['fileName'];
					if(file_exists($installPath."/".$installFile)){
						$sqlSet=$visitor->getSqlSet($installPath,$installFile,$installData);
					}else{
						$sqlSet=array();
					}

					$appDb->setArchivedData($sqlSet,$installFile);

		}

		$archiveStatus="closed";
		$archiveFileName=$appDb->getArchiveFileName();
		if($archiveFileName!="")
			$archiveStatus="open";

		return array(
			'form' => $form,
			'pathSet' => $pathSet,
			'archiveStatus' => $archiveStatus,
			'path' => $path,
		);

	}

	public function closeArchiveEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$visitor = new Visitor();
		$pathSet=array();
		$cleared=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$cleared=$appDb->clearArchiveTables();
			}
		}

		return array(
			'item' => $visitor,
			'cleared' => $cleared,
		);

	}

	public function saveArchiveEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$visitor = new Visitor();

		$pathSet=array();

		$location=$appDb->getArchiveLocation();
		$archiveFileName=$appDb->getArchiveFileName();

		$updated=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$updated=$appDb->updateArchiveData($location, $archiveFileName);
			}
		}

		return array(
			'item' => $visitor,
			'updated' => $updated,
			'archiveFileName' => $archiveFileName,
		);

	}

	public function viewActiveVisitorDataEvent()
	{

		$messages=array();

		$visitorId=0;
		if(isset($GLOBALS['urlParts'][2])){
			$visitorId = $GLOBALS['urlParts'][2];
			$visitorId=(int)$visitorId;
			if(!is_integer($visitorId))
				$visitorId=0;
		}

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$visitor = new Visitor();

		$visitorData=$appDb->getVisitorData($visitorId, 'mod_global_observer_visitor');
		$eventData=$appDb->getEventData($visitorId, 'mod_global_observer');

		if(count($visitorData)==0 || count($eventData)==0)
			$messages[]="No visitor data or event data was found."; 

		return array(
			'id' => $visitorId,
			'visitorData' => $visitorData,
			'eventData' => $eventData,
			'messages' => $messages,
		);

	}

	public function viewArchivedVisitorDataEvent()
	{

		$messages=array();

		$visitorId=0;
		if(isset($GLOBALS['urlParts'][2])){
			$visitorId = $GLOBALS['urlParts'][2];
			$visitorId=(int)$visitorId;
			if(!is_integer($visitorId))
				$visitorId=0;
		}

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$visitor = new Visitor();

		$visitorData=$appDb->getVisitorData($visitorId, 'mod_visitor_archived_visitor');
		$eventData=$appDb->getEventData($visitorId, 'mod_visitor_archived');

		if(count($visitorData)==0 || count($eventData)==0)
			$messages[]="No visitor data or event data was found."; 

		return array(
			'id' => $visitorId,
			'visitorData' => $visitorData,
			'eventData' => $eventData,
			'messages' => $messages,
		);

	}

	public function optOutDataEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new VisitorForm();
		$form->setUrl($GLOBALS['curUrl']);

		$visitor = new Visitor();

			$ip=$visitor->getClientIpEnv();
			if($ip=='UNKNOWN')
				$ip=$visitor->getClientIpServer();

			if(isset($_SERVER['HTTP_USER_AGENT'])){
				$agentData=$_SERVER['HTTP_USER_AGENT'];
			}

		$visitorId=$_SESSION[($GLOBALS['siteId'])]['visitorId'];

		if (isset($_POST['optOut'])) {
			$appDb->optOutData($visitorId);

		}

		return array(
			'form' => $form,
			'ip' => $ip,
			'agentData' => $agentData,
		);

	}

	public function editActiveVisitorEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$messages=array();

		$modConfig=$this->modConfig;

		$form = new VisitorForm();

		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$visitor = new Visitor();
		$visitor->id = $id; 

		$langOptions=$appDb->getLangOptions();
		if(count($langOptions)>0){
			$form->formMap['languageCode']['options']=$langOptions;
		}

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {

				$formData=$form->getData();
				$visitor->convertFormData($formData);

				$appDb->saveVisitor($visitor, 'mod_global_observer_visitor');
			}
			else{
				$form->setErrorMessages();

			}

		}
		else{
			$visitorData = $appDb->getVisitorDetails($id, 'mod_global_observer_visitor');
			if(count($visitorData)>0){
				$form->convertDbData($visitorData);
			}
			else{
				$id=0;
				$messages[]="Visitor id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function deleteActiveVisitorEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$messages=array();

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$visitor = new Visitor();
		$visitor->id = $id; 
		$visitorData = $appDb->getVisitorDetails($id, 'mod_global_observer_visitor');
		if(count($visitorData)>0){
			$visitor->convertDbData($visitorData);
		}
		else{
			$id = 0;
			$messages[]="Visitor id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteVisitor($id, 'global_observer');
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $visitor,
			'deleted' => $deleted,
		);

	}

	public function editArchivedVisitorEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$messages=array();

		$modConfig=$this->modConfig;

		$form = new VisitorForm();

		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$visitor = new Visitor();
		$visitor->id = $id; 

		$langOptions=$appDb->getLangOptions();
		if(count($langOptions)>0){
			$form->formMap['languageCode']['options']=$langOptions;
		}

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {

				$formData=$form->getData();
				$visitor->convertFormData($formData);

				$appDb->saveVisitor($visitor, 'mod_visitor_archived_visitor');
			}
			else{
				$form->setErrorMessages();

			}

		}
		else{
			$visitorData = $appDb->getVisitorDetails($id, 'mod_visitor_archived_visitor');
			if(count($visitorData)>0){
				$form->convertDbData($visitorData);
			}
			else{
				$id=0;
				$messages[]="Visitor id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function deleteArchivedVisitorEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$messages=array();

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$visitor = new Visitor();
		$visitor->id = $id; 
		$visitorData = $appDb->getVisitorDetails($id, 'mod_visitor_archived_visitor');
		if(count($visitorData)>0){
			$visitor->convertDbData($visitorData);
		}
		else{
			$id = 0;
			$messages[]="Visitor id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteVisitor($id, 'visitor_archived');
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $visitor,
			'deleted' => $deleted,
		);

	}

}
