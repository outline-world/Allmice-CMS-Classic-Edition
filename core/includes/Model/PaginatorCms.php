<?php

class PaginatorCms
{
	public $lastPage;
	public $currentPage;
	public $itemsOnPage;
	public $noOfAllItems;
	public $formWidget;
	public $maxRanges;
	public $switchStatus;

	public $aliasSwitch;

	public function getPageData($appDb, $searchData, $otherData){

		$config=$this->getConfigData($appDb);

		if(isset($config['accessRightMethod']) && $config['accessRightMethod']=="skip&order")
			$pageData=$this->getPageData3($appDb, $searchData, $otherData, $config);
//		if(isset($config['accessRightMethod']) && $config['accessRightMethod']=="skip")
		elseif(isset($config['accessRightMethod']) && $config['accessRightMethod']=="skip")
			$pageData=$this->getPageData2($appDb, $searchData, $otherData, $config);
		elseif(isset($config['accessRightMethod']) &&  ($config['accessRightMethod']=="empty" || $config['accessRightMethod']=="full"))
			$pageData=$this->getPageData1($appDb, $searchData, $otherData, $config);
		else
			$pageData=$this->getPageData3($appDb, $searchData, $otherData, $config);

		return $pageData;

	}

	public function getPageData1($appDb, $searchData, $otherData, $config){

		$dataTable=$searchData['dataTable'];
		$selectedFields=$searchData['allFields'];
		$searchField=$searchData['searchField'];
		$searchPhrase=$searchData['searchPhrase'];
		$whereClause=$searchData['whereClause'];
		$uri=$otherData['uri'];

		$pageData=array();
		$this->setProperties1($appDb, $dataTable, $searchField, $searchPhrase, $whereClause, $config);

		$itemsOnPage=$this->itemsOnPage;

		$titleFieldName="";
		$resultFieldName="";

		if(strstr($selectedFields,"[result:]")){
			$tempArr=explode("[result:]",$selectedFields,2);
			$tempArr2=explode(", ",$tempArr[1],2);
			$resultFieldName=$tempArr2[0];
			$subString="SUBSTR(".$resultFieldName.",1,250) AS ".$resultFieldName;
			$selectedFields=str_replace("[result:]","",$selectedFields);
			$selectedFields=str_replace($resultFieldName,$subString,$selectedFields);
		}

		$sqlString="SELECT ".$selectedFields;
		$sqlString.=" FROM ".$appDb->tablePrefix.$dataTable;
		if ($searchPhrase != '' || $whereClause != '')
			$sqlString.=" WHERE ";
		if ($searchPhrase != '')
			$sqlString.=$searchField." LIKE :search";
		if ($searchPhrase != '' && $whereClause != '')
			$sqlString.=" AND ";
		$sqlString.=$whereClause;

		$sqlString.=" LIMIT ".$this->currentPage*$itemsOnPage.",".$itemsOnPage;
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $appDb->dbId->prepare($sqlString);

		if ($searchPhrase != '')
			$stmt->execute(array(
				":search" => "%$searchPhrase%"
			));
		else
			$stmt->execute();

		$resultSet = $stmt->fetchAll();


		foreach ($resultSet as $row) {
			if($resultFieldName!=""){

				if(strstr($row[($resultFieldName)]," ") && strlen($row[($resultFieldName)])>200){
	//Page body introduction (up to 200 characters) should not end in the middle of a word, but between 2 words
					$tempArr=explode(" ",strrev($row[($resultFieldName)]),2);
					$row[($resultFieldName)]=strrev($tempArr[1]);
					$row[($resultFieldName)]=strip_tags(htmlspecialchars_decode($row[($resultFieldName)]));
					$row[($resultFieldName)]=$row[($resultFieldName)]." ...";
				}
				else{
					$row[($resultFieldName)]=strip_tags(htmlspecialchars_decode($row[($resultFieldName)]));
				}
			}

			if($this->aliasSwitch=="on"){
				$sqlString="SELECT alias";
				$sqlString.=" FROM ".$appDb->tablePrefix."core_alias";
				$sqlString.=" WHERE source = '".$uri."/".$row['id']."'";
				$sqlString.=" LIMIT 1";

//					echo "sqlString=".$sqlString."<br>";
				$stmt2 = $appDb->dbId->prepare($sqlString);
				$stmt2->execute();

				$resultSet2 = $stmt2->fetchAll();

				$row['alias'] = "";
				foreach ($resultSet2 as $row2) {
					$row['alias'] = $row2['alias'];
				}
			}

			if($config['accessRightMethod']=="empty"){

				if($whereClause!="" && strstr($whereClause,"WHERE")){
					$whereClause.=" AND ";
				}

				$path=$uri."/".$row['id'];
				$sqlString="SELECT access_level";
				$sqlString.=" FROM ".$appDb->tablePrefix."core_resource r";
				$sqlString.=", ".$appDb->tablePrefix."core_access ac";
				$sqlString.=" WHERE r.uri = '".$path."'";
				$sqlString.=" AND r.id = ac.resource_id";
				$sqlString.=" AND ac.role_id = ".$otherData['activeRole'];
				$sqlString.=" LIMIT 1";

//				echo "sqlString=".$sqlString."<br>";
				$stmt3 = $appDb->dbId->prepare($sqlString);
				$stmt3->execute();

				$resultSet3 = $stmt3->fetchAll();

				$row['access_level'] = "";
				if(count($resultSet3)>0) {
					foreach ($resultSet3 as $row3) {
						$row['access_level'] = $row3['access_level'];
						if($row['access_level']==1)
							$pageData[] = $row;
						else
							$pageData[] = array();
					}
				}else{
					$pageData[] = $row;
				}

			}else{
				$pageData[] = $row;
			}

		}

		return $pageData;

	}

