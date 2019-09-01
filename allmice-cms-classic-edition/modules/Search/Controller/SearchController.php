<?php 
/*
 * Search module for Allmice™ CMS
 * Version 1.6.4 (2019-08-31)
 * Copyright 2017 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * Search module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";

if(isset($GLOBALS['urlParts'][1]) && strstr($GLOBALS['urlParts'][1],"list-by-type")){
	include $pathCoreModel."SimpleForm.php";
	include $pathModuleModel."SearchSimpleForm.php";
}
else{
	include $pathCoreModel."Form.php";
	include $pathModuleModel."SearchForm.php";
}

include "core/includes/Model/"."DatabaseCms.php";
include "core/includes/Model/"."PaginatorCms.php";

include $pathModuleModel."AppDatabase.php";
include $pathModuleModel."Search.php";

class SearchController extends Controller
{

	public $dbConfig;
	public $modConfig;
	public $otherConfig;

	public function indexEvent()
	{

		$id = 1;

		$dbFields="";
		$searchResult=array();

		$form = new SearchForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$activeRole=$appDb->getActiveRole($userId);

		$configData=array();

		if (isset($_POST['searchType'])) {
			$form->updateForm();
			$formData=$form->getData();
			$id=$formData['searchType'];

		}

		$search = new Search();
		$search->id = $id; 

		$typeData = $appDb->getTypeDetails($id);

		$accessRight = $appDb->getAccessRight($typeData['uri'], $activeRole);

		$fieldTitles=array();
		$paginator = new PaginatorCms; 

		$formData=$appDb->getSearchFormData();

		foreach ($formData as $row) {
			$searchOptions[($row['id'])] = $row['title'];
		}
		$form->formMap['searchType']['options']=$searchOptions;

		if (isset($_POST['search']) || isset($_POST['paginPage'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				$search->convertFormData($formData);

				$dataTable=$typeData['search_table'];

				$allFields=$typeData['result_field_names'];
				$fieldTitles=explode(", ",$typeData['result_field_titles']);

				$searchField=$typeData['search_table_field'];
				$search->uri=$typeData['uri'];

				$searchPhrase=(isset($formData['searchPhrase'])) ? $formData['searchPhrase'] : '';
				$searchPhrase=str_replace("*","%",$searchPhrase);

//Function adjustSearchString adds functionality, where:
//   * Search strings within quotes or double quotes will be considered as exact keywords (space part of the keyword).
//   * Otherwise space character " " will be considered the same as MySQL wild character "%".
				$searchPhrase=$search->adjustSearchString($searchPhrase);
				$searchPhrase=htmlentities($searchPhrase);

				$whereClause="";
				$whereClause=$typeData['add_where_clause'];
				$whereClause=str_replace("&amp;#39;","'",$typeData['add_where_clause']);

				$searchData['dataTable']=$dataTable;
				$searchData['allFields']=$allFields;
				$searchData['searchField']=$searchField;
				$searchData['searchPhrase']=$searchPhrase;
				$searchData['whereClause']=$whereClause;
				$searchData['orderClause']=$typeData['order_clause'];
				$otherData['uri']=$search->uri;

				$otherData['activeRole']=$activeRole;

				$searchResult=$paginator->getPageData($appDb, $searchData, $otherData);

				$dbFields=str_replace("[title:]","",$allFields);
				$dbFields=str_replace("[result:]","",$dbFields);
			}
			else{
				$formData=$form->getData();
				$search->convertFormData($formData);
				$form->setErrorMessages();
			}
			$whereClauseEnd="";
			$configData=$appDb->getConfigData($whereClauseEnd);

		}
		else{
			$search->convertFormData($typeData);

			if(count($typeData)>0){
				$search->id=$typeData['id'];
				$search->searchType=$typeData['id'];

			}
			else{
				$id=0;
			}

		}

		return array(
			'search' => $search,
			'form' => $form,
			'resultList' => $searchResult,
			'typeData' => $typeData,
			'fieldList' => explode(", ",$dbFields),
			'fieldTitles' => $fieldTitles,
			'paginator' => $paginator,
			'accessRight' => $accessRight,
			'lang' => $GLOBALS['localLang']['other'],
			'configData' => $configData,
		);

	}

	public function listByTypeEvent()
	{

		$id = 1;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$dbFields="";
		$searchResult=array();

		$form = new SearchSimpleForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$activeRole=$appDb->getActiveRole($userId);

		$search = new Search();
		$search->id = $id; 

		$typeData = $appDb->getTypeDetails($id);
		if(count($typeData)>0){
			$accessRight = $appDb->getAccessRight($typeData['uri'], $activeRole);
		}
		else{
			$id=0;
			$accessRight=false;
		}

		$fieldTitles=array();
		$paginator = new PaginatorCms; 

		$configData=array();

		if (isset($_POST['search']) || isset($_POST['paginPage'])) {
			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {
				$formData=$form->getData();
				$search->convertFormData($formData);

				$search->searchType=$id;

				$dataTable=$typeData['search_table'];

				$allFields=$typeData['result_field_names'];
				$fieldTitles=explode(", ",$typeData['result_field_titles']);

				$searchField=$typeData['search_table_field'];
				$search->uri=$typeData['uri'];

				$searchPhrase=(isset($formData['searchPhrase'])) ? $formData['searchPhrase'] : '';
				$searchPhrase=str_replace("*","%",$searchPhrase);

//Function adjustSearchString adds functionality, where:
//   * Search strings within quotes or double quotes will be considered as exact keywords (space part of the keyword).
//   * Otherwise space character " " will be considered the same as MySQL wild character "%".
				$searchPhrase=$search->adjustSearchString($searchPhrase);
				$searchPhrase=htmlentities($searchPhrase);

				$whereClause="";
				$whereClause=$typeData['add_where_clause'];
				$whereClause=str_replace("&amp;#39;","'",$typeData['add_where_clause']);

				$searchData['dataTable']=$dataTable;
				$searchData['allFields']=$allFields;
				$searchData['searchField']=$searchField;
				$searchData['searchPhrase']=$searchPhrase;
				$searchData['whereClause']=$whereClause;
				$searchData['orderClause']=$typeData['order_clause'];
				$otherData['uri']=$search->uri;

				$otherData['activeRole']=$activeRole;

				$searchResult=$paginator->getPageData($appDb, $searchData, $otherData);

				$dbFields=str_replace("[result:]","",$allFields);

			}
			else{
				$search->searchType=$id;
				$form->setErrorMessages();
			}
		}
		else{
			$search->convertFormData($typeData);

			if(count($typeData)>0){
				$search->id=$typeData['id'];
				$search->searchType=$typeData['id'];
				$form->setValue("id",$typeData['id']);
				$form->setValue("searchType",$typeData['id']);

			}
			else{
				$id=0;
			}

		}

		$whereClauseEnd="";
		$configData=$appDb->getConfigData($whereClauseEnd);
		$GLOBALS['viewPath']=$configData['listByTypeEvent']['viewPath'];

		return array(
			'search' => $search,
			'form' => $form,
			'resultList' => $searchResult,
			'typeData' => $typeData,
			'fieldList' => explode(", ",$dbFields),
			'fieldTitles' => $fieldTitles,
			'paginator' => $paginator,
			'accessRight' => $accessRight,
			'lang' => $GLOBALS['localLang']['other'],
			'configData' => $configData,
		);

	}

	public function addTypeEvent()
	{

		$modConfig=$this->modConfig;

		$form = new SearchForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$search = new Search();
		$search->id = 0; 

		if (isset($_POST['save'])) {

			$form->updateForm();
			$formData=$form->getData();
			$search->convertFormData($formData);

			$appDb->saveSearchType($search);
			$url=$GLOBALS['baseUrl']."/search/list-types";
			$this->redirect($url, false);

		}

		return array(
			'form' => $form,
		);

	}

	public function editTypeEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$messages=array();
		$form = new SearchForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$search = new Search();

		if (isset($_POST['save'])) {

			$form->updateForm();
			$formData=$form->getData();
			$search->convertFormData($formData);

			$search->id=$id;

			$appDb->saveSearchType($search);
		}
		else{
			$typeData = $appDb->getTypeDetails($id);

			if(count($typeData)>0){
				$form->convertDbData($typeData);

			}
			else{
				$id=0;
				$messages[]="Search type id is not correct.";
			}

		}

		return array(
			'id' => $id,
			'messages' => $messages,
			'form' => $form,
		);
	}

	public function deleteTypeEvent()
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

		$search = new Search();
		$search->id = $id; 
		$searchData = $appDb->getTypeDetails($id);
		if(count($searchData)>0){
			$search->convertDbData($searchData);
		}
		else{
			$id = 0;
			$messages[]="Search type id is not correct.";
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
			'item' => $search,
			'deleted' => $deleted,
		);
	}

	public function listTypesEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getSearchFormData();	

		return array(
			'dataList' => $dataList,
		);

	}

}