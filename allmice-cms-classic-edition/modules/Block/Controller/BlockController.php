<?php 
/*
 * Block module for Allmice™ CMS
 * Version 1.6.4 (2019-08-31)
 * Copyright 2017 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * Block module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include "core/includes/Model/"."DatabaseCms.php";
include $pathModuleModel."AppDatabase.php";
include $pathModuleModel."Block.php";
include $pathModuleModel."BlockForm.php";

class BlockController extends Controller
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

	public function listBlocksEvent()
	{

		$modConfig=$this->modConfig;
//		$optionMap=$modConfig['optionMap'];
		$optionMap=$ModConfig['optionMap'] = array(
			0 => "No - block is not cacheable",
			1 => "Yes - block is cacheable",
		);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getBlockList();	

		return array(
			'dataList' => $dataList,
			'optionMap' => $optionMap,
		);

	}

	public function addEvent()
	{

		$modConfig=$this->modConfig;

		$form = new BlockForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$block = new Block();
		$block->id = 0; 

		$roleList=$appDb->getRoleOptions();

		$langOptions=$appDb->getLangOptions();
		if(count($langOptions)>0){
			$form->formMap['languageCode']['options']=$langOptions;
		}

		$form->formMap['roleAccess']['options']=$roleList;
		$form->formMap['caching']['options']=$roleList;

		$cacheData['period']=$modConfig['cachePeriod'];
		$block->cacheData = $cacheData; 

		if (isset($_POST['save'])) {

			$form->updateForm();
			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();
				$block->convertFormData($formData);

				if(isset($_POST['roleAccess'])){
					$form->formMap['roleAccess']['value']=$_POST['roleAccess'];
					$block->roleAccess=$_POST['roleAccess'];
				}
				else{
					$form->formMap['roleAccess']['value']=array();
					$block->roleAccess=array();
				}
				if(isset($_POST['caching'])){
					$form->formMap['caching']['value']=$_POST['caching'];
					$block->cachingRoles=$_POST['caching'];
				}
				else{
					$form->formMap['caching']['value']=array();
					$block->cachingRoles=array();
				}

				$resData['modName']=$GLOBALS['modName'];
				$resData['specName']=$block->blockCode;
				$resData['uri']="/block/view/";
				$resData['type']=40;
				$appDb->saveBlock($block,$resData);
				$url=$GLOBALS['baseUrl']."/block/list-blocks";
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

		$modConfig=$this->modConfig;

		$form = new BlockForm();

		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$block = new Block();
		$block->id = $id; 

		$roleList=$appDb->getRoleOptions();

		$langOptions=$appDb->getLangOptions();
		if(count($langOptions)>0){
			$form->formMap['languageCode']['options']=$langOptions;
		}

		$form->formMap['roleAccess']['options']=$roleList;
		$form->formMap['caching']['options']=$roleList;

		$cacheData['period']=$modConfig['cachePeriod'];

		$block->cacheData = $cacheData; 

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());
			if ($form->isValid) {

				$formData=$form->getData();
				$block->convertFormData($formData);

				if(isset($_POST['roleAccess'])){
					$form->formMap['roleAccess']['value']=$_POST['roleAccess'];
					$block->roleAccess=$_POST['roleAccess'];
				}else{
					$form->formMap['roleAccess']['value']=array();
					$block->roleAccess=$_POST['roleAccess']=array();
				}

				if(isset($_POST['caching'])){
					$form->formMap['caching']['value']=$_POST['caching'];
					$block->cachingRoles=$_POST['caching'];
				}else{
					$form->formMap['caching']['value']=array();
					$block->cachingRoles=array();
				}

				$resData['modName']=$GLOBALS['modName'];
				$resData['specName']=$block->blockCode;
				$resData['uri']="/block/view/";
				$resData['type']=40;
				$appDb->saveBlock($block,$resData);
			}
			else{
				$form->setErrorMessages();

			}

		}
		else{
			$blockData = $appDb->getBlockDetails($id);
			if(count($blockData)>0){
				$form->convertDbData($blockData);
				$accessData = $appDb->getAccessRoleIdSet($id);
				$cachingData = $appDb->getCachingRoleIdSet($id);
				$form->setValue('roleAccess',$accessData);
				$form->setValue('caching',$cachingData);
			}
			else{
				$id=0;
				$messages[]="Block id is not correct.";
			}
		}

		return array(
			'id' => $id,
			'messages' => $messages,
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

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$block = new Block();
		$block->id = $id; 
		$blockData = $appDb->getBlockDetails($id);
		if(count($blockData)>0){
			$block->convertDbData($blockData);
		}
		else{
			$id = 0;
			$messages[]="Block id is not correct.";
		}

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteBlock($id);
			}
		}

		return array(
			'id'    => $id,
			'messages' => $messages,
			'item' => $block,
			'deleted' => $deleted,
		);

	}

}