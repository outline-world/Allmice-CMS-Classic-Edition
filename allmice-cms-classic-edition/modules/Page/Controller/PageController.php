<?php 
/*
 * Page module for Allmice™ CMS
 * Version 1.7.1 (2019-11-19)
 * Copyright 2017 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * Page module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php
include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";

if(isset($GLOBALS['urlParts'][1]) && strstr($GLOBALS['urlParts'][1],"view-pdf")){
	include "modules/Page/config/vendor/tcpdf/"."tcpdf.php";
	include "modules/Page/Model/"."CustomPdf.php";
}

if($pageType2!="frontPage")
	include "core/includes/Model/"."DatabaseCms.php";

if(isset($GLOBALS['urlParts'][1]) && strstr($GLOBALS['urlParts'][1],"view")){
	include "core/includes/Model/"."Captcha.php";
	include $pathModuleModel."Page.php";
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

if(!isset($GLOBALS['urlParts'][1]) || $GLOBALS['urlParts'][1]=="index" || isset($GLOBALS['urlParts'][1]) && (strstr($GLOBALS['urlParts'][1],"view") || strstr($GLOBALS['urlParts'][1],"list"))){
	include "core/includes/Model/"."PaginatorCms.php";
}

include $pathModuleModel."AppDatabase.php";

class PageController extends Controller
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

		$paginator = new PaginatorCms; 

		$pageList = $pageDb->getAllPagesList();	

		$tableScript=$page->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'page' => $page,
			'pageList' => $pageList,
			'statusMap' => $statusMap,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function listAllPagesEvent()
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

		$pageList = $pageDb->getAllPagesList();	

		$tableScript=$page->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'page' => $page,
			'pageList' => $pageList,
			'statusMap' => $statusMap,
			'lang' => $GLOBALS['localLang']['other'],
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

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$Database=$this->dbConfig;
		$pageDb = new AppDatabase($Database['app_db']);

		$whereClauseEnd=" AND type = 'viewEvent'";
		$config = $pageDb->getConfigData($whereClauseEnd);

		if(isset($config['viewEvent']['titleTagTemplate']))
			$GLOBALS['titleTagTemplate']=$config['viewEvent']['titleTagTemplate'];

		$accessList['editAnyPage']=$pageDb->getAccessRight($_SESSION[($siteId)]['userData'],("/page/edit-any-page"));
		$accessList['viewPdfPage']=$pageDb->getAccessRight($_SESSION[($siteId)]['userData'],("/page/view-pdf"));

		$pageData=$pageDb->getPageDetails($id);

		if(isset($pageData['body']))
			$pageData['body']=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$pageData['body']);

		$snippetSet=$pageDb->getPageSnippetSet($id);
		$globalSnippetSet=$pageDb->getGlobalSnippetSet();

//Remove snippets, which are not used on current page to not waste resources (to not run methods, which are related to them) 
		if(count($globalSnippetSet)>0){
			$newSet=array();
			for($i=0;$i<count($globalSnippetSet);$i++){
				if(strstr($pageData['body'],$globalSnippetSet[$i]['uri'])){
					$newSet[]=$globalSnippetSet[$i];
				}
			}
			$globalSnippetSet=$newSet;
		}

		if(count($snippetSet)>0 || count($globalSnippetSet)>0){

			$page = new Page();
			$snippetSet=$page->manageSnippetSet($snippetSet,$globalSnippetSet);

		}

		$template=$pageDb->getTemplate('pageView');
		if(isset($pageData['status']) && $pageData['status']!=1){
			$GLOBALS['pageStatus']="wrongUrl";
		}
		if(isset($pageData['title']) && $pageData['title']!=""){
			$GLOBALS['pageTitle']=$pageData['title'];
		}
		if(isset($pageData['description']) && $pageData['description']!=""){

			$GLOBALS['metaSet']['description']="<meta name=\"description\" content=\"".$pageData['description']."\">";

		}

		$commentWidget="";
		if(isset($config['viewEvent']['commentSwitch']) && $config['viewEvent']['commentSwitch']=="on"){

			if(file_exists($config['viewEvent']['postClassLocation'])){
				$GLOBALS['commentRoleIdList']=$pageDb->getRoleIdList(explode(", ",$config['viewEvent']['commentRoleAccess']));
				include $config['viewEvent']['postClassLocation'];
				$comment=new Post($pageDb,$pageData['creatorId'],$id,$siteId);
				$commentWidget=$comment->formWidget;

			}
		}

		if(isset($config['viewEvent']['pdfLinkSwitch']) && $config['viewEvent']['pdfLinkSwitch']=="off"){
			$accessList['viewPdfPage']=false;
		}

		return array(
			'accessList' => $accessList,
			'template' => $template,
			'pageData' => $pageData,
			'commentWidget' => $commentWidget,
			'lang' => $GLOBALS['localLang']['other'],
			'snippetSet' => $snippetSet,
		);

	}

	public function viewPdfEvent()
	{

		$id = 0;
		if(isset($GLOBALS['urlParts'][2])){
			$id = $GLOBALS['urlParts'][2];
			$id=(int)$id;
			if(!is_integer($id))
				$id=0;
		}

		$pageType="pdf";
//		$pageType="html";

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$Database=$this->dbConfig;
		$pageDb = new AppDatabase($Database['app_db']);

		$whereClauseEnd=" AND (type = 'viewEvent'";
		$whereClauseEnd.=" OR type = 'viewPdfEvent')";
		$config = $pageDb->getConfigData($whereClauseEnd);

		if(isset($config['viewEvent']['titleTagTemplate']))
			$GLOBALS['titleTagTemplate']=$config['viewEvent']['titleTagTemplate'];

		$accessList['editAnyPage']=$pageDb->getAccessRight($_SESSION[($siteId)]['userData'],("/page/edit-any-page"));

		$pageData=$pageDb->getPageDetails($id);

		if(isset($pageData['body']))
			$pageData['body']=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$pageData['body']);

		$snippetSet=$pageDb->getPageSnippetSet($id);
		$globalSnippetSet=$pageDb->getGlobalSnippetSet();

		if(count($snippetSet)>0 || count($globalSnippetSet)>0){

			$page = new Page();
			$snippetSet=$page->manageSnippetSet($snippetSet,$globalSnippetSet);

		}

		$template=$pageDb->getTemplate('pageView');
		if(isset($pageData['status']) && $pageData['status']!=1){
			$GLOBALS['pageStatus']="wrongUrl";
		}
		if(isset($pageData['title']) && $pageData['title']!=""){
			$GLOBALS['pageTitle']=$pageData['title'];
		}
		if(isset($pageData['description']) && $pageData['description']!=""){

			$GLOBALS['metaSet']['description']="<meta name=\"description\" content=\"".$pageData['description']."\">";

		}

		$commentWidget="";
		if(isset($config['viewEvent']['commentSwitch']) && $config['viewEvent']['commentSwitch']=="on"){

			if(file_exists($config['viewEvent']['postClassLocation'])){
				$GLOBALS['commentRoleIdList']=$pageDb->getRoleIdList(explode(", ",$config['viewEvent']['commentRoleAccess']));
				include $config['viewEvent']['postClassLocation'];
				$comment=new Post($pageDb,$pageData['creatorId'],$id,$siteId);
				$commentWidget=$comment->formWidget;

			}
		}

		$GLOBALS['pdfData']['pageList'][0]=trim($pageData['body']);
		$GLOBALS['pdfData']['styleData']="";
		$GLOBALS['pdfData']['author']="";
		$GLOBALS['pdfData']['title']=$GLOBALS['pageTitle'];
		$GLOBALS['pdfData']['subject']=$pageData['description'];
		$GLOBALS['pdfData']['keywords']="";

		$GLOBALS['pdfData']['footerText']=$GLOBALS['localLang']['other']['footerText'];

		$GLOBALS['pdfData']['mainStyles']=$config['viewPdfEvent']['mainStyles'];

		$GLOBALS['pdfData']['displayMode']=$config['viewPdfEvent']['headerFooterDisplayMode'];
		if($GLOBALS['pdfData']['displayMode']=="Tcpdf"){
		}
		else{
			$GLOBALS['pdfData']['headerStyles']=$config['viewPdfEvent']['headerStyles'];
			$GLOBALS['pdfData']['headerHtml']=$config['viewPdfEvent']['headerHtml'];
			$GLOBALS['pdfData']['footerStyles']=$config['viewPdfEvent']['footerStyles'];
			$GLOBALS['pdfData']['footerHtml']=$config['viewPdfEvent']['footerHtml'];
		}

		$GLOBALS['pdfData']['logoCode']=$config['viewPdfEvent']['logoCode'];
		$GLOBALS['pdfData']['logoPath']=$config['viewPdfEvent']['logoPath'];
		
		if($GLOBALS['pdfData']['logoPath']!=""){
			str_replace("[logoPath]",$GLOBALS['pdfData']['logoPath'],$GLOBALS['pdfData']['logoCode']);
		}else{
			$GLOBALS['pdfData']['logoPath']="";
			$GLOBALS['pdfData']['logoCode']="";
		}
		
		if($GLOBALS['pdfData']['logoCode']!=""){
			str_replace("[logoCode]",$GLOBALS['pdfData']['logoCode'],$GLOBALS['pdfData']['headerHtml']);
		}else{
			$GLOBALS['pdfData']['logoPath']="";
			$GLOBALS['pdfData']['logoCode']="";
		}

		$GLOBALS['pdfData']['spacesBeforeFooter']=str_repeat("&nbsp;",50);

		$pdfComposerPath="modules/Page/View/pdf-composer.phtml";

		return array(
			'pageType' => $pageType,
			'pdfComposerPath' => $pdfComposerPath,
			'config' => $config,
		);

	}

	public function addPageEvent()
	{

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$modConfig=$this->modConfig;

		$form = new PageForm();

		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);
		$form->formMap['person_type']['attributes']['onchange']='this.form.submit()';
		$form->formMap['menuId']['attributes']['onchange']='this.form.submit()';

		$page = new Page();
		$uriAlias = new UriAlias();
		$id=0;
		$page -> id = 0; 

		if (isset($_SESSION[$siteId]['userData']['id'])){
			$page->userId=$_SESSION[$siteId]['userData']['id'];
		}

		$Database=$this->dbConfig;
		$pageDb = new AppDatabase($Database['app_db']);

		$roleList=$pageDb->getRoleOptions();
		$form->formMap['roleAccess']['options']=$roleList;

		$roleSet=$pageDb->getRoleSet();

		$whereClauseEnd=" AND type = 'addPageEvent'";
		$config = $pageDb->getConfigData($whereClauseEnd);
		$form->accessFieldStatus=$config['addPageEvent']['roleAccessSwitch'];
		$form->cacheFieldStatus=$config['addPageEvent']['roleCacheSwitch'];
		$form->botTagStatus=$config['addPageEvent']['botTagSwitch'];

		$defaultRoleValues=$form->getDefaultRoles($config, $roleSet);
		$defaultCacheRoleValues=$form->getDefaultCacheRoles($config, $roleSet);

		$form->formMap['roleAccess']['value']=$defaultRoleValues;
		$form->formMap['caching']['value']=$defaultCacheRoleValues;
		$form->formMap['botTag']['value']=$config['addPageEvent']['defaultBotTag'];

		$form->formMap['status']['options'][1]=$GLOBALS['localLang']['other']['statusOption1'];
		$form->formMap['status']['options'][2]=$GLOBALS['localLang']['other']['statusOption2'];
		$form->formMap['botTag']['options'][1]=$GLOBALS['localLang']['other']['botTagOption1'];

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
		if (isset($_POST['menuId'])) {
			$form->updateForm();
			$form->formMap['label']['value']=$_POST['label'];
			$form->formMap['weight']['value']=$_POST['weight'];
			$form->formMap['parentId']['value']=$_POST['parentId'];
			$menuId=$_POST['menuId'];
		}
		$menuItem->menuId = $menuId;

		$itemList=$pageDb->getMenuItemList($menuItem->menuId);
		$parentMap=$menuItem->getParentMap($itemList);

		$form->formMap['parentId']['options']=$parentMap;
		$form->formMap['menuId']['options']=$menuList;

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
				$uriAlias->convertFormData($formData);
				$menuItem->convertFormData($formData);

				if ($form->accessFieldStatus=="off"){
					$page->roleAccess=array();
					$page->roleAccess=$pageDb->getRoleIdList(explode(", ",$config['addPageEvent']['defaultRoleAccess']));
					$page->botTag=$config['addPageEvent']['defaultBotTag'];
				}
				elseif(!is_array($formData['roleAccess']) || !isset($formData['roleAccess'])){
					$page->roleAccess=array();
				}

				if ($form->cacheFieldStatus=="off"){
					$page->cachingRoles=array();
					$page->cachingRoles=$defaultCacheRoleValues;
				}
				elseif(!is_array($formData['caching']) || !isset($formData['caching'])){
					$page->cachingRoles=array();
				}

				$page->userId=0;
				$menuItem->userId=0;
				if (isset($_SESSION[$siteId]['userData']['id'])){
					$page->userId=$_SESSION[$siteId]['userData']['id'];
					$menuItem->userId=$_SESSION[$siteId]['userData']['id'];
				}
				$menuItem->uri=$page->alias;
				$page->created=time();
				$page->edited=$page->created;
				$uriAlias->source=$GLOBALS['modPath'];
				$uriAlias->depth=substr_count ( $uriAlias->alias , "/" );
				$itemList=$pageDb->getMenuItemList($menuItem->menuId);

				if ($form->accessFieldStatus=="off")
					$form->formMap['roleAccess']['value']=$defaultRoleValues;

				if ($form->cacheFieldStatus=="off")
					$form->formMap['caching']['value']=$defaultCacheRoleValues;

				$pageDb->savePage($page,$uriAlias,$menuItem);

				if(isset($GLOBALS['aliasProblem'])){
					$GLOBALS['messageList'][]="<div class=\"problem-note\">".$GLOBALS['localLang']['other']['aliasProblem']."</div>";
				}
				else{

					$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$GLOBALS['localLang']['other']['submitMessage']."</div>";

					$redirectUrl="".$GLOBALS['baseUrl']."/own-page/list-pages";
					$this->redirect($redirectUrl, false);
				}

			}
			else{
				$form->setErrorMessages();
			}

		}

		return array(
			'id' => $id,
			'form' => $form,
			'ckEditorScript' => $ckEditorScript,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function editAnyPageEvent()
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

		$pageData = $pageDb->getPageDetails($id,$_SESSION[$siteId]['userData']['id']);
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

				if(!is_array($formData['roleAccess']) || !isset($formData['roleAccess']))
					$page->roleAccess=array();

				$page->userId=0;
				$menuItem->userId=0;
				if (isset($_SESSION[$siteId]['userData']['id'])){
					$page->userId=$_SESSION[$siteId]['userData']['id'];
					$menuItem->userId=$_SESSION[$siteId]['userData']['id'];
				}
				$menuItem->uri=$page->alias;
				$page->edited=time();
				$uriAlias->source=$GLOBALS['modPath'];
				$uriAlias->depth=substr_count ( $uriAlias->alias , "/" );
				$itemList=$pageDb->getMenuItemList($menuItem->menuId);

				$pageDb->savePage($page,$uriAlias,$menuItem);

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
				$accessData = $pageDb->getAccessRoleIdSet($id);
				$cachingData = $pageDb->getCachingRoleIdSet($id);
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
			}else{
				$id=0;
			}

		}

		if(count($pageData)>0){
			if (isset($_POST['menuId']) && !isset($_POST['submit1'])) {
				$form->updateForm();
				$menuId=$_POST['menuId'];
				$menuItem->menuId = $menuId;
				$itemList=$pageDb->getMenuItemList($menuId);
			}

			$parentMap=$menuItem->getParentMap($itemList);
			$form->formMap['parentId']['options']=$parentMap;
		}

		return array(
			'id' => $id,
			'form' => $form,
			'ckEditorScript' => $ckEditorScript,
			'lang' => $GLOBALS['localLang']['other'],
		);
	}

	public function deleteAnyPageEvent()
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
		$uriAlias = new UriAlias();

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

		return array(
			'id'    => $id,
			'page' => $page,
			'deleted' => $deleted,
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

		$dbData=$appDb->getIntroPostData($id);

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

		return array(
			'id' => $id,
			'form' => $form,
			'lang' => $GLOBALS['localLang']['other'],
			'postData' => $postData,
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

		return array(
			'id' => $id,
			'snippetList' => $snippetSet,
			'pageDetails' => $pageDetails,
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

				$redirectUrl="".$GLOBALS['baseUrl']."/page/list-snippets/".$id;
				$this->redirect($redirectUrl, true);

			}
			else{
				$form->setErrorMessages();
			}

		}

		$accessRight=true;	
		return array(
			'id' => $id,
			'form' => $form,
			'pageDetails' => $pageDetails,
			'accessRight' => $accessRight,
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
		else{

		}

		$accessRight=true;	
		return array(
			'id' => $id,
			'pageId' => $pageId,
			'form' => $form,
			'pageDetails' => $pageDetails,
			'accessRight' => $accessRight,
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

		return array(
			'id'    => $id,
			'pageId' => $pageId,
			'pageDetails' => $pageDetails,
			'snippetData' => $snippetData,
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
			$postData = $appDb->getPostDetails($id);
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

		return array(
			'id' => $id,
			'form' => $form,
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
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

}