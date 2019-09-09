<?php 
/*
 * User module for Allmice™ CMS
 * Version 1.6.5 (2019-09-09)
 * Copyright 2018 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * User module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include "core/includes/Model/"."DatabaseCms.php";
include "core/includes/Model/"."PaginatorCms.php";
include $pathModuleModel."AppDatabase.php";
include "core/includes/Model/"."Captcha.php";

		include $pathModuleModel."User.php";
		include $pathModuleModel."Email.php";

if(!isset($GLOBALS['urlParts'][1])){
	include $pathCoreModel."Form.php";
	include $pathModuleModel."UserForm.php";
}
if(isset($GLOBALS['urlParts'][1]) && !strstr($GLOBALS['urlParts'][1],"list")){

	include $pathCoreModel."Form.php";

	if($GLOBALS['urlParts'][1]=="index" || $GLOBALS['urlParts'][1]=="login" || $GLOBALS['urlParts'][1]=="logout"){
		include $pathModuleModel."UserForm.php";
	}
	elseif(strstr($GLOBALS['urlParts'][1],"contact")){
		include $pathModuleModel."Contact.php";
		include $pathModuleModel."ContactForm.php";
	}
	elseif($GLOBALS['urlParts'][1]=="sign-up"){
		include $pathModuleModel."SignUp.php";
		include $pathModuleModel."SignUpForm.php";
	}
	elseif(strstr($GLOBALS['urlParts'][1],"email-address") || $GLOBALS['urlParts'][1]=="send-verifying-code"){
		include $pathModuleModel."EmailForm.php";
	}
	elseif(strstr($GLOBALS['urlParts'][1],"postal-address")){
		include $pathModuleModel."PostalAddress.php";
		include $pathModuleModel."PostalAddressForm.php";
	}
	elseif($GLOBALS['urlParts'][1]=="register"){
		include $pathModuleModel."UserForm.php";
	}
	elseif(strstr($GLOBALS['urlParts'][1],"recover-account")){
		include $pathModuleModel."EmailForm.php";
	}
	elseif(strstr($GLOBALS['urlParts'][1],"account")){
		include $pathModuleModel."UserForm.php";
	}
	else{
		include $pathModuleModel."UserForm.php";
	}

}
if(isset($GLOBALS['urlParts'][1]) && strstr($GLOBALS['urlParts'][1],"list")){
	include $pathCoreModel."Form.php";
	include $pathModuleModel."UserForm.php";
}

class UserController extends Controller
{  

	public $dbConfig;
	public $modConfig;
	public $otherConfig;

	public function indexEvent()
	{

		$loginForm = new UserForm();

		$Other=$this->otherConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$modConfig=$this->modConfig;

		if(isset($Other['siteSalt']))
			$appDb->salt=$Other['siteSalt'];

		$siteId=$Other['siteId'];
		if(!isset($_SESSION[$siteId]['userData'])){
			$_SESSION[$siteId]['userData']['id']=0;
			$_SESSION[$siteId]['userData']['roleId']=2;
			$_SESSION[$siteId]['userData']['name']="";
		}
		$loginForm->setUrl(($GLOBALS ['baseUrl']."/user"));
		$loginForm->setLanguage($GLOBALS['localLang']['form']);

		$lang=$GLOBALS['localLang']['other'];

		$configData=$appDb->getConfigData('');
		$registerCode=htmlspecialchars_decode($configData['loginView']['registerLink']);
		$registerCode=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$registerCode);
		$registerCode=str_replace("[lang-registerLink]",$lang['registerLink'],$registerCode);
		if($lang['registerText']!="")
			$registerCode=htmlspecialchars_decode($lang['registerText'])." ".$registerCode;
		$registerCode=str_replace("&#39;","'",$registerCode);

		$recoveryCode=htmlspecialchars_decode($configData['loginView']['recoveryLink']);
		$recoveryCode=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$recoveryCode);
		$recoveryCode=str_replace("[lang-recoveryLink]",$lang['recoveryLink'],$recoveryCode);
		if($lang['recoveryText']!="")
			$recoveryCode=htmlspecialchars_decode($lang['recoveryText'])." ".$recoveryCode;

		if(isset($_POST['login'])){

			$userData=$appDb->getUserData($_POST['username'],$_POST['password']);

			if(count($userData)>0 && isset($_POST['username']) && isset($userData['id']) && $userData['id']>0){

				$_SESSION[$siteId]['userData']['id']=$userData['id'];
				$_SESSION[$siteId]['userData']['roleId']=$userData['roleId'];
				$_SESSION[$siteId]['userData']['name']=$_POST['username'];

				$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$lang['message1']."</div>";

			}
			else{
//If user block is active, then it will cause double messages - there are two identical user forms in this case.
//Do not show error message here, if user block is active.
				$blockNameList=array();
				foreach ($GLOBALS['regionMap'] as $row) {
					$blockNameList[]=$row['blockName'];
				}
				if(!in_array('userBlock',$blockNameList)){
					$message=array();
					$GLOBALS['messageList']=array();
					$classStart[]="messageClassStart-red";
					$classEnd[]="messageClassEnd";
					$message[]=$lang['message2'];
					$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
				}
			}

		}
		if(isset($_POST['logout'])){
			$_SESSION[$siteId]['userData']['id']=0;
			$_SESSION[$siteId]['userData']['roleId']=2;
			$_SESSION[$siteId]['userData']['name']="";
			$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$lang['message3']."</div>";

		}

		$userData=$_SESSION[$siteId]['userData'];

		return array(
			'userData' => $userData,
			'loginForm' => $loginForm,
			'registerCode' => $registerCode,
			'recoveryCode' => $recoveryCode,
			'lang' => $lang,
		);

	}

	public function loginEvent()
	{
		$output = $this->indexEvent();

		return $output;
	}

	public function logoutEvent()
	{
		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$_SESSION[$siteId]['userData']['id']=0;
		$_SESSION[$siteId]['userData']['roleId']=2;
		$_SESSION[$siteId]['userData']['name']="";

		$output="";

		$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$GLOBALS['localLang']['other']['message1']."</div>";

			$redirectUrl="".$GLOBALS['baseUrl']."";

			$this->redirect($redirectUrl, false);
		return array(
			'output' => $output,
		);

	}

	public function myAccountOptionsEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$id=$userId;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$user = new User();
		$user->id = $id;
		$email = new Email();
		$appDb->checkUpdateAccountDetails($id,$user,$email);

		$ownEntry=false;
		if($id==$userId)
			$ownEntry=true;

		return array(
			'id' => $id,
			'lang' => $GLOBALS['localLang']['other'],
			'userId' => $userId,
			'ownEntry' => $ownEntry,
		);

	}

	public function signUpEvent()
	{

		$eventPath = "";
		if(isset($GLOBALS['urlParts'][1])){
			$eventPath = $GLOBALS['urlParts'][1];
		}

		$status="initial";

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		if($eventPath=="register"){
			$form = new UserForm();
			$eventName='registerEvent';
		}
		else{
			$form = new SignUpForm();
			$eventName='signUpEvent';
		}

		$form->changeList = $appDb->getChangeList("signUpEvent");
		$form->updateFields();

		$form->setUrl($GLOBALS['curUrl']);

		$countryList=$appDb->getCountryList();
		$form->formMap['country']['options']=$countryList;
		$form->setLanguage($GLOBALS['localLang']['form']);

		$lang = $GLOBALS['localLang']['other'];

		$captcha = new Captcha($appDb,"User","register",$lang);
		$message=array();

		$configData=$appDb->getConfigData('');
		if($eventPath=="sign-up" && $form->formMap['agreement']['required']){
			$agreementCode = htmlspecialchars_decode($configData['signUpView']['agreementLink']);
			$agreementCode = str_replace("[baseUrl]",$GLOBALS['baseUrl'],$agreementCode);
			$agreementCode = $lang['agreementText']." ".str_replace("[lang-agreementLink]",$lang['agreementLink'],$agreementCode);
		}else{
			$agreementCode = ""; 
		}

		if (isset($_POST['getNewCode'])) {
			$form->updateForm();
		}
		if (isset($_POST['register'])) {

			$form->updateForm();

			if ($captcha->test) {

				$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

				$formData=$form->getData();

				if(!isset($formData['password']) || !isset($formData['password2']) || $formData['password']!=$formData['password2']){
					$form->isValid=false;

					$form->errorMessages[]=$lang['passwordError'];
				}

				if($eventPath=="sign-up" && $form->formMap['agreement']['required']){
					if(isset($_POST['agreement']) && $_POST['agreement'] == 'i-agree'){
					}
					else{
						$form->errorMessages[]=$lang['agreementError'];
						$form->isValid=false;
					}
				}

				if ($form->isValid) {

					$user = new User();
					$user->convertFormData($formData);
					$email = new Email();

					if($eventPath=="sign-up"){
						$signUp = new SignUp();
						$signUp->convertFormData($formData);
						$signUp->title=$lang['postalAddressTitle'];
					}

					$email->setVerifyingCode($appDb->getVerCodeList());

					$dbMesData=$appDb->getDbMesData('email');
					$authData=$dbMesData['emailAuthentication'];

					$authFlag=0;
					if($authData['username']=="" || $authData['password']==""){

						$message[]=$lang['message1'];
						$authFlag=-1;
					}

					$user->mainRole=$appDb->getRoleId($configData['defaultMainRole'][($eventName)]);

					$receiverData['email']=$form->formMap['email']['value'];
					$receiverData['name']=$form->formMap['username']['value'];

					$email->emailAddress=$receiverData['email'];
					$user->email=$email->emailAddress;
					$userId=$appDb->checkUsername($receiverData['name']);
					$emailFlag=$appDb->checkModuleEmail($email->emailAddress);
					if($emailFlag==0)
						$emailFlag=$appDb->checkCoreEmail($email->emailAddress);

					if($authFlag==0 && $emailFlag==0 && $userId==0){

						if($email->verifyingCode!=""){

							$status="newUser";

							$mesData=$email->getMesData($receiverData, $authData, $appDb, 'verifyEmail');
							$mesData['timezone']=$dbMesData['email']['timezone'];

							$randomString=$user->getRandomString($GLOBALS['pwSaltLength']);
							$pwSalt=$GLOBALS['pwSaltData'].$randomString;
							$user->cryptedPw=crypt($user->password,$pwSalt);

							$email->status="created";
							$email->memWordQuestion="";
							$email->memWord="";
							$email->comment="";

							if($eventPath=="sign-up"){
								$mesData=$appDb->saveDetailedAccount($user,$email,$signUp,$mesData);

							}else{
								$mesData=$appDb->registerAccount($user,$email,$mesData);
							}

							$mesData['receiver']['contactId']=0;
							$mesData['status']="unread";
							$mesData['type']="system-guest";
							$mesData['comment']="";
							$mesData['userId']=0;

							$resMes=$email->sendMessage($mesData);

							$mesData['ip_v4']=$email->getIP();
							$mesData['time']=time();
							$appDb->saveMessage($mesData);

							$message[]=$lang['message2'];

						}
						else{
							$message[]=$lang['message5'];
						}

					}else{
						$classStart[]="messageClassStart-red";
						$classEnd[]="messageClassEnd";

						if($emailFlag>0){
							$status="registered";

							$message[]=$lang['message3'];
						}
						if($userId>0){
							$status="registered";

							$message[]=$lang['message4'];
						}
						$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
					}

					//==> Start of extension since 6/9/2019
						if(isset($_SESSION[($GLOBALS['siteId'])]['returnUrl']) && $_SESSION[($GLOBALS['siteId'])]['returnUrl']!=""){
					//If sign up is part of some other process, then redirect back to this other process.
							$returnUrl=$_SESSION[($GLOBALS['siteId'])]['returnUrl'];
						//User id must be passed to the parent process.
							$_SESSION[($GLOBALS['siteId'])]['signUp']['userId']=$user->id;
						//MessageList will be passed to the parent process too.
							$_SESSION[($GLOBALS['siteId'])]['signUp']['messageList']=$message;
					//To avoid false redirects, don't keep returnUrl in session, when it is not needed any more.
							unset($_SESSION[($GLOBALS['siteId'])]['returnUrl']);
					//Now, that the preparations have been done, make the redirect leaving this method!
							$this->redirect($returnUrl, false);
						}
					//End of extension <==

				}
				else{

					$form->setErrorMessages();
				}
			}
			else{

					$message[]=$lang['message6'];
					$classStart[]="messageClassStart-red";
					$classEnd[]="messageClassEnd";
					$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
			}

		}
		return array(
			'form' => $form,
			'status' => $status,
			'message' => $message,
			'agreementCode' => $agreementCode,
			'lang' => $lang,
			'captcha' => $captcha,
		);

	}

	public function registerEvent()
	{

		$output = $this->signUpEvent();
		return $output;

	}

	public function verifyEmailEvent()
	{

		$verifyingCode = "";
		if(isset($GLOBALS['urlParts'][2])){
			$verifyingCode = $GLOBALS['urlParts'][2];
		}

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$emailId=$appDb->processVerifyingCode($verifyingCode);

		if($emailId>0){
			$message=$GLOBALS['localLang']['other']['message1'];
		}else{
			$message=$GLOBALS['localLang']['other']['message2'];
		}

		return array(
			'message' => $message,
		);

	}

	public function contactFormEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$username=$_SESSION[$siteId]['userData']['name'];

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

//Configurable code for head tag
		$config = $appDb->getConfigData('head');
		if($config['headTags']['contactForm']!="[none]"){
			if(!isset($GLOBALS['headTags']))
				echo $GLOBALS['headTags']=""; 
			$GLOBALS['headTags']=$GLOBALS['headTags']."\n".$config['headTags']['contactForm']."\n";
		}

		$contactData=$appDb->getAnyContactDetails($id);

		$form = new contactForm();
		$form->setValue("formWithCaptcha",$GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$form->formMap['subject']['required']=true;
		$form->formMap['message']['required']=true;

		if($userId==0){
			$form->formMap['senderName']['required']=true;
			$form->formMap['senderEmail']['required']=true;
		}
		else{
			$form->formMap['senderName']['required']=true;
			$form->formMap['senderEmail']['required']=true;
		}

		$lang = $GLOBALS['localLang']['other'];
		$captcha = new Captcha($appDb,"User","send",$lang);

		if(count($contactData)>0 && $contactData['status']=="active"){

			$dbMesData=$appDb->getDbMesData('email');
			$authData=$dbMesData['emailAuthentication'];

			$receiverData['email']=$contactData['email_address'];
			$receiverData['name']=$contactData['contact_name'];

			$mesData['auth']=$authData;
			$mesData['receiver']=$receiverData;

			if (isset($_POST['getNewCode'])) {
				$form->updateForm();
			}

			if (isset($_POST['send'])) {

				$form->updateForm();
				$formData=$form->getData();

				if ($captcha->test) {

					$email = new Email();

					$senderDescription="";

					if($userId>0){
						$mesData=$email->getMesData($receiverData, $authData, $appDb, 'wrapperMember');
					}
					else{
						$mesData=$email->getMesData($receiverData, $authData, $appDb, 'wrapperGuest');
					}

					$mesData['receiverUserId']=$appDb->getUserId($id);

					if($userId==0){
						$senderData['email']=$formData['senderEmail'];
						$senderData['name']=$formData['senderName'];
						$mesData['sender']=$senderData;
						$mesData['reply']=$mesData['sender'];
						$mesData['type']="guest";
					}else{
						$senderData['email']=$authData['username'];

						$senderData['name']=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];

						$mesData['sender']=$senderData;
						$mesData['reply']=$mesData['sender'];
						$mesData['message']['subject']=str_replace("[memberName]",$username,$mesData['message']['subject']);
						$mesData['message']['content']['html']=str_replace("[memberName]",$username,$mesData['message']['content']['html']);
						$mesData['message']['content']['plain']=str_replace("[memberName]",$username,$mesData['message']['content']['plain']);
						$mesData['type']="member";
					}

					$mesData['message']['subject']=str_replace("[messageSubject]",$formData['subject'],$mesData['message']['subject']);

					$mesData['message']['content']['html']=str_replace("[messageContent]",$formData['message'],$mesData['message']['content']['html']);
					$mesData['message']['content']['plain']=str_replace("[messageContent]",$formData['message'],$mesData['message']['content']['plain']);

					$tokenSet['guestName']=$formData['senderName'];
					$tokenSet['guestEmail']=$formData['senderEmail'];
					$mesData['message']['subject']=str_replace("[guestName]",$tokenSet['guestName'],$mesData['message']['subject']);
					$tokenSet['memberContactId']="";
					$tokenSet['contactForm']=$GLOBALS['baseUrl']."/contact-form";
					$tokenSet['editContactForm']=$GLOBALS['baseUrl']."/edit-contact-form";
					$tokenSet['myContactId']=$id;
					$mesData=$email->replaceTokens($mesData, $tokenSet);

					$mesData['timezone']=$dbMesData['email']['timezone'];

					$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

					if ($form->isValid) {

						$mesData['userId']=$userId;
						$mesData['receiver']['contactId']=$id;
						$mesData['time']=time();
						$mesData['status']="unread";
						$mesData['ip_v4']=$email->getIP();
						$mesData['comment']="";

						$resMes=$email->sendMessage($mesData);

						$appDb->saveMessage($mesData);

						$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$lang['messageSent']."</div>";
						$redirectUrl="".$GLOBALS['baseUrl']."";
						$this->redirect($redirectUrl, false);
//						$form->updateForm();

					}
					else{
						$form->setErrorMessages();
					}

				}
				else {
					$message[]=$lang['message2'];
					$classStart[]="messageClassStart-red";
					$classEnd[]="messageClassEnd";
					$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
				}

			}
		}
		else
			$id = 0;

		return array(
			'form' => $form,
			'id' => $id,
			'userId' => $userId,
			'contactData' => $contactData,
			'captcha' => $captcha,
			'lang' => $lang,
		);

	}

	public function listEmailAddressesEvent()
	{

		$Database=$this->dbConfig;

		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$paginator = new PaginatorCms; 
		$searchPhrase="";
		$whereClause="user_id = ".$userId;
		$dataTable="mod_user_email";
		$allFields="id, email_address, mem_word_question, status";
		$searchField="";
		$list=$paginator->getDbList($appDb, $dataTable, $allFields, $searchField, $searchPhrase, $whereClause);
		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);

		$mainEmail = $appDb->getMainEmailAddress($userId);	

		return array(
			'dataList' => $list,
			'form' => $form,
			'paginator' => $paginator,
			'mainEmail' => $mainEmail,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function listContactFormsEvent()
	{

		$Database=$this->dbConfig;

		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$paginator = new PaginatorCms; 
		$searchPhrase="";

		$allFields="id";
		$dataTable="mod_user_contact";
		$whereClause="user_id = ".$userId;
		$searchField="";

		$list=$paginator->setProperties($appDb, $dataTable, $searchField, $searchPhrase, $whereClause);

		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);

		$list = $appDb->getOwnContactList($userId,$paginator);	
		$mainEmail = $appDb->getMainEmailAddress($userId);	

		return array(
			'dataList' => $list,
			'form' => $form,
			'paginator' => $paginator,
			'mainEmail' => $mainEmail,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function listPostalAddressesEvent()
	{

		$Database=$this->dbConfig;

		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$paginator = new PaginatorCms; 
		$searchPhrase="";
		$allFields="id, title, comment, postal_address";
		$dataTable="mod_user_postal";
		$whereClause="user_id = ".$userId;
		$searchField="";

		$list=$paginator->getDbList($appDb, $dataTable, $allFields, $searchField, $searchPhrase, $whereClause);
		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);

		return array(
			'dataList' => $list,
			'form' => $form,
			'paginator' => $paginator,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function addEmailAddressEvent()
	{

		$form = new EmailForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$email = new Email();
		$email->id = 0;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$user = new User();
		$user->id = $userId;
		$appDb->checkUpdateAccountDetails($userId,$user,$email);

		$eventPath = "";
		if(isset($GLOBALS['urlParts'][1])){
			$eventPath = $GLOBALS['urlParts'][1];
		}

		if($eventPath=="add-any-email-address"){
			$userOptions = $appDb->getUserOptions();
			$form->formMap['userId']['options']=$userOptions;
		}

		if($eventPath=="add-any-email-address"){
			$userId=1;
		}
		else{
			$Other=$this->otherConfig;
			$siteId=$Other['siteId'];
			$userId=$_SESSION[$siteId]['userData']['id'];
		}

		if (isset($_POST['userId']) && !isset($_POST['save'])) {
			$form->updateForm();
			$userId=$_POST['userId'];
		}

		$status="initial";
		$message=array();
		$lang = $GLOBALS['localLang']['other'];

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$email->convertFormData($formData);

				$email->userId=$userId;
				$email->status="created";
				$email->username=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];

				$email->setVerifyingCode($appDb->getVerCodeList());

				$configData=$appDb->getConfigData('');
				$dbMesData=$appDb->getDbMesData('email');
				$authData=$dbMesData['emailAuthentication'];

				$authFlag=0;
				if($authData['username']=="" || $authData['password']==""){
					$message[]=$lang['message1'];
					$authFlag=-1;
				}

				$receiverData['email']=$form->formMap['emailAddress']['value'];
				$receiverData['name']=$email->username;

				$email->emailAddress=$receiverData['email'];

				$emailFlag=$appDb->checkModuleEmail($email->emailAddress);
				if($emailFlag==0)
					$emailFlag=$appDb->checkCoreEmail($email->emailAddress);

				if($authFlag==0 && $emailFlag==0){

					$status="newEmail";

					if($eventPath=="add-email-address" && $email->verifyingCode!=""){
						$mesData=$email->getMesData($receiverData, $authData, $appDb, 'verifyEmail');
						$mesData['timezone']=$dbMesData['email']['timezone'];
						$resMes=$email->sendMessage($mesData);

						$mesData['ip']=$email->getIP();
						$mesData['time']=time();

						$mesData['userId']=0;
						$mesData['receiver']['contactId']=0;
						$mesData['receiverUserId']=$userId;
						$mesData['contactId']=0;
						$mesData['ip_v4']=$email->getIP();
						$mesData['type']="system-guest";
						$mesData['comment']="";

						$appDb->saveMessage($mesData);

						$message[]=$lang['message2'];
					}
					elseif($eventPath=="add-email-address" && $email->verifyingCode==""){
						$message[]=$lang['message4'];
					}

					$appDb->saveEmail($email);

				}
				else{
					$classStart[]="messageClassStart-red";
					$classEnd[]="messageClassEnd";

					if($emailFlag>0){
						$status="registered";
						$message[]=$lang['message3'];
					}
					$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
				}

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'form' => $form,
			'status' => $status,
			'message' => $message,
			'lang' => $lang,
		);

	}

	public function editEmailAddressEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$eventPath = "";
		if(isset($GLOBALS['urlParts'][1])){
			$eventPath = $GLOBALS['urlParts'][1];
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$form = new EmailForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$email = new Email();
		$email->id = $userId;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$emailData = $appDb->getEmailDetails($id);

		$form->convertDbData($emailData);

		$hasContactForms=false;

		if ($eventPath=="edit-any-email-address") {

			$hasContactForms=$appDb->checkIfHasContactForms($id);
			if(!$hasContactForms){
				if(isset($emailData['status']) && $emailData['status']=="verified"){
					$form->setValue('status',1);
					$form->formMap['status']['options'][1]=$GLOBALS['localLang']['other']['statusOption1'];
				}
				elseif(isset($emailData['status']) && $emailData['status']=="created-recent"){
					$form->setValue('status',2);
					$form->formMap['status']['options'][2]=$GLOBALS['localLang']['other']['statusOption2'];
				}
				else{
					$form->setValue('status',0);
					$form->formMap['status']['options'][0]=$GLOBALS['localLang']['other']['statusOption0'];
				}
			}

		}

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$email->convertFormData($formData);
				$email->id=$id;

				if ($eventPath=="edit-any-email-address") {
					if($formData['status']==1)
						$email->status="verified";
					elseif($formData['status']==2)
						$email->status="created-recent";
					else
						$email->status="created";
				}else{
					$email->status=$emailData['status'];
				}

				if($eventPath=="edit-email"){
					$email->status=$emailData['status'];
				}
				$appDb->saveEmail($email);

			}
			else{
				$form->setErrorMessages();
			}

		}

		$ownEntry=false;
		if(isset($emailData['user_id']) && $emailData['user_id']==$userId)
			$ownEntry=true;

		return array(
			'id' => $id,
			'form' => $form,
			'lang' => $GLOBALS['localLang']['other'],
			'ownEntry' => $ownEntry,
			'hasContactForms' => $hasContactForms,
		);

	}

	public function deleteEmailAddressEvent()
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

		$email = new Email();
		$email->id = $id; 
		$dbData = $appDb->getEmailDetails($id);

		if(count($dbData)>0)
			$email->convertDbData($dbData);
		else
			$id = 0;

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			$deleted=$appDb->deleteEmail($id);
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$ownEntry=false;
		if(isset($dbData['user_id']) && $dbData['user_id']==$userId)
			$ownEntry=true;

		$isMainEmail=$appDb->checkIfMainEmail($email->emailAddress);
		$hasContactForms=$appDb->checkIfHasContactForms($email->id);

		return array(
			'id'    => $id,
			'email' => $email,
			'deleted' => $deleted,
			'ownEntry' => $ownEntry,
			'isMainEmail' => $isMainEmail,
			'hasContactForms' => $hasContactForms,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function addContactFormEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$eventPath = "";
		if(isset($GLOBALS['urlParts'][1])){
			$eventPath = $GLOBALS['urlParts'][1];
		}

		$form = new ContactForm();
		$form->changeList = $appDb->getChangeList("addContactFormEvent");
		$defaultValues=$form->updateFields();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$form->formMap['status']['options'][0]=$GLOBALS['localLang']['other']['statusOption0'];
		$form->formMap['status']['options'][1]=$GLOBALS['localLang']['other']['statusOption1'];

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$user = new User();
		$user->id = $userId;
		$email = new Email();
		$appDb->checkUpdateAccountDetails($userId,$user,$email);

		if($eventPath=="add-any-contact-form"){
			$userOptions = $appDb->getUserOptions();
			$form->formMap['userId']['options']=$userOptions;
		}

		$contact = new Contact();
		$contact->id = 0;

		if($eventPath=="add-any-contact-form" && !isset($_POST['userId'])){
			$userId=1;
		}
		elseif($eventPath=="add-any-contact-form" && isset($_POST['userId'])){
			$userId=$_POST['userId'];
		}
		elseif($eventPath!="add-any-contact-form"){
			$Other=$this->otherConfig;
			$siteId=$Other['siteId'];
			$userId=$_SESSION[$siteId]['userData']['id'];
		}

		if (isset($_POST['userId']) && !isset($_POST['save'])) {
			$form->updateForm();
			$userId=$_POST['userId'];
		}

		$emailOptions = $appDb->getOwnEmailOptions($userId);
		$form->formMap['emailId']['options']=$emailOptions;
		$statusOptions=$form->formMap['status']['options'];

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$contact->convertFormData($formData);
				$contact->userId=$userId;
				$contact->convertDefaultData($defaultValues);

				$appDb->saveContact($contact);
				if($eventPath=="add-any-contact-form"){
					$url=$GLOBALS['baseUrl']."/user/list-all-contact-forms";
				}
				else{
					$url=$GLOBALS['baseUrl']."/user/list-contact-forms";
				}
				$this->redirect($url, false);

			}
			else{
				$form->setErrorMessages();
			}

		}

		$message=array();
		$lang = $GLOBALS['localLang']['other'];

		if(count($emailOptions)==0){
			$message[]=$lang['message1'];
		}

		return array(
			'form' => $form,
			'message' => $message,
			'lang' => $lang,
			'emailOptions' => $emailOptions,
		);

	}

	public function editContactFormEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$eventPath = "";
		if(isset($GLOBALS['urlParts'][1])){
			$eventPath = $GLOBALS['urlParts'][1];
		}

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		if($eventPath=="edit-any-contact-form"){
			$userId=$appDb->getContactUserId($id);
		}
		else{
			$Other=$this->otherConfig;
			$siteId=$Other['siteId'];
			$userId=$_SESSION[$siteId]['userData']['id'];
		}

		$form = new ContactForm();
		$form->changeList = $appDb->getChangeList("editContactFormEvent");
		$form->updateFields();

		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);
		$form->formMap['status']['options'][0]=$GLOBALS['localLang']['other']['statusOption0'];
		$form->formMap['status']['options'][1]=$GLOBALS['localLang']['other']['statusOption1'];

		$contact = new Contact();
		$contact->userId = $userId;

		$contactData = $appDb->getContactDetails($id);

		$form->convertDbData($contactData);

		$emailOptions = $appDb->getOwnEmailOptions($userId);
		$form->formMap['emailId']['options']=$emailOptions;
		$statusOptions=$form->formMap['status']['options'];

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$contact->convertFormData2($formData,$contactData);
				$contact->id=$id;
				$appDb->saveContact($contact);

			}
			else{
				$form->setErrorMessages();
			}

		}

		$ownEntry=false;
		if(isset($contactData['user_id']) && $contactData['user_id']==$userId)
			$ownEntry=true;

		return array(
			'id' => $id,
			'form' => $form,
			'lang' => $GLOBALS['localLang']['other'],
			'ownEntry' => $ownEntry,
		);

	}

	public function deleteContactFormEvent()
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

		$contact = new Contact();
		$contact->id = $id; 
		$dbData = $appDb->getContactDetails($id);

		if(count($dbData)>0)
			$contact->convertDbData($dbData);
		else
			$id = 0;

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			$deleted=$appDb->deleteContact($id);
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$ownEntry=false;
		if(isset($dbData['user_id']) && $dbData['user_id']==$userId)
			$ownEntry=true;

		return array(
			'id'    => $id,
			'contact' => $contact,
			'deleted' => $deleted,
			'ownEntry' => $ownEntry,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function addPostalAddressEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new PostalAddressForm();
		$form->changeList = $appDb->getChangeList("xPostalAddressEvent");
		$form->updateFields();

		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
		$user = new User();
		$user->id = $userId;
		$email = new Email();
		$appDb->checkUpdateAccountDetails($userId,$user,$email);

		$eventPath = "";
		if(isset($GLOBALS['urlParts'][1])){
			$eventPath = $GLOBALS['urlParts'][1];
		}

		if($eventPath=="add-any-postal-address"){
			$userOptions = $appDb->getUserOptions();
			$form->formMap['userId']['options']=$userOptions;
		}

		$countryList=$appDb->getCountryList();
		$form->formMap['country']['options']=$countryList;

		$postalAddress = new PostalAddress();

		$postalAddress->id = 0;

		if($eventPath=="add-any-postal-address" && !isset($_POST['userId'])){
			$userId=1;
		}
		elseif($eventPath=="add-any-postal-address" && isset($_POST['userId'])){
			$userId=$_POST['userId'];
		}
		elseif($eventPath!="add-any-postal-address"){
			$Other=$this->otherConfig;
			$siteId=$Other['siteId'];
			$userId=$_SESSION[$siteId]['userData']['id'];
		}

		if (isset($_POST['userId']) && !isset($_POST['save'])) {
			$form->updateForm();
		}

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$postalAddress->convertFormData($formData);

				$postalAddress->userId=$userId;
				$appDb->savePostalAddress($postalAddress);
				if($eventPath=="add-any-postal-address"){
					$url=$GLOBALS['baseUrl']."/user/list-all-postal-addresses";
				}
				else{
					$url=$GLOBALS['baseUrl']."/user/list-postal-addresses";
				}
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

	public function editPostalAddressEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new PostalAddressForm();
		$form->changeList = $appDb->getChangeList("xPostalAddressEvent");
		$form->updateFields();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$postalAddress = new PostalAddress();
		$postalAddress->userId = $userId;

		$contactData = $appDb->getPostalAddressDetails($id);

		$form->convertDbData($contactData);

		$countryList=$appDb->getCountryList();
		$form->formMap['country']['options']=$countryList;

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$postalAddress->convertFormData($formData);
				$postalAddress->id=$id;
				$appDb->savePostalAddress($postalAddress);

			}
			else{
				$form->setErrorMessages();
			}

		}

		$ownEntry=false;
		if(isset($contactData['user_id']) && $contactData['user_id']==$userId)
			$ownEntry=true;

		return array(
			'id' => $id,
			'form' => $form,
			'lang' => $GLOBALS['localLang']['other'],
			'ownEntry' => $ownEntry,
		);

	}

	public function deletePostalAddressEvent()
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

		$postalAddress = new PostalAddress();
		$postalAddress->id = $id; 
		$dbData = $appDb->getPostalAddressDetails($id);

		if(count($dbData)>0)
			$postalAddress->convertDbData($dbData);
		else
			$id = 0;

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			$deleted=$appDb->deletePostalAddress($id);
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$ownEntry=false;
		if(isset($dbData['user_id']) && $dbData['user_id']==$userId)
			$ownEntry=true;

		return array(
			'id'    => $id,
			'postalAddress' => $postalAddress,
			'deleted' => $deleted,
			'ownEntry' => $ownEntry,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function editAccountEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$eventPath = "";
		if(isset($GLOBALS['urlParts'][1])){
			$eventPath = $GLOBALS['urlParts'][1];
		}

		if($eventPath=="edit-any-account"){
			$userId=$id;
		}
		else{
			$Other=$this->otherConfig;
			$siteId=$Other['siteId'];
			$userId=$_SESSION[$siteId]['userData']['id'];
		}

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);
		$form->formMap['passwordStatus']['options'][0]=$GLOBALS['localLang']['other']['statusOption0'];
		$form->formMap['passwordStatus']['options'][1]=$GLOBALS['localLang']['other']['statusOption1'];

		$form->changeList = $appDb->getChangeList("xAccountEvent");
		$form->updateFields();

		$user = new User();
		$user->id = $id;

		$email = new Email();
		$appDb->checkUpdateAccountDetails($id,$user,$email);

		$userData = $appDb->getAccountDetails($id);

		$form->convertDbData($userData);

		if($eventPath=="edit-any-account"){
//Next row gets email addresses, which have whatever status
			$emailOptions = $appDb->getUserEmailOptions($userId);
		}else{
//Next row gets email addresses, which have whatever status
			$emailOptions = $appDb->getUserEmailOptions($userId);
//Next row gets email addresses, which status is verified or accepted
//			$emailOptions = $appDb->getOwnEmailOptions($userId);
		}

		$form->formMap['emailId']['options']=$emailOptions;
		$mainEmail = $appDb->getMainEmailData($userId);	

		if(count($mainEmail)>0)		
			$form->formMap['emailId']['value']=$mainEmail['id'];

		if (isset($_POST['passwordStatus']) && !isset($_POST['save'])) {
			$form->updateForm();
		}

		if (isset($_POST['save'])) {

			$form->updateForm();
			$formData=$form->getData();
			if ($formData['passwordStatus']==0) {
				$form->formMap['password']['required']=false;
				$form->formMap['password2']['required']=false;
			}
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($formData['passwordStatus']==1) {
				if(!isset($formData['password']) || !isset($formData['password2']) || $formData['password']!=$formData['password2']){
					$form->isValid=false;
					$form->errorMessages[]=$GLOBALS['localLang']['other']['message3'];
				}
			}

			if ($form->isValid) {

				$user->convertFormData($formData);
				$user->id=$id;

				$user->email=$emailOptions[($user->emailId)];

				if ($formData['passwordStatus']==1) {
					$randomString=$user->getRandomString($GLOBALS['pwSaltLength']);
					$pwSalt=$GLOBALS['pwSaltData'].$randomString;
					$user->cryptedPw=crypt($user->password,$pwSalt);
				}
				else{
					$user->cryptedPw=$userData['crypted_pw'];
				}

				if($eventPath=="edit-account"){
					if ($userData['first_name']!="") {
						$user->firstName=$userData['first_name'];
						$user->middleNames=$userData['middle_names'];
					}
					elseif ($userData['middle_names']!="") {
						$user->middleNames=$userData['middle_names'];
					}
					if ($userData['last_name']!="") {
						$user->lastName=$userData['last_name'];
					}
					$user->username=$userData['username'];
				}

				$appDb->saveAccount($user);

			}
			else{
				$form->setErrorMessages();
			}

		}

		$ownEntry=false;
		if($id==$userId)
			$ownEntry=true;

		return array(
			'id' => $id,
			'form' => $form,
			'lang' => $GLOBALS['localLang']['other'],
			'ownEntry' => $ownEntry,
		);

	}

	public function deleteAccountEvent()
	{

		$id = 0;

		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$eventPath = "";
		if(isset($GLOBALS['urlParts'][1])){
			$eventPath = $GLOBALS['urlParts'][1];
		}

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$accountData=array();

		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);

		if(strstr($eventPath,"delete-any-account")){
			$form->setLanguage($GLOBALS['localLang']['form']);
			$form->formMap['delMethod']['options'][0]=$GLOBALS['localLang']['other']['delOption0'];
			$form->formMap['delMethod']['options'][1]=$GLOBALS['localLang']['other']['delOption1'];
		}

		$user = new User();
		$user->id = $id;

		$curUserId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];
//		if($id>1){
		if($id>0){
			$accountData = $appDb->getAccountDetails($id);
			$user->convertDbData($accountData);
		}
		else
			$id = 0;

		$deleted=false;

		$delMethod="keepRef";

		if (isset($_POST['del'])) {
			if (isset($_POST['delMethod']) && $_POST['delMethod']==1) {
				$delMethod="delAll";
			}

			$del = $_POST['del'];
			$randomString=$user->getRandomString($GLOBALS['pwSaltLength']);
			$pwSalt=$GLOBALS['pwSaltData'].$randomString;
			$user->cryptedPw=crypt(time(),$pwSalt);
			$deleted=$appDb->deleteAccount($id,$user,$delMethod);

			if(!strstr($eventPath,"delete-any-account") && $deleted){

				$siteId=($GLOBALS['siteId']);
				$_SESSION[($siteId)]['userData']['id']=0;
				$_SESSION[($siteId)]['userData']['roleId']=2;
				$_SESSION[($siteId)]['userData']['name']="";

				$_SESSION[($siteId)]['messageList'][]="<div class=\"success-note\">".$GLOBALS['localLang']['other']['afterMessage']."</div>";

				$url=$GLOBALS['baseUrl'];
				$this->redirect($url, false);

			}

		}

		$ownEntry=false;
		if(strstr($GLOBALS['curUrl'],"/delete-any-account"))
		{
			$ownEntry=true;
		}else{
			if(count($accountData)>0)
				if($id==$curUserId)
					$ownEntry=true;
		}
		return array(
			'id'    => $id,
			'form' => $form,
			'user' => $user,
			'deleted' => $deleted,
			'ownEntry' => $ownEntry,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function listAccountsEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);
		$paginator = new PaginatorCms; 
		$searchField="";
		$searchPhrase="";
		$allFields="id, username, mail, status";
		$dataTable="core_user";
		$whereClause="id > 1";
		$list=$paginator->getDbList($appDb, $dataTable, $allFields, $searchField, $searchPhrase, $whereClause);

		return array(
			'dataList' => $list,
			'form' => $form,
			'paginator' => $paginator,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function listAllEmailAddressesEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);
		$paginator = new PaginatorCms; 
		$searchField="";
		$searchPhrase="";
		$allFields="id";
		$dataTable="mod_user_email";
		$whereClause="";
		$list=$paginator->setProperties($appDb, $dataTable, $searchField, $searchPhrase, $whereClause);

		$list = $appDb->getEmailList($paginator);	

		return array(
			'dataList' => $list,
			'form' => $form,
			'paginator' => $paginator,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function listAllPostalAddressesEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);
		$paginator = new PaginatorCms; 
		$searchField="";
		$searchPhrase="";
		$allFields="id";
		$dataTable="mod_user_postal";
		$whereClause="";
		$list=$paginator->setProperties($appDb, $dataTable, $searchField, $searchPhrase, $whereClause);

		$list = $appDb->getPostalList($paginator);	

		return array(
			'dataList' => $list,
			'form' => $form,
			'paginator' => $paginator,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function listAllContactFormsEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);
		$paginator = new PaginatorCms; 
		$searchField="";
		$searchPhrase="";
		$allFields="id";
		$dataTable="mod_user_contact";
		$whereClause="";
		$list=$paginator->setProperties($appDb, $dataTable, $searchField, $searchPhrase, $whereClause);

		$list = $appDb->getContactList($paginator);	

		return array(
			'dataList' => $list,
			'form' => $form,
			'paginator' => $paginator,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function addAccountEvent()
	{

		$status="initial";

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new UserForm();

		$form->changeList = $appDb->getChangeList("signUpEvent");
		$form->updateFields();

		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$lang = $GLOBALS['localLang']['other'];

		$message=array();
		if (isset($_POST['register'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();

				$user = new User();
				$user->convertFormData($formData);

				$user->mainRole = 3;

				$userId=$appDb->checkUsername($user->username);
				$emailFlag=$appDb->checkModuleEmail($user->email);
				if($emailFlag==0)
					$emailFlag=$appDb->checkCoreEmail($user->email);

				if($emailFlag==0 && $userId==0){

					$status="newUser";

					$randomString=$user->getRandomString($GLOBALS['pwSaltLength']);
					$pwSalt=$GLOBALS['pwSaltData'].$randomString;
					$user->cryptedPw=crypt($user->password,$pwSalt);
					$appDb->saveAccount($user);
					$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$lang['message1']."</div>";
					$url=$GLOBALS['baseUrl']."/user/list-accounts";
					$this->redirect($url, false);

				}else{
					$classStart[]="messageClassStart-red";
					$classEnd[]="messageClassEnd";

					if($emailFlag>0){
						$status="registered";
						$message[]=$lang['message2'];
					}
					if($userId>0){
						$status="registered";
						$message[]=$lang['message3'];
					}
					$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
				}

			}
			else{
				$form->setErrorMessages();
			}

		}

		$form->formMap['email']['guide']='Be sure, that this email exists and belongs to the person, whom you are opening the user account. This email address may be later used for relating contact forms to it and for sending automated messages.';

//			'guide' => 'Be sure, that this email exists and belongs to the person, whom you are opening the user account. System may later use it for relating contact forms to it and for sending automated messages.',

		return array(
			'form' => $form,
			'status' => $status,
			'message' => $message,
			'lang' => $lang,
		);

	}

	public function editAnyAccountEvent()
	{
		$output = $this->editAccountEvent();
		return $output;
	}

	public function deleteAnyAccountEvent()
	{
		$output = $this->deleteAccountEvent();
		return $output;
	}

	public function addAnyEmailAddressEvent()
	{
		$output = $this->addEmailAddressEvent();
		return $output;
	}

	public function editAnyEmailAddressEvent()
	{
		$output = $this->editEmailAddressEvent();
		return $output;
	}

	public function deleteAnyEmailAddressEvent()
	{
		$output = $this->deleteEmailAddressEvent();
		return $output;
	}

	public function addAnyContactFormEvent()
	{
		$output = $this->addContactFormEvent();
		return $output;
	}

	public function editAnyContactFormEvent()
	{
		$output = $this->editContactFormEvent();
		return $output;
	}

	public function deleteAnyContactFormEvent()
	{
		$output = $this->deleteContactFormEvent();
		return $output;
	}

	public function addAnyPostalAddressEvent()
	{
		$output = $this->addPostalAddressEvent();
		return $output;
	}

	public function editAnyPostalAddressEvent()
	{
		$output = $this->editPostalAddressEvent();
		return $output;
	}

	public function deleteAnyPostalAddressEvent()
	{
		$output = $this->deletePostalAddressEvent();
		return $output;
	}

	public function recoverAccountEvent()
	{

		$recoveryData=array();
		$form = new EmailForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$lang=$GLOBALS['localLang']['other'];

		$user = new User();
		$email = new Email();
		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$pageStatus="initial";		

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		if (isset($_POST['submitEmail']) || isset($_POST['submitWord'])) {

			$pageStatus="email";		

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$emailAddress=$formData['emailAddress'];

				$recoveryData=$appDb->getRecoveryData($emailAddress);

				if(count($recoveryData)>0){

					if (isset($_POST['submitEmail'])) {
						$classStart[]="messageClassStart-green";
						$classEnd[]="messageClassEnd";

						$status="notSent";
						$message[]=$lang['message4'];

						$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
					}
					$curTime=time();

					$period=1*24*60*60;

					if(isset($_POST['submitWord']) && ($recoveryData['mem_word']=="" || isset($formData['memWord']) && $recoveryData['mem_word']==$formData['memWord'])){

						$configData=$appDb->getConfigData('recoverAccount');
						if(isset($configData['recoverAccount']['passwordRequestPeriod']) && $configData['recoverAccount']['passwordRequestPeriod']!="")
							$period=(int)$configData['recoverAccount']['passwordRequestPeriod'];

						if($recoveryData['mem_word']=="" && $curTime<$recoveryData['change_time']+$period){
							$classStart[]="messageClassStart-red";
							$classEnd[]="messageClassEnd";

							$status="sent";
							$lang['message5']=str_replace("[period]",("".round($period/(60*60),2)),$lang['message5']);
							$message[]=$lang['message5'];

							$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
						}
						else{

							$dbMesData=$appDb->getDbMesData('email');
							$authData=$dbMesData['emailAuthentication'];

							$receiverData['email']=$form->formMap['emailAddress']['value'];
							$receiverData['name']=$recoveryData['username'];
							$user->email=$receiverData['email'];
							$channelId=$appDb->checkEmail($user->email);
							$userId=$appDb->checkUsername($receiverData['name']);

							$senderData['email']=$authData['username'];
							$senderData['name']="CMS";

							$mesTemplate=$appDb->getMesTemplate('verifyEmail');
							$user->id=$recoveryData['userId'];
							$user->username=$recoveryData['username'];
							$user->password=$user->getRandomString(16);
							$email->username=$recoveryData['username'];

							$randomString=$user->getRandomString($GLOBALS['pwSaltLength']);
							$pwSalt=$GLOBALS['pwSaltData'].$randomString;
							$user->cryptedPw=crypt($user->password,$pwSalt);

							$mesData=$email->getMesData($receiverData, $authData, $appDb, 'recoverAccount');

							$mesData['ip']=$email->getIP();
							$mesData['time']=time();

							$mesData['message']['content']['plain']=str_replace("[password]",$user->password,$mesData['message']['content']['plain']);
							$mesData['message']['content']['html']=str_replace("[password]",$user->password,$mesData['message']['content']['html']);

							$mesData['userId']=0;
							$mesData['receiverUserId']=$userId;
							$mesData['receiver']['contactId']=0;
							$mesData['time']=time();
							$mesData['status']="unread";
							$mesData['ip_v4']=$email->getIP();
							$mesData['type']="system-guest";
							$mesData['comment']="";
							$mesData['timezone']=$dbMesData['email']['timezone'];

							$appDb->saveMessage($mesData);

							$appDb->processAccountRecovery($user);

							$resMes=$email->sendMessage($mesData);

							$classStart[]="messageClassStart-green";
							$classEnd[]="messageClassEnd";

							$pageStatus="sent";
							$message[]=$lang['message6'];

							$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);

						}

					}elseif(isset($_POST['submitWord'])){
						$classStart[]="messageClassStart-red";
						$classEnd[]="messageClassEnd";
						$message[]=$lang['message7'];
						$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
					}

				}
				else{
					$classStart[]="messageClassStart-red";
					$classEnd[]="messageClassEnd";

					$message[]=$lang['message8'];

					$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);

					$recoveryData['memWord']="";
					$recoveryData['memWordQuestion']="";

				}

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'pageStatus' => $pageStatus,
			'form' => $form,
			'recoveryData' => $recoveryData,
			'user' => $user,
			'lang' => $lang,
		);

	}

	public function sendVerifyingCodeEvent()
	{

		$form = new EmailForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$lang=$GLOBALS['localLang']['other'];

		$email = new Email();
		$email->id = 0;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$pageStatus="initial";		

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$message=array();

		$curTime=time();

		$period=1*24*60*60;
		if (isset($_POST['submitEmail'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$emailAddress=$formData['emailAddress'];
				$emailData=$appDb->getEmailVerifyingData($emailAddress);

				if(count($emailData)>0){

					$configData=$appDb->getConfigData('sendVerifyingCode');
					if(isset($configData['sendVerifyingCode']['verifyingCodePeriod']) && $configData['sendVerifyingCode']['verifyingCodePeriod']!="")
						$period=(int)$configData['sendVerifyingCode']['verifyingCodePeriod'];

					if($emailData['status']=="created-recent" && $curTime<$emailData['change_time']+$period){
						$classStart[]="messageClassStart-red";
						$classEnd[]="messageClassEnd";

						$status="sent";
						$lang['message4']=str_replace("[period]", ("".(round($period/(60*60),2))), $lang['message4']);
						$message[]=$lang['message4'];

						$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
					}
					else{

						$email->convertFormData($formData);

						$email->id=$emailData['id'];
						$email->userId=$emailData['user_id'];

						$email->status="created-recent";

						$email->username=$emailData['username'];

						$email->setVerifyingCode($appDb->getVerCodeList());

						$configData=$appDb->getConfigData('');

						$dbMesData=$appDb->getDbMesData('email');
						$authData=$dbMesData['emailAuthentication'];

						$authFlag=0;
						if($authData['username']=="" || $authData['password']==""){

							$message[]=$lang['authConfError'];
							$authFlag=-1;
						}

						$receiverData['email']=$form->formMap['emailAddress']['value'];
						$receiverData['name']=$email->username;

						if($authFlag==0 && $email->verifyingCode!=""){

							$mesData=$email->getMesData($receiverData, $authData, $appDb, 'verifyEmail');
							$mesData['userId']=$userId;
							$mesData['receiver']['contactId']=0;
							$mesData['receiverUserId']=$emailData['user_id'];
							$mesData['time']=time();
							$mesData['status']="unread";
							$mesData['ip_v4']=$email->getIP();
							$mesData['type']="system-guest";
							$mesData['comment']="";
							$mesData['timezone']=$dbMesData['email']['timezone'];

							$resMes=$email->sendMessage($mesData);
							$appDb->saveMessage($mesData);

							$message[]=$lang['linkSent'];
							$pageStatus="sent";

							$appDb->updateVerifyingCode($email);

						}
						elseif($email->verifyingCode==""){
							$message[]=$lang['message4'];
						}

					}

				}else{
					$classStart[]="messageClassStart-red";
					$classEnd[]="messageClassEnd";

					$message[]=$lang['message2'];

					$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);

				}

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'pageStatus' => $pageStatus,
			'form' => $form,
			'lang' => $lang,
			'message' => $message,
		);
	}

	public function changeUserStatusEvent()
	{

		$id = 0;

		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$form = new UserForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);
		$form->formMap['userStatus']['options'][1]=$GLOBALS['localLang']['other']['statusOption1'];
		$form->formMap['userStatus']['options'][2]=$GLOBALS['localLang']['other']['statusOption2'];
		$lang=$GLOBALS['localLang']['other'];

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$userData = $appDb->getUserCoreData($id);
		$form->formMap['userStatus']['value']=$userData['status'];

		if (isset($_POST['save'])) {
			$form->updateForm();
			$appDb->changeUserStatus($id,$form->formMap['userStatus']['value']);

			$classStart[]="messageClassStart-green";
			$classEnd[]="messageClassEnd";
			$message[]=$lang['message1'];
			$GLOBALS['messageList']=array_merge($classStart,$message,$classEnd);
		}

		return array(
			'id' => $id,
			'form' => $form,
			'userData' => $userData,
			'lang' => $lang,
		);
	}

}