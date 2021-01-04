<?php

class SearchBlock
{

	public $dbId;
	public $tablePrefix;

	function buildSearchBlock() {

		$blockView="";
		$id=0;

		$appDb = $GLOBALS['db'];
		$this->dbId=$GLOBALS['db']['id'];
		$this->tablePrefix=$GLOBALS['db']['tablePrefix'];

		$configData=$this->getConfigData('searchBlock');

		$tempArr=explode(", ", $configData['searchBlock']['searchType']);

		if(isset($tempArr[0]) && isset($tempArr[1])){

			$sqlString="SELECT id";
			$sqlString.=" FROM ".$this->tablePrefix."mod_search";
			$sqlString.=" WHERE search_table = :table";
			$sqlString.=" AND search_table_field = :field";
			$sqlString.=" AND language_code = :langCode";
			$sqlString.=" LIMIT 1";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":table" => $tempArr[0],
				":field" => $tempArr[1],
				":langCode" => $GLOBALS['langCode']
			));
			$resultSet = $stmt->fetchAll();

			foreach ($resultSet as $row) {
				$id = $row['id'];
			}

		}

		if($id==0 && isset($tempArr[0]) && isset($tempArr[1])){
			$sqlString="SELECT id";
			$sqlString.=" FROM ".$this->tablePrefix."mod_search";
			$sqlString.=" WHERE search_table = :table";
			$sqlString.=" AND search_table_field = :field";
			$sqlString.=" AND language_code = 'en'";
			$sqlString.=" LIMIT 1";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":table" => $tempArr[0],
				":field" => $tempArr[1]
			));
			$resultSet = $stmt->fetchAll();

			foreach ($resultSet as $row) {
				$id = $row['id'];
			}

		}

		if($id>0){
			$blockView="";

			$blockView.="<form action=\"".$GLOBALS['baseUrl']."/search/list-by-type/".$id."\" method=\"post\">\n";
			$blockView.="<div class=\"search-phrase\">";
			$blockView.="<input name=\"searchPhrase\" class=\"search-phrase\" type=\"text\" value=\"\">";
			$blockView.="</div>";
			$blockView.="<div class=\"search-button\">";
			$blockView.="<input name=\"search\" class=\"search-button\" type=\"submit\" value=\"\">";
			$blockView.="</div>";

			$blockView.="</form>";

		}

		return $blockView;
	}

	public function getConfigData($typePrefix)
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'Search'";
		if($typePrefix!="")
			$sqlString.=" AND type LIKE '".$typePrefix."%'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$configData[($row['type'])][($row['uri'])] = $row['value'];
		}

		return $configData;

	}

}
