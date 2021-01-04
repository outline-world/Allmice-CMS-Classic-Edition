<?php

class Phrase
{
	public $id;
	public $languageCode;
	public $langCode;
	public $moduleName;
	public $specificName;
	public $type;
	public $uri;
	public $text;
	public $phraseSet;

	public function getPhraseSet($phraseTable,$headerLine)
	{

		$phraseSet=array();
		$tempArr = explode("\n",$phraseTable);
		$tempArr[0]=trim($tempArr[0]);
		$headerLine=trim($headerLine);

		if($tempArr[0]==$headerLine){

			for($i=0;$i<count($tempArr);$i++) {

				if($tempArr[$i]!=""){

					$tempArr2 = explode("\t",$tempArr[$i]);
					for($j=0;$j<count($tempArr2);$j++) {
						$tempArr2[$j]=trim($tempArr2[$j]);
					}
					if($i==0){
						$header=$tempArr2;
					}else{
						for($j=0;$j<count($tempArr2);$j++) {
							$phraseDetails[($header[$j])]=$tempArr2[$j];
						}
						$phraseSet[]=$phraseDetails;
					}

				}
			}
		}

		return $phraseSet;

	}

	public function getTypeSet()
	{

		$typeSet = array(
			11 => 'Global block (11)',
			21 => 'Local form (21)',
			22 => 'Local other (22)',
		);
		return $typeSet;

	}

	public function getSqlString($phraseSet)
	{

		$sqlString="";
		$sqlString="INSERT INTO `core_language` (`language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES\n";

		for($i=0;$i<count($phraseSet);$i++) {
			$sqlRow="(";

			$sqlRow.=("'".$phraseSet[$i]['language_code']."', ");
			$sqlRow.=($phraseSet[$i]['type'].", ");
			$sqlRow.=("'".$phraseSet[$i]['module_name']."', ");
			$sqlRow.=("'".$phraseSet[$i]['specific_name']."', ");
			$sqlRow.=("'".$phraseSet[$i]['uri']."', ");
			$sqlRow.=("'".$phraseSet[$i]['text']."'");

			$sqlString.=$sqlRow;
			if($i==(count($phraseSet)-1)){
				$sqlString.=");\n";
			}else{
				$sqlString.="),\n";
			}

		}

		return $sqlString;

	}

	public function getSqlSet($sqlContent,$installData)
	{

		$sqlSet=array();

		$tempArr=explode("\n",$sqlContent);

		$rowStatus="sep";
		$curSql="";
		foreach($tempArr as $row){
			if(isset($row)){
				if(substr($row,0,2)!="--" && $row!="" && substr($row,0,3)!="/*!" && substr($row, -1)!=";"){
					$curSql.=$row;
					$rowStatus="sql";
				}elseif(substr($row,0,2)!="--" && $row!="" && substr($row,0,3)!="/*!" && substr($row, -1)==";"){
					if($rowStatus=="sep"){
						$curSql="";
					}else{
					}
					$curSql.=$row;
					$rowStatus="sql";

					$curSql=str_replace($installData['needle'],($installData['tablePrefix'].$installData['needle']),$curSql);
					$curSql=str_replace($installData['needle2'],($installData['tablePrefix'].$installData['needle2']),$curSql);

					$sqlSet[]=$curSql;
					$curSql="";

				}else{
					$curSql="";
					$rowStatus="sep";
				}
			}
		}

		return $sqlSet;

	}
	public function getTsvTable($phraseSet)
	{

		$sqlString="";
		$sqlString="language_code	type	module_name	specific_name	uri	text\n";

		for($i=0;$i<count($phraseSet);$i++) {

			$sqlRow="";

			$sqlRow.=("".$phraseSet[$i]['language_code']."\t");
			$sqlRow.=($phraseSet[$i]['type']."\t");
			$sqlRow.=("".$phraseSet[$i]['module_name']."\t");
			$sqlRow.=("".$phraseSet[$i]['specific_name']."\t");
			$sqlRow.=("".$phraseSet[$i]['uri']."\t");
			$sqlRow.=("".$phraseSet[$i]['text']."");

			$sqlString.=$sqlRow;
			if($i==(count($phraseSet)-1)){
				$sqlString.="\n";
			}else{
				$sqlString.="\n";
			}

		}

		return $sqlString;

	}

	public function getLangOptions($langList)
	{
		$langOptions=array();

		foreach ($langList as $row) {
			$langOptions[($row['language_code'])] = ($row['label']." (".$row['language_code'].")");
		}

		return $langOptions;

	}

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;

		$this->langId = (isset($data['langId'])) ? $data['langId'] : '';
		$this->langCode = (isset($data['langCode'])) ? $data['langCode'] : '';

		$this->moduleName = (isset($data['moduleName'])) ? $data['moduleName'] : '';
		$this->specificName = (isset($data['specificName'])) ? $data['specificName'] : '';

		$this->type = (isset($data['type'])) ? $data['type'] : 11;
		$this->uri = (isset($data['uri'])) ? $data['uri'] : '';
		$this->text = (isset($data['text'])) ? $data['text'] : '';
		$this->phraseSet = (isset($data['phraseSet'])) ? $data['phraseSet'] : null;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;

		$this->langId = (isset($data['language_code'])) ? $data['language_code'] : 0;
		$this->langCode = (isset($data['language_code'])) ? $data['language_code'] : '';

		$this->moduleName = (isset($data['module_name'])) ? $data['module_name'] : '';
		$this->specificName = (isset($data['specific_name'])) ? $data['specific_name'] : '';
		$this->type = (isset($data['type'])) ? $data['type'] : 11;
		$this->uri = (isset($data['uri'])) ? $data['uri'] : '';
		$this->text = (isset($data['text'])) ? $data['text'] : '';

	}

}
