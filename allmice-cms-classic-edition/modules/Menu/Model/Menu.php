<?php

class Menu
{

	public $id;

	public $code;
	public $status;
	public $title;
	public $type;
	public $roleAccess;
	public $cachingRoles;
	public $cacheData;
	public $userId;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->code = (isset($data['code'])) ? $data['code'] : null;
		$this->status = (isset($data['status'])) ? $data['status'] : null;
		$this->title = (isset($data['title'])) ? $data['title'] : null;
		$this->type = (isset($data['type'])) ? $data['type'] : null;
		$this->roleAccess = (isset($data['roleAccess'])) ? $data['roleAccess'] : null;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->code = (isset($data['code'])) ? $data['code'] : null;
		$this->status = (isset($data['status'])) ? $data['status'] : null;
		$this->title = (isset($data['title'])) ? $data['title'] : null;
		$this->type = (isset($data['type'])) ? $data['type'] : null;
		$this->roleAccess = (isset($data['role_id'])) ? $data['role_id'] : null;

	}

	public function getMenuCode($itemData) 
	{

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

	public function getName($words)
	{

		$tempArr=explode(" ", $words);

		$capital="";

		for($i=0;$i<count($tempArr);$i++){
			$capital.=("".ucfirst($tempArr[$i]));
		}

		return $capital;

	}

	public function getCamel($words)
	{

		$tempArr=explode(" ", $words);

		$camel="";
		$camel=lcfirst($tempArr[0]);
		for($i=1;$i<count($tempArr);$i++){
			$camel.=("".ucfirst($tempArr[$i]));
		}

		return $camel;

	}

	public function getPath($words)
	{
		$tempArr=explode(" ", $words);

		$path="";
		$path=lcfirst($tempArr[0]);
		for($i=1;$i<count($tempArr);$i++){
			$path.=("-".lcfirst($tempArr[$i]));
		}

		return $path;

	}

	public function buildVerticalMenu($menuCode,$itemData,$menuTitle,$menuLang)
	{

		$menuCode="\n";

		if(isset($menuLang['title']))
			$menuTitle=$menuLang['title'];
		$menuCode.="<div class=\"menu-view-title\"><h2>\n";
		$menuCode.=$menuTitle;
		$menuCode.="</h2></div>\n";
		$menuCode.="<div class=\"menu-view-content\">\n";
		$menuCode.="<ul class=\"menu-view menu-view-parent\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		

		for($i=0;$i<count($itemData);$i++){
			$itemCode="";
			if($itemData[$i]['uri']==$curUri)
				$itemTag="<li class=\"active menu-view-item\">\n";
			else
				$itemTag="<li class=\"menu-view-item\">\n";

			$langUri="item/".$itemData[$i]['id'];
			if(isset($menuLang[($langUri)]) && $menuLang[($langUri)]!="")
				$itemData[$i]['label']=$menuLang[($langUri)];

			if($lastDepth<$itemData[$i]['depth']){
				if($i!=0){
					$menuCode.="<ul class=\"menu-view menu-view-child\">\n";
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
				$itemCode.="</li>\n";

			}
			if(isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>$itemData[($i+1)]['depth']){

				for($k=$itemData[($i+1)]['depth'];$k<$itemData[($i)]['depth'];$k++){

				$itemCode.="</li>\n";
				$itemCode.="</ul>\n";
				}
			}
			if($i!=(count($itemData)-1) && $itemData[$i]['depth']>$itemData[($i+1)]['depth']){
				$itemCode.="</li>\n";

			}
			if(!isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>0){

				for($k=0;$k<$itemData[($i)]['depth'];$k++){

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

	public function buildActiveSubmenu($menuCode,$itemData,$menuTitle,$menuLang)
	{

		$menuCode="\n";

		if(isset($menuLang['title']))
			$menuTitle=$menuLang['title'];
		$menuCode.="<div class=\"menu-view-title\"><h2>\n";
		$menuCode.=$menuTitle;
		$menuCode.="</h2></div>\n";
		$menuCode.="<div class=\"menu-view-content\">\n";
		$menuCode.="<ul class=\"menu-view menu-view-parent\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		

		for($i=0;$i<count($itemData);$i++){
			$itemCode="";
			if($itemData[$i]['uri']==$curUri)
				$itemTag="<li class=\"active menu-view-item\">\n";
			else
				$itemTag="<li class=\"menu-view-item\">\n";

			$langUri="item/".$itemData[$i]['id'];
			if(isset($menuLang[($langUri)]) && $menuLang[($langUri)]!="")
				$itemData[$i]['label']=$menuLang[($langUri)];

			if($lastDepth<$itemData[$i]['depth']){
				if($i!=0){
					$menuCode.="<ul class=\"menu-view menu-view-child\">\n";
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
				$itemCode.="</li>\n";

			}
			if(isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>$itemData[($i+1)]['depth']){

				for($k=$itemData[($i+1)]['depth'];$k<$itemData[($i)]['depth'];$k++){

				$itemCode.="</li>\n";
				$itemCode.="</ul>\n";
				}
			}
			if($i!=(count($itemData)-1) && $itemData[$i]['depth']>$itemData[($i+1)]['depth']){
				$itemCode.="</li>\n";

			}
			if(!isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>0){

				for($k=0;$k<$itemData[($i)]['depth'];$k++){

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

	public function buildHorizontalMenu($menuCode,$itemData,$menuTitle,$menuLang)
	{

		$menuCode="\n";

		$menuCode.="<div class=\"navi navi-content\">\n";
		$menuCode.="<ul class=\"navi navi-parent\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		

		for($i=0;$i<count($itemData);$i++){
			$itemCode="";
			if($itemData[$i]['uri']==$curUri)
				$itemTag="<li class=\"active\">\n";
			else
				$itemTag="<li>\n";
			$langUri="item/".$itemData[$i]['id'];
			if(isset($menuLang[($langUri)]) && $menuLang[($langUri)]!="")
				$itemData[$i]['label']=$menuLang[($langUri)];

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
				$itemCode.="</li>\n";

			}
			if(isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>$itemData[($i+1)]['depth']){

				for($k=$itemData[($i+1)]['depth'];$k<$itemData[($i)]['depth'];$k++){

				$itemCode.="</li>\n";
				$itemCode.="</ul>\n";
				}
			}
			if($i!=(count($itemData)-1) && $itemData[$i]['depth']>$itemData[($i+1)]['depth']){
				$itemCode.="</li>\n";

			}
			if(!isset($itemData[($i+1)]['depth']) && $itemData[($i)]['depth']>0){

				for($k=0;$k<$itemData[($i)]['depth'];$k++){

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

	public function buildLinkSet2($menuCode,$itemData,$menuTitle,$menuLang,$menuType)
	{
		$menuCode="\n";

		if($menuType==35 || $menuType==36){
			if(isset($menuLang['title']))
				$menuTitle=$menuLang['title'];
			$menuCode.="<div class=\"set-title\"><h2>\n";
			$menuCode.=$menuTitle;
			$menuCode.="</h2></div>\n";
		}
		$menuCode.="<div class=\"set-content\">\n";
		$curUri=str_replace($GLOBALS['baseUrl'],"",$GLOBALS['curUrl']);
		$lastDepth=0;		

		$tempSet=array();

		$parentIndex=0;
		$subMenu="";
		for($i=0;$i<count($itemData);$i++){

			$itemCode="";

			if($itemData[$i]['depth']==1){

				if($i==0){

					if($itemData[$i]['uri']==$curUri)
						$itemTag="<div class=\"active set-item l".$itemData[$i]['depth']."\" id=\"pi-".$itemData[$i]['id']."\">\n";
					else
						$itemTag="<div class=\"set-item l".$itemData[$i]['depth']."\" id=\"pi-".$itemData[$i]['id']."\">\n";

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

					$tempSet[($parentIndex)]['rootItem']=$itemCode;
					$tempSet[($parentIndex)]['id']=$itemData[$i]['id'];

				}
				else{

					$tempSet[($parentIndex)]['subMenu']=$subMenu;
					$subMenu="";
					$parentIndex++;

					if($itemData[$i]['uri']==$curUri)
						$itemTag="<div class=\"active set-item l".$itemData[$i]['depth']."\" id=\"pi-".$itemData[$i]['id']."\">\n";
					else
						$itemTag="<div class=\"set-item l".$itemData[$i]['depth']."\" id=\"pi-".$itemData[$i]['id']."\">\n";

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

					$tempSet[($parentIndex)]['rootItem']=$itemCode;
					$tempSet[($parentIndex)]['id']=$itemData[$i]['id'];

				}

			}else{

				if($itemData[$i]['uri']==$curUri)
					$itemTag="<div class=\"active set-item l".$itemData[$i]['depth']."\" id=\"ci-".$itemData[$i]['id']."\">\n";
				else
					$itemTag="<div class=\"set-item l".$itemData[$i]['depth']."\" id=\"ci-".$itemData[$i]['id']."\">\n";

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
				$subMenu.=$itemCode;
			}
		}
			$tempSet[($parentIndex)]['subMenu']=$subMenu;

$menuCode="";

		for($i=0;$i<count($tempSet);$i++){
			$menuCode.=$tempSet[$i]['rootItem'];
			$menuCode.="<div class=\"set-sub\" id=\"si-".$tempSet[$i]['id']."\">\n";
			$menuCode.=$tempSet[$i]['subMenu'];
			$menuCode.="</div>\n";
		}

		return $menuCode;

	}

}
