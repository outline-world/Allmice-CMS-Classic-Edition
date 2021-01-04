<?php

/*
Be aware, that in case of multi-site system the config values in this file are valid for every site.
If you wish to have separate config values for different sites in a multisite code-system, then use some module, 
which replaces such configuration values with new values from core_config table.
*/

//========================================
/*Development config start*/
/*Following lines of code are for sites under development. 
Comment them out, if the website is stable and active, to avoid: 
* webpage creating time calculation message at the end of every page;
* unlikely, but still possible error and warning messages. */

/*
	$startTime = round(microtime(true) * 1000);
	//Errors, warnings, notices
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$finalCode="core/includes/final-code.php";
 */

/*Development config end*/
	
	$GLOBALS['siteSaltData']="$5$"."rounds=5000$";
	$GLOBALS['pwSaltData']="$5$"."rounds=5000$";
	$GLOBALS['siteSaltLength']=16;
	$GLOBALS['pwSaltLength']=16;
	
	$GLOBALS['hostBase']=$pathData['host'].$pathData['base'];
	
	//Following values should be overwritten by the corresponding values in core_config database table, but are still kept here for any case as older code.
	$dateFormat='d/m/Y';
	$GLOBALS['langCode']="en";
	$GLOBALS['dateFormat']=$dateFormat;
	$GLOBALS['timeFormat']='d/m/Y H:i';

	$Theme = array(
//The minimal system needs a default theme, which is configured here and located in core/themes directory.
//Such default theme (any theme in core/themes directory) can not be installed through Theme module. 
//Such theme gets installed by installing the minimal system. */
		'name' => "AllmiceDefault",
		'path' => "core/themes/AllmiceDefault",
	);

	$layoutFile="layout.phtml";
	$layoutPath="core/View/";

//===> Add modules as 'members' of the array 'Module'
//   for global modules (those which are activated always and not depending on URLs) leave 'path' value empty.

	$corePath="core/modules/";
	$defaultModPath="modules/";

	$Module[] = array(
		'name' => "App",
		'path' => "app",
		'codePath' => $corePath,
		'configPath' => "",
	);
	$Module[] = array(
		'name' => "GlobalCore",
		'path' => "",
		'codePath' => $corePath,
		'configPath' => "",
	);

	$middleCode="core/includes/middle-code.php";
	$beforeViewCode="core/includes/before-view-code.php";

	$frontPage="front-page.phtml";
	$wrongUrlPath="wrong-address.phtml";

//Choose template file for edition
	$Other['installPath']="misc/input/install-website/TemplateMinimal";
	$Other['installPath']="misc/input/install-website/TemplateClassic";
	$GLOBALS['version']="Classic Edition 🐭 Version 1.7.1";

	$tempArr=explode("://",$GLOBALS['baseUrl']);
	$sitePath=str_replace("/","_",$tempArr[1]);
	$configPath=("sites/".$sitePath."/config.php");

	$tempArr2=explode("_",$sitePath,2);
	if(!isset($tempArr2[1]))
		$tempArr2[1]=$tempArr2[0];
	$configPath2=("sites/".$tempArr2[1]."/config.php");

	if(!file_exists($configPath) && file_exists($configPath2)){
		$configPath=$configPath2;
	}
	if(file_exists($configPath))
		include($configPath);

	$GLOBALS['dateFormat']=$dateFormat;

	$aliasSwitch="off";
	$aliasSwitch="on";

	$cacheSwitch="off";
	$cacheSwitch="on";

//Be careful with accessSwitch - if it is off, then all content is available for all visitors - 
//   e.g. anonymous unauthenticated visitors can delete, insert and modify data.
	$accessSwitch="off";
	$accessSwitch="on";

	$blockSwitch="off";
	$blockSwitch="on";

	$themeSwitch="off";
	$themeSwitch="on";

	$blockLanguageSwitch="off";

	$roleMode="multiple";
	$roleMode="single";

	$ModConfig['aliasSwitch']=$aliasSwitch;
	$ModConfig['cacheSwitch']=$cacheSwitch;
	$ModConfig['accessSwitch']=$accessSwitch;
	$ModConfig['themeSwitch']=$themeSwitch;
	$ModConfig['blockSwitch']=$blockSwitch;
	$ModConfig['roleMode']=$roleMode;

//==>Finding current site id - Start

	if(isset($siteName)){
		$Other['siteName']=$siteName;
		$GLOBALS['siteName']=$siteName;
	}else{
		$GLOBALS['siteName']="";
	}

	if(isset($siteSalt)){
		$plainString=$pathData['host'].$pathData['base'];

		$salt=$GLOBALS['siteSaltData'].$siteSalt.'$';

		$siteHash=crypt($plainString,$salt);

		$tempArr=explode("$",$siteHash);
		$siteId=$tempArr[4];
		$Other['siteId']=$siteId;

		$Other['siteId']=$siteSalt;

		$Other['siteSalt']=$siteSalt;
	}
	$baseUrl=$GLOBALS['baseUrl'];

//==>Finding current site id - End

	$GLOBALS['urlType']="source";
	$GLOBALS['pageTitle']="";
	$pageType="html";

/*Development config end*/

//========================================
/*End-user config start*/

//CacheperiodMin in minutes	
	$ModConfig['cachePeriodMin']=60;
	$ModConfig['cachePeriod']=$ModConfig['cachePeriodMin']*60;

/*
Session handling -> see class GlobalCoreController
* Sessions will be saved in database.
* Session lifetime control - a "last activity" session variable will be used.
* To restrict the size of session database -
*    a cleaning method will be called after every $modConfig['sessDbCleanPeriod'] seconds.
*    The cleaning method is in GlobalCore module database class - cleanSessData($modConfig['sessDbCleanPeriod']).
*/
//Session inactivity lifetime in x minutes: $ModConfig['sessLifetime']=x*60; 
	$ModConfig['sessLifetime']=2*60*60;
//Database cleaning period of session entries in x days: $ModConfig['sessDbCleanPeriod']=x*24*60*60; 
	$ModConfig['sessDbCleanPeriod']=30*24*60*60;

	$GLOBALS['wrongAddress']="Page was not found or you have no access to this page.";

/*End-user config end*/
