<?php 
/*
 * Admin module for Allmice™ CMS
 * Version 1.7.1 (2019-10-27)
 * Copyright 2017 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * Admin module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

	include $pathCoreController."Controller.php";
	include $pathCoreModel."Form.php";
	include "core/includes/Model/"."DatabaseCms.php";

	if(isset($GLOBALS['urlParts'][1]) && (strstr($GLOBALS['urlParts'][1],"role")
	 || strstr($GLOBALS['urlParts'][1],"index")
	 || strstr($GLOBALS['urlParts'][1],"user")
	 || strstr($GLOBALS['urlParts'][1],"alias"))){

		include $pathModuleModel."AppDatabase.php";

		include $pathModuleModel."Role.php";
		include $pathModuleModel."User.php";
		include $pathModuleModel."Alias.php";

		include $pathModuleModel."AdminForm.php";
	}elseif(!isset($GLOBALS['urlParts'][1])){

		include $pathModuleModel."AppDatabase.php";
	}else{

		include $pathModuleModel."AppDatabase2.php";
		include $pathModuleModel."Config.php";
		include $pathModuleModel."AdminForm2.php";
	}

class AdminController extends Controller
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

	public function listUsersEvent()
	{

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getUserList();	

		return array(
			'dataList' => $dataList,
		);

	}

	public function addUserEvent()
	{

		$modConfig=$this->modConfig;
		$Other=$this->otherConfig;

		$form = new AdminForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		if(isset($Other['siteSalt']))
			$appDb->salt=$Other['siteSalt'];

		$roleSet = $appDb->getRoleList();	

		for($i=0;$i<count($roleSet);$i++)
		{
			$roleOptSet[($roleSet[$i]['id'])]=$roleSet[$i]['title'];
		}

		$form->formMap['mainRole']['options']=$roleOptSet;
		$form->formMap['save']['value']="Save user";

		$user = new User();

		$user->id = 0; 

		if (isset($_POST['save'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {
				$formData=$form->getData();
				$user->convertFormData($formData);

				$randomString=$user->getRandomString($GLOBALS['pwSaltLength']);
				$pwSalt=$GLOBALS['pwSaltData'].$randomString;
				$user->cryptedPw=crypt($user->password,$pwSalt);
				$appDb->saveUser($user);

				$url=$GLOBALS['baseUrl']."/admin/list-users";
				$this->redirect($url, false);
			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'form' => $form,
		);

	}

	public function editUserEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$modConfig=$this->modConfig;
		$Other=$this->otherConfig;
		$messages=array();

		$form = new AdminForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$roleSet = $appDb->getRoleList();	

		for($i=0;$i<count($roleSet);$i++)
		{
			$roleOptSet[($roleSet[$i]['id'])]=$roleSet[$i]['title'];
		}
		$form->formMap['mainRole']['options']=$roleOptSet;

		$user = new User();

		$user->id = $id; 

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {
				$roleValues=$_POST['mainRole'];

				$form->formMap['roleSet']['value']=$roleValues;
				$formData=$form->getData();
				$user->convertFormData($formData);

				$randomString=$user->getRandomString($GLOBALS['pwSaltLength']);
				$pwSalt=$GLOBALS['pwSaltData'].$randomString;
				$user->cryptedPw=crypt($user->password,$pwSalt);

				$appDb->saveUser($user);
			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

			$userData = $appDb->getUserDetails($id);
			if(count($userData)>0){
				$form->convertUserDbData($userData);
				$form->setValue('password','');
			}
			else{
				$id=0;
				$messages[]="User id is not correct.";
			}

		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function assignRolesEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$modConfig=$this->modConfig;
		$messages=array();

		$form = new AdminForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		if(isset($Other['siteSalt']))
			$appDb->salt=$Other['siteSalt'];

		$user = new User();
		$user->id = $id; 

		$userData = $appDb->getUserDetails($id);
		if(count($userData)>0){
			$roleSet = $appDb->getRoleList();	
			$mainRoleId=$userData['active_role_id'];

			for($i=0;$i<count($roleSet);$i++)
			{
				if($roleSet[$i]['id']!=2 && $roleSet[$i]['id']!=$mainRoleId)
					$roleOptSet[($roleSet[$i]['id'])]=$roleSet[$i]['title'];
				if($roleSet[$i]['id']==$mainRoleId)
					$mainRoleName=$roleSet[$i]['title'];
			}

			$form->formMap['userRoles']['options']=$roleOptSet;

		}else{
			$id=0;
			$mainRoleName="";
			$userData['username']="";
		}

		if (isset($_POST['save'])) {

			$formRoleValues=array();
			if (isset($_POST['userRoles']))
				$formRoleValues=$_POST['userRoles'];

			$form->setValue('userRoles',$formRoleValues);
			$appDb->saveUserRole($formRoleValues,$id,$mainRoleId);

		}
		else{
			if($id>0){
				$dbRoleValues = $appDb->getRoleIdSet($id,$mainRoleId);
				$form->setValue('userRoles',$dbRoleValues);
			}
			else{
				$id=0;
				$messages[]="User id is not correct.";
			}

		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
			'mainRoleName' => $mainRoleName,
			'userName' => $userData['username'],
		);

	}

	public function deleteUserEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$modConfig=$this->modConfig;
		$messages=array();

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$user = new User();
		$user->id = $id; 
		$userData = $appDb->getUserDetails($id);
		if(count($userData)>0){
			$user->convertDbData($userData);
		}
		else{
			$id=0;
			$messages[]="User id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteUser($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $user,
			'deleted' => $deleted,
		);

	}

	public function listRolesEvent()
	{

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getRoleList();	

		return array(
			'dataList' => $dataList,
		);

	}

	public function addRoleEvent()
	{

		$modConfig=$this->modConfig;

		$form = new AdminForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$role = new Role();
		$role->id = 0; 

		if (isset($_POST['save'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {
				$formData=$form->getData();
				$role->convertFormData($formData);
				$appDb->saveRole($role);
				$redirectUrl="".$GLOBALS['baseUrl']."/admin/list-roles";
				$this->redirect($redirectUrl, true);
			}
			else{
				$form->setErrorMessages();
			}
		}

		return array(
			'form' => $form,
		);

	}

	public function editRoleEvent()
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

		$form = new AdminForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$role = new Role();
		$role->id = $id; 

		if (isset($_POST['save'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {
				$formData=$form->getData();
				$role->convertFormData($formData);
				$appDb->saveRole($role);
			}
			else{
				$form->setErrorMessages();
			}
		}
		else{
			$roleData = $appDb->getRoleDetails($id);
			if(count($roleData)>0){
				$form->convertRoleDbData($roleData);
			}
			else{
				$id=0;
				$messages[]="Role id is not correct.";
			}

		}

		return array(
			'id' => $id,
			'form' => $form,
			'messages' => $messages,
		);

	}

	public function deleteRoleEvent()
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

		$role = new Role();
		$role->id = $id; 
		$roleData = $appDb->getRoleDetails($id);
		if(count($roleData)>0){
			$role->convertDbData($roleData);
		}
		else{
			$id = 0;
			$messages[]="Role id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteRole($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $role,
			'deleted' => $deleted,
		);

	}

	public function listAliasesEvent()
	{

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new AdminForm();
		$formMap =$form->formMap; 
		$dataList = $appDb->getAliasList();	

		return array(
			'dataList' => $dataList,
			'form' => $form,
		);

	}

	public function addAliasEvent()
	{

		$modConfig=$this->modConfig;

		$form = new AdminForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$alias = new Alias();
		$alias->id = 0; 

		$sourceList=$appDb->getSourceList();
		$form->formMap['source']['options']=$sourceList;

		if (isset($_POST['save'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();

				$alias->convertFormData($formData);
				$alias->sourceValue=$sourceList[($formData['source'])];

				$appDb->saveAlias($alias);

				$redirectUrl="".$GLOBALS['baseUrl']."/admin/list-aliases";
				$this->redirect($redirectUrl, true);
			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'form' => $form,
		);

	}

	public function editAliasEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$modConfig=$this->modConfig;

		$form = new AdminForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$alias = new Alias();
		$alias->id = $id;
		$messages=array();

		$sourceList=$appDb->getSourceList();
		$form->formMap['source']['options']=$sourceList;

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();

				$alias->convertFormData($formData);
				$alias->sourceValue=$sourceList[($formData['source'])];
				$appDb->saveAlias($alias);

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

			$aliasData = $appDb->getAliasDetails($id);
			$alias->convertDbData($aliasData);
			if(count($aliasData)>0){
				$form->convertAliasDbData($aliasData);

			}
			else{
				$id=0;
				$messages[]="Alias id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function deleteAliasEvent()
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

		$alias = new Alias();
		$alias->id = $id; 
		$aliasData = $appDb->getAliasDetails($id);
		if(count($aliasData)>0){
			$alias->convertDbData($aliasData);
		}
		else{
			$id = 0;
			$messages[]="Alias id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteAlias($id);
			}

		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'alias' => $alias,
			'deleted' => $deleted,
		);

	}

	public function listBotAccessResourcesEvent()
	{

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase2($Database['app_db']);

		$form = new AdminForm2();
		$dataList = $appDb->getAccessList();	

		return array(
			'dataList' => $dataList,
			'form' => $form,
		);

	}

	public function editBotAccessEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$form = new AdminForm2();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase2($Database['app_db']);

		$messages=array();
		$accessData = $appDb->getBotAccessDetails($id);

		if (isset($_POST['save'])) {

			$form->updateForm();

			$formData=$form->getData();

			$appDb->saveBotAccess($formData);

		}
		else{

			if(count($accessData)>0){
				$form->convertAccessDbData($accessData);
			}
			else{
				$id=0;
				$messages[]="Id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
			'accessData' => $accessData,
		);

	}

	public function listConfigEvent()
	{

		$form = new AdminForm2();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase2($Database['app_db']);

		$dbModules=$appDb->getConfigModuleSet();

		$modSet[-1]="[None chosen]";
		$modSet[0]="[All modules]";
//		$modSet[0]="All modules";
		$modNameSet[0]="";
		$modId=-1;
//		$modId=0;

		if (isset($_POST['modId'])) {
			$modId=$_POST['modId'];
		}

		$modName="";
		for($i=0;$i<count($dbModules);$i++)
		{
//			$modSet[($i+1)]=$dbModules[$i]['modTitle'];
//			$modNameSet[($i+1)]=$dbModules[$i]['modName'];
			$modSet[($i+2)]=$dbModules[$i]['modTitle'];
			$modNameSet[($i+2)]=$dbModules[$i]['modName'];
		}

		$typeSet[0]="All types";
		$typeId=0;

		if (isset($_POST['typeId'])) {
			$typeId=$_POST['typeId'];
		}

		if ($modId>=0) {

			$dbTypes=$appDb->getConfigTypeSet($modId, $modNameSet[($modId)], $typeId);
	
			for($i=0;$i<count($dbTypes);$i++)
			{
				$typeSet[($i+1)]=$dbTypes[$i]['type'];
	
			}
	
			if ($typeId>(count($typeSet)+1)) {
				$typeId=0;
			}
	
			if ($typeId==0) {
				$typeCode="";
			}else{
				$typeCode=$typeSet[($typeId)];
			}

		}

		$form->formMap['modId']['options']=$modSet;
		$form->formMap['modId']['value']=$modId;

		$form->formMap['typeId']['options']=$typeSet;
		$form->formMap['typeId']['value']=$typeId;

		$modName="";
		if($modId>0)
			$modName=$dbModules[($modId-2)]['modName'];
//			$modName=$dbModules[($modId-1)]['modName'];

		if($modId==-1)
			$dataList=array();
		else
			$dataList = $appDb->getConfigList($modName,$typeCode);

		$tableScript=$form->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'form' => $form,
			'dataList' => $dataList,
		);

	}

	public function addConfigEvent()
	{

		$form = new AdminForm2();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase2($Database['app_db']);

		$config = new Config();
		$config->id = 0; 

		if (isset($_POST['save'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {
				$formData=$form->getData();
				$config->convertFormData($formData);
				$appDb->saveConfig($config);
				$redirectUrl="".$GLOBALS['baseUrl']."/admin/list-config";
				$this->redirect($redirectUrl, true);
			}
			else{
				$form->setErrorMessages();
			}
		}

		return array(
			'form' => $form,
		);

	}

	public function editConfigEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$messages=array();

		$form = new AdminForm2();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase2($Database['app_db']);

		$config = new Config();
		$config->id = $id; 

		if (isset($_POST['save'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {
				$formData=$form->getData();
				$formData['value']=$form->specialCharsDecode($formData['value']);
				$config->convertFormData($formData);
				$appDb->saveConfig($config);
			}
			else{
				$form->setErrorMessages();
			}
		}
		else{
			$configData = $appDb->getConfigDetails($id);
			if(count($configData)>0){
				$form->convertConfigDbData($configData);
			}
			else{
				$id=0;
				$messages[]="Role id is not correct.";
			}

		}

		return array(
			'id' => $id,
			'form' => $form,
			'messages' => $messages,
		);

	}

	public function deleteConfigEvent()
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
		$appDb = new AppDatabase2($Database['app_db']);

		$config = new Config();
		$config->id = $id; 
		$configData = $appDb->getConfigDetails($id);
		if(count($configData)>0){
			$config->convertDbData($configData);
		}
		else{
			$id = 0;
			$messages[]="Configuration item id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteConfig($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $config,
			'deleted' => $deleted,
		);

	}

}