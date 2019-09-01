<?php

class Language 
{
	public $id;
	public $languageCode;
	public $languageCode2;

	public $label;
	public $status;
	public $direction;

	public $dateFormat;
	public $timeFormat;
	public $numberFormat;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->languageCode = (isset($data['languageCode'])) ? $data['languageCode'] : "";
		$this->languageCode2 = (isset($data['languageCode2'])) ? $data['languageCode2'] : "";

		$this->label = (isset($data['label'])) ? $data['label'] : "";
		$this->status = (isset($data['status'])) ? $data['status'] : 0;
		$this->direction = (isset($data['direction'])) ? $data['direction'] : "";

		$this->dateFormat = (isset($data['dateFormat'])) ? $data['dateFormat'] : "";
		$this->timeFormat = (isset($data['timeFormat'])) ? $data['timeFormat'] : "";
		$this->numberFormat = (isset($data['numberFormat'])) ? $data['numberFormat'] : "";

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->languageCode = (isset($data['language_code'])) ? $data['language_code'] : "";
		$this->languageCode2 = (isset($data['language_code2'])) ? $data['language_code2'] : "";

		$this->label = (isset($data['label'])) ? $data['label'] : "";
		$this->status = (isset($data['status'])) ? $data['status'] : 0;
		$this->direction = (isset($data['direction'])) ? $data['direction'] : "";

		$this->dateFormat = (isset($data['date_format'])) ? $data['date_format'] : "";
		$this->timeFormat = (isset($data['time_format'])) ? $data['time_format'] : "";
		$this->numberFormat = (isset($data['number_format'])) ? $data['number_format'] : "";
	}

	public function getSqlSet($installPath,$sqlFile,$installData)
	{

		$sqlSet=array();
		$inputPath=$installPath."/".$sqlFile;

		$fp=fopen($inputPath,'r');
		$sqlFile = fread($fp, filesize($inputPath));
		fclose($fp);

		$tempArr=explode("\n",$sqlFile);

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

}
