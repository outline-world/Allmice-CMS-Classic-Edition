<?php

class GlobalBlock
{

	public $id;

	public function buildVerticalMenuBlock($blockCode,$itemData,$menuTitle)
	{

		$menuCode="\n";

		$menuCode.="<div class=\"menu-title\"><h2>\n";
		$menuCode.=$menuTitle;
		$menuCode.="</h2></div>\n";
		$menuCode.="<div class=\"menu-content\">\n";
		$menuCode.="<ul class=\"menu menu-parent\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		

		$arraySize=count($itemData);
		for($i=0;$i<$arraySize;$i++){
			$itemStatus="normal";
			$itemCode="";
			if($itemData[$i]['uri']==$curUri){
				$itemTag="<li class=\"menu active menu-item\">\n";
				$itemStatus="active";
			}
			else{
				$itemTag="<li class=\"menu menu-item\">\n";
			}

			$langUri="item/".$itemData[$i]['id'];

			if($lastDepth<$itemData[$i]['depth']){
				if($i!=0){
					$menuCode.="<ul class=\"menu menu-child\">\n";
				}
				$itemCode.=$itemTag;
			}else{
				$itemCode.=$itemTag;
			}

			if ($itemData[$i]['status']==2)
				$target=" target=\"_blank\"";
			else
				$target="";

			if (substr($itemData[$i]['uri'], 0, 1) == '/'){
				if($itemStatus=="active")
					$itemCode.="<div class=\"menu-ap\">\n";
				else
					$itemCode.="<div class=\"menu-pp\">\n";
				$itemCode.="<a href=\"".$GLOBALS['baseUrl'].''.$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a>\n";
				$itemCode.="</div>\n";
			}
			else{
				if($itemStatus=="active")
					$itemCode.="<div class=\"menu-ap\">\n";
				else
					$itemCode.="<div class=\"menu-pp\">\n";
				$itemCode.="<a href=\"".$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a>\n";
				$itemCode.="</div>\n";
			}

			if($i!=(count($itemData)-1) && $itemData[$i]['depth']==$itemData[($i+1)]['depth']){
//Closing an item level
				$itemCode.="</li>\n";
				//Not end of menu
			}
			if(isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>$itemData[($i+1)]['depth']){
				//End of level in the middle of menu
				for($k=$itemData[($i+1)]['depth'];$k<$itemData[($i)]['depth'];$k++){
					//There may end many levels at the same time
				$itemCode.="</li>\n";
				$itemCode.="</ul>\n";
				}
			}
			if($i!=(count($itemData)-1) && $itemData[$i]['depth']>$itemData[($i+1)]['depth']){
				$itemCode.="</li>\n";
				//Not end of menu; current item's depth is bigger, than next item's depth
			}
			if(!isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>0){
				//End of menu
				for($k=0;$k<$itemData[($i)]['depth'];$k++){
					//There may end many levels at the same time
					$itemCode.="</li>\n";
					$itemCode.="</ul>\n";
				}
			}
			$lastDepth=$itemData[$i]['depth'];
			$menuCode.=$itemCode;
		}
		$menuCode.="</div>\n";
		return $menuCode;

	}

	public function buildActiveSubMenuBlock($blockCode,$itemData,$menuTitle)
	{

		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);

		$openMainId="";
		$openItemId="";

		$menuCode="\n";
		$itemDataModi=array();

		$arraySize=count($itemData);
		for($i=0;$i<$arraySize;$i++){
//1. loop adds parentCode and itemCode
//   and finds out which parent menu will be open

			$itemCode=$itemData[$i]['order_code'];
			$tempArr=explode("-",$itemCode,2);
			$itemData[$i]['parentCode']=$tempArr[0];
			$itemData[$i]['itemCode']=$itemCode;

			if($curUri==$itemData[$i]['uri']){
				$openMainId=$tempArr[0];
				$openItemId=$itemCode;
			}

		}

		$j=0;
		for($i=0;$i<$arraySize;$i++){
//2. loop removes unnecessary items 
			if($itemData[$i]['depth']==1 || $itemData[$i]['parentCode']==$openMainId){
				$itemDataModi[$j]=$itemData[$i];
				$j++;
			}

		}

