<?php

	include "core/includes/Model/"."DatabaseCms.php";
	include "modules/Page/Model/AppDatabase2.php";

	class FrontPage
	{

		public $dbConfig;
		public $modConfig;
		public $otherConfig;

		public function buildTextBlock()
		{

			$blockView="";

			$id = 3;

			$Database=$this->dbConfig;
			$pageDb = new AppDatabase2($Database['app_db']);
			$pageData=$pageDb->getPageDetails($id);
			$blockView.=(htmlspecialchars_decode($pageData['body']));

			return $blockView;
		}

		public function buildFrontPage($id)
		{
			$fpView="";
			$Database=$this->dbConfig;
			$pageDb = new AppDatabase2($Database['app_db']);
			$template=$pageDb->getTemplate('frontpageView');

			if(isset($GLOBALS['pageType2']) && $GLOBALS['pageType2']=="frontPage"){
				$GLOBALS['urlParts'][0]="page";
				$GLOBALS['urlParts'][1]="view";
				$GLOBALS['urlParts'][2]=$id;
			}

			$pageData=$pageDb->getPageDetails($id);

			$Other=$this->otherConfig;
			$siteId=$Other['siteId'];
			$accessList['editAnyPage']=$pageDb->getAccessRight($_SESSION[($siteId)]['userData'],("/page/edit-any-page"));

			if(count($pageData)>0){

				$editorData="";
				if($accessList['editAnyPage']==true){

					$editorData="<a href=\"";
					$editorData.=$GLOBALS['baseUrl']."/page/edit-any-page/".$pageData['id']."\"";
					$editorData.=" target=\"_blank\"";
					$editorData.=">";
					$editorData.="Edit";
					$editorData.="</a>\n";

				}

				$template=str_replace("[editorData]",$editorData,$template);
				$template=str_replace("[title]",$pageData['title'],$template);
				$template=str_replace("[description]",$pageData['description'],$template);
				$template=str_replace("[body]",$pageData['body'],$template);
				$template=str_replace("[creator]",$pageData['creator'],$template);
				$template=str_replace("[editor]",$pageData['editor'],$template);
				$template=str_replace("[created]",date($GLOBALS['timeFormat'],$pageData['created']),$template);
				$template=str_replace("[edited]",date($GLOBALS['timeFormat'],$pageData['edited']),$template);
			}

			if(isset($pageData['body']))
				$fpView.=htmlspecialchars_decode($template);

			return $fpView;
		}

		public function buildFooterArea()
		{

			$id=1;
			$fpView="";
			$fpView="Footer area";

			return $fpView;
		}

	}
