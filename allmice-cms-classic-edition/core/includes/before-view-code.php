<?php

	if(isset($_SESSION[($GLOBALS['siteId'])]['messageList']) && count($_SESSION[($GLOBALS['siteId'])]['messageList'])>0){
//Messages can be displayed easy everywhere in the Allmice CMS code.
//   Just add an item as message string to the array $_SESSION[($GLOBALS['siteId'])]['messageList'].
//   Such messages will be kept as session arrays even if submit button makes a redirect and will be displayed in this case after redirect.
//   After displaying such messages the array $_SESSION[($GLOBALS['siteId'])]['messageList'] will be cleared (unset)
//      so that the messages will be displayed only once.

		if(isset($GLOBALS['messageList'])){
			$GLOBALS['messageList']=array_merge($GLOBALS['messageList'],$_SESSION[($GLOBALS['siteId'])]['messageList']);
		}else{
			$GLOBALS['messageList']=$_SESSION[($GLOBALS['siteId'])]['messageList'];
		}
		unset($_SESSION[($GLOBALS['siteId'])]['messageList']);

	}

	if(isset($GLOBALS['messageList'])){
//If you wish to display messages on current page, then add them to the array $GLOBALS['messageList'] or $_SESSION[($GLOBALS['siteId'])]['messageList'].
//   If you wish the messages to be displayed after a submit button click or redirect to another page happens, then add them 
//      to array $_SESSION[($GLOBALS['siteId'])]['messageList']. 
		if(isset($Region['messageArea']) && $Region['messageArea']!=""){
		}
		else
			$Region['messageArea']="";

		$mes=$GLOBALS['messageList'];

		if(!in_array("messageClassEnd", $mes)){
			for($i=0;$i<count($mes);$i++) {
	
				$mes[$i]=str_replace("&amp;","&",$mes[$i]);
				$mes[$i]=str_replace("&#39;","'",$mes[$i]);
				if($i<(count($mes)-1))
					$Region['messageArea'].=($mes[$i]."<br />\n");
				else
					$Region['messageArea'].=($mes[$i]."\n");
	
			}
		}
		else{
			for($i=0;$i<count($mes);$i++) {
	
				$mes[$i]=str_replace("&amp;","&",$mes[$i]);
				$mes[$i]=str_replace("&#39;","'",$mes[$i]);
				if(strstr($mes[$i],"messageClassStart-")){
					$tempArr=explode("-",$mes[$i],2);

					if($tempArr[1]=="green"){
						$tempArr[1]="success-note";
					}
					elseif($tempArr[1]=="red"){
						$tempArr[1]="problem-note";
					}

					$Region['messageArea'].=("<div class=\"".$tempArr[1]."\">");
				}
				elseif($mes[$i]=="messageClassEnd")
					$Region['messageArea'].=("</div>\n");
//				elseif($i<(count($mes)-1))
				elseif($i<(count($mes)-2))
					$Region['messageArea'].=($mes[$i]."<br />\n");
				else
					$Region['messageArea'].=($mes[$i]."\n");
	
			}
		}

	}

	if(isset($cachingMap['main']) && $cachingMap['main']['status']=="elapsed"){

		ob_start(); // turn on output buffering

		include($contentView);
		$mainContent = ob_get_contents(); // get the contents of the output buffer
		ob_end_clean(); //  clean (erase) the output buffer and turn off output buffering

		$mainContent=str_replace("'","&#39;",$mainContent);
//Backslash \ ascii code 92, may not show good creating different meaning (escaping character for \n, \t, \r, etc.)
		$mainContent=str_replace("\\","&#92;",$mainContent);

		$contentSet=array();
		$contentSet['type']="general";
		$contentSet['title']="";
		$contentSet['description']="";
		$contentSet['mainContent']=$mainContent;
		if(isset($GLOBALS['pageTitle']))
			$contentSet['title']=$GLOBALS['pageTitle'];
		if(isset($GLOBALS['metaSet']['description']))
			$contentSet['description']=$GLOBALS['metaSet']['description'];

		$curTime=time();

		if($contentSet['type']=="general"){
			//If caching type is general - this means managed with GlobalCore Caching class 
			$incModC="core/modules/GlobalCore/Model/Caching.php";
			if(file_exists($incModC)){
				include $incModC;

				$caching=new Caching();
				$cachingMap['main']['content']=serialize($contentSet);

				$cachingMap['main']['lastTime']=$curTime;
				$caching->updateCacheData($cachingMap['main']);

			}
		}

	}
	elseif(isset($cachingMap['main']) && $cachingMap['main']['status']=="valid"){

		$cacheContent=$cachingMap['main']['content'];
		$cacheContent=str_replace("&#92;","\\",$cacheContent);
		$cacheContent=str_replace("&#39;","'",$cacheContent);

		$contentView=$layoutPath."cache.phtml";
	//View component of the framework

	}

	if(isset($GLOBALS['pageStatus'])){
	
		if($GLOBALS['pageStatus']=="wrongUrl"){
			$contentView=$layoutPath.$wrongUrlPath;
			$GLOBALS['metaSet']['bot']="<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
		}
		$GLOBALS['metaTags']=$GLOBALS['metaSet']['base'].$GLOBALS['metaSet']['bot'].$GLOBALS['metaSet']['description']."\n";
	}
	
	if(isset($GLOBALS['pageType']) && $GLOBALS['pageType']=="print"){
		$layoutFile="layout-print.phtml";
		$layoutLocation=$layoutPath.$layoutFile;
	}
	elseif(isset($GLOBALS['pageType']) && $GLOBALS['pageType']=="pdf"){
		$layoutFile="layout-pdf.php";
		$layoutLocation=$layoutPath.$layoutFile;
	}

	$titlePrefix="";

	if(isset($Region['siteName']) && $Region['siteName']!="")
		$GLOBALS['siteName']=$siteName;
	elseif(isset($siteName) && $siteName!="")
		$GLOBALS['siteName']=$siteName;
	else
		$GLOBALS['siteName']="";

	if(isset($GLOBALS['titleTagTemplate']) && isset($GLOBALS['titleTagTemplate'])!=""){
//If a method, which uses template
		$GLOBALS['titleTag']=$GLOBALS['titleTagTemplate'];
		if(isset($GLOBALS['pageTitle']) && $GLOBALS['pageTitle']!="")
			$GLOBALS['titleTag']=str_replace("[title]",$GLOBALS['pageTitle'],$GLOBALS['titleTag']);
		$GLOBALS['titleTag']=str_replace("[siteName]",$GLOBALS['siteName'],$GLOBALS['titleTag']);
	}
	else{
//If template is not used
		if(isset($GLOBALS['pageType2']) && $GLOBALS['pageType2']!="frontPage"){
			if(isset($GLOBALS['urlParts'][0]) && $GLOBALS['urlParts'][0]!=""){
				$titlePrefix=ucwords(str_replace("-"," ",$GLOBALS['urlParts'][0]));
				if(isset($GLOBALS['urlParts'][1]) && $GLOBALS['urlParts'][1]!=""){
					$titlePrefix=$titlePrefix." - ".ucfirst(str_replace("-"," ",$GLOBALS['urlParts'][1]));
				}
				$titlePrefix=$titlePrefix." | ";
			}
		}
		$GLOBALS['titleTag']=$titlePrefix.$GLOBALS['siteName'];
	}

//==> You can compose in a module totally custom titles
	if(isset($GLOBALS['customTitle']) && $GLOBALS['customTitle']!="")
		$GLOBALS['titleTag']=$GLOBALS['customTitle'];

//==> You can use a custom view file for a module method, if module method supports it.
//In this case in module method - before return array there must be following lines, which shows path to the custom view file recorded in database as config entry:
//			$configData=$appDb->getConfigData($whereClauseEnd);
//        $GLOBALS['viewPath']=$configData['listByTypeEvent']['viewPath'];
/*There must be a config entry for this module method - it can be added through module install sql file.
The config entry must have following properties, if e.g. Search module list-by-type method:
Module name: Search
uri: viewPath
Type: listByTypeEvent
Description: 
Value: custom/templates/search/list-by-type.phtml
*/
	if(isset($GLOBALS['viewPath']) && $GLOBALS['viewPath']!=""){
		if (file_exists($GLOBALS['viewPath'])){
//		if (file_exists($GLOBALS['viewPath']) && strstr($contentView,"list-by-type.phtml")){
			$contentView=$GLOBALS['viewPath'];
		}
	}
