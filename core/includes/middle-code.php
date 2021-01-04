<?php
//Passes output values from global module Controller classes to View layout file

	if(!isset($GlobalData['GlobalCore']['cachingMap'])){
		$GlobalData['GlobalCore']['cachingMap']['status'] = "off";
		$GlobalData['GlobalCore']['cachingMap']['main']['status'] = "off";
	}
	
//	if(!isset($GlobalData['GlobalCore']['Url'])){
	if(isset($GlobalData['GlobalCore']['Url']) && isset($GlobalData['GlobalCore']['accessRight'])){
//Common case - default behaviour
	}
	elseif(!isset($GlobalData['GlobalCore']['Url']) && !isset($GlobalData['GlobalCore']['accessRight'])){
//Case, when website has not been installed yet
		$GlobalData['GlobalCore']['Url']['parts'] = Array ();
		$GlobalData['GlobalCore']['Url']['moduleData']['Name'] = "";
		$GlobalData['GlobalCore']['accessRight'] = 1;
	}
	else{
//Any other exceptional case, if any - no access
		$GlobalData['GlobalCore']['accessRight'] = 0;
	}

	$cachingMap=$GlobalData['GlobalCore']['cachingMap'];

	if(isset($GlobalData['GlobalCore']['Theme']))
		$Theme=$GlobalData['GlobalCore']['Theme'];

	$layoutPath=$Theme['path']."/";

	$accessRight=$GlobalData['GlobalCore']['accessRight'];

	if($GLOBALS['urlType']=="alias"){
		$localModPath=$defaultModPath;
		$incPart['Name']=$GlobalData['GlobalCore']['Url']['moduleData']['Name'];
	}

//Next if condition shows page if accessRight==TRUE?
	if(isset($GlobalData['GlobalCore']) && count($GlobalData['GlobalCore']['Url']['parts'])>0){
		$pathData['urlParts']=$GlobalData['GlobalCore']['Url']['parts'];
		$incPart=$GlobalData['GlobalCore']['Url']['moduleData'];
	}

	if(isset($cacheContent) && strlen($cacheContent)>0){
//Maybe deprecated and not needed? Cache functionality was implemented in another way, than was planned initially - without a separated phtml file -
//   see Caching code below!
		$layoutFile="cache.phtml";
	}

	if(isset($GlobalData['GlobalCore']['localModule'][0]))
	$Module=$GlobalData['GlobalCore']['localModule'][0];
	if(!isset($GlobalData['GlobalCore']['globalModules']))
		$GlobalData['GlobalCore']['globalModules']=array();
	$globalModules=$GlobalData['GlobalCore']['globalModules'];

