<?php

class LanguageBlocks {

	public $dbId;
	public $tablePrefix;

	public function setChooserBlock()
	{

		$Other=$this->otherConfig;
		$siteId=$GLOBALS['siteId'];

		$GLOBALS['langBlock']['activeLanguage']="";

		$appDb = $GLOBALS['db'];
		$this->dbId=$GLOBALS['db']['id'];
		$this->tablePrefix=$GLOBALS['db']['tablePrefix'];

		if(isset($_SESSION[$siteId]['langCode']))
			$activeLanguage=$_SESSION[$siteId]['langCode'];
		else
			$activeLanguage=$GLOBALS['langCode'];

		if(isset($_POST['langOption'])){

			$lang=$this->getLangSet("setChooserBlock:langOptions");

			if($_POST['langOption']!="langForm"){

				$activeLanguage=$_POST['langOption'];
				$GLOBALS['langCode']=$activeLanguage;
				$_SESSION[$siteId]['langCode']=$activeLanguage;

				$code2=$this->getCode($_POST['langOption']);
				$GLOBALS['langCode2']=$code2;
				$_SESSION[$siteId]['langCode2']=$code2;

				$redirectUrl=$GLOBALS['curUrl'];
					$redirectChoice=false;
					header('Location:' . $redirectUrl, true, $redirectChoice ? 301 : 302);
					exit();

			}

			$optionSet=$this->getLanguageOptions();
			$blockView="";
			$blockView.="<div id=\"language-form-area\" class=\"language-form-area\">";
			$blockView.="<form name=\"languageOptions\" action=\"".$GLOBALS['curUrl']."\" method=\"post\">\n";
			$blockView.="<div class=\"language-block-header\">";
			$blockView.="<div class=\"window-title\">".$lang['title']."</div>";
			$blockView.="<input name=\"closeArea\" type=\"submit\" class=\"close-button\" value=\"X\" />";
//			$blockView.="<br />";
			$blockView.="</div>";
			$blockView.="<div class=\"language-block-content\">";

			$blockView.=$lang['label1'];
			$blockView.="<br />";
			$blockView.=("&nbsp;&nbsp;".$this->getLabel($activeLanguage));
			$blockView.="<br />";
			$blockView.="<br />";
			$blockView.="<div class=\"lang-list-text\">";
			$blockView.=$lang['label2'];
			$blockView.="</div>";

			foreach ($optionSet as $row) {
				if($row['language_code']!=$activeLanguage){
					$blockView.="<div id=\"lang-option\">";
					$blockView.="<button id=\"lang-option-button\" type=\"submit\" name=\"langOption\" class=\"user-block\" value=\"".$row['language_code']."\" />";
					$blockView.=$row['label'];
					$blockView.="</button>";
					$blockView.="</div>";
				}
			}

			$blockView.="</div>";

			$blockView.="</form>";

			$blockView.="</div>";

			$blockScript=$this->getBlockScript();
			$GLOBALS['headTags']=$GLOBALS['headTags'].$blockScript;

		}

		else{

			$lang=$this->getLangSet("setChooserBlock:langLink");

			$GLOBALS['langBlock']['activeLanguage']=$this->getLabel($activeLanguage);
			$GLOBALS['langBlock']['languageLabel']=$lang['buttonStart1'];

			if(isset($GLOBALS['urlParts'][2])){
				$itemData=$this->getCurrentItemData($GLOBALS['urlParts'][2]);

				$curPath=$GLOBALS['urlParts'][0]."/".$GLOBALS['urlParts'][1];

				if(count($itemData)>0 && $itemData['language_code']!=$activeLanguage && $itemData['path']==$curPath){

					$itemData2=$this->getChildItemData($activeLanguage,$itemData['parent_item_id']);
					if($itemData['parent_item_id']==$itemData['child_item_id']){

						$source="/".$GLOBALS['urlParts'][0]."/".$GLOBALS['urlParts'][1]."/".$itemData2['child_item_id'];
						$alias=$this->getAlias($source);
					}else{

						if($itemData2['parent_item_id']==$itemData2['child_item_id']){

							$source="/".$GLOBALS['urlParts'][0]."/".$GLOBALS['urlParts'][1]."/".$itemData2['child_item_id'];
							$alias=$this->getAlias($source);
						}
						else{

							$source="/".$GLOBALS['urlParts'][0]."/".$GLOBALS['urlParts'][1]."/".$itemData2['child_item_id'];
							$alias=$this->getAlias($source);
						}

					}

					if($alias!="")
						$redirectUrl="".$GLOBALS['baseUrl'].$alias;
					else
						$redirectUrl="".$GLOBALS['baseUrl'].$source;

				$redirectChoice=false;
				header('Location:' . $redirectUrl, true, $redirectChoice ? 301 : 302);
				exit();

				}
			}
			$blockView="";
			$blockView.="<div class=\"lang-button\">";
			$blockView.="<form name=\"languageChooser\" action=\"".$GLOBALS['curUrl']."\" method=\"post\">\n";
			$blockView.="";
			$blockView.="<button type=\"submit\" name=\"langOption\" class=\"user-block\" value=\"langForm\" />";
			$blockView.=$lang['buttonStart1'];
			$blockView.="</button>";
			$blockView.="</form>";
			$blockView.="</div>";

		}

		$langDetails=$this->getLanguageDetails();
		if(count($langDetails)>0){

			$GLOBALS['langDirection']=$langDetails['direction'];
			$GLOBALS['dateFormat']=$langDetails['date_format'];
			$GLOBALS['timeFormat']=$langDetails['time_format'];
			$tempArr=explode("#",$langDetails['number_format']);
			$GLOBALS['numberFormat']['separator']=$tempArr[0];
			$GLOBALS['numberFormat']['decimals']=$tempArr[1];
			$GLOBALS['numberFormat']['decimalpoint']=$tempArr[2];

		}

		return $blockView;

	}

