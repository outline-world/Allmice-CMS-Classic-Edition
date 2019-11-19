<?php 
/*
 * System Manager module for Allmice™ CMS
 * Version 1.7.1 (2019-11-19)
 * Copyright 2017 - 2019 by Any Outline LTD
 * http://www.allmice.com/cms
 * System Manager module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

	include $pathCoreController."Controller.php";
	include $pathCoreModel."Form.php";

	include $pathModuleModel."AppDatabase.php";

	include $pathModuleModel."Module.php";
	include $pathModuleModel."Access.php";

	include $pathModuleModel."AppForm.php";

	include $pathModuleModel."Application.php";

	include $pathModuleModel."TsvSet.php";
	include $pathModuleModel."TsvForm.php";
	include $pathModuleModel."TsvDatabase.php";

class SystemManagerController extends Controller
{  

	public $dbConfig;
	public $modConfig;
	public $otherConfig;

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

	public function manageAccessEvent()
	{

		$modConfig=$this->modConfig;

		$form = new AppForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$roleSet = $appDb->getRoleList();

		$roleId=$form->formMap['roleId']['value'];
		$modId=-1;
		if (isset($_POST['modId']))
			$modId=$_POST['modId'];
		if (isset($_POST['roleId']))
			$roleId=$_POST['roleId'];

		$dbModules=$appDb->getLocalModuleSet();

//Difference between modSet and modSetLabels arrays:
// * For resources module name is needed - modSet array.
// * For labels module title is better - modSetLabels array.
		$modSet[-1]="";
		$modSet[0]="";
		$modSetLabels[-1]="[None chosen]";
		$modSetLabels[0]="[All modules]";

		for($i=0;$i<count($dbModules);$i++)
		{
			$modSet[($i+2)]=$dbModules[$i]['module_name'];
			$modSetLabels[($i+2)]=$dbModules[$i]['title'];
		}
//		$form->formMap['modId']['options']=$modSet;
		$form->formMap['modId']['options']=$modSetLabels;
		$form->formMap['modId']['value']=$modId;

		for($i=0;$i<count($roleSet);$i++)
		{
//Never let change resource access rights for admin role - admin role must always have all access!
			if($roleSet[$i]['id']!=1)
				$roleOptSet[($roleSet[$i]['id'])]=$roleSet[$i]['title'];
		}
		$form->formMap['roleId']['options']=$roleOptSet;

		$sqlWhere="";
		$sqlWhere.=" AND p.role_id = ".$roleId."";
		if($modId>0){
			$sqlWhere.=" AND r.module_name = '".$modSet[($modId)]."'";
		}

		if($modId==-1)
			$resSet=array();
		else
			$resSet = $appDb->getModuleResourceSet($sqlWhere);

		if (isset($_POST['save']) || isset($_POST['modId']) || isset($_POST['roleId'])) {

			$form->updateForm();

			$resCbValues=array();
			if(isset($_POST['resCb']))
				$resCbValues=$_POST['resCb'];

			for($i=0;$i<count($resSet);$i++){

				if (isset($_POST['save'])) {
					if(in_array($resSet[$i]['id'], $resCbValues)){
						$resSet[$i]['access_level']=1;

					}
					else
						$resSet[$i]['access_level']=0;
				}

			}

		}

		if (isset($_POST['save'])) {

			$access = new Access();

			$formData=$form->getData();
			$access->convertFormData($formData);
			for($i=0;$i<count($resSet);$i++){
				$access->roleId=$roleId;
				$access->resId=$resSet[$i]['id'];
				$access->accessLevel=$resSet[$i]['access_level'];
				$appDb->updateAccess($access);
			}
		}

		$module = new Module();
		$helpScript=$module->getHelpScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$helpScript;

		return array(
			'form' => $form,
			'resList' => $resSet,
			'lang' => $GLOBALS['localLang']['other'],
			'modId' => $modId,
		);

	}

	public function installModulesEvent()
	{

		$app = new Application();

		$modConfig=$this->modConfig;

		$form = new AppForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$module = new Module();

		$dbModules=$appDb->getModuleSet();

		$modData=$module->getModuleSet($dbModules);

		$modCbValues=array();

		if (isset($_POST['save'])) {

//Installing functionality starts

			$modSet=$modData['modList'];
			$modCbArray=$modData['modCbArray'];

			$form->updateForm();

			$modCbValues=$_POST['modCb'];
			$access = new Access();

			for($i=0;$i<count($modSet);$i++){
				$modCbArray[$i]['id']=$i;
				if(in_array($modCbArray[$i]['id'], $modCbValues)){
					$modCbArray[$i]['status']="checked";

					if($modSet[$i]['codePath']=="")
						$installPath="modules/".$modSet[$i]['name']."/config/Install";
					else
						$installPath=$modSet[$i]['codePath'].$modSet[$i]['name']."/config/Install";

					$installFile=$modSet[$i]['path'].".sql";
					$installData['tablePrefix']=$appDb->tablePrefix;
					$installData['needle']="mod_";
					$installData['needle2']="core_";

					$installConfig=$installPath."/install-config.php";
					if(file_exists($installConfig)){
						include $installConfig;
						$modSet[$i]['title']=$modInstall['title'];
						$modSet[$i]['description']=$modInstall['description'];
						$modSet[$i]['path']=$modInstall['path'];
						$modSet[$i]['developer']=$modInstall['developer'];
						if(isset($modInstall['configPath']))						
							$modSet[$i]['configPath']=$modInstall['configPath'];
						else
							$modSet[$i]['configPath']="";
						if(isset($modInstall['requiredModules']))						
							$modSet[$i]['requiredModules']=$modInstall['requiredModules'];
						else
							$modSet[$i]['requiredModules']="";

						if($modInstall['path']!="")
							$modSet[$i]['type']=22;
						else
							$modSet[$i]['type']=21;

					}

					if(file_exists($installPath."/".$installFile)){
						$sqlSet=$app->getSqlSet($installPath,$installFile,$installData);
					}else{
						$sqlSet=array();
					}

					$appDb->installModule($modSet[$i],$access,$sqlSet);

				}
				else
					$modCbArray[$i]['status']="";
			}

//Installing functionality ends

//Preparing data for view after installing functionality (view rewrite)

			$dbModules=$appDb->getModuleSet();
			$modData=$module->getModuleSet($dbModules);

		}

		$modData['modList']=$module->setInstallStatus($modData['modList'],$dbModules);

		$tableScript=$module->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'form' => $form,
			'modList' => $modData['modList'],
			'modPassiveList' => $dbModules,
			'modCbArray' => $modData['modCbArray'],
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function uninstallModulesEvent()
	{
		$app = new Application();

		$modConfig=$this->modConfig;

		$form = new AppForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$module = new Module();

//Preparing data for view

		$dbModules=$appDb->getModuleSet();
		$modData=$module->getModuleSet($dbModules);

		$modCbValues=array();

		$modCbArray=array();
		for($i=0;$i<count($dbModules);$i++){
			$modCbArray[$i]['id']=$i;
			$modCbArray[$i]['status']="";
		}

		if (isset($_POST['save'])) {

			$form->updateForm();
			$modCbValues=$_POST['modCb'];

			for($i=0;$i<count($dbModules);$i++){
				if(in_array($modCbArray[$i]['id'], $modCbValues)){
					$modCbArray[$i]['status']="checked";

					$installPath="modules/".$dbModules[$i]['module_name']."/config/Uninstall";
					$installFile=$dbModules[$i]['path'].".sql";
					$installData['tablePrefix']=$appDb->tablePrefix;
					$installData['needle']="mod_";
					$installData['needle2']="core_";

					if(file_exists($installPath."/".$installFile)){
						$sqlSet=$app->getSqlSet($installPath,$installFile,$installData);
					}else{
						$sqlSet=array();
					}
//Note: $modSet[$i]['path'] value is probably empty - it is needed by uninstalling to delete any module aliases (if any)
					$appDb->uninstallModule($dbModules[$i]['module_name'],$dbModules[$i]['path']);

					$appDb->changeTables($sqlSet);

				}
				else
					$modCbArray[$i]['status']="";
			}
			$url=$GLOBALS['baseUrl']."/system-manager/uninstall-modules";
			$this->redirect($url, false);

		}
		$dbModules=$module->setUninstallStatus($dbModules);

		$tableScript=$module->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'form' => $form,
			'passiveList' => $modData['modList'],
			'activeList' => $dbModules,
			'modCbArray' => $modCbArray,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function uninstallModuleStructureEvent()
	{

		$modConfig=$this->modConfig;

		$form = new AppForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$module = new Module();

//Preparing data for view

		$dbModules=$appDb->getModuleSet();
		$modData=$module->getModuleSet($dbModules);

		$modCbValues=array();

		$modCbArray=array();
		for($i=0;$i<count($dbModules);$i++){
			$modCbArray[$i]['id']=$i;
			$modCbArray[$i]['status']="";
		}

		if (isset($_POST['save'])) {

			$form->updateForm();
			$modCbValues=$_POST['modCb'];

			for($i=0;$i<count($dbModules);$i++){
				if(in_array($modCbArray[$i]['id'], $modCbValues)){
					$modCbArray[$i]['status']="checked";
//Note: $modSet[$i]['path'] value is probably empty - it is needed by uninstalling to delete any module aliases (if any)
					$appDb->uninstallModuleStructure($dbModules[$i]['module_name'],$dbModules[$i]['path']);
				}
				else
					$modCbArray[$i]['status']="";
			}

			$dbModules=$appDb->getModuleSet();
			$modData=$module->getModuleSet($dbModules);

			$url=$GLOBALS['baseUrl']."/app/uninstall-modules";

		}

		$tableScript=$module->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'form' => $form,
			'passiveList' => $modData['modList'],
			'activeList' => $dbModules,
			'modCbArray' => $modCbArray,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function installModuleStructureEvent()
	{

		$modConfig=$this->modConfig;

		$form = new AppForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$module = new Module();

		$dbModules=$appDb->getModuleSet();

		$modData=$module->getModuleSet($dbModules);

		$modCbValues=array();

		if (isset($_POST['save'])) {

//Installing functionality starts

			$modSet=$modData['modList'];
			$modCbArray=$modData['modCbArray'];

			$form->updateForm();

			$modCbValues=$_POST['modCb'];
			$access = new Access();

			for($i=0;$i<count($modSet);$i++){
				$modCbArray[$i]['id']=$i;
				if(in_array($modCbArray[$i]['id'], $modCbValues)){
					$modCbArray[$i]['status']="checked";

					$installPath="modules/".$modSet[$i]['name']."/config/Install";
					$installData['tablePrefix']=$appDb->tablePrefix;
					$installData['needle']="mod_";
					$installData['needle2']="core_";

					$installConfig=$installPath."/install-config.php";
					if(file_exists($installConfig)){
						include $installConfig;
						$modSet[$i]['title']=$modInstall['title'];
						$modSet[$i]['description']=$modInstall['description'];
						$modSet[$i]['path']=$modInstall['path'];
						$modSet[$i]['developer']=$modInstall['developer'];
						if(isset($modInstall['configPath']))						
							$modSet[$i]['configPath']=$modInstall['configPath'];
						else
							$modSet[$i]['configPath']="";
						if(isset($modInstall['requiredModules']))						
							$modSet[$i]['requiredModules']=$modInstall['requiredModules'];
						else
							$modSet[$i]['requiredModules']="";

						if($modInstall['path']!="")
							$modSet[$i]['type']=22;
						else
							$modSet[$i]['type']=21;

					}

					$sqlSet=array();

					$appDb->installModuleStructure($modSet[$i],$access,$sqlSet);

				}
				else
					$modCbArray[$i]['status']="";
			}

//Installing functionality ends

//Preparing data for view after installing functionality (view rewrite)

			$dbModules=$appDb->getModuleSet();
			$modData=$module->getModuleSet($dbModules);

		}

		$tableScript=$module->getTableScript();
		$GLOBALS['headTags']=$GLOBALS['headTags'].$tableScript;

		return array(
			'form' => $form,
			'modList' => $modData['modList'],
			'modPassiveList' => $dbModules,
			'modCbArray' => $modData['modCbArray'],
			'lang' => $GLOBALS['localLang']['other'],
		);

	}


	public function addEditTsvSetEvent()
	{

		$note="";

		$form = new TsvForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new TsvDatabase($Database['app_db']);

		$tsvSet = new TsvSet();

		if (isset($_POST['save'])) {
			$form->updateForm();
			$formData=$form->getData();

			if (isset($_POST['htmlReplace'])) {
				$form->formMap['htmlReplace']['value']=array(0);
			}else{
				$formData['tsvSet']=$form->specialCharsDecode($formData['tsvSet']);
				$form->formMap['htmlReplace']['value']=array();
			}

			$tsvSet=$tsvSet->getTsvSet($formData['tsvSet']);

			if(strstr($formData['keyFields'], ", "));
				$keySet=explode(", ",$formData['keyFields']);
			if(strstr($formData['keyFields'], "\t"));
				$keySet=explode("\t",$formData['keyFields']);

			$tsvCorrect=$appDb->checkTsvSet($tsvSet,$keySet,$formData['tableName']);

			if($tsvCorrect){
				$errorCode=$appDb->saveTsvSet($tsvSet,$keySet,$formData['tableName']);
				if($errorCode=="noError"){
					$note="TSV data was inserted or updated in database.";
				}
				elseif($errorCode=="noValueField"){
					$note="Data was not updated, because there was no value column in TSV data (all columns were key columns).";
				}
				else{
					$note="There was an error by trying to insert or update TSV data in database.";
				}
			}
			else{
				$note="Database table name does not match with field names!";
			}

		}
		else{
			$form->formMap['htmlReplace']['value']=array(0);
		}

		return array(
			'form' => $form,
			'note' => $note,
		);

	}

	public function deleteTsvSetEvent()
	{

		$form = new TsvForm();
		$form->setUrl($GLOBALS['curUrl']);

		$Database=$this->dbConfig;
		$appDb = new TsvDatabase($Database['app_db']);

		$tsvSet = new TsvSet();

		if (isset($_POST['submit1'])) {
			$form->updateForm();
			$formData=$form->getData();

			$tsvSet=$tsvSet->getTsvSet($formData['tsvSet']);

			if(strstr($formData['keyFields'], ", "));
				$keySet=explode(", ",$formData['keyFields']);
			if(strstr($formData['keyFields'], "\t"));
				$keySet=explode("\t",$formData['keyFields']);

			$tsvCorrect=$appDb->checkTsvSet($tsvSet,$keySet,$formData['tableName']);

			if($tsvCorrect){
				if(count($tsvSet)>0)
					$appDb->deleteTsvSet($tsvSet,$keySet,$formData['tableName']);
			}
			else{
				$note="Database table name does not match with field names!";
			}

		}
		else{
		}

		return array(
			'form' => $form,
		);

	}

	public function listTsvSetEvent()
	{

		$Database=$this->dbConfig;
		$appDb = new TsvDatabase($Database['app_db']);
		$note="";
		$form = new TsvForm();
		$form->setUrl($GLOBALS['curUrl']);

		$form->formMap['outputString']['label']="Output - TSV table with phrases:";

		$form->formMap['submit1']['value']="Submit";

		$tsvSet = new TsvSet();

		$GLOBALS['localLang']['other']['tableOption0']="No table";
		$zeroLabel=$GLOBALS['localLang']['other']['tableOption0'];
		$tableList=$appDb->getTableListOptions($zeroLabel);
		$form->formMap['tableNameList']['options']=$tableList;

		if (isset($_POST['tableNameList'])) {
			$form->updateForm();
			$formData=$form->getData();

			$columnNames=$appDb->getColumnNames($formData['tableNameList']);

				$header="";
				for($i=0;$i<count($columnNames);$i++)
				{
					if($i==0)
						$header.=$columnNames[$i];
					else
						$header.=("\t".$columnNames[$i]);
				}
				$form->formMap['keyFields']['value']=$header;
				$form->formMap['keyValues']['value']="";
				$form->formMap['outputString']['value']="";

		}
		if (isset($_POST['submit1'])) {
			$form->updateForm();
			$formData=$form->getData();

			if(strstr($formData['keyFields'], ", "))
				$columnSet=explode(", ",$formData['keyFields']);
			elseif(strstr($formData['keyFields'], "\t")){
				$columnSet=explode("\t",$formData['keyFields']);
			}
			else{
				$columnSet[0]=$formData['keyFields'];
			}
			for($i=0;$i<count($columnSet);$i++)
			{
				$columnSet[$i]=trim($columnSet[$i]," \t\n\r\0\x0B");
			}

			if(strstr($formData['keyValues'], ", "))
				$valueSet=explode(", ",$formData['keyValues']);
			elseif(strstr($formData['keyValues'], "\t")){
				$valueSet=explode("\t",$formData['keyValues']);
			}
			else{
				$valueSet[0]=$formData['keyValues'];
			}
			for($i=0;$i<count($valueSet);$i++)
			{
				$valueSet[$i]=trim($valueSet[$i]," \t\n\r\0\x0B");
			}

			$tsvCorrect=$appDb->checkTsvSetSimple($columnSet,$formData['tableNameList']);
			$columnNames=$appDb->getColumnNames($formData['tableNameList']);

			if(count($columnSet)!=count($valueSet))
				$tsvCorrect=false;

			if($tsvCorrect){
				$searchResult=$appDb->getTsvList($formData['tableNameList'], $columnSet, $valueSet);
				$tsvTable=$tsvSet->getTsvTable($columnNames, $searchResult);

				$form->formMap['outputString']['value']=$tsvTable;

			}else{
				$note="Database table name does not match with field names!";
			}

			if(count($columnSet)!=count($valueSet)){
				$note="The number of filtering column names and values of such columns must be equal!";
			}
		}

		return array(
			'form' => $form,
			'note' => $note,
		);

	}

}