//==================================================
//Global Modules overwrite

	if(isset($globalModules) && count($globalModules)>0){
//Overwriting details of global modules replacing config file Module data with database Module data
		foreach($globalModules as $row){

			$globalModC="modules/".$row['name']."/Controller/".$row['name']."Controller.php";
			include $globalModC;
			$modCName=$row['name']."Controller";
			$modContro=new $modCName();
			$modContro->dbConfig=$Database;
			$modContro->otherConfig=$Other;
			$modContro->modConfig=$ModConfig;
			$modContro->indexEvent();
			$GlobalData[($row['name'])]=$modContro->globalData;

		}

	}

	if($GLOBALS['pageType2']=="frontPage" && isset($GLOBALS['frontPageStatus']) && $GLOBALS['frontPageStatus']=="on"){
//If frontPage class and method have been recorded in db. table core_config
//   (this was clarified in GlobalCoreController class)
		$fpData=$GLOBALS['frontPageData'];
		$GLOBALS['frontPageView']="Frontpage has not been configured correctly.";

		$tempArr=explode("/",$fpData['value']);

		if(file_exists($fpData['uri'])){

			include $fpData['uri'];
			$className=$tempArr[0];
			$methodName=$tempArr[1];

			if(class_exists($className)){

				$fpOb=new $className();
				if(isset($Database))
					$fpOb->dbConfig=$Database;
				if(isset($Other))
					$fpOb->otherConfig=$Other;
				if(isset($ModConfig))
					$fpOb->modConfig=$ModConfig;

				if(method_exists($fpOb,$methodName))
					$GLOBALS['frontPageView']=$fpOb->$methodName($tempArr[2]);

			}
		}

	}

	if(isset($GLOBALS['regionMap'])){
//If custom global modules are used to prepare block view
		$Region=array();
		$regionMap=$GLOBALS['regionMap'];

		$uriBasedClasses=array();
		$blInstanceSet=array();
		foreach($regionMap as $regionArray){

			if(!isset($Region[($regionArray['regionName'])]))
				$Region[($regionArray['regionName'])]="";
			if($regionArray['type']=="uriBased"){

				if(file_exists($regionArray['uri']) && !in_array($regionArray['uri'], $uriBasedClasses)){

					include $regionArray['uri'];
					$uriBasedClasses[]=$regionArray['uri'];
//include_once is slower, than include
//					include_once $regionArray['uri'];
//If same class is used to prepare many uriBased blocks, and such class name repeats among core_block entries, 
//   then there may be multiple including attempts for the same class file.
//Such case may happen also, if a module will be uninstalled, which uses an uriBased block and 
//   installed again and installing inserts through sql file also the uriBased block second time.
//As alternative to the slower include_once function the array $uriBasedClasses will be used to avoid multiple including attempts.
					$reversedParts = explode('/', strrev($regionArray['uri']), 2);

					$className=str_replace(".php","",strrev($reversedParts[0]));
					$customBlock=new $className();
//$customBlock refers to different class instances by every loop cycle; 
//   following array helps to find (in following elseif condition)
//   existing block class instances using className as key.  
					$blInstanceSet[($className)]=$customBlock;

					if(isset($Database))
						$customBlock->dbConfig=$Database;
					if(isset($Other))
						$customBlock->otherConfig=$Other;
					if(isset($ModConfig))
						$customBlock->modConfig=$ModConfig;

					$methodName=$regionArray['displayMethod'];

					if(method_exists($customBlock,$methodName))
						$regionArray['view']=$customBlock->$methodName();
					else
						$regionArray['view']="";
				}
				elseif(file_exists($regionArray['uri']) && in_array($regionArray['uri'], $uriBasedClasses)){
//Case if there are more than one uriBased GlobalCore module blocks, 
//   which are using for their building one or more methods of the same class.

					$reversedParts = explode('/', strrev($regionArray['uri']), 2);
					$className=str_replace(".php","",strrev($reversedParts[0]));
					$customBlock=$blInstanceSet[($className)];

					if(isset($Database))
						$customBlock->dbConfig=$Database;
					if(isset($Other))
						$customBlock->otherConfig=$Other;
					if(isset($ModConfig))
						$customBlock->modConfig=$ModConfig;

					$methodName=$regionArray['displayMethod'];

					if(method_exists($customBlock,$methodName))
						$regionArray['view']=$customBlock->$methodName();
					else
						$regionArray['view']="";
				}

			}

			$Region[($regionArray['regionName'])].=$regionArray['view'];

		}

	}else {
		if(!isset($GlobalData['GlobalCore']['Region']))
			$GlobalData['GlobalCore']['Region']=array();
		$Region=$GlobalData['GlobalCore']['Region'];
	}
	if($GLOBALS['siteStatus']=="new"){
		$siteName="Allmice CMS - Install a new website";
		$GLOBALS['messages'][]="<a href=\"".$GLOBALS['baseUrl']."/app/install-website\">Click here to install a new website!</a>\n";

		$GLOBALS['logoImage']="<img src=\"".$GLOBALS['baseUrl']."/misc/input/themes/default/new-website-logo.png\">";
	}
	elseif($GLOBALS['siteStatus']=="ConfigOkDbProblem"){
		$siteName="Allmice CMS - Database problem";
		if(count($GLOBALS['messages'])!=0)
			$GLOBALS['messages'][]="This website has a database problem!\n";
	}

//==================================================
//Local Module overwrite

//Caching choice - choose Caching module as local module instead of url based option
	//Allowing custom module paths
	$modPath="modules/";
	if(isset($Module['codePath']) && $Module['codePath']!="")
		$modPath=$Module['codePath'];

//Preparing current URL based module details
	if(isset($Module['path']) && $Module['path']!="" && $pathData['urlParts'][0]!="" && $Module['path']==$pathData['urlParts'][0]){
		$curTime=time();

		$incPart['Name']=$Module['name'];
		$incPart['View']=$Module['path'];

		$localModPath=$modPath;

		if($Module['configPath']!="" && file_exists($Module['configPath']))
			include $Module['configPath'];

	}

	if(isset($cachingMap['main']['status']) && $cachingMap['main']['status']=="valid"){
		$curTime=time();
		unset($localModPath);
	}
