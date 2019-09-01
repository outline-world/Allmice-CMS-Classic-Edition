<?php 
/*
 * Menu module for Allmice™ CMS
 * Version 1.6.4 (2019-08-31)
 * Copyright 2017 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * Menu module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include "core/includes/Model/"."DatabaseCms.php";
include $pathModuleModel."AppDatabase.php";
include $pathModuleModel."Menu.php";
include $pathModuleModel."MenuForm.php";
include $pathModuleModel."MenuItem.php";

class MenuController extends Controller
{

	public $dbConfig;
	public $otherConfig;
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

	public function viewEvent()
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
		$menuId = $id;

		$menuData=$appDb->getMenuData($menuId);

		if(isset($menuData['title']) && $menuData['title']!=""){
			$GLOBALS['pageTitle']=$menuData['title'];
		}

		$itemList=$appDb->getActiveMenuItemList($menuId);
		$menu = new Menu();

		$menu->convertDbData($menuData);
		$menuCode="";

		if($menu->type>=10 && $menu->type<20){

			$menuCode=$menu->buildHorizontalMenu($menu->code,$itemList,$menu->title,"");
		}
		elseif($menu->type>=20 && $menu->type<23){

			$menuCode=$menu->buildVerticalMenu($menu->code,$itemList,$menu->title,"");
		}
		elseif($menu->type>=23 && $menu->type<25){

			$menuCode=$menu->buildActiveSubmenu($menu->code,$itemList,$menu->title,"");
		}
		elseif($menu->type>=30 && $menu->type<35){

			$menuCode=$menu->buildLinkSet($menu->code,$itemList,$menu->title,"",$menu->type);
		}
		elseif($menu->type>=35 && $menu->type<40){

			$menuCode=$menu->buildLinkSet2($menu->code,$itemList,$menu->title,"",$menu->type);
		}
		else{

		}

		return array(
			'menuCode' => $menuCode,
		);

	}

	public function listMenusEvent()
	{

		$modConfig=$this->modConfig;
		$form = new MenuForm();

		$formMap=$form->formMap;
		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getMenuList();
		$totalMenus=count($dataList);	

		for($i=0;$i<$totalMenus;$i++){
			$dataList[$i]['statusString']=$formMap['status']['options'][($dataList[$i]['status'])];
			$dataList[$i]['typeString']=$formMap['type']['options'][($dataList[$i]['type'])];
		}

		return array(
			'dataList' => $dataList,
		);

	}

	public function addMenuEvent()
	{
		$modConfig=$this->modConfig;

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$form = new MenuForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$roleList=$appDb->getRoleOptions();
		$form->formMap['roleAccess']['options']=$roleList;
		$form->formMap['caching']['options']=$roleList;

		$menu = new Menu();
		$menu->id = 0; 

		$cacheData['period']=$modConfig['cachePeriod'];
		$menu->cacheData = $cacheData; 

		$saved=false;

		if (isset($_POST['saveMenu'])) {

			if (isset($_SESSION[$siteId]['userData']['id'])){
				$menu->userId=$_SESSION[$siteId]['userData']['id'];
			}

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();
				$menu->convertFormData($formData);

				$form->formMap['roleAccess']['value']=$_POST['roleAccess'];
				$menu->roleAccess=$_POST['roleAccess'];

				if(isset($_POST['caching'])){
					$form->formMap['caching']['value']=$_POST['caching'];
					$menu->cachingRoles=$_POST['caching'];
				}
				else{
					$form->formMap['caching']['value']=array();
					$menu->cachingRoles=array();
				}
				$resData['modName']=$GLOBALS['modName'];
				$resData['specName']=$menu->code;
				$resData['uri']="/menu/view/";

				$menu->id=$appDb->saveMenu($menu,$resData);

				$saved=true;

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'form' => $form,
			'menu' => $menu,
			'saved' => $saved,
		);

	}

	public function editMenuEvent()
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
		$siteId=$Other['siteId'];

		$form = new MenuForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$roleList=$appDb->getRoleOptions();
		$form->formMap['roleAccess']['options']=$roleList;

		$form->formMap['caching']['options']=$roleList;

		$menu = new Menu();
		$menu->id = $id; 

		$cacheData['period']=$modConfig['cachePeriod'];
		$menu->cacheData = $cacheData; 

		if (isset($_POST['saveMenu'])) {

			if (isset($_SESSION[$siteId]['userData']['id'])){
				$menu->userId=$_SESSION[$siteId]['userData']['id'];
			}

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {

				$formData=$form->getData();
				$menu->convertFormData($formData);

				if(!isset($_POST['roleAccess']))
					$_POST['roleAccess']=array();
				$form->formMap['roleAccess']['value']=$_POST['roleAccess'];
				$menu->roleAccess=$_POST['roleAccess'];

				if(!isset($_POST['caching']))
					$_POST['caching']=array();
				$form->formMap['caching']['value']=$_POST['caching'];
				$menu->cachingRoles=$_POST['caching'];

				$resData['modName']=$GLOBALS['modName'];
				$resData['specName']=$menu->code;
				$resData['uri']="/menu/view/";

				if($menu->type<100)
					$resData['type']=3;
				else
					$resData['type']=2;

				$menu->roleAccess=$_POST['roleAccess'];
				$menu->cachingRoles=$_POST['caching'];
				$form->formMap['roleAccess']['value']=$_POST['roleAccess'];
				$appDb->saveMenu($menu,$resData);

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

			$menuData = $appDb->getMenuDetails($id);
			if(count($menuData)>0){
				$accessData = array(1);
				$accessData = $appDb->getAccessRoleIdSet($id);
				$cachingData = $appDb->getCachingRoleIdSet($id);
				$form->convertDbData($menuData);
				$form->setValue('roleAccess',$accessData);
				$form->setValue('caching',$cachingData);
			}else{
				$id=0;
			}

		}

		return array(
			'id' => $id,
			'form' => $form,
		);

	}

	public function deleteMenuEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$menu = new Menu();
		$menu->id = $id; 
		$menuData = $appDb->getMenuDetails($id);
		if(count($menuData)>0)
			$menu->convertDbData($menuData);
		else
			$id = 0;

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteMenu($id);
			}

		}

		return array(
			'id'    => $id,
			'item' => $menu,
			'deleted' => $deleted,
		);

	}

	public function listMenuItemsEvent()
	{

		$menuId=0;
		if(isset($GLOBALS['urlParts'][2])){
			$menuId = $GLOBALS['urlParts'][2];
			$menuId=(int)$menuId;
			if(!is_integer($menuId))
				$menuId=0;
		}

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$listOptions = $appDb->getMenuListOptions();	

		$form = new MenuForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->formMap['menuList']['options']=$listOptions;

		if(isset($_POST['menuList'])){
			$menuId=$_POST['menuList'];

		}
		$form->formMap['menuList']['value']=$menuId;

		if($menuId==0)
			$dataList = $appDb->getAllMenuItems();
		else	
			$dataList = $appDb->getMenuItemList($menuId);

		return array(
			'dataList' => $dataList,
			'form' => $form,
			'menuId' => $menuId,
		);

	}

	public function addMenuItemEvent()
	{

		$menuId=0;
		if(isset($GLOBALS['urlParts'][2])){
			$menuId = $GLOBALS['urlParts'][2];
			$menuId=(int)$menuId;
			if(!is_integer($menuId))
				$menuId=0;
		}

		$modConfig=$this->modConfig;

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$form = new MenuForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$dataList = $appDb->getMenuItemList($menuId);	

		$menuItem = new MenuItem();
		$menuItem->menuId = $menuId;

		$itemList=$appDb->getMenuItemList($menuItem->menuId);
		$parentMap=$menuItem->getParentMap($itemList);

		$menuDetails=$appDb->getMenuDetails($menuItem->menuId);

		$form->formMap['parentId']['options']=$parentMap;

		if (isset($_POST['saveMenuItem'])) {

			if (isset($_SESSION[$siteId]['userData']['id'])){
				$menuItem->userId=$_SESSION[$siteId]['userData']['id'];
			}

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {
				$formData=$form->getData();
				$menuItem->convertFormData($formData);
				$menuItem->menuId = $menuId; 
				$menuItem->depth = 1; 

				$parentData=$appDb->getParentItemData($menuItem);

				$menuItem->depth = $parentData['depth']+1; 

				$appDb->saveMenuItem($menuItem);
				$appDb->buildOrderCode($menuItem->menuId);

				$url=$GLOBALS['baseUrl']."/menu/list-menu-items/".$menuId;
				$this->redirect($url, false);

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'form' => $form,
			'menuId' => $menuId,
			'menuDetails' => $menuDetails,
		);

	}

	public function editMenuItemEvent()
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
		$siteId=$Other['siteId'];

		$form = new MenuForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$menuItem = new MenuItem();
		$menuItem->id = $id;

		if (isset($_POST['saveMenuItem'])) {

			if (isset($_SESSION[$siteId]['userData']['id'])){
				$menuItem->userId=$_SESSION[$siteId]['userData']['id'];
			}

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),array());

			if ($form->isValid) {
				$formData=$form->getData();
				$menuItem->convertFormData($formData);

				$parentData=$appDb->getParentItemData($menuItem);

				$menuItem->depth = $parentData['depth']+1; 

				$appDb->saveMenuItem($menuItem);
				$appDb->buildOrderCode($menuItem->menuId);
			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

			$menuItemData = $appDb->getMenuItemDetails($id);
			if(count($menuItemData)>0){
				$form->convertDbData($menuItemData);
				$menuItem->convertDbData($menuItemData);
			}else{
				$menuItem->id = 0;
			}
		}

		if(isset($menuItem->id) && $menuItem->id!=0){
			$menuDetails=$appDb->getMenuDetails($menuItem->menuId);
			$itemList=$appDb->getMenuItemList($menuItem->menuId);

			$parentMap=$menuItem->getParentMap($itemList);

			$form->formMap['parentId']['options']=$parentMap;

			$menuId = $menuItem->menuId;
		}else{
			$menuDetails['title']="";
		}

		return array(
			'id' => $id,
			'form' => $form,
			'menuItem' => $menuItem,
			'menuDetails' => $menuDetails,
		);

	}

	public function deleteMenuItemEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$menuItem = new MenuItem();
		$menuItem->id = $id; 
		$menuItemData = $appDb->getMenuItemDetails($id);

		if(count($menuItemData))
			$menuItem->convertDbData($menuItemData);
		else
			$id = 0;

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			if ($del == 'Yes') {
				$deleted=$appDb->deleteMenuItem($id);
			}
		}

		return array(
			'id'    => $id,
			'item' => $menuItem,
			'deleted' => $deleted,
		);

	}

	public function buildModuleMenuEvent()
	{

		$modConfig=$this->modConfig;

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$form = new MenuForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$modId=0;
		if (isset($_POST['modId']))
			$modId=$_POST['modId'];

		$dbModules=$appDb->getModuleSet();

		$modSet[0]="All modules";

		for($i=0;$i<count($dbModules);$i++)
		{
			$modSet[($i+1)]=$dbModules[$i]['module_name'];
		}
		$form->formMap['modId']['options']=$modSet;
		$form->formMap['modId']['value']=$modId;

		$roleId=1;
		$sqlWhere="";
		$sqlWhere.=" AND p.role_id = ".$roleId."";
		if($modId>0){
			$sqlWhere.=" AND r.module_name = '".$modSet[($modId)]."'";
		}

		$resSet = $appDb->getModuleResourceSet($sqlWhere);

		$saved=false;
		$menu = new Menu();

		if (isset($_POST['save']) || isset($_POST['modId'])) {

			if (isset($_SESSION[$siteId]['userData']['id'])){
				$userId=$_SESSION[$siteId]['userData']['id'];
			}

			$form->updateForm();

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

					$modId=$i+1;
				}
			}
		}

		if (isset($_POST['save'])) {
			$saved=true;

			$formData=$form->getData();
			$menu->id=$appDb->saveLocalMenuSet($resSet,$userId);

			$menuData = $appDb->getMenuDetails($menu->id);
			$menu->convertDbData($menuData);

		}

		return array(
			'form' => $form,
			'resList' => $resSet,
			'menu' => $menu,
			'saved' => $saved,
		);

	}

}