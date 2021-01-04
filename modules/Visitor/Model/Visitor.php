<?php

class Visitor
{

	public $id;
	public $ip;
	public $agentData;
	public $status;
	public $sessId;

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

	public function getClientIpEnv() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	        $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;
	}

	// Function to get the client ip address
	public function getClientIpServer() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;
	}

	public function convertFormData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->ip = (isset($data['ip'])) ? $data['ip'] : '';
		$this->agentData = (isset($data['agentData'])) ? $data['agentData'] : '';
		$this->status = (isset($data['status'])) ? $data['status'] : 0;
		$this->sessId = (isset($data['sessId'])) ? $data['sessId'] : '';
	}

	public function convertDbData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->ip = (isset($data['ip'])) ? $data['ip'] : '';
		$this->agentData = (isset($data['device_data'])) ? $data['device_data'] : '';
		$this->status = (isset($data['status'])) ? $data['status'] : 0;
		$this->sessId = (isset($data['sess_id'])) ? $data['sess_id'] : '';
	}
}