	public function getPageData2($appDb, $searchData, $otherData, $config){

//	Search result in case if "Access switch is on";

		$dataTable=$searchData['dataTable'];
		$selectedFields=$searchData['allFields'];
		$searchField=$searchData['searchField'];
		$searchPhrase=$searchData['searchPhrase'];
		$whereClause=$searchData['whereClause'];
		$uri=$otherData['uri'];

		$pageData=array();

		$titleFieldName="";
		$resultFieldName="";

		if(strstr($selectedFields,"[result:]")){
			$tempArr=explode("[result:]",$selectedFields,2);
			$tempArr2=explode(", ",$tempArr[1],2);
			$resultFieldName=$tempArr2[0];
			$subString="SUBSTR(".$resultFieldName.",1,250) AS ".$resultFieldName;
			$selectedFields=str_replace("[result:]","",$selectedFields);
			$selectedFields=str_replace($resultFieldName,$subString,$selectedFields);
		}

//The code in method getPageData will return search result, if current role has access for such content, but
//   total items found will be shown for all content - if no access, then it is mentioned in search result table.
//Following code takes into account the total number, total pages of accessible content.
//It may be slower, but more user friendly.
//Looks very complex to put search query and content access data into same SQL query and this will not be done.
//idSet array will be found, which includes all the accessible content id values of the current search query for the current role. 

		$countAccessSet=0;

//Getting ids for all search results - not depending on current paginator properties
		$sqlString="SELECT id";
		$sqlString.=" FROM ".$appDb->tablePrefix.$dataTable;
		if ($searchPhrase != '' || $whereClause != '')
			$sqlString.=" WHERE ";
		if ($searchPhrase != '')
			$sqlString.=$searchField." LIKE :search";
		if ($searchPhrase != '' && $whereClause != '')
			$sqlString.=" AND ";
		$sqlString.=$whereClause;

		$stmt = $appDb->dbId->prepare($sqlString);

		if ($searchPhrase != '')
			$stmt->execute(array(
				":search" => "%$searchPhrase%"
			));
		else
			$stmt->execute();

		$resultSet11 = $stmt->fetchAll();

		$idSet=array();
		foreach ($resultSet11 as $row) {

//Getting access right for every search result
			$path=$uri."/".$row['id'];
			$sqlString="SELECT access_level";
			$sqlString.=" FROM ".$appDb->tablePrefix."core_resource r";
			$sqlString.=", ".$appDb->tablePrefix."core_access ac";
			$sqlString.=" WHERE r.uri = '".$path."'";
			$sqlString.=" AND r.id = ac.resource_id";
			$sqlString.=" AND ac.role_id = ".$otherData['activeRole'];
			$sqlString.=" LIMIT 1";

//				echo "sqlString=".$sqlString."<br>";
			$stmt3 = $appDb->dbId->prepare($sqlString);
			$stmt3->execute();

			$resultSet3 = $stmt3->fetchAll();

			$row['access_level'] = "";
			if(count($resultSet3)>0) {
				foreach ($resultSet3 as $row3) {
					if($row3['access_level']==1)
						$idSet[]=$row['id'];
				}
			}

		}

//To find search result correctly - items on page - $extraLimit is needed,
//   because some of the items in the search result query may not have access right for current user.
//   The value extraLimit determines, how many such items are there.
		$extraLimit=count($resultSet11)-count($idSet);

//Setting properties for paginator
		$this->noOfAllItems=count($idSet);

		$this->setProperties2($appDb, $config);
		$itemsOnPage=$this->itemsOnPage;


		if($this->itemsOnPage>0){
	
			$this->lastPage=floor(count($idSet)/$this->itemsOnPage);
	
	//Page and range will not be determined in sql query, but using the idSet array -
	//   where clause will have simply following logic: WHERE id >= $idSet[x1] AND id < $idSet[xN] to get a chunk from db to filter later.  
	//Because ORDER BY will not be used in these SQL queries, then id is always in ascending order and above approach is good.
	//If page = 3 and range = 10, then
	
	//Getting all search result according to current paginator properties - current page number, items on page etc.
			$rangeEnd=0;
			if(count($idSet)<($this->currentPage+1)*$itemsOnPage)
				$rangeEnd=count($idSet)-1;
			else
				$rangeEnd=($this->currentPage+1)*$itemsOnPage-1;
	
			$whereClause2=" AND id >= ".$idSet[($this->currentPage*$itemsOnPage)]." AND id < ".($idSet[($rangeEnd)]+1)."";
	
			$sqlString="SELECT ".$selectedFields;
			$sqlString.=" FROM ".$appDb->tablePrefix.$dataTable;
			if ($searchPhrase != '' || $whereClause != '')
				$sqlString.=" WHERE ";
			if ($searchPhrase != '')
				$sqlString.=$searchField." LIKE :search";
			if ($searchPhrase != '' && $whereClause != '')
				$sqlString.=" AND ";
			$sqlString.=$whereClause;
			$sqlString.=$whereClause2;
	//		$sqlString.=(" LIMIT ".$itemsOnPage);
			$sqlString.=(" LIMIT ".($itemsOnPage+$extraLimit));
	
	//		echo "sqlString=".$sqlString."<br>";
	
			$stmt = $appDb->dbId->prepare($sqlString);
		
			if ($searchPhrase != '')
				$stmt->execute(array(
					":search" => "%$searchPhrase%"
				));
			else
			$stmt->execute();
	
			$allSearchSet = array();
			$resultSet2 = $stmt->fetchAll();
	
			foreach ($resultSet2 as $row2) {
				for ($i=($this->currentPage*$itemsOnPage);$i<=$rangeEnd;$i++) {
	//Filtering search result according current paginator properties and access right
					if($row2['id']==$idSet[$i]){
						$accessSearchSet[]=$row2;
					}
				}
			}
	
			if(strstr($selectedFields,"[result:]")){
				$tempArr=explode("[result:]",$selectedFields,2);
				$tempArr2=explode(", ",$tempArr[1],2);
				$resultFieldName=$tempArr2[0];
				$subString="SUBSTR(".$resultFieldName.",1,250) AS ".$resultFieldName;
				$selectedFields=str_replace("[result:]","",$selectedFields);
				$selectedFields=str_replace($resultFieldName,$subString,$selectedFields);
			}
	
			foreach ($accessSearchSet as $row) {
	
				if($resultFieldName!=""){
	
					if(strstr($row[($resultFieldName)]," ") && strlen($row[($resultFieldName)])>200){
		//Page body introduction (up to 200 characters) should not end in the middle of a word, but between 2 words
						$tempArr=explode(" ",strrev($row[($resultFieldName)]),2);
						$row[($resultFieldName)]=strrev($tempArr[1]);
						$row[($resultFieldName)]=strip_tags(htmlspecialchars_decode($row[($resultFieldName)]));
						$row[($resultFieldName)]=$row[($resultFieldName)]." ...";
					}
					else{
						$row[($resultFieldName)]=strip_tags(htmlspecialchars_decode($row[($resultFieldName)]));
					}
				}
	
				if($this->aliasSwitch=="on"){
	
					$sqlString="SELECT alias";
					$sqlString.=" FROM ".$appDb->tablePrefix."core_alias";
					$sqlString.=" WHERE source = '".$uri."/".$row['id']."'";
					$sqlString.=" LIMIT 1";
	
	//					echo "sqlString=".$sqlString."<br>";
					$stmt2 = $appDb->dbId->prepare($sqlString);
					$stmt2->execute();
	
					$resultSet2 = $stmt2->fetchAll();
	
					$row['alias'] = "";
					foreach ($resultSet2 as $row2) {
						$row['alias'] = $row2['alias'];
					}
				}
	
				$pageData[] = $row;
	
			}

		}

		return $pageData;

	}

