<?php

class Application
{

	public $id;
	public $className;
	public $path;
	public $salt;

	public function setSiteConfigData($installData,$installPath)
	{

		$tempArr=explode("://",$GLOBALS['baseUrl']);
		$sitePath=str_replace("/","_",$tempArr[1]);

		$inputPath=$installPath."/config.php";
		$fp=fopen($inputPath,'r');
		$configModel = fread($fp, filesize($inputPath));
		fclose($fp);

		$outputPath=("sites/".$sitePath);
		$pDir=$outputPath;
		if(!file_exists ( $pDir )){
			mkdir($pDir, 0777);
		}

		$configContent="testContent";

		$configContent=str_replace("[siteName]",$installData['siteName'],$configModel);
		$configContent=str_replace("[dbName]",$installData['dbName'],$configContent);
		$configContent=str_replace("[dbUserName]",$installData['dbUserName'],$configContent);
		$configContent=str_replace("[dbUserPassword]",$installData['dbUserPassword'],$configContent);
		$configContent=str_replace("[dbHost]",$installData['dbHost'],$configContent);
		$configContent=str_replace("[tablePrefix]",$installData['tablePrefix'],$configContent);

		$configContent=str_replace("[siteSalt]",$this->salt,$configContent);

		$outputPath=$outputPath."/"."config.php";

		$fp=fopen($outputPath,'w');
		fwrite($fp, $configContent);
		fclose($fp);

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

					$queryStart="CREATE TABLE `";
					$needle=$queryStart.$installData['needle'];
					$needle2=$queryStart.$installData['needle2'];
					$curSql=str_replace($needle,($queryStart.$installData['tablePrefix'].$installData['needle']),$curSql);
					$curSql=str_replace($needle2,($queryStart.$installData['tablePrefix'].$installData['needle2']),$curSql);

					$queryStart="INSERT INTO `";
					$needle=$queryStart.$installData['needle'];
					$needle2=$queryStart.$installData['needle2'];
					$curSql=str_replace($needle,($queryStart.$installData['tablePrefix'].$installData['needle']),$curSql);
					$curSql=str_replace($needle2,($queryStart.$installData['tablePrefix'].$installData['needle2']),$curSql);

					$queryStart="ALTER TABLE `";
					$needle=$queryStart.$installData['needle'];
					$needle2=$queryStart.$installData['needle2'];
					$curSql=str_replace($needle,($queryStart.$installData['tablePrefix'].$installData['needle']),$curSql);
					$curSql=str_replace($needle2,($queryStart.$installData['tablePrefix'].$installData['needle2']),$curSql);

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

	function generateRandomString($length = 16) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

}
