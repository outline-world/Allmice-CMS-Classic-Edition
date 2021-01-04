<?php 
/*
 * Own Page module for Allmice™ CMS
 * Version 1.8.1 (2020-12-26)
 * Copyright 2020 by Adeenas OÜ, Copyright 2017 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Own Page module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php
include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";

if($pageType2!="frontPage")
	include "core/includes/Model/"."DatabaseCms.php";

if(isset($GLOBALS['urlParts'][1]) && strstr($GLOBALS['urlParts'][1],"view")){
	include "modules/Page/Model/Post.php";
	include "core/includes/Model/"."Captcha.php";
}
else{

	if(isset($GLOBALS['urlParts'][1]) && (strstr($GLOBALS['urlParts'][1],"post") || strstr($GLOBALS['urlParts'][1],"snippet"))){
		include $pathModuleModel."ExtraForm.php";
	}
	else{
		include $pathModuleModel."Page.php";
		include $pathModuleModel."UriAlias.php";
		include $pathModuleModel."PageForm.php";
		include $pathModuleModel."MenuItem.php";
	}
}

if(!isset($GLOBALS['urlParts'][1]) || isset($GLOBALS['urlParts'][1]) && (strstr($GLOBALS['urlParts'][1],"view") || strstr($GLOBALS['urlParts'][1],"list"))){
	include "core/includes/Model/"."PaginatorCms.php";
}

include $pathModuleModel."AppDatabase.php";

class OwnPageController extends Controller
{

	public $dbConfig;

	public $modConfig;
	public $otherConfig;

	public function indexEvent()
	{

		$modConfig=$this->modConfig;

		$pageForm = new PageForm();
		$pageForm->setUrl($GLOBALS['curUrl']);

		$pageForm->formMap['person_type']['attributes']['onchange']='this.form.submit()';
		$statusMap[1]=$GLOBALS['localLang']['other']['statusOption1'];
		$statusMap[2]=$GLOBALS['localLang']['other']['statusOption2'];

		$page = new Page();

		$Database=$this->dbConfig;

		$pageDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$pageList = $pageDb->getOwnPagesList($userId);	

		$tableScript=$page->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'page' => $page,
			'pageList' => $pageList,
			'statusMap' => $statusMap,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function listPagesEvent()
	{

		$modConfig=$this->modConfig;

		$pageForm = new PageForm();
		$pageForm->setUrl($GLOBALS['curUrl']);

		$pageForm->formMap['person_type']['attributes']['onchange']='this.form.submit()';
		$statusMap[1]=$GLOBALS['localLang']['other']['statusOption1'];
		$statusMap[2]=$GLOBALS['localLang']['other']['statusOption2'];

		$page = new Page();

		$Database=$this->dbConfig;

		$pageDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$pageList = $pageDb->getOwnPagesList($userId);	

		$tableScript=$page->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'page' => $page,
			'pageList' => $pageList,
			'statusMap' => $statusMap,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function editPageEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$modConfig=$this->modConfig;
		$itemList=array();

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];

		$form = new PageForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);
		$form->formMap['status']['options'][1]=$GLOBALS['localLang']['other']['statusOption1'];
		$form->formMap['status']['options'][2]=$GLOBALS['localLang']['other']['statusOption2'];
		$form->formMap['botTag']['options'][1]=$GLOBALS['localLang']['other']['botTagOption1'];

		$page = new Page();
		$uriAlias = new UriAlias();
		$page->id = $id;

		$Database=$this->dbConfig;
		$pageDb = new AppDatabase($Database['app_db']);

		$whereClauseEnd=" AND type = 'editPageEvent'";
		$config = $pageDb->getConfigData($whereClauseEnd);
		$form->accessFieldStatus=$config['editPageEvent']['roleAccessSwitch'];
		$form->cacheFieldStatus=$config['editPageEvent']['roleCacheSwitch'];
		$form->botTagStatus=$config['editPageEvent']['botTagSwitch'];

		$roleList=$pageDb->getRoleOptions();

		$form->formMap['roleAccess']['options']=$roleList;
		$form->formMap['caching']['options']=$roleList;

		$ckEditorScript="";
		$ckEditorScript.="<script>\n";
		$ckEditorScript.="CKEDITOR.replace( 'bodyArea' );\n";
		$ckEditorScript.="</script>\n";

		$cacheData['period']=$modConfig['cachePeriod'];
		$page->cacheData = $cacheData; 

		$zeroLabel=$GLOBALS['localLang']['other']['menuOption0'];
		$menuList=$pageDb->getMenuListOptions($zeroLabel);
		$menuId=0;
		$menuItem = new MenuItem();
		$menuItem->menuId = $menuId;
		$form->formMap['menuId']['options']=$menuList;

		$pageData = $pageDb->getOwnPageDetails($id,$_SESSION[$siteId]['userData']['id']);

		if(count($pageData)>0){
			$accessData = $pageDb->getAccessRoleIdSet($id);
			$cachingData = $pageDb->getCachingRoleIdSet($id);

		}

		if (isset($_POST['submit1'])) {

			$form->updateForm();
			if (isset($_POST['bodyArea'])){
				$form->formMap['bodyArea']['value']=$_POST['bodyArea'];
			}

			$form->validation($pageDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$formData=$form->getData();
				if (isset($_POST['bodyArea'])){
					$formData['bodyArea']=$_POST['bodyArea'];
				}

				$page->convertFormData($formData);
				$menuItem->convertFormData($formData);
				$uriAlias->convertFormData($formData);

				if ($form->accessFieldStatus=="off"){
					$page->roleAccess=$accessData;
				}
				elseif(!is_array($formData['roleAccess']) || !isset($formData['roleAccess'])){
					$page->roleAccess=$accessData;
				}

				if ($form->cacheFieldStatus=="off"){
					$page->cachingRoles=$cachingData;
				}
				elseif(!is_array($formData['caching']) || !isset($formData['caching'])){
					$page->cachingRoles=$cachingData;
				}

				$page->userId=0;
				$menuItem->userId=0;
				if (isset($_SESSION[$siteId]['userData']['id'])){
					$page->userId=$_SESSION[$siteId]['userData']['id'];
					$menuItem->userId=$_SESSION[$siteId]['userData']['id'];
				}
				$menuItem->uri=$page->alias;
				$page->edited=time();

				$uriAlias->source="page";
				$uriAlias->depth=substr_count ( $uriAlias->alias , "/" );
				$itemList=$pageDb->getMenuItemList($menuItem->menuId);

				$pageDb->savePage($page,$uriAlias,$menuItem,$config['editPageEvent']);

				if(isset($GLOBALS['aliasProblem'])){
//					$GLOBALS['localLang']['other']['aliasProblem']="Alias is not correct and was not saved. Most common causes for this problem: This alias may already exist for another page or starts with path of an installed module or does not have a leading slash (/) or has many leading slashes.";
					$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"problem-note\">".$GLOBALS['localLang']['other']['aliasProblem']."</div>";
				}
				else{
					if(!isset($GLOBALS['localLang']['other']['submitMessageEnd']))
						$GLOBALS['localLang']['other']['submitMessageEnd']="";
					$messageSet=$GLOBALS['localLang']['other']['submitMessage']." ".date($GLOBALS['timeFormat'],$page->edited).$GLOBALS['localLang']['other']['submitMessageEnd'];
					$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$messageSet."</div>";
				}

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

			if(count($pageData)>0){

				$uriData = $pageDb->getUriDetails($id);
				$botData = $pageDb->getBotAccessLevel($id);

				$pageData['caching']=$cachingData;
				$pageData['alias']=$uriData['alias'];
				$pageData['roleAccess']=$accessData;
				$pageData['botTag']=$botData;

				$form->convertPageDbData($pageData);

				$page->creatorId=$pageData['creatorId'];

				if($uriData['alias']!="")
					$itemData = $pageDb->getMenuItemByUri($uriData['alias']);
				else
					$itemData = $pageDb->getMenuItemByUri(("/page/view/".$id));

				if(count($itemData)>0)
					$form->convertMenuDbData($itemData);
				else
					$itemData['menuId']=0;
				$itemList=$pageDb->getMenuItemList($itemData['menuId']);

				$menuItem->convertDbData($itemData);
			}

		}

		if(isset($pageData) && count($pageData)>0){
			if (isset($_POST['menuId']) && !isset($_POST['submit1'])) {
				$form->updateForm();
				$menuId=$_POST['menuId'];
				$menuItem->menuId = $menuId;
				$itemList=$pageDb->getMenuItemList($menuId);
			}

			$parentMap=$menuItem->getParentMap($itemList);
			$form->formMap['parentId']['options']=$parentMap;
		}

		$ownPage=false;

		if(count($pageData)>0){
			if($pageData['creatorId']==$userId)
				$ownPage=true;
		}
		else
			$id = 0;

		$editorType="plainTextEditor";
		$editorType="ckEditor";

		return array(
			'id' => $id,
			'form' => $form,
			'ckEditorScript' => $ckEditorScript,
			'ownPage' => $ownPage,
			'editorType' => $editorType,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function deletePageEvent()
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

		$page = new Page();
		$page->id = $id; 
		$pageData = $appDb->getPageDetails($id);
		if(count($pageData)>0)
			$page->convertDbData($pageData);
		else
			$id = 0;

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			$deleted=$appDb->deletePage($id);
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$ownPage=false;

		if(count($pageData)>0)
			if($pageData['creatorId']==$userId)
				$ownPage=true;

		return array(
			'id'    => $id,
			'page' => $page,
			'deleted' => $deleted,
			'ownPage' => $ownPage,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function managePostingAccessEvent()
	{
		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$form = new ExtraForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$modConfig=$this->modConfig;
		$form->setValue('postStatus',2);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$pageDetails = $appDb->getPageCutDetails($id);
		if(count($pageDetails)==0)
			$id=0;

		$userId=$_SESSION[($GLOBALS['siteId'])]['userData']['id'];

		$dbData=$appDb->getIntroPostData($id);

		$pageData = $appDb->getOwnPageDetails($id,$_SESSION[($GLOBALS['siteId'])]['userData']['id']);
		if (isset($_POST['save'])) {

			if(count($dbData)>0){
					$dbData['sqlType']="update";
			}
			else{
					$dbData['sqlType']="insert";
			}
			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			if ($form->isValid) {

				$postData=$form->getData();
				$postData['pageId']=$id;
				$postData['sqlType']=$dbData['sqlType'];

				$postData['type']=20;
				if(isset($_POST['postingAccess'])){
					$postData['type']=21;
				}

				$Other=$this->otherConfig;
				$siteId=$Other['siteId'];
				$userId=$_SESSION[$siteId]['userData']['id'];
				$postData['userId']=$userId;

				$appDb->saveAccessChange($postData);

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

			if(count($dbData)>0){
				$form->formMap['postingIntro']['value']=$dbData['content'];

				if($dbData['type']==21)
					$form->formMap['postingAccess']['attributes']=array(
						'checked' => "checked"
					);
			}
			if(isset($dbData['type']))
				$postData['type']=$dbData['type'];
			else
				$postData['type']=20;

		}

		$ownPage=false;

		if(count($pageData)>0){
			if($pageData['creatorId']==$userId)
				$ownPage=true;
		}
		else
			$id = 0;

		return array(
			'id' => $id,
			'form' => $form,
			'lang' => $GLOBALS['localLang']['other'],
			'postData' => $postData,
			'ownPage' => $ownPage,
			'pageDetails' => $pageDetails,
		);

	}

	public function listSnippetsEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$paginator = new PaginatorCms; 

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$pageDetails = $appDb->getPageCutDetails($id);
		if(count($pageDetails)>0){
		}
		else{
			$id=0;
		}

		$snippetSet=$appDb->getPageSnippetShortSet($id);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$ownPage=false;
		if(count($pageDetails)>0)
			if($pageDetails['creatorId']==$userId)
				$ownPage=true;

		return array(
			'id' => $id,
			'snippetList' => $snippetSet,
			'pageDetails' => $pageDetails,
			'ownPage' => $ownPage,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function addSnippetEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$form = new ExtraForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$form->formMap['snippetType']['options'][1]=$GLOBALS['localLang']['other']['typeOption1'];
		$form->formMap['snippetType']['options'][2]=$GLOBALS['localLang']['other']['typeOption2'];

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$pageDetails = $appDb->getPageCutDetails($id);

		if(count($pageDetails)>0){
			$form->setValue('id',$pageDetails['id']);
		}
		else{
			$id=0;
		}

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);
			if ($form->isValid) {
				$snippetId=$appDb->insertSnippet($id);
				$redirectUrl="".$GLOBALS['baseUrl']."/own-page/list-snippets/".$id;
				$this->redirect($redirectUrl, true);
			}
			else{
				$form->setErrorMessages();
			}

		}

		$userId=$_SESSION[$siteId]['userData']['id'];
		$ownPage=false;
		if(count($pageDetails)>0)
			if($pageDetails['creatorId']==$userId)
				$ownPage=true;

		$accessRight=true;	
		return array(
			'id' => $id,
			'form' => $form,
			'pageDetails' => $pageDetails,
			'ownPage' => $ownPage,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function editSnippetEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$form = new ExtraForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$form->formMap['snippetType']['options'][1]=$GLOBALS['localLang']['other']['typeOption1'];
		$form->formMap['snippetType']['options'][2]=$GLOBALS['localLang']['other']['typeOption2'];

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$pageId = $appDb->getPageId($id);
		$pageDetails = $appDb->getPageCutDetails($pageId);

		if(count($pageDetails)>0){
			$form->setValue('id',$pageDetails['id']);
		}
		else{
			$id=0;
		}

		$snippetData = $appDb->getSnippetDetails($id);
		if(count($snippetData)>0){
			$form->setValue('id',$snippetData['id']);
			$form->setValue('snippetCode',$snippetData['uri']);
			$form->setValue('snippetContent',$snippetData['content']);
			$form->setValue('snippetType',$snippetData['type']);
		}
		else{
			$id=0;
		}

		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);
			if ($form->isValid) {

				$appDb->updateSnippet($id,$pageId);
				$redirectUrl="".$GLOBALS['curUrl'];
				$this->redirect($redirectUrl, true);

			}
			else{
				$form->setErrorMessages();
			}

		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$ownPage=false;
		if(count($pageDetails)>0)
			if($pageDetails['creatorId']==$userId)
				$ownPage=true;

		return array(
			'id' => $id,
			'pageId' => $pageId,
			'form' => $form,
			'pageDetails' => $pageDetails,
			'ownPage' => $ownPage,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function deleteSnippetEvent()
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

		$pageId = $appDb->getPageId($id);
		$pageDetails = $appDb->getPageCutDetails($pageId);

		$snippetData = $appDb->getSnippetDetails($id);
		if(count($snippetData)>0){
		}
		else
			$id = 0;

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			$deleted=$appDb->deleteSnippet($id);
		}

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$ownPage=false;
		if(count($pageDetails)>0)
			if($pageDetails['creatorId']==$userId)
				$ownPage=true;

		return array(
			'id'    => $id,
			'pageId' => $pageId,
			'pageDetails' => $pageDetails,
			'snippetData' => $snippetData,
			'ownPage' => $ownPage,
			'deleted' => $deleted,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function editPostEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$form = new ExtraForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$modConfig=$this->modConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$postData = $appDb->getPostDetails($id);
		if (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);
			if ($form->isValid) {

				$appDb->updatePost($id,$siteId,$form);
				$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$GLOBALS['localLang']['other']['submitMessage']."</div>";

			}
			else{
				$form->setErrorMessages();
			}

		}
		else{

			if(count($postData)>0){
				$form->setValue('id',$postData['id']);
				$postData['content']=str_replace("<br />","\n",$postData['content']);
				$form->setValue('postContent',$postData['content']);
				$form->setValue('postStatus',$postData['status']);

			}
			else{
				$id=0;
			}

		}

		$accessRight="#";	

		$pageId = $appDb->getPageIdByPost($id);
		$pageDetails = $appDb->getPageCutDetails($pageId);

		if(isset($pageDetails['creatorId']) && $_SESSION[($GLOBALS['siteId'])]['userData']['id']==$pageDetails['creatorId'])
			$accessRight.="pageOwner#";

		if(isset($postData['creator_id']) && $_SESSION[($GLOBALS['siteId'])]['userData']['id']==$postData['creator_id'])
			$accessRight.="postOwner#";

		return array(
			'id' => $id,
			'form' => $form,
			'accessRight' => $accessRight,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function deletePostEvent()
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

		$pageId = $appDb->getPageIdByPost($id);
		$pageDetails = $appDb->getPageCutDetails($pageId);

		$postData = $appDb->getPostShortDetails($id);
		if(count($postData)>0){
		}
		else
			$id = 0;

		$accessRight="#";	

		$pageId = $appDb->getPageIdByPost($id);
		$pageDetails = $appDb->getPageCutDetails($pageId);

		if(isset($pageDetails['creatorId']) && $_SESSION[($GLOBALS['siteId'])]['userData']['id']==$pageDetails['creatorId'])
			$accessRight.="pageOwner#";

		if(isset($postData['creator_id']) && $_SESSION[($GLOBALS['siteId'])]['userData']['id']==$postData['creator_id'])
			$accessRight.="postOwner#";

		$deleted=false;

		if (isset($_POST['del'])) {
			$del = $_POST['del'];
			$deleted=$appDb->deletePost($id);
		}

		return array(
			'id'    => $id,
			'pageDetails' => $pageDetails,
			'postData' => $postData,
			'deleted' => $deleted,
			'accessRight' => $accessRight,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

}