	public function getPageData3($appDb, $searchData, $otherData, $config){

//	Search result in case if accessRightMethod is skip&order;

		$dataTable=$searchData['dataTable'];
		$selectedFields=$searchData['allFields'];
		$searchField=$searchData['searchField'];
		$searchPhrase=$searchData['searchPhrase'];
		$whereClause=$searchData['whereClause'];
		$orderClause=$searchData['orderClause'];
		$uri=$otherData['uri'];

		$pageData=array();

		$titleFieldName="";
		$resultFieldName="";

//Table identifier s in SQL query string means source

		if(strstr($selectedFields,"[result:]")){
			$tempArr=explode("[result:]",$selectedFields,2);
			$tempArr2=explode(", ",$tempArr[1],2);
			$resultFieldName=$tempArr2[0];
			$subString="SUBSTR(s.".$resultFieldName.",1,250) AS ".$resultFieldName;
			$selectedFields=str_replace("[result:]","",$selectedFields);
			$selectedFields=str_replace($resultFieldName,$subString,$selectedFields);
		}

		if($selectedFields!=""){
			$tempArr=explode(", ",$selectedFields);
			$selectedFields="s.".$tempArr[0]." AS ".$tempArr[0];
			for($i=1;$i<count($tempArr);$i++){
				if(!strstr($tempArr[$i],"SUBSTR")){
					$selectedFields.=(", s.".$tempArr[$i]." AS ".$tempArr[$i]);
				}else{
					$selectedFields.=(", ".$tempArr[$i]);
				}
			}
		}

		$countAccessSet=0;

//Table identifier s in SQL query string means source
		$sqlString="SELECT";
		$sqlString.=" ac.access_level AS access_level";
		$sqlString.=", ".$selectedFields;
		$sqlString.=" FROM ".$appDb->tablePrefix.$dataTable." s";
		$sqlString.=" INNER JOIN ".$appDb->tablePrefix."core_resource r";
		$sqlString.=" ON r.source_id = s.id";
		$sqlString.=" INNER JOIN ".$appDb->tablePrefix."core_access ac";
		$sqlString.=" ON r.id = ac.resource_id";
		if ($searchPhrase != '' || $whereClause != '')
			$sqlString.=" WHERE ";
		if ($searchPhrase != '')
			$sqlString.="s.".$searchField." LIKE :search";
		$sqlString.=" AND r.uri LIKE '".$uri."%'";
		$sqlString.=" AND ac.role_id = ".$otherData['activeRole'];
		$sqlString.=" AND ac.access_level > 0";
		if ($searchPhrase != '' && $whereClause != '')
			$sqlString.=" AND ";
		$sqlString.=$whereClause;
		if ($orderClause != ''){
			$sqlString.=" ORDER BY ";
			$sqlString.=$orderClause;
		}

//		echo "sqlString=".$sqlString."<br>";

		$stmt = $appDb->dbId->prepare($sqlString);

		if ($searchPhrase != '')
			$stmt->execute(array(
				":search" => "%$searchPhrase%"
			));
		else
			$stmt->execute();

		$resultSet11 = $stmt->fetchAll();

		$accessSearchSet=array();

		foreach ($resultSet11 as $row) {
			$accessSearchSet[]=$row;
		}

//Get all aliases
		$sqlString="SELECT";
		$sqlString.=" s.id AS sourceId";
		$sqlString.=", r.id AS resourceId";
		$sqlString.=", al.alias AS alias";
		$sqlString.=" FROM ".$appDb->tablePrefix.$dataTable." s";
		$sqlString.=" INNER JOIN ".$appDb->tablePrefix."core_resource r";
		$sqlString.=" ON r.source_id = s.id";
		$sqlString.=" INNER JOIN ".$appDb->tablePrefix."core_access ac";
		$sqlString.=" ON r.id = ac.resource_id";
		$sqlString.=" INNER JOIN ".$appDb->tablePrefix."core_alias al";
		$sqlString.=" ON r.id = al.resource_id";
		if ($searchPhrase != '' || $whereClause != '')
			$sqlString.=" WHERE ";
		if ($searchPhrase != '')
			$sqlString.="s.".$searchField." LIKE :search";
		$sqlString.=" AND r.uri LIKE '".$uri."%'";
		$sqlString.=" AND ac.role_id = ".$otherData['activeRole'];
		$sqlString.=" AND ac.access_level > 0";
		if ($searchPhrase != '' && $whereClause != '')
			$sqlString.=" AND ";
		$sqlString.=$whereClause;
		if ($orderClause != ''){
			$sqlString.=" ORDER BY ";
			$sqlString.=$orderClause;
		}

//			echo "sqlString (alias)=".$sqlString."<br>";

		$stmt = $appDb->dbId->prepare($sqlString);

		if ($searchPhrase != '')
			$stmt->execute(array(
				":search" => "%$searchPhrase%"
			));
		else
			$stmt->execute();

		$resultSetAl = $stmt->fetchAll();

		$aliasList=array();
		$viewSearchSet=array();
		$idSet=array();

		foreach ($resultSetAl as $row) {
			$aliasList[($row['sourceId'])]['alias']=$row['alias'];
			$aliasList[($row['sourceId'])]['resId']=$row['resourceId'];
		}

//Setting properties for paginator
		$this->noOfAllItems=count($resultSet11);
		$this->setProperties2($appDb, $config);
		$itemsOnPage=$this->itemsOnPage;
		if($this->itemsOnPage>0){
			$this->lastPage=floor(count($resultSet11)/$this->itemsOnPage);
	//Getting all search result according to current paginator properties - current page number, items on page etc.
			$viewSearchSet = array_slice($accessSearchSet, ($this->currentPage*$this->itemsOnPage), $this->itemsOnPage);
		}

		foreach ($viewSearchSet as $row) {

			if($resultFieldName!=""){

				if(strstr($row[($resultFieldName)]," ") && strlen($row[($resultFieldName)])>200){
	//Page body introduction (up to 200 characters) should not end in the middle of a word, but between 2 words
					$tempArr=explode(" ",strrev($row[($resultFieldName)]),2);
					$row[($resultFieldName)]=strrev($tempArr[1]);
					$row[($resultFieldName)]=strip_tags(htmlspecialchars_decode($row[($resultFieldName)]));
					$row[($resultFieldName)]=$row[($resultFieldName)]." ...";
				}
				else{
					$row[($resultFieldName)]=strip_tags(htmlspecialchars_decode($row[($resultFieldName)]));
				}
			}

			if($this->aliasSwitch=="on"){

				$row['alias'] = $aliasList[($row['id'])]['alias'];

			}

			$pageData[] = $row;

		}

		return $pageData;

	}

