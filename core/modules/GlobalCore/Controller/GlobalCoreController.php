<?php 
/*
 * Allmice™ CMS
 * Version 1.8.1 (2020-12-26)
 * Copyright 2020 by Adeenas OÜ, Copyright 2017 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>
 <?php

include $pathCoreModel."Database.php";
include $corePath."GlobalCore/Model/"."Core.php";
include $corePath."GlobalCore/Model/"."CoreDatabase.php";
include $corePath."GlobalCore/Model/"."GlobalBlock.php";

class GlobalCoreController {
	public $otherConfig;
	public $globalData;
	public $dbConfig;
	public $modConfig;

	public function __construct()
	{
	}

	public function indexEvent()
	{
		$Other=$this->otherConfig;

		$modConfig=$this->modConfig;

		$curTime=time();

		if(isset($GLOBALS['urlParts']) && $GLOBALS['urlParts'][0]=="" || !isset($GLOBALS['urlParts']))
//If frontpage
			$pageType2="frontPage";
		else
			$pageType2="modPage";
//In root index scope $pageType variable exists, which purpose is to separate file formats - e.g. html/pdf.
//   Although it is in another scope, another variable name will be used here - $pageType2 to separate module based pages from front page.

		$tempArr=explode("://",$GLOBALS['baseUrl']);
		$sitePath=str_replace("/","_",$tempArr[1]);
		$configPath=("sites/".$sitePath."/config.php");

		$tempArr2=explode("_",$sitePath,2);
		if(!isset($tempArr2[1]))
			$tempArr2[1]=$tempArr2[0];
		$configPath2=("sites/".$tempArr2[1]."/config.php");

		$uriSourceStatus=1;

		$curPath="";
		if(isset($GLOBALS['urlParts'][0]) && $GLOBALS['urlParts'][0]!=""){
			$curPath.=("/".$GLOBALS['urlParts'][0]);
			if(isset($GLOBALS['urlParts'][1]) && $GLOBALS['urlParts'][1]!=""){
				$curPath.=("/".$GLOBALS['urlParts'][1]);
				if(isset($GLOBALS['urlParts'][2]) && $GLOBALS['urlParts'][2]!=""){
					$curPath.=("/".$GLOBALS['urlParts'][2]);
				}
			}
		}

		if(isset($Other['siteId']))
			$siteId=$Other['siteId'];
		else
			$Other['siteId']="";
		$GLOBALS['siteId']=$Other['siteId'];

		$core = new Core();

		$GLOBALS['siteStatus']="";

		if(!file_exists($configPath) && file_exists($configPath2)){
			$configPath=$configPath2;
		}

		if(file_exists($configPath)){
			$GLOBALS['siteStatus'].="ConfigOk";

			$Database=$this->dbConfig;
			$appDb = new CoreDatabase($Database['app_db']);
			$langData=$appDb->getLangConfigData();
			$globalDbConfig=$appDb->getConfigData("GlobalCore");

			if(intval($globalDbConfig['cachePeriod']['value'])!=0)
				$modConfig['cachePeriod']=$globalDbConfig['cachePeriod']['value']*60;
			if(intval($globalDbConfig['sessLifetime']['value'])!=0)
				$modConfig['sessLifetime']=$globalDbConfig['sessLifetime']['value']*60;
			if(intval($globalDbConfig['dbCleaningPeriod']['value'])!=0)
				$modConfig['sessDbCleanPeriod']=$globalDbConfig['dbCleaningPeriod']['value']*24*60*60;

			if(isset($langData['mainLanguage'])){
				$GLOBALS['langDirection']="ltr";
				$tempArr=explode(";",$langData['mainLanguage'],2);
				$GLOBALS['langCode']=$tempArr[0];
				$GLOBALS['langCode2']=$tempArr[1];
				$GLOBALS['db']['id']=$appDb->dbId;
				$GLOBALS['db']['tablePrefix']=$appDb->tablePrefix;

				if(isset($langData['mainDateFormat']) && $langData['mainDateFormat']!=""){
					$GLOBALS['dateFormat']=$langData['mainDateFormat'];
				}
				if(isset($langData['mainTimeFormat']) && $langData['mainTimeFormat']!=""){
					$GLOBALS['timeFormat']=$langData['mainTimeFormat'];
				}
				if(isset($langData['mainShortTimeFormat']) && $langData['mainShortTimeFormat']!=""){
					$GLOBALS['shortTimeFormat']=$langData['mainShortTimeFormat'];
				}

			}else{
				$langData['status']="dbProblem";
			}

			if($langData['status']!="dbProblem"){

				$tempArr=explode(";",$langData['mainLanguage'],2);

				$GLOBALS['siteStatus'].="DbOk";
				session_set_save_handler(
					array($appDb, "open"),
					array($appDb, "close"),
					array($appDb, "read"),
					array($appDb, "write"),
					array($appDb, "destroy"),
					array($appDb, "gc")
				);

		//Below is an extra gc (cleanSessData) function call - not to let the core_session table to get too big
		//   this means to have control independently from session_set_save_handler

				$appDb->cleanSessData($modConfig['sessDbCleanPeriod']);

			}
			else
				$GLOBALS['siteStatus'].="DbProblem";

//Without following session_start user logging in may not work 
			session_start();

			if (isset($_SESSION[($Other['siteId'])]['lastActivity']) && (time() - $_SESSION[($Other['siteId'])]['lastActivity'] > $modConfig['sessLifetime'])) {
			    // last request was more than $modConfig['sessLifetime'] seconds ago
			    session_unset();     // unset $_SESSION variable for the run-time 
			    session_destroy();   // destroy session data in storage
			    session_start();     // start new session 
			}
			$_SESSION[($Other['siteId'])]['lastActivity'] = time(); // update last activity time stamp

		}else{
			$GLOBALS['siteStatus'].="ConfigProblem";
//			echo "Site config doesn't exist";
		}

		if($GLOBALS['siteStatus']=="ConfigOkDbOk"){
//		if($GLOBALS['siteStatus']=="ConfigOk"){

//Change langCode, if it is a session value or was chosen as new language during last action
			if(isset($_SESSION[($Other['siteId'])]['userData']['roleId']))
				$userRole=$_SESSION[($Other['siteId'])]['userData']['roleId'];
			else
				$userRole=2;

			if(isset($langData['defaultLanguage']) && $langData['defaultLanguage']!="" 
			 && !isset($_SESSION[($Other['siteId'])]['langCode']) && $userRole!=1){
//$userRole assignment exists below too - added there earlier, but 
//   many things can happen before the duplicate assignment, which may cause the code not to work correctly if to leave it here only
				$activeRoleTitle=$appDb->getRoleTitle($userRole);

				$tempArr=explode(";",$langData['defaultLanguage']);

				for($i=2;$i<count($tempArr);$i++){
					if($activeRoleTitle==$tempArr[$i]){
						$GLOBALS['langCode']=$tempArr[0];
						$GLOBALS['langCode2']=$tempArr[1];
					}
				}

				if(isset($langData['defaultDateFormat']) && $langData['defaultDateFormat']!=""){
					$GLOBALS['dateFormat']=$langData['defaultDateFormat'];
				}
				if(isset($langData['defaultTimeFormat']) && $langData['defaultTimeFormat']!=""){
					$GLOBALS['timeFormat']=$langData['defaultTimeFormat'];
				}
				if(isset($langData['defaultShortTimeFormat']) && $langData['defaultShortTimeFormat']!=""){
					$GLOBALS['shortTimeFormat']=$langData['defaultShortTimeFormat'];
				}
			}

			if($userRole!=1){
				if (isset($_SESSION[($Other['siteId'])]['langCode'])) {
					$GLOBALS['langCode']=$_SESSION[($Other['siteId'])]['langCode'];
				}else{
					$_SESSION[($Other['siteId'])]['langCode']=$GLOBALS['langCode'];
				}

				if (isset($_SESSION[($Other['siteId'])]['langCode2'])) {
					$GLOBALS['langCode2']=$_SESSION[($Other['siteId'])]['langCode2'];
				}else{
					$_SESSION[($Other['siteId'])]['langCode2']=$GLOBALS['langCode2'];
				}
			}else{
				$_SESSION[($Other['siteId'])]['langCode']=$GLOBALS['langCode'];
				$_SESSION[($Other['siteId'])]['langCode2']=$GLOBALS['langCode2'];
			}

			$GLOBALS['siteStatus']="inUse";

//If app is installed

			$output['Module']=$appDb->getModuleData();
			$output['globalModules']=$appDb->getGlobalModuleData();
			$output['localModule']=$appDb->getLocalModuleData($GLOBALS['urlParts'][0]);

			$tempArr=explode($GLOBALS['baseUrl'],$GLOBALS['curUrl']);
			$curUrl=$tempArr[1];

		}else{
//If app is not installed
			if($GLOBALS['siteStatus']=="ConfigProblem")
				$GLOBALS['siteStatus']="new";
			$modConfig['aliasSwitch']="off";
			$modConfig['accessSwitch']="off";
			$modConfig['cacheSwitch']="off";
			$modConfig['blockSwitch']="off";
			$modConfig['themeSwitch']="off";
		}

	//===========
	//Url choice

		if($modConfig['aliasSwitch']!="off"){

			$uriData=$appDb->getUri($curUrl);

			if(count($uriData)>0){

				$uriData['source'] = ltrim($uriData['source'], '/');

				$urlParts=explode("/",$uriData['source']);

				$GLOBALS['urlParts']=$urlParts;
			}else{
				$urlParts=array();
			}

			$GLOBALS['modName']="";
//If front page, then module name remains empty string 
			if(isset($urlParts[0])){
//If alias, then finds locale module name 
				$moduleData['View']=$urlParts[0];
				$tempArr=explode("-",$urlParts[0]);
				$tempArrTotal=count($tempArr);
				$moduleData['Name']="";
				for($i=0;$i<$tempArrTotal;$i++){
					$moduleData['Name'].=ucfirst($tempArr[0]);
				}
			}
			elseif(isset($GLOBALS['urlParts'][0])){
//If not alias, then finds locale module name 
				$tempArr=explode("-",$GLOBALS['urlParts'][0]);
				$tempArrTotal=count($tempArr);
				$moduleData['Name']="";
				for($i=0;$i<$tempArrTotal;$i++){
					$moduleData['Name'].=ucfirst($tempArr[$i]);
				}
			}
			$GLOBALS['modName']=$moduleData['Name'];

			if(isset($urlParts))
				$output['Url']['parts']=$urlParts;
			if(isset($moduleData))
				$output['Url']['moduleData']=$moduleData;

		}

	//===========

	//===========
	//Access (permission) choice

		$botAccess=1;
		$accessRight=false;

		if($modConfig['accessSwitch']!="off"){

			if(count($uriData)==0){
		//no alias
				$urlType="source";
				$urlParts=explode("/",substr($curUrl,1));
				if(!isset($urlParts[1]))
					$urlParts[1]="index";
				$path="/".$urlParts[0];

				for($i=1;$i<2;$i++){
					$path.="/".$urlParts[$i];
				}

			}else{
		//with alias
				$urlType="alias";
				$path="/page/view";
			}
			$GLOBALS['urlType']=$urlType;

			if(!isset($_SESSION[($Other['siteId'])]['userData']['id'])){
				$_SESSION[($Other['siteId'])]['userData']['id']=0;		
				$_SESSION[($Other['siteId'])]['userData']['roleId']=2;		
				$_SESSION[($Other['siteId'])]['userData']['name']="";		
			}

			$userRole=$_SESSION[($Other['siteId'])]['userData']['roleId'];

//			If event access, then $type=1;
//			Where is page access determined?; if page access, then $type=2;
			$type=1;

//Following 3 lines are here for general cases - if id is not set in url
			$resData=$appDb->getAcceptedRoles($path,$type);
			$resRoles=$resData['role'];
			$botAccess=$resData['botAccess'];

			if(isset($urlParts[2])){
//Rewrite access right, if a resource exists for a specific module item e.g. for a specific page
				$path.=("/".$urlParts[2]);
				if($appDb->resExists($path)){
//Resource doesn't exist for every specific item
//Following 3 lines are here for specific cases - if id is set in url
					$resData=$appDb->getAcceptedRoles($path,$type);
					$resRoles=$resData['role'];
					$botAccess=$resData['botAccess'];
				}
			}

			$userRoles=$appDb->getUserRoles($_SESSION[($Other['siteId'])]['userData']['id']);

			if(count($userRoles)>1){
//Access, if multiple roles - if count($userRoles)>1 - should not be very much slower, 
//   because in practical cases one user still will not have usually too many roles 
//   (if more than 1, then usually probably not more than 3). E.g. a user may have roles authenticated & client.
				foreach ($userRoles as $checkRole) {
					if(in_array($checkRole, $resRoles)){
						$accessRight=true;
					}
				}
			}
			else{
//Access, if only one role - easier and faster logic.
//   In most cases it is enough, if one user has only one role - 
//   this is the case, if in database in table core_user the field value count($userRoles)>1.
				if(in_array($userRole, $resRoles)){
					$accessRight=true;
				}
			}

			if($pageType2=="frontPage"){
	//If frontpage, then access is always permitted
				$accessRight=true;
				$GLOBALS['frontPageStatus']="off";
				$fpData=$appDb->getFrontPageData();
				if(count($fpData)>0)
					$GLOBALS['frontPageStatus']="on";
				$GLOBALS['frontPageData']=$fpData;
			}

			if(isset($GLOBALS['urlParts'][0]) && isset($GLOBALS['urlParts'][1]) && $GLOBALS['urlParts'][0]=="admin" && $GLOBALS['urlParts'][1]=="install"){
	//Exceptions, if admin module and install event

				if(file_exists($configPath))
					$accessRight=false;
				else
					$accessRight=true;
			}

			$uriSourceStatus=$appDb->getSourceStatus($curPath);

			if($urlType=="source"){
//Checking, if current source url has an alias.
//   If it has, then checking, does this alias prohibit access to its duplicate - to current source url.
				if($uriSourceStatus==0){
					$accessRight=false;
				}
			}
			if(isset($GLOBALS['urlParts'][0]) && isset($GLOBALS['urlParts'][1]) && $GLOBALS['siteStatus']=="inUse" && $GLOBALS['urlParts'][0]=="app" && $GLOBALS['urlParts'][1]=="install-website")
				$accessRight=false;

			$GLOBALS['pageStatus']="validUrl";

			if(!$accessRight){
//		Switch on/off for access functionality
					$output['Url']['parts'][0]="messages";
					$output['Url']['parts'][1]="access";
					$output['Url']['parts'][2]=0;
					$output['Url']['moduleData']['Name']="Messages";
					$output['Url']['moduleData']['View']="messages";

					$GLOBALS['pageStatus']="wrongUrl";

			}

			$output['accessRight']=$accessRight;

	//===========

	//===========
	//Prepare html meta, script and other tags (saved in core_config table)

// Prepares metatags with initial values - it may be overwritten later in middle code or in some local module

			$localDbConfig=array();
			if(isset($GLOBALS['urlParts'][1])){
				$localDbConfig=$appDb->getConfigData($GLOBALS['modName']);
			}

			$method="";
			if(isset($GLOBALS['urlParts'][1]))
				$method=$GLOBALS['urlParts'][1];

			$GLOBALS['metaSet']['base']=$core->getBaseMetaTags($botAccess);
			$GLOBALS['metaSet']['bot']=$core->getBotTag($botAccess);
			$GLOBALS['metaSet']['description']=$appDb->getDescriptionTag($GLOBALS['modName'],$method);

			if($GLOBALS['metaSet']['description']=="" && isset($globalDbConfig['metaDescription']))
				$GLOBALS['metaSet']['description']=$globalDbConfig['metaDescription']['value'];

			$GLOBALS['headTags']="";
			if(isset($globalDbConfig['headTags']['value']) && $globalDbConfig['headTags']['value']!="" && $globalDbConfig['headTags']['value']!="[off]"){

				$scriptSet=$appDb->getTagSet($GLOBALS['modName'],$method,"headTags");

	// Prepares script tags with initial values - it may be overwritten later in middle code or in some local module
				$GLOBALS['headTags']="";

				if($scriptSet!=""){
					$scriptSet=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$scriptSet);
					$scriptSet=str_replace("[none]","",$scriptSet);
					$GLOBALS['headTags'].=$scriptSet;
				}else{
					if(isset($globalDbConfig['headTags']['value'])){
						$scriptSet=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['headTags']['value']);
						$GLOBALS['headTags'].=$scriptSet;
					}
				}
			}

			$GLOBALS['otherTags1']="";

			if(isset($globalDbConfig['otherTags1']['value']) && $globalDbConfig['otherTags1']['value']!="" && $globalDbConfig['otherTags1']['value']!="[off]"){

//If value==[off], then don't waste time and resources to decide how to get such tags from database.
//If value!=[off], then first check, if current event and module have specific values 
//  If current event has not a specific value, then check current module as default value.
//  If current module has no specific value, then use website's default value.
				$tagSet=$appDb->getTagSet($GLOBALS['modName'],$method,"otherTags1");
				$GLOBALS['otherTags1']="";
				if($tagSet!=""){
					$tagSet=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$tagSet);
					$tagSet=str_replace("[none]","",$tagSet);
					$GLOBALS['otherTags1'].=$tagSet;
				}else{
					if(isset($globalDbConfig['otherTags1']['value']) && $globalDbConfig['otherTags1']['value']!=""){
						$tagSet=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['otherTags1']['value']);
						$GLOBALS['otherTags1'].=$tagSet;
					}
				}
			}

			$GLOBALS['otherTags2']="";

			if(isset($globalDbConfig['otherTags2']['value']) && $globalDbConfig['otherTags2']['value']!="" && $globalDbConfig['otherTags2']['value']!="[off]"){

				$tagSet=$appDb->getTagSet($GLOBALS['modName'],$method,"otherTags2");
				$GLOBALS['otherTags2']="";
				if($tagSet!=""){
					$tagSet=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$tagSet);
					$tagSet=str_replace("[none]","",$tagSet);
					$GLOBALS['otherTags2'].=$tagSet;
				}else{
					if(isset($globalDbConfig['otherTags2']['value'])){
						$tagSet=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['otherTags2']['value']);
						$GLOBALS['otherTags2'].=$tagSet;
					}
				}
			}

			if(isset($globalDbConfig['faviconPath']['value']) && $globalDbConfig['faviconPath']['value']!=""){
				$path=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['faviconPath']['value']);
				$GLOBALS['faviconPath']=$path;
			}

			if(isset($globalDbConfig['customValue']['value']) && $globalDbConfig['customValue']['value']!=""){
				$path=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['customValue']['value']);
				$GLOBALS['customValue']=$path;
			}

			if(isset($globalDbConfig['faviconImage']['value']) && $globalDbConfig['faviconImage']['value']!=""){
				$tag=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['faviconImage']['value']);
				$GLOBALS['faviconImage']=$tag;
			}

			if(isset($globalDbConfig['logoImage']['value']) && $globalDbConfig['logoImage']['value']!=""){
				$tag=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['logoImage']['value']);
//If site name is blockLanguage based saved in db, 
//   then the alt property of image tag is not taking account the text, which is saved as language phrase for siteName
				$tag=str_replace("[siteName]",$GLOBALS['siteName'],$tag);
				$GLOBALS['logoImage']=$tag;
			}
			if(isset($globalDbConfig['smallLogoImage']['value']) && $globalDbConfig['smallLogoImage']['value']!=""){
				$tag=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['smallLogoImage']['value']);
				$tag=str_replace("[siteName]",$GLOBALS['siteName'],$tag);
				$GLOBALS['smallLogoImage']=$tag;
			}

			if(isset($globalDbConfig['siteNameImage']['value']) && $globalDbConfig['siteNameImage']['value']!=""){
				$tag=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['siteNameImage']['value']);
//If site name is blockLanguage based saved in db, 
//   then the alt property of image tag is not taking account the text, which is saved as language phrase for siteName
				$tag=str_replace("[siteName]",$GLOBALS['siteName'],$tag);
				$GLOBALS['siteNameImage']=$tag;
			}
			if(isset($globalDbConfig['smallSiteNameImage']['value']) && $globalDbConfig['smallSiteNameImage']['value']!=""){
				$tag=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$globalDbConfig['smallSiteNameImage']['value']);
				$tag=str_replace("[siteName]",$GLOBALS['siteName'],$tag);
				$GLOBALS['smallSiteNameImage']=$tag;
			}

// Prepares other head tags with initial values - it may be overwritten later in middle code or in some local module
//   Add this functionality later

		}
	//===========

	//===========
	//Theme choice

		if($modConfig['themeSwitch']!="off"){
			$themeDbData=$appDb->getThemeData($userRole);
			$themeData['name']=$themeDbData['name'];
			if($themeDbData['path']!="")
				$themeData['path']=$themeDbData['path'].$themeDbData['name'];
			else
				$themeData['path']="themes/".$themeDbData['name'];
		}

	//===========

	//===========
	//Caching choice for local mainContent

		if($modConfig['cacheSwitch']!="off"){

			$cachingMap['status']="off";
			$cachingMap['main']['status']="off";			

			$cacheData=$appDb->getCacheData($userRole,$path);

			if(count($cacheData)>0){
				$cachingMap['status']="on";
				$cachingMap['main']['path']=$path;			

				$contentSet=unserialize($cacheData['content']);			
				if(isset($contentSet['title']) && $contentSet['title']!="")
					$GLOBALS['pageTitle']=$contentSet['title'];
				if(isset($contentSet['description']) && $contentSet['description']!="")
					$GLOBALS['metaSet']['description']=$contentSet['description'];

				$cachingMap['main']['content']="".$contentSet['mainContent'];			
				$cachingMap['main']['period']=$cacheData['period'];			
				$cachingMap['main']['lastTime']=$cacheData['lastTime'];			
				$cachingMap['main']['roleId']=$_SESSION[($Other['siteId'])]['userData']['roleId'];			

				if(($cachingMap['main']['period']+$cachingMap['main']['lastTime'])>$curTime){
					$cachingMap['main']['status']="valid";			
				}else{
					$cachingMap['main']['status']="elapsed";			
				}

			}

		}
	//===========

	//===========
	//Block choice

		if($modConfig['blockSwitch']!="off"){

			$cacheResult=$appDb->getBlockCacheData($userRole,$path);

			$blockSet=$appDb->getBlockSet($userRole,$GLOBALS['langCode']);
			$block=new GlobalBlock();

			$modConfig=$this->modConfig;

			if(isset($modConfig['siteSalt']))
				$appDb->salt=$modConfig['siteSalt'];

			$regList=array();

//Are following $Region array lines obsolete?
			$Region['topBar']="";
			$Region['leftArea']="";

			$regInd=0;
			$lastRegCode="";
			$userInd=0;
			$menuInd=0;

			$cacheStatus="off";
			$curTime=time();

			for($i=0;$i<count($blockSet);$i++){
	//Using block access right, not menu access right

				$blockAccessRight=0;

				if(count($userRoles)>1){
//Block Access, if multiple roles - if count($userRoles)>1

					$type=40;
					$path=("/block/view/".$blockSet[$i]['id']);
					if($appDb->resExists($path)){
						$blockResRoles=$appDb->getAcceptedBlockRoles($path,$type);
						foreach ($userRoles as $checkRole) {
							if(in_array($checkRole, $blockResRoles)){
								$blockAccessRight=1;
							}
						}
					}

				}
				else{
	//Block Access, if only one role - easier and faster logic.
					$blockAccessRight=$appDb->getAccessRight($userRole,$blockSet[$i]['block_code']);

				}

				if($blockAccessRight==1){

					if (isset($cacheResult['list']) && in_array($blockSet[$i]['block_code'], $cacheResult['list'])){
//If there is an entry in core_caching table according to current blockCode and current role
						if ($cacheResult['time'][($blockSet[$i]['block_code'])]>$curTime){
							$cacheStatus="valid";
						}else{
							$cacheStatus="elapsed";
						}
					}else{
						$cacheStatus="off";
					}

					if ($cacheStatus=="valid"){

//Block caching: fills region data with exisitng cache content
						if(isset($Region[($blockSet[$i]['region_code'])])){
							$Region[($blockSet[$i]['region_code'])].=($cacheResult['content'][($blockSet[$i]['block_code'])]);
							$blockView=$Region[($blockSet[$i]['region_code'])];
						}else{
							$Region[($blockSet[$i]['region_code'])]=($cacheResult['content'][($blockSet[$i]['block_code'])]);
							$blockView=$Region[($blockSet[$i]['region_code'])];
						}
					}else{
//Creating new block content

						$methodName=$blockSet[$i]['display_method'];

						$blockLang=$appDb->getBlockLang($blockSet[$i]['block_code'],"en");

						if($GLOBALS['langCode']!="en"){
							$otherBlockLang=$appDb->getBlockLang($blockSet[$i]['block_code'],$GLOBALS['langCode']);

				//Language block phrase replacements, if language is not English
							if(isset($otherBlockLang)){
								foreach(array_keys($otherBlockLang) as $otherKey){
								  $blockLang[($otherKey)]=$otherBlockLang[($otherKey)];

								}
							}

						}

						$blockView="";
						if($blockSet[$i]['type']=="Menu"){
		//Menu blocks
							if(!isset($Region[($blockSet[$i]['region_code'])]))
								$Region[($blockSet[$i]['region_code'])]="";
							if($methodName=="buildMenuBlock"){

								$itemData=$appDb->getActiveMenuItemList($blockSet[$i]['block_code']);

								if(count($itemData)>0){
//If menu items exist
									$menuData=$appDb->getMenuData($blockSet[$i]['block_code']);
									$blockView=$block->$methodName($blockSet[$i]['block_code'],$itemData,$menuData);
								}
							}

							$Region[($blockSet[$i]['region_code'])].=$blockView;
//====================
	//Region caching
						}
						elseif($blockSet[$i]['type']=="User"){
							if(!isset($Region[($blockSet[$i]['region_code'])]))
								$Region[($blockSet[$i]['region_code'])]="";
							if($methodName=="buildUserBlock"){
								$blockView=$block->$methodName($blockSet[$i]['block_code'],$siteId,$blockLang);
							}

							$Region[($blockSet[$i]['region_code'])].=$blockView;

						}
						elseif($blockSet[$i]['type']=="siteName"){
							if(!isset($Region[($blockSet[$i]['region_code'])]))
								$Region[($blockSet[$i]['region_code'])]="";
		//User blocks
							if($methodName=="getSiteName"){
								$blockView=$blockLang['siteName'];
								$GLOBALS['siteName']=$blockLang['siteName'];

//If logoImage tag has value in db. core_config table 
//   and if language phrase has been used for siteName
//   then use such language phrase as alt text for logo image.
								if(isset($GLOBALS['logoImage']) && $GLOBALS['logoImage']!="")
									$GLOBALS['logoImage']=str_replace("[siteName]",$blockLang['siteName'],$GLOBALS['logoImage']);

							}

							$Region[($blockSet[$i]['region_code'])].=$blockView;

						}
						elseif($blockSet[$i]['type']=="footerArea"){

							if(!isset($Region[($blockSet[$i]['region_code'])]))
								$Region[($blockSet[$i]['region_code'])]="";
		//User blocks
							if($methodName=="buildFooterArea"){
								if(isset($globalDbConfig['coreFooterArea']['value']) && $globalDbConfig['coreFooterArea']['value']!=""){
									$blockView=str_replace("[Year]",date('Y'),$globalDbConfig['coreFooterArea']['value']);
									$blockView=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$blockView);
								}
							}

							$Region[($blockSet[$i]['region_code'])].=$blockView;

						}
						elseif($blockSet[$i]['type']=="uriBased"){
		//Uri blocks - uri determines another module and method, which will be used to create the block content.
		//   These will be custom blocks, which are using GlobalCore module caching and access possibilities.
		//Other module could be local url based module, then it will not be used by default.
		//See middle-code.php file - uriBased block will be created there.
							$blockView="";

						}
						elseif($blockSet[$i]['type']=="coreFrontPage"){
							if($pageType2=="modPage")
								$blockView="";
							else{
								if(!isset($Region[($blockSet[$i]['region_code'])]))
									$Region[($blockSet[$i]['region_code'])]="";
								$blockView=$block->$methodName($siteId,$Other['siteName']);
								$Region[($blockSet[$i]['region_code'])].=$blockView;
							}
						}
					}

					$regionArray['blockName']=$blockSet[$i]['block_code'];
					$regionArray['regionName']=$blockSet[$i]['region_code'];
					$regionArray['displayMethod']=$blockSet[$i]['display_method'];
					$regionArray['view']=$blockView;
					$regionArray['type']=$blockSet[$i]['type'];
					$regionArray['uri']=$blockSet[$i]['uri'];
					$regionArray['rank']=$blockSet[$i]['rank'];
					$regionArray['languageCode']=$blockSet[$i]['language_code'];
					$regionMap[]=$regionArray;

					if ($cacheStatus=="elapsed"){
						$cacheData['resId']=$cacheResult['resId'][($blockSet[$i]['block_code'])];
						$cacheData['lastTime']=$curTime;
						$cacheData['content']=$blockView;
						$cacheData['roleId']=$userRole;
						$appDb->updateBlockCaching($cacheData);

					}

				}
			}

//If logoImage tag has value in db. core_config table 
//   and if language phrase has not been used for siteName as alt text for such image,
//   then the siteName got from website's config file will be used as alt text.
			if(isset($GLOBALS['logoImage']) && $GLOBALS['logoImage']!="")
				$GLOBALS['logoImage']=str_replace("[siteName]",$Other['siteName'],$GLOBALS['logoImage']);

		}
	//===========

	//===========
	//Local language choice for module event pages (not id based language)

		if(isset($cachingMap) && $cachingMap['main']['status']!="valid" && $output['accessRight']){
//Start to process language functionality only if content is not cached and has access right.
//   Otherwise proper language should already be included into ready-made cached content and 
//   no resources will be wasted to process language functionality.

			if(isset($GLOBALS['urlParts'][0])){
				$tempArr=explode("-",$GLOBALS['urlParts'][0]);
				$modName="";
				for($i=0;$i<count($tempArr);$i++){
					$modName.=ucfirst($tempArr[$i]);
				}

				if(isset($GLOBALS['urlParts'][1])){
					$tempArr=explode("-",$GLOBALS['urlParts'][1]);
					$eventName=$tempArr[0];
					for($i=1;$i<count($tempArr);$i++){
						$eventName.=ucfirst($tempArr[$i]);
					}
				}else{
					$eventName="index";
				}
			}
			$eventName.="Event";
	//Gets all phrases of default language for local module		
			$localLang=$appDb->getLocalLang($modName,$eventName,"en");
	//If current language is not default language (English)		
			if($GLOBALS['langCode']!="en"){
	//It may happen, that not all of the phrases are translated, if language_code is other than en.
	//   For such cases English will be always considered as default and if other language has been made active,
	//   then only existing phrases of other language will be used, otherwise English phrases will be used.
	//   If there was not such approach, then in case of missing phrases in other language,
	//   the spots for such missing phrases had in module event view file no text at all and this would be very confusing.
				$otherLocalLang=$appDb->getLocalLang($modName,$eventName,$GLOBALS['langCode']);

	//1. Language local form phrase replacements
				if(isset($localLang['form'])){
					foreach(array_keys($localLang['form']) as $uriInd){
		//Looks fast approach, if in first loop a map of all English phrases will be made 
		//   using logic: $enMap[$uri]=$localLang['form'][$index], where $uri=$localLang['form'][$index]['uri']
					  $enMap[($localLang['form'][($uriInd)]['uri'])]=$uriInd;
					}
				}

				if(isset($otherLocalLang['form'])){
					foreach(array_keys($otherLocalLang['form']) as $otherInd){
		//Looks fast approach, if in the other loop replacements will be made, if any 
		//   in form $enMap[$uri]=$localLang['form'][$index], where $uri=$localLang['form'][$index]['uri']
					  $otherUri=$otherLocalLang['form'][($otherInd)]['uri'];
					  $otherText=$otherLocalLang['form'][($otherInd)]['text'];
					  $enInd=$enMap[($otherUri)];
					  $localLang['form'][($enInd)]['text']=$otherText;
					}
				}

	//2. Language local other phrase replacements
				if(isset($otherLocalLang['other'])){
					foreach(array_keys($otherLocalLang['other']) as $otherKey){
					  $localLang['other'][($otherKey)]=$otherLocalLang['other'][($otherKey)];
					}
				}

			}

//Gets all phrases of current language and replaces in the phrases of default language
//   these phrases, which exist also in current language		

			$GLOBALS['localLang']=$localLang;

		}

	//===========

		if(isset($cachingMap))
			$output['cachingMap']=$cachingMap;
		if(isset($Region))
			$output['Region']=$Region;
		if(isset($regionMap))
			$GLOBALS['regionMap']=$regionMap;
		if(isset($themeData))
			$output['Theme']=$themeData;

		if(isset($output)){

			$this->globalData=$output;
		}

		$GLOBALS['pageType2']=$pageType2;

	/* Following message is for admin only - thus it needs no translating. */
		if(!isset($GLOBALS['regionMap']) && isset($GlobalData['GlobalCore']['regionMap'])){
			$GLOBALS['regionMap']=$GlobalData['GlobalCore']['regionMap'];
		}
		elseif($GLOBALS['siteStatus']!="new" && !isset($GLOBALS['regionMap']) && !isset($GlobalData['GlobalCore']['regionMap'])){
	//		$GLOBALS['regionMap']=$GlobalData['GlobalCore']['regionMap'];
			$GLOBALS['messageList'][]="Website system didn't recognize any regions.<br>This issue will usually appear because of one of the following reasons:<br>1) A language was chosen, which had no blocks. If this is the reason, then clearing cookies of your browser should help forcing website to use the default language again.<br>2) If you are trying to reinstall a website, then database may be empty, but configuration file and directory for current website already exists in sites directory. If this is the reason, then delete the old configuration directory about this website from sites directory and reload current web page to try installing again.";
			$GLOBALS['regionMap']=array();
		}

	}

}
