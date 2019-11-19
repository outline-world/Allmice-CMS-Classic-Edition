<?php 
/*
 * Form Field module for Allmice™ CMS
 * Version 1.7.1 (2019-10-27)
 * Copyright 2017 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * Form Field module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include "core/includes/Model/"."DatabaseCms.php";
include $pathModuleModel."AppDatabase.php";
include $pathModuleModel."Field.php";
include $pathModuleModel."FieldForm.php";

class FormFieldController extends Controller
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

	public function listFieldsEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getFieldList();	

		return array(
			'dataList' => $dataList,
		);

	}

	public function addEvent()
	{

		$form = new FieldForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$field = new Field();
		$field->id = 0; 

		if (isset($_POST['submit1'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {
				$formData=$form->getData();
				$field->convertFormData($formData);
				$appDb->saveField($field);

				$url=$GLOBALS['baseUrl']."/form-field/list-fields";
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

	public function editEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}
		$messages=array();

		$form = new FieldForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$field = new Field();
		$field->id = $id; 

		if (isset($_POST['submit1'])) {
			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {
				$formData=$form->getData();
				$field->convertFormData($formData);
				$appDb->saveField($field);
			}
			else{
				$form->setErrorMessages();
			}
		}
		else{
			$formData = $appDb->getFieldDetails($id);
			$form->convertDbData($formData);
		}

		return array(
			'id' => $id,
			'form' => $form,
		);

	}

	public function deleteEvent()
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

		$field = new Field();
		$field->id = $id; 
		$fieldData = $appDb->getFieldDetails($id);
		if(count($fieldData)>0){
			$field->convertDbData($fieldData);
		}
		else{
			$id = 0;
			$messages[]="Item id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteField($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $field,
			'deleted' => $deleted,
		);

	}

}