	public function setProperties1($appDb, $dataTable, $searchField, $searchPhrase, $whereClause, $config){

		if(!isset($this->currentPage))
			$this->currentPage=0;
		$currentPage=$this->currentPage;

		if(isset($config['itemsOnPage']))
			$this->itemsOnPage=$config['itemsOnPage'];
		else
			$this->itemsOnPage=40;

		if(isset($config['maxRanges']))
			$this->maxRanges=$config['maxRanges'];
		else
			$this->maxRanges=50;

		if(isset($config['displayPaginatorSwitch']))
			$this->switchStatus=$config['displayPaginatorSwitch'];
		else
			$this->switchStatus="on";

		if(isset($config['aliasCheckSwitch']))
			$this->aliasSwitch=$config['aliasCheckSwitch'];
		else
			$this->aliasSwitch="on";
		if(isset($config['accessCheckSwitch']))
			$this->accessSwitch=$config['accessCheckSwitch'];
		else
			$this->accessSwitch="on";

		$itemsOnPage=$this->itemsOnPage;

		if(!isset($this->maxRanges))
			$this->maxRanges=30;
		$maxRanges=$this->maxRanges;

		$sqlString="SELECT COUNT(id) AS total";
		$sqlString.=" FROM ".$appDb->tablePrefix.$dataTable;

		if ($searchPhrase == '' && $whereClause != ''){
			$sqlString.=" WHERE ";
			$sqlString.=$whereClause;
		}
		elseif ($searchPhrase != ''){
			$sqlString.=" WHERE ";
			$sqlString.=$searchField." LIKE :search";  
		}

		if ($searchPhrase != '' && $whereClause != ''){
			$sqlString.=" AND ";
			$sqlString.=$whereClause;  
		}

//		echo "sqlString=".$sqlString."<br>";

		$stmt = $appDb->dbId->prepare($sqlString);

		if ($searchPhrase != '')
			$stmt->execute(array(
				":search" => "%$searchPhrase%"
			));
		else
			$stmt->execute();

		$this->noOfAllItems = $stmt->fetchColumn();

		if($this->switchStatus=="onDemand"){
			if($this->itemsOnPage>=$this->noOfAllItems){
				$this->formWidget="";
				$this->itemsOnPage=$this->noOfAllItems;
			}
			else{
				$paginData=$this->findPaginData();
				$this->currentPage=$paginData['formStatus']['currentPage'];
				$this->formWidget=$paginData['formWidget'];
			}
		}
		elseif($this->switchStatus=="on"){
			$paginData=$this->findPaginData();
			$this->currentPage=$paginData['formStatus']['currentPage'];
			$this->formWidget=$paginData['formWidget'];
		}
		else{
			$this->formWidget="";
			$this->itemsOnPage=$this->noOfAllItems;
		}
	}