	public function getLanguageOptions()
	{

		$optionData = array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";
		$sqlString.=" WHERE status > 0";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$optionData[] = $row;
		}

		return $optionData;

	}

	public function getLanguageDetails()
	{

		$optionData = array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";
		$sqlString.=" WHERE status > 0";
		$sqlString.=" AND language_code = '".$GLOBALS['langCode']."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$optionData = $row;
		}

		return $optionData;

	}

	public function getLabel($code)
	{

		$label = "";

		$sqlString="SELECT label";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";
		$sqlString.=" WHERE language_code = '".$code."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$label = $row['label'];
		}

		return $label;

	}

	public function getCode($code)
	{

		$label = "";

		$sqlString="SELECT language_code2";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";
		$sqlString.=" WHERE language_code = '".$code."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$code2 = $row['language_code2'];
		}

		return $code2;

	}

	public function getCurrentItemData($id)
	{

		$itemData=array();
		$label = "";

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language_item";
		$sqlString.=" WHERE child_item_id = ".$id."";
		$sqlString.=" AND module_name = 'Page'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemData = $row;
		}

		return $itemData;

	}

	public function getChildItemData($langCode, $parentId)
	{

		$itemData=array();

		$label = "";

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language_item";
		$sqlString.=" WHERE language_code = '".$langCode."'";
		$sqlString.=" AND parent_item_id = ".$parentId;
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemData = $row;
		}

		return $itemData;

	}

	public function getAlias($source)
	{

		$itemData=array();

		$alias = "";

		$sqlString="SELECT alias";
		$sqlString.=" FROM ".$this->tablePrefix."core_alias";
		$sqlString.=" WHERE source = '".$source."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$alias = $row['alias'];
		}

		return $alias;

	}

	public function getLangSet($specificName)
	{

		$itemData=array();

		$alias = "";

		$sqlString="SELECT uri, text";
		$sqlString.=" FROM ".$this->tablePrefix."core_language";
		$sqlString.=" WHERE module_name = 'Language'";
		$sqlString.=" AND type = '11'";
		$sqlString.=" AND specific_name = '".$specificName."'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$lang[($row['uri'])] = $row['text'];
		}

		return $lang;

	}

	public function getBlockScript()
	{

		$script="";

$script=<<<EOT
<script type="text/javascript">
$(document).ready(function(){
	$(".generic-block").hide();
	$(".lang-block-space").show();
});
</script>
EOT;

		return $script;

	}

}
