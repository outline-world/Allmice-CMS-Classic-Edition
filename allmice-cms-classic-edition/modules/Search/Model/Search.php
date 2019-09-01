<?php

class Search
{

	public $id;

	public $title;
	public $searchPhrase;
	public $description;
	public $modName;
	public $searchTable;
	public $searchTableField;
	public $searchType;
	public $titleTableField;
	public $uri;
	public $addWhereClause;
	public $orderClause;
	public $resultFieldFields;
	public $resultFieldTitles;
	public $language;

	public function convertFormData($data)
	{

		$this->id = (isset($data['searchType'])) ? $data['searchType'] : 0;
		$this->title = (isset($data['title'])) ? $data['title'] : '';
		$this->searchPhrase = (isset($data['searchPhrase'])) ? $data['searchPhrase'] : '';

		$this->searchPhrase = "%".str_replace("*","%",$this->searchPhrase)."%";

		$this->description = (isset($data['description'])) ? $data['description'] : '';
		$this->modName = (isset($data['modName'])) ? $data['modName'] : '';
		$this->searchTable = (isset($data['searchTable'])) ? $data['searchTable'] : '';
		$this->searchTableField = (isset($data['searchTableField'])) ? $data['searchTableField'] : '';
		$this->searchType = (isset($data['searchType'])) ? $data['searchType'] : 0;
		$this->titleTableField = (isset($data['titleTableField'])) ? $data['titleTableField'] : '';
		$this->uri = (isset($data['uri'])) ? $data['uri'] : '';
		$this->addWhereClause = (isset($data['addWhereClause'])) ? $data['addWhereClause'] : '';
		$this->orderClause = (isset($data['orderClause'])) ? $data['orderClause'] : '';
		$this->resultFieldNames = (isset($data['resultFieldNames'])) ? $data['resultFieldNames'] : '';
		$this->resultFieldTitles = (isset($data['resultFieldTitles'])) ? $data['resultFieldTitles'] : '';

		$this->language = (isset($data['language'])) ? $data['language'] : '';

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->title = (isset($data['title'])) ? $data['title'] : '';
		$this->description = (isset($data['description'])) ? $data['description'] : '';
		$this->modName = (isset($data['module_name'])) ? $data['module_name'] : '';
		$this->searchTable = (isset($data['search_table'])) ? $data['search_table'] : '';
		$this->searchTableField = (isset($data['search_table_field'])) ? $data['search_table_field'] : '';
		$this->searchType = (isset($data['id'])) ? $data['id'] : '';
		$this->titleTableField = (isset($data['title_table_field'])) ? $data['title_table_field'] : '';
		$this->uri = (isset($data['uri'])) ? $data['uri'] : '';
		$this->addWhereClause = (isset($data['add_where_clause'])) ? $data['add_where_clause'] : "";
		$this->orderClause = (isset($data['order_clause'])) ? $data['order_clause'] : "";
		$this->resultFieldNames = (isset($data['result_field_names'])) ? $data['result_field_names'] : '';
		$this->resultFieldTitles = (isset($data['result_field_titles'])) ? $data['result_field_titles'] : '';

		$this->language = (isset($data['language_code'])) ? $data['language_code'] : '';

	}

	public function adjustSearchString($searchString)
	{
//Function adjustSearchString adds functionality, where:
//   * Search strings within quotes or double quotes will be considered as exact keywords (space part of the keyword).
//   * Otherwise space character " " will be considered the same as MySQL wild character "%".

		$searchString=str_replace("&#39;","'",$searchString);
		$searchString=str_replace('&quot;','"',$searchString);

		$status="noQuotes";

		$firstChar = mb_substr($searchString, 0, 1, "UTF-8");
//echo "firstChar=";
//echo $firstChar;
//echo "<br>";
		if($firstChar=="'"){
//echo "first char is quote<br>";
			$lastChar = mb_substr($searchString, -1, 1, "UTF-8");
			if($lastChar=="'"){
				$tempString="[#s#]".$searchString."[#e#]";

				$searchString=str_replace(("[#s#]"."'"),"",$tempString);
				$searchString=str_replace(("'"."[#e#]"),"",$searchString);

				$status="withQuotes";
			}
			
		}
		elseif($firstChar=='"'){
//echo "first char is double quote<br>";
			$lastChar = mb_substr($searchString, -1, 1, "UTF-8");
			if($lastChar=='"'){
				$tempString='[#s#]'.$searchString.'[#e#]';
				$searchString=str_replace(('[#s#]'.'"'),'',$tempString);
				$searchString=str_replace(('"'.'[#e#]'),'',$searchString);

				$status="withQuotes";
			}
		}

		if($status=="noQuotes")
			$searchString=str_replace(" ","%",$searchString);

		return $searchString;

	}

}