	public function setProperties2($appDb, $config){

		if(!isset($this->currentPage))
			$this->currentPage=0;
		$currentPage=$this->currentPage;

		if(isset($config['itemsOnPage']))
			$this->itemsOnPage=$config['itemsOnPage'];
		else
			$this->itemsOnPage=40;

		if(isset($config['maxRanges']))
			$this->maxRanges=$config['maxRanges'];
		else
			$this->maxRanges=50;

		if(isset($config['displayPaginatorSwitch']))
			$this->switchStatus=$config['displayPaginatorSwitch'];
		else
			$this->switchStatus="on";

		if(isset($config['aliasCheckSwitch']))
			$this->aliasSwitch=$config['aliasCheckSwitch'];
		else
			$this->aliasSwitch="on";
		if(isset($config['accessCheckSwitch']))
			$this->accessSwitch=$config['accessCheckSwitch'];
		else
			$this->accessSwitch="on";

		$itemsOnPage=$this->itemsOnPage;

		if(!isset($this->maxRanges))
			$this->maxRanges=30;
		$maxRanges=$this->maxRanges;

		if($this->switchStatus=="onDemand"){
			if($this->itemsOnPage>=$this->noOfAllItems){
				$this->formWidget="";
				$this->itemsOnPage=$this->noOfAllItems;
			}
			else{
				$paginData=$this->findPaginData();
				$this->currentPage=$paginData['formStatus']['currentPage'];
				$this->formWidget=$paginData['formWidget'];
			}
		}
		elseif($this->switchStatus=="on"){
			$paginData=$this->findPaginData();
			$this->currentPage=$paginData['formStatus']['currentPage'];
			$this->formWidget=$paginData['formWidget'];
		}
		else{
			$this->formWidget="";
			$this->itemsOnPage=$this->noOfAllItems;
		}

	}

