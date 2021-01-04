<?php 
/*
 * Theme module for Allmice™ CMS
 * Version 1.8.1 (2020-12-26)
 * Copyright 2020 by Adeenas OÜ, Copyright 2017 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Theme module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include "core/includes/Model/"."DatabaseCms.php";
include $pathModuleModel."AppDatabase.php";
include $pathModuleModel."Theme.php";
include $pathModuleModel."ThemeForm.php";
include $pathModuleModel."Access.php";

class ThemeController extends Controller
{

	public function indexEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$roleId=1;
		$sqlWhere="";
		$sqlWhere.=" AND p.role_id = ".$roleId."";
		$sqlWhere.=" AND r.module_name = '".$GLOBALS['modName']."'";

		$eventSet = $appDb->getModuleEventSet($sqlWhere);

		return array(
			'eventSet' => $eventSet,
		);

	}

	public function installThemesEvent()
	{

		$modConfig=$this->modConfig;

		$form = new ThemeForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$theme = new Theme();

		$dbThemes=$appDb->getThemeSet();

		$themeSet=$theme->getThemeSet($dbThemes);

		$modCbValues=array();

		if (isset($_POST['save'])) {

			$themeCbArray=$themeSet['themeCbArray'];
			$themeList=$themeSet['themeList'];
			$form->updateForm();

			$themeCbValues=$_POST['themeCb'];
			$access = new Access();

			for($i=0;$i<count($themeList);$i++){
				$themeCbArray[$i]['id']=$i;
				if(in_array($themeCbArray[$i]['id'], $themeCbValues)){

					$themeCbArray[$i]['status']="checked";

					if($themeList[$i]['codePath']==""){
						$installPath="themes/".$themeList[$i]['name']."/config/Install";
						$themePath="themes/";
					}
					else{
						$installPath=$themeList[$i]['codePath'].$themeList[$i]['name']."/config/Install";
						$themePath=$themeList[$i]['codePath'];
					}

					$installConfig=$installPath."/install-config.php";

					if(file_exists($installConfig)){
						include $installConfig;
						$themeList[$i]['name']=$themeInstall['name'];
						$themeList[$i]['title']=$themeInstall['title'];
						$themeList[$i]['description']=$themeInstall['description'];
						$themeList[$i]['developer']=$themeInstall['developer'];
						$themeList[$i]['path']=$themePath;
					}
					$appDb->installTheme($themeList[$i],$access);

				}
				else
					$themeCbArray[$i]['status']="";
			}

			$dbThemes=$appDb->getThemeSet();
			$themeSet=$theme->getThemeSet($dbThemes);

		}
		$form->setValue("save","Install checked themes");

		return array(
			'form' => $form,
			'uiThemes' => $themeSet['themeList'],
			'dbThemes' => $dbThemes,
			'themeCbArray' => $themeSet['themeCbArray'],
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function uninstallThemesEvent()
	{

		$form = new ThemeForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$theme = new Theme();

		$dbThemes=$appDb->getThemeSet();

		$themeSet=$theme->getThemeSet($dbThemes);

		$modCbValues=array();

		for($i=0;$i<count($dbThemes);$i++){
			$themeCbArray[$i]['id']=$i;
			$themeCbArray[$i]['status']="";

		}

		if (isset($_POST['save'])) {

			$themeList=$themeSet['themeList'];
			$themeCbArray=$themeSet['themeCbArray'];

			$form->updateForm();

			$themeCbValues=$_POST['themeCb'];
			$access = new Access();

			for($i=0;$i<count($dbThemes);$i++){
				$themeCbArray[$i]['id']=$i;
				if(in_array($themeCbArray[$i]['id'], $themeCbValues)){

					$themeCbArray[$i]['status']="checked";
					$appDb->uninstallTheme($dbThemes[$i]['name']);

				}
				else
					$themeCbArray[$i]['status']="";

			}
			$dbThemes=$appDb->getThemeSet();
			$themeSet=$theme->getThemeSet($dbThemes);

			$url=$GLOBALS['baseUrl']."/theme/uninstall-themes";
			$this->redirect($url, false);

		}
		else{
			for($i=0;$i<count($dbThemes);$i++){
				$themeCbArray[$i]['id']=$i;
				$themeCbArray[$i]['status']="";
				$themeSet['themeCbArray']=$themeCbArray;
			}
		}
		$form->setValue("save","Uninstall checked themes");

		return array(
			'form' => $form,
			'uiThemes' => $themeSet['themeList'],
			'dbThemes' => $dbThemes,
			'themeCbArray' => $themeSet['themeCbArray'],
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function chooseDefaultThemeEvent()
	{

		$form = new ThemeForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$theme = new Theme();
		$dbThemes=$appDb->getWholeThemeSet();
		$themeSet=$theme->getThemeSet($dbThemes);

		$roleOptions=$appDb->getRoleOptions();

		$themeOptions=array();
		foreach ($dbThemes as $row) {
			$themeOptions[] = $row['id'];
		}

		$form->formMap['roleId']['options']=$roleOptions;
		$form->formMap['roleId']['value']=3;
		$form->formMap['themeId']['options']=$themeOptions;
		$form->formMap['themeId']['value']=1;

		if (isset($_POST['save'])) {

			$form->updateForm();
			$formData=$form->getData();
			$theme->convertFormData($formData);

			if (isset($_POST['themeId'])) {
				$themeId=$_POST['themeId'];
				$theme->themeId=$_POST['themeId'];
				$form->formMap['themeId']['value']=$_POST['themeId'];

			}

			$appDb->changeActiveTheme($theme);

		}
		elseif(isset($_POST['roleId'])) {
			$form->updateForm();
			$themeId = $appDb->getDefaultTheme($form->formMap['roleId']['value']);
			$form->setValue("themeId",$themeId);
		}
		else{

			$themeId = $appDb->getDefaultTheme($form->formMap['roleId']['value']);
			$form->setValue("themeId",$themeId);

		}

		return array(
			'form' => $form,
			'uiThemes' => $themeSet['themeList'],
			'dbThemes' => $dbThemes,
			'themeCbArray' => $themeSet['themeCbArray'],
		);

	}

	public function changeThemeColorsEvent()
	{

		$selectorKeySet=array();

		$urlSet=array();
		$fontSet=array();
		$borderSet=array();
		$shadowSet=array();

		$note="";

		$form = new ThemeForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->formMap['action']['value']="Extract colors";

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$colorSet=array();

		if (isset($_POST['action']) || isset($_POST['getOutput'])) {
			$form->updateForm();
			$formData=$form->getData();

			$tempSet=str_replace(": ", ":", $formData['cssData']);
			$tempSet=str_replace(":", ": ", $tempSet);
			$tempSet=str_replace(" {", "{", $tempSet);
			$tempSet=str_replace("{", " {", $tempSet);

			$tempArr=explode("\n",$tempSet);

			$cleanSet=array();

			$rowNo=0;
			foreach ($tempArr as $row) {
				$row=trim($row);
				$rowNo++;

//It is giving warning and following condition looks confusing
//Warning: strstr(): Empty needle in /var/www/html/a-cms/allmice-cms-next-version/modules/Theme/Controller/ThemeController.php on line 290

				if($row!=""){
					$row=trim($row, " \t\n\r\0\x0B");
					$cleanSet[]=$row;
				}

				if(strstr($row,"/*") && !strstr($row,"*/")){
					$note="Invalid comment signs were detected. Input CSS data can contain only comments, which start and end on the same line.";
					$note.="<br>";
					$note.="One of the problematic rows was row number: ".$rowNo;