		$menuCode="\n";

		$menuCode.="<div class=\"menu-title\"><h2>\n";
		$menuCode.=$menuTitle;
		$menuCode.="</h2></div>\n";
		$menuCode.="<div class=\"menu-content\">\n";
		$menuCode.="<ul class=\"menu menu-parent\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		

		$itemData=$itemDataModi;
		$arraySize=count($itemDataModi);
		for($i=0;$i<$arraySize;$i++){
//3. loop creates the menu code 
			$itemStatus="normal";

			$itemCode="";
			if($itemData[$i]['uri']==$curUri){
				$itemTag="<li class=\"active\">\n";
				$itemStatus="active";
			}
			else{
				$itemTag="<li>\n";
			}

			$langUri="item/".$itemData[$i]['id'];

			if($lastDepth<$itemData[$i]['depth']){
				if($i!=0){
					$menuCode.="<ul class=\"menu menu-child\">\n";
				}
				$itemCode.=$itemTag;
			}else{
				$itemCode.=$itemTag;
			}

			if ($itemData[$i]['status']==2)
				$target=" target=\"_blank\"";
			else
				$target="";

			if (substr($itemData[$i]['uri'], 0, 1) == '/'){
				if($itemStatus=="active")
					$itemCode.="<div class=\"menu-ac\">\n";
				else
					$itemCode.="<div class=\"menu-pc\">\n";
				$itemCode.="<a href=\"".$GLOBALS['baseUrl'].''.$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a>\n";
				$itemCode.="</div>\n";
			}
			else{
				if($itemStatus=="active")
					$itemCode.="<div class=\"menu-ac\">\n";
				else
					$itemCode.="<div class=\"menu-pc\">\n";
				$itemCode.="<a href=\"".$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a>\n";
				$itemCode.="</div>\n";
			}

			if($i!=(count($itemData)-1) && $itemData[$i]['depth']==$itemData[($i+1)]['depth']){
//Closing an item level
				$itemCode.="</li>\n";
				//Not end of menu
			}
			if(isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>$itemData[($i+1)]['depth']){
				//End of level in the middle of menu
				for($k=$itemData[($i+1)]['depth'];$k<$itemData[($i)]['depth'];$k++){
					//There may end many levels at the same time
				$itemCode.="</li>\n";
				$itemCode.="</ul>\n";
				}
			}
			if($i!=(count($itemData)-1) && $itemData[$i]['depth']>$itemData[($i+1)]['depth']){
				$itemCode.="</li>\n";
				//Not end of menu; current item's depth is bigger, than next item's depth
			}
			if(!isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>0){
				//End of menu
				for($k=0;$k<$itemData[($i)]['depth'];$k++){
					//There may end many levels at the same time
					$itemCode.="</li>\n";
					$itemCode.="</ul>\n";
				}
			}
			$lastDepth=$itemData[$i]['depth'];
			$menuCode.=$itemCode;

		}
		$menuCode.="</div>\n";

		return $menuCode;

	}

	public function buildDropDownAllSubBlock($blockCode,$itemData,$menuTitle)
	{

		$currentItem="#";

		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);

		$openMainId="";
		$openItemId="";

		$menuCode="\n";
		$itemDataModi=array();

		$arraySize=count($itemData);
		for($i=0;$i<$arraySize;$i++){
//1. loop adds parentCode and itemCode
//   and finds out which parent menu will be open

			$itemCode=$itemData[$i]['order_code'];
			$tempArr=explode("-",$itemCode,2);
			$itemData[$i]['parentCode']=$tempArr[0];
			$itemData[$i]['itemCode']=$itemCode;

			if($curUri==$itemData[$i]['uri']){
				$openMainId=$tempArr[0];
				$openItemId=$itemCode;
			}

		}