	public function getPaginWidget($paginData)
	{

		$url1 = $_SERVER['SERVER_NAME'];
		$url2 = $_SERVER['REQUEST_URI'];
		$curUrl="http:"."/"."/".$url1.$url2;
		$appUri="http:"."/"."/".$url1.$url2;

		$buttonStatus['left']="";
		$buttonStatus['right']="";
		if($paginData['currentPage']==0)
			$buttonStatus['left']=" disabled=\"disabled\"";
		if($paginData['currentPage']==$this->lastPage)
			$buttonStatus['right']=" disabled=\"disabled\"";

		$formWidget="";

		$formWidget.="<div class=\"paginator\">\n";
		$formWidget.="<input type=\"submit\" name=\"paginFirst\" class=\"pagin\" value=\"|<<\" />\n";
		$formWidget.="<input type=\"submit\" name=\"paginPrev\" class=\"pagin\" value=\"<<\"".$buttonStatus['left']." />\n";
		$formWidget.="<select name=\"paginPage\" class=\"pagin-select\" onchange=\"this.form.submit()\">\n";
		$status="";

		if(($this->lastPage)>($this->maxRanges)){
//Max pages listed
			$gap=ceil(($this->lastPage+1)/$this->maxRanges);
	
			$statusFlag=false;

			for($i=0;$i<($this->lastPage);$i+=$gap){

				$status="";
				if($paginData['currentPage']>=$i && $paginData['currentPage']<($i+$gap) && !$statusFlag){
					$status=" selected=\"selected\"";
					$statusFlag=true;
				}
				$formWidget.="<option class=\"pagin-option\" value=\"".$i."\"".$status.">".($i+1)."-".($i+$gap)."</option>\n";
			}

		}
		else{ 
//All pages listed
			for($i=0;$i<=($this->lastPage);$i++){
				$status="";
				if($i==$paginData['currentPage'])
					$status=" selected=\"selected\"";
				$formWidget.="<option class=\"pagin-option\" value=\"".$i."\"".$status.">".($i+1)."</option>\n";
			}
		}

		$formWidget.="</select>\n";
		$formWidget.="<input type=\"submit\" name=\"paginNext\" class=\"pagin\" value=\">>\"".$buttonStatus['right']." />\n";
		$formWidget.="<input type=\"submit\" name=\"paginLast\" class=\"pagin\" value=\">>|\" />\n";
		$formWidget.="</div>\n";

		return $formWidget;

	}