//					$note.="One of the problematic rows: ".$row;
					$note.="<br>";
				}

			}

			if($note!=""){
				$cleanSet=array();
			}

			$selectorSet=array();
			$selectorKeySet=array();
			$declarSet=array();

			$status="none";
			$selectorStart="";
			$index=1;

			foreach ($cleanSet as $row) {

				if(strstr($row,"{")){
					$selectorStart=$selectorStart."\n".str_replace(" {","",$row);

					$selector['code']="s-".$index;
					$index++;
					$selector['content']=$selectorStart;
					$selectorSet[]=$selector;
					$selectorKeySet[($selector['code'])]=$selector['content'];

					$status="content";
				}

				if(!strstr($row,"{") && !strstr($row,"}")){

					if($status=="content"){
						$declar['selector']=$selector['code'];
						$declar['content']=$row;

						$declarSet[]=$declar;
					}else{
						$selectorStart=$selectorStart.$row."\n";

					}
				}
				if(strstr($row,"}")){
					$status="selector";
					$selectorStart="";
				}

			}

			$colorSet=array();
			$colorKeySet=array();

			$urlSet=array();
			$borderSet=array();
			$fontSet=array();
			$shadowSet=array();

			$tempDecSet=array();
			foreach ($declarSet as $row) {
				$row['content']=$form->specialCharsDecode($row['content']);
				if(strstr($row['content'],"#")){

					$tempArr=explode("#", $row['content'], 2);
					$tempArr2=explode(";", $tempArr[1], 2);
					$tempArr3=explode(" ", $tempArr2[0], 2);
					$color="#".$tempArr3[0];

					$rowNew['color']=$color;

					$rowNew['declar']=$row['content'];
					$rowNew['selector']=$row['selector'];

					$colorKeySet[($color)]=$rowNew;

					$colorSet[]=$rowNew;

				}
				if(strstr($row['content'],"url")){
					$urlRow['declar']=$row['content'];
					$urlRow['selector']=$row['selector'];
					$urlSet[]=$urlRow;
				}

			}

			$color=array();
			$selector=array();
			$declar=array();
			foreach ($colorSet as $key => $row) {
				$color[$key]  = $row['color'];
				$selector[$key] = $row['selector'];
				$declar[$key] = $row['declar'];
			}

			array_multisort($color, SORT_ASC, $selector, SORT_ASC, $declar, SORT_ASC, $colorSet);

			if (isset($_POST['getOutput'])) {

				$output=$formData['cssData'];

				for ($i=0;$i<count($colorSet);$i++) {
					$postKey='newColor'.$i;

					if(isset($_POST[($postKey)])){

						$oldColor1=$colorSet[$i]['color'].";";
						$newColor1=$_POST[($postKey)].";";
						$oldColor2=$colorSet[$i]['color']." ";
						$newColor2=$_POST[($postKey)]." ";

						$output=str_replace($oldColor1,$newColor1,$output);
						$output=str_replace($oldColor2,$newColor2,$output);

					}

				}

				$form->setValue('newCssData',$output);

			}

		}

		return array(
			'form' => $form,
			'colorSet' => $colorSet,
			'selectorKeySet' => $selectorKeySet,
			'note' => $note,
		);

	}

	public function replaceCssDeclarationsEvent()
	{

		$selectorKeySet=array();

		$form = new ThemeForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->formMap['action']['value']="Find declarations";

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$itemSet=array();
		$note="";

		$keyword="border";
		$keyword="url";
		$keyword="text-shadow";

		if (isset($_POST['action']) || isset($_POST['getOutput'])) {
			$form->updateForm();
			$formData=$form->getData();

			$keyword=$formData['keyword'];

			$tempSet=$formData['cssData'];
			$tempSet=str_replace(" {", "{", $tempSet);
			$tempSet=str_replace("{", " {", $tempSet);

			$tempArr=explode("\n",$tempSet);

			$rowSet=$tempArr;
			$cleanSet=array();

			foreach ($tempArr as $row) {
				$row=trim($row);

				if(strstr($row,"") && $row!=""){
					$tempArr2=explode("",$tempArr2[1],2);
					$row=$tempArr2[0].$tempArr3[1];
					$row=trim($row, " \t\n\r\0\x0B");
				}

				if(!strstr($row,"") && $row!=""){
					$cleanSet[]=$row;

				}
			}

			$selectorSet=array();
			$selectorKeySet=array();
			$declarSet=array();

			$status="none";
			$selectorStart="";
			$index=1;

			foreach ($cleanSet as $row) {

				if(strstr($row,"{")){
					$selectorStart=$selectorStart."\n".str_replace(" {","",$row);

					$selector['code']="s-".$index;
					$index++;
					$selector['content']=$selectorStart;
					$selectorSet[]=$selector;
					$selectorKeySet[($selector['code'])]=$selector['content'];

					$status="content";
				}

				if(!strstr($row,"{") && !strstr($row,"}")){

					if($status=="content"){
						$declar['selector']=$selector['code'];
						$declar['content']=$row;

						$declarSet[]=$declar;
					}else{
						$selectorStart=$selectorStart.$row."\n";

					}
				}
				if(strstr($row,"}")){
					$status="selector";
					$selectorStart="";
				}

			}

			$itemSet=array();

			foreach ($declarSet as $row) {
				$row['content']=$form->specialCharsDecode($row['content']);

				if(strstr($row['content'],$keyword)){
					$urlRow['declar']=$row['content'];
					$urlRow['selector']=$row['selector'];
					$itemSet[]=$urlRow;
				}

			}

			$selector=array();
			$declar=array();
			foreach ($itemSet as $key => $row) {
			    $selector[$key] = $row['selector'];
			    $declar[$key] = $row['declar'];
			}

			array_multisort($declar, SORT_ASC, $selector, SORT_ASC, $itemSet);

				$output=$formData['cssData'];

				$output="";

			if (isset($_POST['getOutput'])) {

				for ($i=0;$i<count($itemSet);$i++) {

					if(isset($_POST[('newUrl'.$i)])){
						$oldVal=$itemSet[$i]['declar'];
						$newVal=$_POST[('newUrl'.$i)];

						for ($j=0;$j<count($rowSet);$j++) {
							$rowSet[$j]=$form->specialCharsDecode($rowSet[$j]);

							if(strstr(trim($rowSet[$j], " \t\n\r\0\x0B"),trim($oldVal, " \t\n\r\0\x0B"))){
								$rowSet[$j]="\t".$newVal;
							}
						}

					}
				}

				foreach ($rowSet as $row) {
					$output.=("".$row."\n");
				}
				$form->setValue('newCssData',$output);

			}

		}

		return array(
			'form' => $form,
			'selectorKeySet' => $selectorKeySet,
			'declarSet' => $itemSet,
			'note' => $note,
		);

	}

	public function createCssFromTemplateEvent()
	{

		$form = new ThemeForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->formMap['action']['value']="Process template data";
		$form->formMap['cssData']['label']="Input - template file content";

		$dataSet=array();
		$note="";

		if (isset($_POST['action']) || isset($_POST['getOutput'])) {
			$form->updateForm();
			$formData=$form->getData();

			$tempSet=$formData['cssData'];
			$tempSet=$form->specialCharsDecode($tempSet);

			$tempArr=explode("#==========#",$tempSet);
			$configData=array();

			$output=$tempArr[0];

			$replaceSet['color']=array();
			$replaceSet['declar']=array();

			if(isset($tempArr[1])){
				$tempArr2=explode("\n",$tempArr[1]);

				foreach ($tempArr2 as $row) {
					$row=trim($row, " \t\n\r\0\x0B");
					if ($row!="") {
						$tempArr3=explode("\t",$row);

						$configData[]=$tempArr3;
					}

				}

				if(count($configData)>1 && count($configData[0])==4){

					for ($i=1;$i<count($configData);$i++) {

						$dataRow['oldValue']=trim($configData[$i][0], " \t\n\r\0\x0B");
						$dataRow['newValue']=trim($configData[$i][1], " \t\n\r\0\x0B");
						if (isset($_POST[('newValue'.($i-1))])) {
							$dataRow['newValue']=$_POST[('newValue'.($i-1))];

						}

						if (!strstr($tempArr[0],$dataRow['oldValue'])) {
							$dataRow['note']="<div class=\"problem-note\">Declaration not found in CSS data.</div>";
						}else{
							$dataRow['note']="";
						}

						$dataRow['type']=$configData[$i][2];
						$dataRow['description']=$configData[$i][3];
						$dataSet[]=$dataRow;
						if($dataRow['newValue']!=""){

							if($dataRow['type']=="color"){
								$replaceSet['color'][]=$dataRow;
							}
							else{
								$replaceSet['declar'][]=$dataRow;
							}

						}

					}
					if (count($replaceSet['declar'])>0) {
						foreach ($replaceSet['declar'] as $dataRow) {

							$output=$form->specialCharsCode($output);
							$dataRow['oldValue']=$form->specialCharsCode($dataRow['oldValue']);
							$dataRow['newValue']=$form->specialCharsCode($dataRow['newValue']);

							$output=str_replace($dataRow['oldValue'],$dataRow['newValue'],$output);
							$output=$form->specialCharsDecode($output);

						}
					}
					if (count($replaceSet['color'])>0) {
						foreach ($replaceSet['color'] as $dataRow) {
							$output=str_replace($dataRow['oldValue'],$dataRow['newValue'],$output);
						}
					}

					$form->setValue('newCssData',$output);

				}
				else{
					$note="Template format is not correct.";
				}

			}
			else{
				$note="Template format is not correct.";
			}
		}

		return array(
			'form' => $form,
			'dataSet' => $dataSet,
			'note' => $note,
		);

	}

}