//2. loop removes unnecessary items 

		$menuCode="\n";

		$menuCode.="<div class=\"dd-menu\">\n";
		$menuCode.="<ul id=\"".$blockCode."\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		
		$subMenuStatus="closed";
		for($i=0;$i<$arraySize;$i++){
//2. loop creates the menu code 

			if(($lastDepth==0 || $lastDepth==1) && $itemData[$i]['depth']>1){
//Opens submenu if there are items left
				$menuCode.="<div class=\"dd-content\">\n";
				$subMenuStatus="open";

			}

			$itemCode="";
			if($itemData[$i]['depth']==1){
				$itemTag="<li class=\"main-item\">\n";

			}
			else
			{
					$itemTag="<li>\n";
			}

			$langUri="item/".$itemData[$i]['id'];

			if($lastDepth<$itemData[$i]['depth']){
				if($i!=0){
					$menuCode.="<ul class=\"sub-menu\">\n";
				}
				$itemCode.=$itemTag;
			}else{
				$itemCode.=$itemTag;
			}

			if ($itemData[$i]['status']==2)
				$target=" target=\"_blank\"";
			else
				$target="";

			if(strstr($openItemId,$itemData[$i]['itemCode']))
				$activeClass=" active";
			else
				$activeClass="";

			if($itemData[$i]['depth']==1){
				if (substr($itemData[$i]['uri'], 0, 1) == '/')
					$itemCode.="<div class=\"main-item".$activeClass."\"><a href=\"".$GLOBALS['baseUrl'].''.$itemData[$i]['uri']."\"".$target." class=\"drop-link\">".$itemData[$i]['label']."</a></div>\n";
				else
					$itemCode.="<div class=\"main-item".$activeClass."\"><a href=\"".$itemData[$i]['uri']."\"".$target." class=\"drop-link\">".$itemData[$i]['label']."</a></div>\n";
			}else{
				if (substr($itemData[$i]['uri'], 0, 1) == '/')
					$itemCode.="<div class=\"sub-item".$activeClass."\"><a href=\"".$GLOBALS['baseUrl'].''.$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a></div>\n";
				else
					$itemCode.="<div class=\"sub-item".$activeClass."\"><a href=\"".$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a></div>\n";
			}

			if($i!=(count($itemData)-1) && $itemData[$i]['depth']==$itemData[($i+1)]['depth']){
//Closing an item level
				$itemCode.="</li>\n";
				//Not end of menu
			}
			if(isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>$itemData[($i+1)]['depth']){
				//End of level in the middle of menu
				for($k=$itemData[($i+1)]['depth'];$k<$itemData[($i)]['depth'];$k++){
					//There may end many levels at the same time
					$itemCode.="</li>\n";
					$itemCode.="</ul>\n";
				}
				if($subMenuStatus=="open" && $itemData[($i+1)]['depth']==1){
	//Opens submenu if there are items left
					$itemCode.="</div>\n";
					$subMenuStatus="closed";
				}
			}
			if($i!=(count($itemData)-1) && $itemData[$i]['depth']>$itemData[($i+1)]['depth']){

				$itemCode.="</li>\n";
				//Not end of menu; current item's depth is bigger, than next item's depth
			}
			if(!isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>0){
				//End of menu
				for($k=0;$k<$itemData[($i)]['depth'];$k++){
					//There may end many levels at the same time
					if($k==$itemData[($i)]['depth']-1){
						if($subMenuStatus=="open"){
			//Opens submenu if there are items left
							$itemCode.="</div>\n";
							$subMenuStatus="closed";
						}
					}
					$itemCode.="</li>\n";
					$itemCode.="</ul>\n";
				}

			}

			$lastDepth=$itemData[$i]['depth'];
			$menuCode.=$itemCode;

		}

		$menuCode.="</div>\n";

		return $menuCode;

	}

	public function buildHorizontalMenuBlock($blockCode,$itemData,$menuTitle)
	{

		$menuCode="\n";

		$menuCode.="<div class=\"navi navi-content\">\n";
		$menuCode.="<ul class=\"navi navi-parent\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		

		for($i=0;$i<count($itemData);$i++){
			$itemCode="";

			if($itemData[$i]['uri']==$curUri)
				$itemTag="<li class=\"navi active navi-item\">\n";
			else
				$itemTag="<li class=\"navi navi-item\">\n";
			$langUri="item/".$itemData[$i]['id'];

			if($lastDepth<$itemData[$i]['depth']){
				if($i!=0){
					$menuCode.="<ul class=\"navi navi-child\">\n";
				}
				$itemCode.=$itemTag;
			}else{
				$itemCode.=$itemTag;
			}

			if ($itemData[$i]['status']==2)
				$target=" target=\"_blank\"";
			else
				$target="";

			if (substr($itemData[$i]['uri'], 0, 1) == '/')
				$itemCode.="<a href=\"".$GLOBALS['baseUrl'].''.$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a>\n";
			else
				$itemCode.="<a href=\"".$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a>\n";

			if($i!=(count($itemData)-1) && $itemData[$i]['depth']==$itemData[($i+1)]['depth']){
//Closing an item level
				$itemCode.="</li>\n";
				//Not end of menu
			}
			if(isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>$itemData[($i+1)]['depth']){
				//End of level in the middle of menu
				for($k=$itemData[($i+1)]['depth'];$k<$itemData[($i)]['depth'];$k++){
					//There may end many levels at the same time
				$itemCode.="</li>\n";
				$itemCode.="</ul>\n";
				}
			}
			if($i!=(count($itemData)-1) && $itemData[$i]['depth']>$itemData[($i+1)]['depth']){
				$itemCode.="</li>\n";
				//Not end of menu; current item's depth is bigger, than next item's depth
			}
			if(!isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>0){
				//End of menu
				for($k=0;$k<$itemData[($i)]['depth'];$k++){
					//There may end many levels at the same time
					$itemCode.="</li>\n";
					$itemCode.="</ul>\n";
				}
			}
			$lastDepth=$itemData[$i]['depth'];
			$menuCode.=$itemCode;
		}

		$menuCode.="</div>\n";
		return $menuCode;

	}

	public function buildLinkSet($menuCode,$itemData,$menuTitle,$menuLang,$menuType)
	{

		$menuCode="\n";

		if($menuType==33 || $menuType==34){
			if(isset($menuLang['title']))
				$menuTitle=$menuLang['title'];
			$menuCode.="<div class=\"set-title\"><h2>\n";
			$menuCode.=$menuTitle;
			$menuCode.="</h2></div>\n";
		}
		$menuCode.="<div class=\"set-content\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		

		for($i=0;$i<count($itemData);$i++){

			$itemCode="";

			if($itemData[$i]['uri']==$curUri)
				$itemTag="<div class=\"active set-item l".$itemData[$i]['depth']."\" id=\"set-".$itemData[$i]['id']."\">\n";
			else
				$itemTag="<div class=\"set-item l".$itemData[$i]['depth']."\" id=\"set-".$itemData[$i]['id']."\">\n";

			$langUri="item/".$itemData[$i]['id'];

			if(isset($menuLang[($langUri)]) && $menuLang[($langUri)]!="")
				$itemData[$i]['label']=$menuLang[($langUri)];

			$itemCode.=$itemTag;

			if ($itemData[$i]['status']==2)
				$target=" target=\"_blank\"";
			else
				$target="";

			if (substr($itemData[$i]['uri'], 0, 1) == '/')
				$itemCode.="<a href=\"".$GLOBALS['baseUrl'].''.$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a>\n";
			else
				$itemCode.="<a href=\"".$itemData[$i]['uri']."\"".$target.">".$itemData[$i]['label']."</a>\n";

			$itemCode.="</div>\n";
			$menuCode.=$itemCode;
		}
		$menuCode.="</div>\n";
		return $menuCode;

	}

	public function buildMenuBlock($blockCode,$itemData,$menuData)
	{

		$menuCode="";

//Very important - do not delete this comment!!!
//If $blockLang is empty or otherwise not in use, then it may cause the problem, 
//   that url request will be made many times and $_SESSION variables can not be used properly.
//   That's why $blockLang is at the moment commented out in the following methods.

		$menuTitle=$menuData['title'];
		$menuType=$menuData['type'];
		if($menuType>=20 && $menuType<23)
			$menuCode=$this->buildVerticalMenuBlock($blockCode,$itemData,$menuTitle);
		elseif($menuType>=23 && $menuType<25)
			$menuCode=$this->buildActiveSubMenuBlock($blockCode,$itemData,$menuTitle);
//		elseif($menuType>=25 && $menuType<30)
//			$menuCode=$this->buildSfVerticalMenuBlock($blockCode,$itemData,$menuTitle);
		elseif($menuType>=10 && $menuType<15)
			$menuCode=$this->buildHorizontalMenuBlock($blockCode,$itemData,$menuTitle);
//		elseif($menuType>=15 && $menuType<17)
//			$menuCode=$this->buildSfHorizontalMenuBlock($blockCode,$itemData,$menuTitle);
		elseif($menuType>=17 && $menuType<19)
			$menuCode=$this->buildDropDownAllSubBlock($blockCode,$itemData,$menuTitle);
		elseif($menuType>=30 && $menuType<40)
			$menuCode=$this->buildLinkSet($blockCode,$itemData,$menuTitle,$menuType);
		elseif($menuType>=40 && $menuType<50)
			$menuCode="";
		else
			$menuCode="";

		return $menuCode;
	}

	public function getMenuCode($itemData) 
	{
//Only one level for ul-li structure, is nested by spaces
//   Simpler stucture, more characters, probably not as ul and li are meant to be
		$labelGap="";
		$menuCode="";

		$menuCode.="<div class=\"menu-content\">";
		$menuCode.="<ul class=\"menu menu-parent\">";

		for($i=0;$i<count($itemData);$i++){
			$labelGap="&nbsp;&nbsp;&nbsp;";
			$labelGap="";

			$itemCode="";
			$itemCode.="<li class=\"menu-item\">";
			$itemCode.=$labelGap."<a href=\"".$GLOBALS['baseUrl'].''.$itemData[$i]['uri']."\">".$itemData[$i]['label']."</a>";
			$itemCode.="</li>\n";

			for($j=1;$j<$itemData[$i]['depth'];$j++){
				$labelGap.="&nbsp;&nbsp;&nbsp;";
				$itemCode="";
				$itemCode.="<li class=\"menu-item\">";
				$itemCode.=$labelGap."<a href=\"".$GLOBALS['baseUrl'].''.$itemData[$i]['uri']."\">".$itemData[$i]['label']."</a>";
				$itemCode.="</li>\n";

			}
			$menuCode.=$itemCode;

		}

		$menuCode.="</ul>\n";
		$menuCode.="</div>\n";

		return $menuCode;
	}

	public function buildUserBlock($blockCode,$siteId,$blockLang)
	{
		$logStatus="out";

		if(!isset($_SESSION[$siteId]['userData'])){
			$_SESSION[$siteId]['userData']['id']=0;
			$_SESSION[$siteId]['userData']['roleId']=2;
			$_SESSION[$siteId]['userData']['name']="";
		}

		if(isset($_SESSION[$siteId]['userData']) && $_SESSION[$siteId]['userData']['id']>0){
			$logStatus="in";
		}

		$userData=$_SESSION[$siteId]['userData'];

		if($blockCode=="appUserArea")
			$userPath="app-user";
		else
			$userPath="user";

		if($logStatus=="out"){

			$block = "<a href=\"".$GLOBALS['baseUrl']."/".$userPath."/login\">".$blockLang['link/login']."</a>";

		}else{
			$block="".$blockLang['label']." ";
			$block.=$userData['name'];
			$block.="&nbsp;";
			$block.="<a href=\"".$GLOBALS['baseUrl']."/".$userPath."/logout\">".$blockLang['link/logout']."</a>";

		}
		return $block;
	}

	public function buildBlockEvent($blockCode)
	{

		$blockView="Output from view method, if blockcode is ".$blockCode;

		return $blockView;
	}

	public function buildFooterArea()
	{

		$blockView="Output from view method, if blockcode is ";

		return $blockView;
	}

	public function getFrontPage($siteId,$siteName)
	{

   	$blockView="";

		if($GLOBALS['siteStatus']=="inUse"){

			$blockView.="Welcome to ".$siteName."!";
			$blockView.="<br \>";

			if($_SESSION[$siteId]['userData']['id']==1)
			  	$blockView.="<a href=\"".$GLOBALS['baseUrl']."/app\">Administrator links</a>\n";
		}
		else{
		  	$blockView.="<a href=\"".$GLOBALS['baseUrl']."/app/install-website\">Click here to install a new website!</a>\n";
		}

		return $blockView;
	}

}