	public function findPaginData()
	{

		$paginData['itemsOnPage']=$this->itemsOnPage;
		$defaultPage=0;
		$paginData['currentPage']=$defaultPage;

		$paginData['noOfAllItems']=$this->noOfAllItems;

		if(isset($_SESSION['currentPage'])){
      	$paginData['currentPage']=$_SESSION['currentPage'];
		}else{
      	$_SESSION['currentPage']=$paginData['currentPage'];
		}

		$this->lastPage=ceil($paginData['noOfAllItems']/$paginData['itemsOnPage'])-1;

		if (isset($_POST['paginNext']) && $_POST['paginNext']!="") {
				// button next was pressed
			$paginData['currentPage']++;
		}
		elseif (isset($_POST['paginPrev']) && $_POST['paginPrev']!="") {
				//button previous was pressed
			$paginData['currentPage']--;
		}
		elseif (isset($_POST['paginFirst']) && $_POST['paginFirst']!="") {
				// button first was pressed
			$paginData['currentPage']=0;
		}
		elseif (isset($_POST['paginLast']) && $_POST['paginLast']!="") {
				// button last was pressed
			$paginData['currentPage']=$this->lastPage;
		}
		elseif (isset($_POST['paginPage']) && $_POST['paginPage']!="") {
			$paginData['currentPage']=(int)$_POST['paginPage'];
		}else{
			$paginData['currentPage']=$defaultPage;
		}

		if($paginData['currentPage']>$this->lastPage)
			$paginData['currentPage']=0;
		$this->currentPage=$paginData['currentPage'];
		$_POST['paginCurrentPage']=$this->currentPage;

     	$_SESSION['currentPage']=$paginData['currentPage'];

		$formWidget=$this->getPaginWidget($paginData);

		$paginFormData['formStatus']=$paginData;
		$paginFormData['formWidget']=$formWidget;

		return $paginFormData;

	}

	public function getDbList($appDb, $dataTable, $selectedFields, $searchField, $searchPhrase, $whereClause){
//Obsolete, use getPageData instead of this.
//Some module methods may still use it. 23/10/2017 User module list events are using current method. 
//For example user/list-email-addresses 23/10/2018.
		$searchResult=array();

		$this->setProperties($appDb, $dataTable, $searchField, $searchPhrase, $whereClause);

		$itemsOnPage=$this->itemsOnPage;

		$titleFieldName="";
		$resultFieldName="";
		if(strstr($selectedFields,"[title:]")){
			$tempArr=explode("[title:]",$selectedFields,2);
			$tempArr2=explode(", ",$tempArr[1],2);
			$titleFieldName=$tempArr2[0];
			$selectedFields=str_replace("[title:]","",$selectedFields);
		}
		if(strstr($selectedFields,"[result:]")){
			$tempArr=explode("[result:]",$selectedFields,2);
			$tempArr2=explode(", ",$tempArr[1],2);
			$resultFieldName=$tempArr2[0];

			$subString="SUBSTR(".$resultFieldName.",1,300) AS ".$resultFieldName;
			$selectedFields=str_replace("[result:]","",$selectedFields);
			$selectedFields=str_replace($resultFieldName,$subString,$selectedFields);
		}

		$sqlString="SELECT ".$selectedFields;
		$sqlString.=" FROM ".$appDb->tablePrefix.$dataTable;
		if ($searchPhrase != '' || $whereClause != '')
			$sqlString.=" WHERE ";
		if ($searchPhrase != '')
			$sqlString.=$searchField." LIKE :search";
		if ($searchPhrase != '' && $whereClause != '')
			$sqlString.=" AND ";
		$sqlString.=$whereClause;

		$sqlString.=" LIMIT ".$this->currentPage*$itemsOnPage.",".$itemsOnPage;
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $appDb->dbId->prepare($sqlString);

		if ($searchPhrase != '')
			$stmt->execute(array(
				":search" => "%$searchPhrase%"
			));
		else
			$stmt->execute();

		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			if($resultFieldName!=""){
				if(strstr($row[($resultFieldName)]," ") && strlen($row[($resultFieldName)])>200){
	//Page body introduction (up to 200 characters) should not end in the middle of a word, but between 2 words
					$row[($resultFieldName)]=strip_tags(htmlspecialchars_decode($row[($resultFieldName)]));
					$tempArr=explode(" ",strrev($row[($resultFieldName)]),2);
					$row[($resultFieldName)]=strrev($tempArr[1])." ...";
				}
				else{
					$row[($resultFieldName)]=strip_tags(htmlspecialchars_decode($row[($resultFieldName)]));
				}
			}

			$accessRight=true;
			if($accessRight){

				$searchResult[] = $row;
			}

		}

