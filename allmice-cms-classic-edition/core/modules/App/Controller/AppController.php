<?php 
/*
 * Allmice™ CMS
 * Version 1.5.4 (2019-05-06)
 * Copyright 2017 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>
 <?php

	include $pathCoreController."Controller.php";
	include $pathCoreModel."Form.php";

	include $pathModuleModel."AppDatabase.php";

	include $pathModuleModel."Access.php";
	include $pathModuleModel."User.php";
	include $pathModuleModel."Module.php";
	include $pathModuleModel."Application.php";

	if(isset($GLOBALS['urlParts']) && count($GLOBALS['urlParts'])>1 && $GLOBALS['urlParts'][1]=="install-website"){
		include $pathModuleModel."InstallForm.php";
	}else{
		include $pathModuleModel."AppForm.php";
	}

class AppController extends Controller
{  

	public $dbConfig;
	public $modConfig;
	public $otherConfig;

	public function indexEvent()
	{
		$message="";
		return array(
			'message' => $message,
			'lang' => $GLOBALS['localLang']['other'],
		);
	}

	public function manageAccessEvent()
	{
//Note- Important method - do not delete!
		$modConfig=$this->modConfig;

		$form = new AppForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$roleSet = $appDb->getRoleList();

		$roleId=$form->formMap['roleId']['value'];
		$modId=0;
		if (isset($_POST['modId']))
			$modId=$_POST['modId'];
		if (isset($_POST['roleId']))
			$roleId=$_POST['roleId'];

		$dbModules=$appDb->getLocalModuleSet();

		$modSet[0]="All modules";

		for($i=0;$i<count($dbModules);$i++)
		{
			$modSet[($i+1)]=$dbModules[$i]['module_name'];

		}
		$form->formMap['modId']['options']=$modSet;
		$form->formMap['modId']['value']=$modId;

		for($i=0;$i<count($roleSet);$i++)
		{
//Never let change resource access rights for admin role - admin role must always have all access!
			if($roleSet[$i]['id']!=1)
				$roleOptSet[($roleSet[$i]['id'])]=$roleSet[$i]['title'];
		}
		$form->formMap['roleId']['options']=$roleOptSet;

		$sqlWhere="";
		$sqlWhere.=" AND p.role_id = ".$roleId."";
		if($modId>0){
			$sqlWhere.=" AND r.module_name = '".$modSet[($modId)]."'";
		}

		$resSet = $appDb->getModuleResourceSet($sqlWhere);

		if (isset($_POST['save']) || isset($_POST['modId']) || isset($_POST['roleId'])) {

			$form->updateForm();

			$resCbValues=array();
			if(isset($_POST['resCb']))
				$resCbValues=$_POST['resCb'];

			for($i=0;$i<count($resSet);$i++){

				if (isset($_POST['save'])) {
					if(in_array($resSet[$i]['id'], $resCbValues)){
						$resSet[$i]['access_level']=1;

					}
					else
						$resSet[$i]['access_level']=0;
				}

			}

		}
		else{
			for($i=0;$i<count($dbModules);$i++)
			{
				if($dbModules[$i]['module_name']=="User"){
	//If User module is installed, then it will be default on permission page
					$modId=$i+1;
				}

			}

		}

		if (isset($_POST['save'])) {

			$access = new Access();

			$formData=$form->getData();
			$access->convertFormData($formData);
			for($i=0;$i<count($resSet);$i++){
				$access->roleId=$roleId;
				$access->resId=$resSet[$i]['id'];
				$access->accessLevel=$resSet[$i]['access_level'];
				$appDb->updateAccess($access);
			}
		}

		return array(
			'form' => $form,
			'resList' => $resSet,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function installModulesEvent()
	{

		$app = new Application();

		$modConfig=$this->modConfig;

		$form = new AppForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$module = new Module();

		$dbModules=$appDb->getModuleSet();

		$modData=$module->getModuleSet($dbModules);

		$modCbValues=array();

		if (isset($_POST['save'])) {

//Installing functionality starts

			$modSet=$modData['modList'];

			$modCbArray=$modData['modCbArray'];

			$form->updateForm();

			$modCbValues=$_POST['modCb'];
			$access = new Access();

			for($i=0;$i<count($modSet);$i++){
				$modCbArray[$i]['id']=$i;
				if(in_array($modCbArray[$i]['id'], $modCbValues)){
					$modCbArray[$i]['status']="checked";

					$installPath="modules/".$modSet[$i]['name']."/config/Install";
					$installFile=$modSet[$i]['path'].".sql";
					$installData['tablePrefix']=$appDb->tablePrefix;
					$installData['needle']="mod_";
					$installData['needle2']="core_";

					$installConfig=$installPath."/install-config.php";
					if(file_exists($installConfig)){
						include $installConfig;
						$modSet[$i]['title']=$modInstall['title'];
						$modSet[$i]['description']=$modInstall['description'];
						$modSet[$i]['path']=$modInstall['path'];
						$modSet[$i]['developer']=$modInstall['developer'];
						if(isset($modInstall['configPath']))						
							$modSet[$i]['configPath']=$modInstall['configPath'];
						else
							$modSet[$i]['configPath']="";
						if(isset($modInstall['requiredModules']))						
							$modSet[$i]['requiredModules']=$modInstall['requiredModules'];
						else
							$modSet[$i]['requiredModules']="";

						if($modInstall['path']!="")
							$modSet[$i]['type']=22;
						else
							$modSet[$i]['type']=21;

					}

					if(file_exists($installPath."/".$installFile)){
						$sqlSet=$app->getSqlSet($installPath,$installFile,$installData);
					}else{
						$sqlSet=array();
					}

					$appDb->installModule($modSet[$i],$access,$sqlSet);

				}
				else
					$modCbArray[$i]['status']="";
			}

//Installing functionality ends

//Preparing data for view after installing functionality (view rewrite)

			$dbModules=$appDb->getModuleSet();
			$modData=$module->getModuleSet($dbModules);

		}

		return array(
			'form' => $form,
			'modList' => $modData['modList'],
			'modPassiveList' => $dbModules,
			'modCbArray' => $modData['modCbArray'],
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function uninstallModulesEvent()
	{

		$modConfig=$this->modConfig;

		$form = new AppForm();
		$form->setUrl($GLOBALS['curUrl']);

		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$module = new Module();

//Preparing data for view

		$dbModules=$appDb->getModuleSet();
		$modData=$module->getModuleSet($dbModules);

		$modCbValues=array();

		$modCbArray=array();
		for($i=0;$i<count($dbModules);$i++){
			$modCbArray[$i]['id']=$i;
			$modCbArray[$i]['status']="";
		}

		if (isset($_POST['save'])) {

			$form->updateForm();
			$modCbValues=$_POST['modCb'];

			for($i=0;$i<count($dbModules);$i++){
				if(in_array($modCbArray[$i]['id'], $modCbValues)){
					$modCbArray[$i]['status']="checked";
//Note: $modSet[$i]['path'] value is probably empty - it is needed by uninstalling to delete any module aliases (if any)
					$appDb->uninstallModule($dbModules[$i]['module_name'],$dbModules[$i]['path']);
				}
				else
					$modCbArray[$i]['status']="";
			}
			$url=$GLOBALS['baseUrl']."/app/uninstall-modules";
			$this->redirect($url, false);

		}

		return array(
			'form' => $form,
			'passiveList' => $modData['modList'],
			'activeList' => $dbModules,
			'modCbArray' => $modCbArray,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function installWebsiteEvent()
	{

		$app = new Application();

		$form = new InstallForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Other=$this->otherConfig;

		$sitesDir = 'sites';

		if (!is_writable($sitesDir)) {

			$GLOBALS['messageList']=array();
			$classStart[]="messageClassStart-red";
			$classEnd[]="messageClassEnd";
			$dbMessage[]="Directory \"sites\" must be writable during installing process!";
			$GLOBALS['messageList']=array_merge($classStart,$dbMessage,$classEnd);
			$isWriteable = false;

		} else {
			$isWriteable = true;
		}

		$mesString=array();

		if (isset($_POST['install'])) {

			$form->updateForm();
			$form->checkValidity();

			$installData=$form->getFormValues();

			if ($form->isValid) {

				$newSiteSalt=$app->generateRandomString(16);
				$app->salt=$newSiteSalt;

				$installData['needle']="core_";
				$installData['needle2']="mod_";

				$sqlSet=$app->getSqlSet($Other['installPath'],"allmice_cms.sql",$installData);

				$Database['install'] = array(
					'dbName' => $installData['dbName'],
					'userName' => $installData['dbUserName'],
					'userPassword' => $installData['dbUserPassword'],
					'dbHost' => $installData['dbHost'],
				);

				$appDb = new AppDatabase($Database['install']);

				if(!$appDb->isValid){
					$GLOBALS['messageList']=array();
					$classStart[]="messageClassStart-red";
					$classEnd[]="messageClassEnd";
					$dbMessage[]="Something is wrong with database details.";
					$GLOBALS['messageList']=array_merge($classStart,$dbMessage,$classEnd);
				}
				else{
					$appDb->salt=$newSiteSalt;
					$appDb->tablePrefix=$form->formMap['tablePrefix']['value'];

					$user = new User();

					$user->id = 1; 
					$user->mainRole = 1; 

//Since version 1.6.3 admin user email is not required any more by installing the website
//					$user->eMail = $installData['eMail'];
					$user->eMail = "";
					$user->password = $installData['adminPassword'];
					$user->username = "admin";
					$user->userStatus = 2;
					//status=2 : confirmed
					$user->roleSet = array(1);
					$pwSalt=$app->generateRandomString($GLOBALS['pwSaltLength']);	

//Somehow other sql statements will not be executed, if executing the statements extracted from sql file (array sqlSet).
//To sove this issue, new password for admin user must be included (placeholder token replaced) to
//   such corresponding extracted statement - look for token '[replaceCryptedPassword]'.
					$sqlSet=$appDb->replacePassword($sqlSet, $user, $pwSalt);

					if(count($sqlSet)>0){
						$appDb->setDatabase($sqlSet);
	//Old method call:					$appDb->updateUser($user, $pwSalt);
	
						$app->setSiteConfigData($installData,$Other['installPath']);
	
						$url=$GLOBALS['baseUrl'];
						$this->redirect($url, false);
					}else{
						$GLOBALS['messageList']=array();
						$classStart[]="messageClassStart-red";
						$classEnd[]="messageClassEnd";
						$dbMessage[]="There were no SQL statements in SQL file or no statement with admin password replacing token.";
						$GLOBALS['messageList']=array_merge($classStart,$dbMessage,$classEnd);
					}

				}
			}else{

				$GLOBALS['messageList']=array();
				$classStart[]="messageClassStart-red";
				$classEnd[]="messageClassEnd";
				$GLOBALS['messageList']=array_merge($classStart,$form->errorMessages,$classEnd);
			}
			if(isset($form->errorMessages))
				$mesString=$form->convertMesData($form->errorMessages);
		}

		return array(
			'form' => $form,
			'errorMessages' => $mesString,
			'isWriteable' => $isWriteable,
		);

	}

}
