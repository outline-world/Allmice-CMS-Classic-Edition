<?php 
/*
 * Message module for Allmice™ CMS
 * Version 1.8.1 (2020-12-30)
 * Copyright 2020 by Adeenas OÜ, Copyright 2017 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Message module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include "core/includes/Model/"."DatabaseCms.php";
include $pathModuleModel."AppDatabase.php";
include $pathModuleModel."Message.php";
include $pathModuleModel."MessageForm.php";
include $pathModuleModel."Template.php";
include $pathModuleModel."TemplateForm.php";

class MessageController extends Controller
{

	public $dbConfig;
	public $modConfig;
	public $otherConfig;

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

	public function listTemplatesEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$sqlWhere="";
		$dataList = $appDb->getTemplateList($sqlWhere);	

		return array(
			'dataList' => $dataList,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function addTemplateEvent()
	{

		$form = new TemplateForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$template = new Template();
		$template->id = 0; 

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();
				$template->convertFormData($formData);

				$appDb->saveTemplate($template);
				$url=$GLOBALS['baseUrl']."/message/list-templates";
				$this->redirect($url, false);

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'form' => $form,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function editTemplateEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$messages=array();
		$form = new TemplateForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$template = new Template();
		$template->id = $id;

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {

				$formData=$form->getData();
				$template->convertFormData($formData);

				$appDb->saveTemplate($template);

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{
			$templateData = $appDb->getTemplateDetails($id);

			if(count($templateData)>0){
				$form->convertDbData($templateData);

			}
			else{
				$id=0;
				$messages[]="Template id is not correct.";
			}

		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function deleteTemplateEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$messages=array();

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$template = new Template();
		$template->id = $id; 
		$templateData = $appDb->getTemplateDetails($id);
		if(count($templateData)>0){
			$template->convertDbData($templateData);
		}
		else{
			$id = 0;
			$messages[]="Template id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteTemplate($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $template,
			'deleted' => $deleted,
			'lang' => $GLOBALS['localLang']['other'],
		);
	}

	public function writeMessageEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$problemNote=array();
		$successNote=array();

		$modConfig=$this->modConfig;

		$form = new MessageForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$message = new Message();
		$message->id = $id; 

		$lang=$GLOBALS['localLang']['other'];

		$sqlWhere="";		
		$sqlWhere.=" WHERE m.id = ".$id;
		$mesData = $appDb->getMessageDetails($sqlWhere);	

		$form->setValue('content',$message->formatOrigin($mesData));

		$form->formMap['receiverName']['required']=true;
		$form->formMap['subject']['required']=true;
		$form->formMap['content']['required']=true;

		if (isset($_POST['save']) || isset($_POST['send'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$message->convertFormData($formData);

				$senderData['id']=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
				$senderData['name']=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];
				$recipientId=$appDb->checkRecipient($message->receiverName, $senderData);

				$message->id=0;
				$message->time=time();
				$message->senderId=$senderData['id'];
				$message->senderName=$senderData['name'];
				$message->receiverId=$recipientId;
				$message->statusForReceiver="unsent";
				$message->statusForSender="unsent";

				$message->ipv4=$message->getIP();

				$message->receiverEmail="";
				$message->senderEmail="";
				$message->type="user-user";
				$message->parentId=$appDb->getParentId($id);

				$message->content=str_replace("\n","<br />\n",$message->content);
				$message->id=$appDb->saveMessage($message);
				$successNote[]=$lang['message1'];

				if (isset($_POST['send'])) {
					if($recipientId>0){

						$message->ipv4=$message->getIP();
						$message->receiverEmail=$appDb->getActiveEmail($recipientId);
						$message->senderEmail=$appDb->getActiveEmail($senderData['id']);

						$message->statusForReceiver="unread";
						$message->statusForSender="sent";

						$dbMesData=$appDb->getDbMesData('email');
						$authData=$dbMesData['emailAuthentication'];

						$authFlag=0;
						if($authData['username']=="" || $authData['password']==""){
							$problemNote[]=$lang['message2'];
							$authFlag=-1;
						}

						if($authFlag==0){

							$receiverData['email']=$message->receiverEmail;
							$receiverData['name']=$message->receiverName;

							$mesData=$message->getMesData($receiverData, $authData, $appDb, 'wrapperUser');
							$mesData=$message->replaceTokens($mesData,$message);

							$mesData['timezone']=$dbMesData['email']['timezone'];

							$resMes=$message->sendMessage($mesData);

							$message->statusForReceiver="unread";
							$message->statusForSender="sent";
							$appDb->markMessageSent($message);

						}

						$successNote[]=$lang['message3'];
					}
					else {
						$problemNote[]=$lang['message4'];

					}

				}

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

		$sqlWhere="";		
		$sqlWhere.=" WHERE m.receiver_user_id = u.id";
		$sqlWhere.=" AND m.id = ".$id;
		$mesData = $appDb->getMessageDetails($sqlWhere);	

		if ($id>0) {

			$replyContent=$lang['replyStart'];
			$replyContent=str_replace("[messageTime]",date($GLOBALS['timeFormat'],$mesData['time']),$replyContent);
			$replyContent=str_replace("[senderName]",$mesData['senderName'],$replyContent);
			$replyContent=str_replace("&amp;#92;n","\n",$replyContent);
			$replyContent=str_replace("&#92;n","\n",$replyContent);

			$replyContent.=$mesData['content']."\n";
			$mesData['content']=$replyContent."\n";

			$form->setValue('content',$message->formatContent($mesData));

			$form->setValue('receiverName',$mesData['senderName']);
			$form->setValue('subject',"Re: ".$mesData['subject']);

			}

		}

		$message->setSessNoteSet($problemNote,"problem-note");
		$message->setSessNoteSet($successNote,"success-note");

		return array(
			'form' => $form,
			'lang' => $lang,
		);

	}

	public function editMessageEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$problemNote=array();
		$successNote=array();

		$modConfig=$this->modConfig;

		$form = new MessageForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$form->formMap['receiverName']['required']=true;
		$form->formMap['subject']['required']=true;
		$form->formMap['content']['required']=true;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$message = new Message();
		$message->id = $id;

		$lang=$GLOBALS['localLang']['other'];

 		$sqlWhere="";		
		$sqlWhere.=" WHERE m.receiver_user_id = u.id";
		$sqlWhere.=" AND m.id = ".$id;
		$mesData = $appDb->getMessageDetails($sqlWhere);	

		if (isset($_POST['save']) || isset($_POST['send'])) {
			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$message->convertFormData($formData);

				$senderData['id']=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
				$senderData['name']=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];
				$recipientId=$appDb->checkRecipient($message->receiverName, $senderData);

				$message->time=time();
				$message->senderName=$senderData['name'];
				$message->receiverId=$recipientId;
				$message->statusForReceiver="unsent";
				$message->statusForSender="unsent";

				$message->ipv4=$message->getIP();

				$message->content=str_replace("\n","<br />\n",$message->content);
				$appDb->saveMessage($message);
				$successNote[]=$lang['message1'];
				if (isset($_POST['send'])) {
					if($recipientId>0){

						$message->ipv4=$message->getIP();
						$message->receiverEmail=$appDb->getActiveEmail($recipientId);
						$message->senderEmail=$appDb->getActiveEmail($senderData['id']);

						$dbMesData=$appDb->getDbMesData('email');
						$authData=$dbMesData['emailAuthentication'];

						$authFlag=0;
						if($authData['username']=="" || $authData['password']==""){
							$problemNote[]=$lang['message2'];
							$authFlag=-1;
						}

						if($authFlag==0){

							$receiverData['email']=$message->receiverEmail;
							$receiverData['name']=$message->receiverName;

							$mesData=$message->getMesData($receiverData, $authData, $appDb, 'wrapperUser');
							$mesData=$message->replaceTokens($mesData,$message);

							$mesData['timezone']=$dbMesData['email']['timezone'];

							$resMes=$message->sendMessage($mesData);

							$message->statusForReceiver="unread";
							$message->statusForSender="sent";
							$appDb->markMessageSent($message);

						}

						$mesData['receiverId']=$recipientId;
						$mesData['senderId']=$senderData['id'];
						if(!isset($mesData['statusForReceiver']))
							$mesData['statusForReceiver']="";
						if(!isset($mesData['statusForSender']))
							$mesData['statusForSender']="";

						$successNote[]=$lang['message3'];
					}
					else {
						$problemNote[]=$lang['message4'];

					}

				}

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

			if ($id>0) {

				if(count($mesData)>0){
					if(!isset($mesData['receiverName']) || $mesData['receiverName']==""){

						$form->setValue('receiverName',$mesData['recipientName']);
					}else{
						$form->setValue('receiverName',$mesData['receiverName']);
					}
					$form->setValue('subject',$mesData['subject']);
					$form->setValue('content',$message->formatContent($mesData));
				}

			}

		}

		$curUserId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];

		$ownMes=false;

		if(count($mesData)>0 && ($mesData['senderId']==$curUserId || $mesData['receiverId']==$curUserId))
			$ownMes=true;
		else{
			$id=0;
		}

		if(count($mesData)>0){
			if ($curUserId == $mesData['senderId'] && $mesData['statusForSender']=="deleted") {
				$ownMes=false;
			}
			elseif ($curUserId == $mesData['receiverId'] && $mesData['statusForReceiver']=="deleted") {
				$ownMes=false;
			}
			elseif ($curUserId == $mesData['receiverId'] && $mesData['statusForSender']=="unsent") {
				$ownMes=false;
			}

			if ($mesData['statusForSender']!="unsent") {
				$ownMes=false;
			}

		}

		$message->setSessNoteSet($problemNote,"problem-note");
		$message->setSessNoteSet($successNote,"success-note");

		return array(
			'id' => $id,
			'form' => $form,
			'ownMes' => $ownMes,
			'lang' => $lang,
		);

	}

	public function deleteMessageEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$message = new Message();
		$message->id = $id;

		$curUserId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];

		$sqlWhere="";		
		$sqlWhere.=" WHERE m.receiver_user_id = u.id";
		$sqlWhere.=" AND m.id = ".$id;
		$mesData = $appDb->getMessageDetails($sqlWhere);	

		if(count($mesData)>0){
			if(!isset($mesData['receiverName']) || $mesData['receiverName']==""){

				$mesData['receiverName']=$mesData['recipientName'];
			}else{
				$mesData['recipientName']=$mesData['receiverName'];
			}

		}
		else{
			$id = 0;
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];

			if ($curUserId == $mesData['senderId'] && $mesData['statusForSender']=="unsent") {
				$appDb->deleteMessage($message->id);
			}
			elseif ($curUserId == $mesData['receiverId'] && $mesData['statusForSender']=="deleted") {
				$appDb->deleteMessage($message->id);
			}
			elseif ($curUserId == $mesData['receiverId'] && $mesData['statusForSender']!="deleted") {
				$message->statusForSender=$mesData['statusForSender'];
				$message->statusForReceiver="deleted";
				$appDb->markMessageDeleted($message);
			}
			elseif ($curUserId == $mesData['senderId'] && $mesData['statusForReceiver']=="deleted") {
				$appDb->deleteMessage($message->id);
			}
			elseif ($curUserId == $mesData['senderId'] && $mesData['statusForReceiver']!="deleted") {
				$message->statusForSender="deleted";
				$message->statusForReceiver=$mesData['statusForReceiver'];
				$appDb->markMessageDeleted($message);
			}
			else {
				$appDb->deleteMessage($message->id);
			}

			$deleted=true;

		}

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$ownMes=false;
		if(count($mesData)>0 && ($mesData['senderId']==$userId || $mesData['receiverId']==$userId))
			$ownMes=true;

		if(count($mesData)>0){
			if ($curUserId == $mesData['senderId'] && $mesData['statusForSender']=="deleted") {
				$ownMes=false;
			}
			elseif ($curUserId == $mesData['receiverId'] && $mesData['statusForReceiver']=="deleted") {
				$ownMes=false;
			}
			elseif ($curUserId == $mesData['receiverId'] && $mesData['statusForSender']=="unsent") {
				$ownMes=false;
			}
		}

		return array(
			'id'    => $id,
			'mesData' => $mesData,
			'deleted' => $deleted,
			'ownMes' => $ownMes,
			'lang' => $GLOBALS['localLang']['other'],
		);
	}

	public function listMessagesEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$userName=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];

		$sqlWhere=" WHERE receiver_user_id = ".$userId;
		$dataListIn = $appDb->getMessageInList($sqlWhere);	

		$sqlWhere=" WHERE m.sender_user_id = ".$userId;
		$sqlWhere.=" AND m.receiver_user_id = u.id";
		$dataListOut = $appDb->getMessageOutList($sqlWhere);	

		return array(
			'dataListIn' => $dataListIn,
			'dataListOut' => $dataListOut,
			'userName' => $userName,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function viewMessageEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$lang=$GLOBALS['localLang']['other'];

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$userName=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];

		$curUserId=$userId;

		$sqlWhere="";		
		$sqlWhere.=" WHERE m.receiver_user_id = u.id";
		$sqlWhere.=" AND m.id = ".$id;
		$mesData = $appDb->getMessageDetails($sqlWhere);	

		if(count($mesData)>0){

			if(!isset($mesData['receiverName']) || $mesData['receiverName']==""){

				$mesData['receiverName']=$mesData['recipientName'];
			}else{
				$mesData['recipientName']=$mesData['receiverName'];
			}

		}
		else{
			$id = 0;
		}

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$ownMes=false;
		if(count($mesData)>0 && ($mesData['senderId']==$userId || $mesData['receiverId']==$userId))
			$ownMes=true;

		if(count($mesData)>0){
			if ($curUserId == $mesData['senderId'] && $mesData['statusForSender']=="deleted") {
				$ownMes=false;
			}
			elseif ($curUserId == $mesData['receiverId'] && $mesData['statusForReceiver']=="deleted") {
				$ownMes=false;
			}
			elseif ($curUserId == $mesData['receiverId'] && $mesData['statusForSender']=="unsent") {
				$ownMes=false;
			}

			if ($curUserId == $mesData['receiverId']) {
				$appDb->changeStatus4Receiver($id,"read");
			}

		}

		return array(
			'id' => $id,
			'mesData' => $mesData,
			'ownMes' => $ownMes,
			'lang' => $lang,
		);

	}

	public function listAllMessagesEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$userName=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];

		$sqlWhere="";
		$dataList = $appDb->getMessageList($sqlWhere);	
		return array(
			'dataList' => $dataList,
			'userName' => $userName,
		);

	}

	public function viewAnyMessageEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$messages=array();

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$userName=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];

		$sqlWhere="";		
		$sqlWhere.=" WHERE m.receiver_user_id = u.id";
		$sqlWhere.=" AND m.id = ".$id;
		$mesData = $appDb->getMessageDetails($sqlWhere);	

		if(!isset($mesData['receiverName']) || $mesData['receiverName']==""){
			$mesData['receiverName']=$mesData['recipientName'];
		}else{
			$mesData['recipientName']=$mesData['receiverName'];
		}

		if(count($mesData)>0){
		}
		else{
			$id = 0;
			$messages[]="Message id is not correct.";
		}

		return array(
			'id' => $id,
			'mesData' => $mesData,
			'messages' => $messages,
		);

	}

	public function deleteAnyMessageEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$messages=array();

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$message = new Message();
		$message->id = $id; 

		$sqlWhere="";		
		$sqlWhere.=" WHERE m.receiver_user_id = u.id";
		$sqlWhere.=" AND m.id = ".$id;
		$mesData = $appDb->getMessageDetails($sqlWhere);	

		if(!isset($mesData['receiverName']) || $mesData['receiverName']==""){
			$mesData['receiverName']=$mesData['recipientName'];
		}else{
			$mesData['recipientName']=$mesData['receiverName'];
		}

		if(count($mesData)>0){
		}
		else{
			$id = 0;
			$messages[]="Message id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteSearchType($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'mesData' => $mesData,
			'deleted' => $deleted,
		);
	}

	public function listUserBlockingsEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$userName=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];

		$dataList = $appDb->getBlockingList($userId);	

		return array(
			'dataList' => $dataList,
			'userName' => $userName,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function addUserBlockingEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$lang=$GLOBALS['localLang']['other'];

		$modConfig=$this->modConfig;
		$note="";

		$form = new MessageForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$message = new Message();
		$message->id = 0; 

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$message->convertFormData($formData);

				$curUserId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
				$dataList = $appDb->getBlockingList($curUserId);	

				$otherUserData['id']=0;
				$otherUserData['name']="";
				$otherUserId=$appDb->getUserId($message->username);

				$otherUserData['id']=$otherUserId;
				$otherUserData['name']=$message->username;
				if($otherUserId>1 && !in_array($otherUserData,$dataList)){

					if(strlen(serialize($dataList))<2000){
						array_push($dataList,$otherUserData);
						if(count($dataList)>1)
							$appDb->updateBlockingList($curUserId, $dataList);
						else	
							$appDb->insertBlockingList($curUserId, $dataList);	
						$note=str_replace("[username]",$otherUserData['name'],$lang['message1']);
						$note.="<br />";
						$note.="<br />";

					}else{
						$note=$lang['message3'];
						$note.="<br />";
						$note.="<br />";
					}

				}else{

					$note=$lang['message2'];
					$note.="<br />";
					$note.="<br />";
				}

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{
			if ($id>0) {

				$form->setValue('receiverName',$mesData['senderName']);
				$form->setValue('subject',"Re: ".$mesData['subject']);

			}

		}

		return array(
			'form' => $form,
			'lang' => $lang,
			'note' => $note,
		);

	}

	public function removeUserBlockingEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$lang=$GLOBALS['localLang']['other'];

		$otherUserData['name']="";
		$form = new MessageForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$curUserId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$dataList = $appDb->getBlockingList($curUserId);	

		$newList=array();
		$userInList=false;
		foreach ($dataList as $row) {

			if($id==$row['id']){
				$userInList=true;
				$otherUserData['name']=$row['name'];
			}else{
				$newList[]=$row;
			}

		}

		if($id>1 && $userInList){

			if(count($newList)>0)
				$appDb->updateBlockingList($curUserId, $newList);
			else	
				$appDb->deleteBlockingList($curUserId);	

			$note=str_replace("[username]",$otherUserData['name'],$lang['message1']);
			$note.="<br />";
			$note.="<br />";

		}else{
			$note=$lang['message2'];
			$note.="<br />";
			$note.="<br />";

		}

		return array(
			'note' => $note,
			'lang' => $lang,
		);
	}

}