		return $searchResult;

	}

	public function setProperties($appDb, $dataTable, $searchField, $searchPhrase, $whereClause){

//Obsolete (related to getDbList), use getPageData & (setProperties1 or setProperties2) instead of this.
//Some module methods may still use it. 23/10/2017 User module list events are using current method. 
//For example user/list-contact-forms 23/10/2018.

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$appDb->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'App'";  
		$sqlString.=" AND type = 'paginator'";

		$stmt = $appDb->dbId->prepare($sqlString);

		$stmt->execute();

		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$config[($row['uri'])]=$row['value'];
		}

		if(!isset($this->currentPage))
			$this->currentPage=0;
		$currentPage=$this->currentPage;

//		echo "sqlString=".$sqlString."<br>";

		if(isset($config['itemsOnPage']))
			$this->itemsOnPage=$config['itemsOnPage'];
		else
			$this->itemsOnPage=40;

		if(isset($config['maxRanges']))
			$this->maxRanges=$config['maxRanges'];
		else
			$this->maxRanges=50;

		if(isset($config['displayPaginatorSwitch']))
			$this->switchStatus=$config['displayPaginatorSwitch'];
		else
			$this->switchStatus="on";

		if(isset($config['aliasCheckSwitch']))
			$this->aliasSwitch=$config['aliasCheckSwitch'];
		else
			$this->aliasSwitch="on";
		if(isset($config['accessCheckSwitch']))
			$this->accessSwitch=$config['accessCheckSwitch'];
		else
			$this->accessSwitch="on";

		$itemsOnPage=$this->itemsOnPage;

		if(!isset($this->maxRanges))
			$this->maxRanges=30;
		$maxRanges=$this->maxRanges;

		$sqlString="SELECT COUNT(id) AS total";
		$sqlString.=" FROM ".$appDb->tablePrefix.$dataTable;

		if ($searchPhrase == '' && $whereClause != ''){
			$sqlString.=" WHERE ";
			$sqlString.=$whereClause;
		}
		elseif ($searchPhrase != ''){
			$sqlString.=" WHERE ";
			$sqlString.=$searchField." LIKE :search";  
		}

		if ($searchPhrase != '' && $whereClause != ''){
			$sqlString.=" AND ";
			$sqlString.=$whereClause;  
		}

//		echo "sqlString=".$sqlString."<br>";

		$stmt = $appDb->dbId->prepare($sqlString);

		if ($searchPhrase != '')
			$stmt->execute(array(
				":search" => "%$searchPhrase%"
			));
		else
			$stmt->execute();

		$this->noOfAllItems = $stmt->fetchColumn();

		if($this->switchStatus=="onDemand"){
			if($this->itemsOnPage>=$this->noOfAllItems){
				$this->formWidget="";
				$this->itemsOnPage=$this->noOfAllItems;
			}
			else{
				$paginData=$this->findPaginData();
				$this->currentPage=$paginData['formStatus']['currentPage'];
				$this->formWidget=$paginData['formWidget'];
			}
		}
		elseif($this->switchStatus=="on"){
			$paginData=$this->findPaginData();
			$this->currentPage=$paginData['formStatus']['currentPage'];
			$this->formWidget=$paginData['formWidget'];
		}
		else{
			$this->formWidget="";
			$this->itemsOnPage=$this->noOfAllItems;
		}
	}

	public function getConfigData($appDb){

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$appDb->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'App'";  
		$sqlString.=" AND type = 'paginator'";

		$stmt = $appDb->dbId->prepare($sqlString);

		$stmt->execute();

		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$configData[($row['uri'])]=$row['value'];
		}

		return $configData;

	}

}
