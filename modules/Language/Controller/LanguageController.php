<?php 
/*
 * Language module for Allmice™ CMS
 * Version 1.8.1 (2020-12-26)
 * Copyright 2020 by Adeenas OÜ, Copyright 2017 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Language module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include "core/includes/Model/"."PaginatorCms.php";
include "core/includes/Model/"."DatabaseCms.php";
include $pathModuleModel."AppDatabase.php";

if(isset($GLOBALS['urlParts'][1])){
	if(strstr($GLOBALS['urlParts'][1],"-phrase")){
		include $pathModuleModel."PhraseForm.php";
		include $pathModuleModel."Phrase.php";
	}
	elseif(strstr($GLOBALS['urlParts'][1],"manage-language")){
		include $pathModuleModel."PhraseForm.php";
		include $pathModuleModel."Phrase.php";
		include $pathModuleModel."Language.php";
	}
	elseif(strstr($GLOBALS['urlParts'][1],"-language")){
		include $pathModuleModel."LanguageForm.php";
		include $pathModuleModel."Language.php";
	}
	elseif(strstr($GLOBALS['urlParts'][1],"-relation")){
		include $pathModuleModel."RelationForm.php";
		include $pathModuleModel."Relation.php";
	}

}

class LanguageController extends Controller
{

	public $dbConfig;
	public $modConfig;
	public $modLang;

	public function indexEvent()
	{

		$Database=$this->dbConfig;
		$modConfig=$this->modConfig;

		$message="";
		return array(
			'message' => $message,
		);

	}

	public function listLanguagesEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$langList=$appDb->getLangList();
		$langOptions  = array(
			0 => 'Passive',
			1 => 'Active',
		);

		return array(
			'langList' => $langList,
			'langOptions' => $langOptions,
		);
	}

	public function addLanguageDetailsEvent()
	{

		$id = 0;

		$messages=array();
		$modConfig=$this->modConfig;

		$form = new LanguageForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$language = new Language();
		$language->id = $id; 

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();
				$language->convertFormData($formData);

				$appDb->saveLanguageDetails($language);
				$url=$GLOBALS['baseUrl'].'/'.$GLOBALS['modPath'].'/list-languages';
				$this->redirect($url, false);

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function editLanguageDetailsEvent()
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

		$form = new LanguageForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$language = new Language();
		$language->id = $id; 

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();
				$language->convertFormData($formData);

				$appDb->saveLanguageDetails($language);
			}
			else{
				$form->setErrorMessages();
			}

		}
		else{
			$langData = $appDb->getLangDetails($id);
			if(count($langData)>0){
				$form->convertLangDbData($langData);
			}
			else{
				$id=0;
				$messages[]="Language id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function deleteLanguageDetailsEvent()
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

		$language = new Language();
		$language->id = $id;

		$langData = $appDb->getLangDetails($id);

		if(count($langData)>0){
			$language->convertDbData($langData);
		}
		else{
			$id = 0;
			$messages[]="Language id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteLanguageDetails($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $language,
			'deleted' => $deleted,
		);

	}

	public function addEditPhraseSetEvent()
	{

		$form = new PhraseForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$lang = new Phrase();

		$headerLine="language_code	type	module_name	specific_name	uri	text";

		if (isset($_POST['save'])) {
			$form->updateForm();
			$formData=$form->getData();

			$phraseSet=$lang->getPhraseSet($formData['phraseSet'],$headerLine);

			$appDb->savePhraseSet($phraseSet);

			$sqlString=$lang->getSqlString($phraseSet);

			$form->setValue('outputString',$sqlString);

		}

		return array(
			'form' => $form,
		);

	}

	public function deletePhraseSetEvent()
	{

		$form = new PhraseForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$lang = new Phrase();

		$headerLine="language_code	type	module_name	specific_name	uri";

		if (isset($_POST['submit1'])) {
			$form->updateForm();
			$formData=$form->getData();

			$phraseSet=$lang->getPhraseSet($formData['phraseSet'],$headerLine);

			if(count($phraseSet)>0)
				$appDb->deletePhraseSet($phraseSet);

		}
		else{
			$form->setValue('phraseSet',$headerLine);

		}

		return array(
			'form' => $form,
		);

	}

	public function viewPhraseSetTableEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new PhraseForm();
		$form->setUrl($GLOBALS['curUrl']);

		$form->formMap['outputString']['label']="Output - TSV table with phrases:";
		$dbModules=$appDb->getCoreLangModSet();
		$dbLangSet=$appDb->getLanguageSet();

		$modSet[0]="[None chosen]";
		$langSet[0]="[None chosen]";
		$modSet[1]="[All chosen]";
		$langSet[1]="[All chosen]";
		$modId=0;
		$langId=0;

		$phrase = new Phrase();

		if (isset($_POST['modId'])) {
			$modId=$_POST['modId'];
		}

		if (isset($_POST['langId'])) {
			$langId=$_POST['langId'];
		}

		for($i=0;$i<count($dbModules);$i++)
		{
			$modSet[($i+2)]=$dbModules[$i]['modTitle'];
		}
		for($i=0;$i<count($dbLangSet);$i++)
		{
			$langSet[($i+2)]=$dbLangSet[$i]['label']." (".$dbLangSet[$i]['language_code'].")";
		}

		$form->formMap['modId']['options']=$modSet;
		$form->formMap['modId']['value']=$modId;

		$form->formMap['langId']['options']=$langSet;
		$form->formMap['langId']['value']=$langId;

		$modName="";
		if($modId>1)
			$modName=$dbModules[($modId-2)]['modName'];
		elseif($modId==1)
			$modName="[All]";

		$langCode="";
		if($langId>1)
			$langCode=$dbLangSet[($langId-2)]['language_code'];
		elseif($langId==1)
			$langCode="[All]";

		$searchResult=$appDb->getPhraseList($modName, $langCode);
		$tsvResult=$phrase->getTsvTable($searchResult);

		$form->setValue('outputString',$tsvResult);

		return array(
			'dataList' => $searchResult,
			'form' => $form,
		);

	}

	public function listPhrasesEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new PhraseForm();
		$form->setUrl($GLOBALS['curUrl']);

		$form->formMap['outputString']['label']="Output - TSV table with phrases:";
		$dbModules=$appDb->getCoreLangModSet();
		$dbLangSet=$appDb->getLanguageSet();

		$modSet[0]="[None chosen]";
		$langSet[0]="[None chosen]";
		$modSet[1]="[All chosen]";
		$langSet[1]="[All chosen]";
		$modId=0;
		$langId=0;

		$phrase = new Phrase();

		if (isset($_POST['modId'])) {
			$modId=$_POST['modId'];
		}

		if (isset($_POST['langId'])) {
			$langId=$_POST['langId'];
		}

		for($i=0;$i<count($dbModules);$i++)
		{
			$modSet[($i+2)]=$dbModules[$i]['modTitle'];
		}
		for($i=0;$i<count($dbLangSet);$i++)
		{
			$langSet[($i+2)]=$dbLangSet[$i]['label']." (".$dbLangSet[$i]['language_code'].")";
		}

		$form->formMap['modId']['options']=$modSet;
		$form->formMap['modId']['value']=$modId;

		$form->formMap['langId']['options']=$langSet;
		$form->formMap['langId']['value']=$langId;

		$modName="";
		if($modId>1)
			$modName=$dbModules[($modId-2)]['modName'];
		elseif($modId==1)
			$modName="[All]";

		$langCode="";
		if($langId>1)
			$langCode=$dbLangSet[($langId-2)]['language_code'];
		elseif($langId==1)
			$langCode="[All]";

		$dataList=$appDb->getPhraseList($modName, $langCode);

		$typeSet=$phrase->getTypeSet();		

		return array(
			'dataList' => $dataList,
			'form' => $form,
			'typeSet' => $typeSet,
		);
	}

	public function addPhraseEvent()
	{

		$id = 0;

		$messages=array();
		$modConfig=$this->modConfig;

		$form = new PhraseForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$phrase = new Phrase();
		$phrase->id = $id; 

		$dbLangSet=$appDb->getLanguageSet();
		$langOptions = $phrase->getLangOptions($dbLangSet);

		$form->formMap['langCode']['options']=$langOptions;
		$form->formMap['langCode']['value']=$GLOBALS['langCode'];

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();
				$phrase->convertFormData($formData);

				$appDb->savePhrase($phrase);

				$url=$GLOBALS['baseUrl'].'/'.$GLOBALS['modPath'].'/list-phrases';
				$this->redirect($url, false);

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function editPhraseEvent()
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

		$form = new PhraseForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$phrase = new Phrase();
		$phrase->id = $id; 

		$dbLangSet=$appDb->getLanguageSet();
		$langOptions = $phrase->getLangOptions($dbLangSet);

		$form->formMap['langCode']['options']=$langOptions;

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();
				$phrase->convertFormData($formData);

				$appDb->savePhrase($phrase);
			}
			else{
				$form->setErrorMessages();
			}

		}
		else{
			$phraseData = $appDb->getPhraseDetails($id);
			if(count($phraseData)>0){
				$form->convertDbData($phraseData);
			}
			else{
				$id=0;
				$messages[]="Phrase id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function deletePhraseEvent()
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

		$phrase = new Phrase();
		$phrase->id = $id; 
		$phraseData = $appDb->getPhraseDetails($id);
		if(count($phraseData)>0){
			$phrase->convertDbData($phraseData);
		}
		else{
			$id = 0;
			$messages[]="Phrase id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deletePhrase($id);
			}
		}

		$typeSet=$phrase->getTypeSet();		

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $phrase,
			'deleted' => $deleted,
			'typeSet' => $typeSet,
		);

	}

	public function manageLanguageFileEvent()
	{

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$phrase = new Phrase();
		$content="";

		$fileSize=0;
		$amountOfQueries=0;

		if( isset($_POST['process']) ) {

		  $pageStatus="step1";

			if(isset($_POST['process']) && $_FILES['userfile']['size'] > 0){

				$fileName = $_FILES['userfile']['name'];
				$tmpName  = $_FILES['userfile']['tmp_name'];
				$fileSize = $_FILES['userfile']['size'];
				$fileType = $_FILES['userfile']['type'];

				$fp      = fopen($tmpName, 'r');
				$content = fread($fp, filesize($tmpName));

				fclose($fp);

			}

			$installData['tablePrefix']=$appDb->tablePrefix;
			$installData['needle']="mod_";
			$installData['needle2']="core_";

			$sqlSet=$phrase->getSqlSet($content,$installData);

			$amountOfQueries=count($sqlSet);

			$appDb->makeQueries($sqlSet);

		}else{
			$pageStatus="initial-form";
			$sqlSet=array();

		}

		return array(
			'pageStatus' => $pageStatus,
			'fileSize' => $fileSize,
			'amountOfQueries' => $amountOfQueries,
			'content' => $content,
		);

	}

	public function listRelationsEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$form = new RelationForm();
		$form->setUrl($GLOBALS['curUrl']);

		$dbModules=$appDb->getRelLangModSet();
		$dbLangSet=$appDb->getLanguageSet();

		$modSet[0]="[None chosen]";
		$langSet[0]="[None chosen]";
		$modSet[1]="[All chosen]";
		$langSet[1]="[All chosen]";
		$modId=0;
		$langId=0;
		$modId=1;
		$langId=1;

		if (isset($_POST['modId'])) {
			$modId=$_POST['modId'];
		}

		if (isset($_POST['langId'])) {
			$langId=$_POST['langId'];
		}

		for($i=0;$i<count($dbModules);$i++)
		{
			$modSet[($i+2)]=$dbModules[$i]['modTitle'];
		}
		for($i=0;$i<count($dbLangSet);$i++)
		{
			$langSet[($i+2)]=$dbLangSet[$i]['label']." (".$dbLangSet[$i]['language_code'].")";
		}

		$form->formMap['modId']['options']=$modSet;
		$form->formMap['modId']['value']=$modId;

		$form->formMap['langId']['options']=$langSet;
		$form->formMap['langId']['value']=$langId;

		$modName="";
		if($modId>1)
			$modName=$dbModules[($modId-2)]['modName'];
		elseif($modId==1)
			$modName="[All]";

		$langCode="";
		if($langId>1)
			$langCode=$dbLangSet[($langId-2)]['language_code'];
		elseif($langId==1)
			$langCode="[All]";

		$dataList=$appDb->getRelationList($modName, $langCode);

		return array(
			'dataList' => $dataList,
			'form' => $form,
		);

	}

	public function listPagesEvent()
	{

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;

		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$pageList = $appDb->getAllPagesList();	

		return array(
			'pageList' => $pageList,
		);

	}

	public function addRelationEvent()
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

		$form = new RelationForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$relation = new Relation();
		$relation->id = 0; 

		$dbLangSet=$appDb->getLanguageSet();
		$langOptions = $relation->getLangOptions($dbLangSet);

		$pageList = $appDb->getAllPagesList();	
		$pageOptions = $relation->getPageOptions($pageList);

		$pageDetails = $appDb->getPageDetails($id);

		$form->formMap['parentId']['options']=$pageOptions;
		$form->formMap['langCode']['options']=$langOptions;

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

				$formData=$form->getData();
				$relation->convertFormData($formData);
				$relation->childId = $id; 
				$relation->modName = "Page"; 
				$relation->type = "page"; 
				$relation->path = "page/view"; 

				$appDb->saveRelation($relation);

				$url=$GLOBALS['baseUrl'].'/'.$GLOBALS['modPath'].'/list-pages';
				$this->redirect($url, false);

		}
		else{
			if(count($pageDetails)>0){
			}
			else{
				$id=0;
				$messages[]="Page id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'form' => $form,
			'pageDetails' => $pageDetails,
			'messages' => $messages,
		);

	}

	public function editRelationEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$messages=array();

		$form = new RelationForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$relation = new Relation();
		$relation->id = $id;

		$dbLangSet=$appDb->getLanguageSet();
		$langOptions = $relation->getLangOptions($dbLangSet);

		$pageList = $appDb->getAllPagesList();	
		$pageOptions = $relation->getPageOptions($pageList);

		$pageDetails = $appDb->getPageDetails($id);

		$form->formMap['parentId']['options']=$pageOptions;
		$form->formMap['childId']['options']=$pageOptions;
		$form->formMap['langCode']['options']=$langOptions;

		if (isset($_POST['save'])) {

			$form->updateForm();

			$formData=$form->getData();
			$relation->convertFormData($formData);

			$appDb->saveRelation($relation);

		}
		else{
			$relData = $appDb->getRelationDetails($id);
			if(count($relData)>0){
				$form->convertDbData($relData);
			}
			else{
				$id=0;
				$messages[]="Relation id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);

	}

	public function deleteRelationEvent()
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

		$relation = new Relation();

		$relation->id = $id; 
		$relationData = $appDb->getRelationDetails($id);
		if(count($relationData)>0){
			$relation->convertDbData($relationData);
		}
		else{
			$id = 0;
			$messages[]="Relation id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteRelation($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $relation,
			'relationData' => $relationData,
			'deleted' => $deleted,
		);

	}

}