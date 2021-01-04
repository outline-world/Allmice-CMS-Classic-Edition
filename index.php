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

	function getPathData() {
	  $path = array();
	  if (isset($_SERVER['REQUEST_URI'])) {
	    $requestPath = explode('?', $_SERVER['REQUEST_URI']);

	    $path['host'] = $_SERVER['SERVER_NAME'];
	    $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
	    $path['specificUtf8'] = substr(urldecode($requestPath[0]), strlen($path['base']) + 1);
	    $path['specific'] = utf8_decode($path['specificUtf8']);
	    if ($path['specific'] == basename($_SERVER['PHP_SELF'])) {
	      $path['specific'] = '';
	    }
	    $path['urlParts'] = explode('/', $path['specific']);
	  }
		return $path;
	}
	$pathData = getPathData();

	if(isset($_SERVER['HTTPS']))
		$protocol="https";
	else
		$protocol="http";

	$uri1 = $_SERVER['SERVER_NAME'];
	$uri2 = $_SERVER['REQUEST_URI'];

/*
Framework system 'root' scope arrays related to Controller classes.
   These arrays are not global and must be passed between the scopes (e.g. from 'root' scope to the modules' controller classes).
$Module
$Database
$Other

$GLOBALS variables initialized here in index.php file:
	$GLOBALS['host']
	$GLOBALS['baseUrl']
	$GLOBALS['curUrl']
	$GLOBALS['urlParts']
	$GLOBALS['modName'] 
	$GLOBALS['modPath']
*/
	$GLOBALS['host']=$pathData['host'];
	$GLOBALS['baseUrl']=$protocol."://".$pathData['host'].$pathData['base'];
	$GLOBALS['curUrl']=$protocol."://".$uri1.$uri2;
	$GLOBALS['urlParts']=$pathData['urlParts'];

//Note: Finding out, which module corresponds to current URL and including 'global modules'
	$pathCoreModel="core/Model/";
	$pathCoreController="core/Controller/";

	include_once ("config.php");

	foreach($Module as $row){

//Allowing custom module paths
		$modPath="modules/";
		if(isset($row['codePath']) && $row['codePath']!="")
			$modPath=$row['codePath'];

//Preparing current URL based module details
		if($row['path']!="" && $pathData['urlParts'][0]!="" && $row['path']==$pathData['urlParts'][0]){
			$incPart['Name']=$row['name'];

			$incPart['View']=$row['path'];

			$localModPath=$modPath;

//Including url module based config, if any
			if($row['configPath']!="" && isset($row['configPath']))
				include_once $row['configPath'];

		}

//Including global modules
		if($row['path']==""){

//Including global module based config, if any
			if($row['configPath']!="" && isset($row['configPath']))
				include_once $row['configPath'];

			$globalModC=$modPath.$row['name']."/Controller/".$row['name']."Controller.php";

			include_once $globalModC;

			$modCName=$row['name']."Controller";

			$modContro=new $modCName();
			if(isset($Database))
				$modContro->dbConfig=$Database;
			if(isset($Other))
				$modContro->otherConfig=$Other;
			if(isset($ModConfig))
				$modContro->modConfig=$ModConfig;
			$modContro->indexEvent();
			$GlobalData[($row['name'])]=$modContro->globalData;

		}
	}

	if(isset($middleCode))
		include_once $middleCode;

//Including current url-based module components.

	$eventName="";

	if($pathData['urlParts'][0]!="" && isset($localModPath) && isset($incPart['Name'])){

			$incModC=$localModPath.$incPart['Name']."/Controller/".$incPart['Name']."Controller.php";

			$pathModuleView=$localModPath.$incPart['Name']."/View/";
			$pathModuleModel=$localModPath.$incPart['Name']."/Model/";
			$pathModuleMain=$localModPath.$incPart['Name']."/";

		if(count($pathData['urlParts'])==1){

			$contentView=$pathModuleView."index.phtml";
			$eventName="indexEvent";

		}
		elseif(count($pathData['urlParts'])>1){

			$tempArr=explode("-",$pathData['urlParts'][1]);
			$eventName.=$tempArr[0];		
			for($i=1;$i<count($tempArr);$i++){
				$eventName.=ucfirst($tempArr[$i]);		
			}
			$eventName.="Event";		
			$contentView=$pathModuleView.($pathData['urlParts'][1].".phtml");

		}

		$GLOBALS['modName']=$incPart['Name'];
		$GLOBALS['modPath']=$incPart['View'];

		if(file_exists($incModC)){

			include_once $incModC;

			$modCName=$incPart['Name']."Controller";

			$modContro=new $modCName();
			if(isset($Database))
				$modContro->dbConfig=$Database;
			if(isset($Other))
				$modContro->otherConfig=$Other;
	//$ModConfig will be chosen according to module url - see above
			if(isset($ModConfig))
				$modContro->modConfig=$ModConfig;
			if(isset($modLang))
				$modContro->modLang=$modLang;

			if (method_exists($modContro,$eventName)){
				$viewData=$modContro->$eventName();
				extract($viewData);
			}else{
				$contentView=$layoutPath.$wrongUrlPath;
			}

		}else{
			$contentView=$layoutPath.$wrongUrlPath;
		}

	}
	elseif($pathData['urlParts'][0]==""){
		$contentView=$layoutPath.$frontPage;
	}
	else{
		$contentView=$layoutPath.$wrongUrlPath;
	}

//View component of the framework
	if($pageType=="pdf"){
		$layoutFile="layout-pdf.phtml";
	}

	$layoutLocation=$layoutPath.$layoutFile;

	if(isset($beforeViewCode))
		include_once($beforeViewCode);

	include_once($layoutLocation);

	if(isset($finalCode))
		include_once $finalCode;
