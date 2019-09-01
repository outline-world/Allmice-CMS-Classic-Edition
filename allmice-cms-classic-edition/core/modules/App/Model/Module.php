<?php

class Module
{

	public $id;
	public $className;
	public $path;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->className = (isset($data['className'])) ? $data['className'] : null;
		$this->type = (isset($data['type'])) ? $data['type'] : null;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->className = (isset($data['module_name'])) ? $data['module_name'] : null;
		$this->type = (isset($data['type'])) ? $data['type'] : null;

	}

	public function getEventSet($modData)
	{

//==========
// ==> Finding event names and paths - start

			if($modData['path']!=""){

				$inputPath=("modules/".$modData['name']."/Controller/".$modData['name']."Controller.php");

				$fp=fopen($inputPath,'r');
				$contents = fread($fp, filesize($inputPath));
				fclose($fp);

/*
1. Delete comment regions
2. Delete comment lines
3. Choose lines, which include strings "public function" and "Event"
*/

//==> Remove php comments - start
				$tempArr=explode("/*",$contents);
				$newData=$tempArr[0];

				for($j=1;$j<count($tempArr);$j++){
					$tempArr2=explode("*/",$tempArr[$j]);

					if(count($tempArr2)>1){
						$newData.=$tempArr2[1];
					}else{
					}
				}

				$tempArr=explode("\n",$newData);

				for($j=0;$j<count($tempArr);$j++){
					$tempArr2=explode("//",$tempArr[$j]);
					$newLines[]=$tempArr2[0];
				}

// ==> Remove php comments - end

				for($j=0;$j<count($newLines);$j++){

// Loop of all code lines without comments
					if(strstr($newLines[$j],"public function") && strstr($newLines[$j],"Event") && !strstr($newLines[$j],"strstr")){

// If the line is Event function line

// Get event name from function line
						$tempArr=explode("Event",$newLines[$j]);
						$tempArr2=explode(" ",$tempArr[0]);
						$end = array_pop($tempArr2); // removes the last element, and returns it

// Get event path from event name
						$parts = preg_split("/(?=[A-Z])/", $end);
						$path=$parts[0];
						for($k=1;$k<count($parts);$k++){
							$path.=("-".lcfirst($parts[$k]));
						}

// Record event results
						$eventData['name']=$end;
						$eventData['path']=$path;
						$eventSet[]=$eventData;

					}
// end of event loop

				}
//				$newI++;
// end of path if
			}

// end of module loop
//		}

// ==> Finding module and event names and paths - end
//==========
		return $eventSet;

	}

	function getWords( $camelCase ) {
		$output = "";

		foreach( str_split( $camelCase ) as $char ) {
			strtoupper( $char ) == $char and $output and $output .= " ";
			$output .= $char;
		}
		return $output;
	}

	public function getModPath($words)
	{

		$tempArr=explode(" ", $words);

		$path="";
		$path=lcfirst($tempArr[0]);
		for($i=1;$i<count($tempArr);$i++){
			$path.=("-".lcfirst($tempArr[$i]));
		}

		return $path;

	}

	public function getPath($words)
	{
		$tempArr=explode(" ", $words);

		$path="";
		$path=lcfirst($tempArr[0]);
		for($i=1;$i<count($tempArr);$i++){
			$path.=("-".lcfirst($tempArr[$i]));
		}

		return $path;

	}

	public function checkModValidity($modInstall)
	{

		$modIsValid=false;
		if(isset($modInstall['title'])
			 && isset($modInstall['description'])
			 && isset($modInstall['path'])
//			 && isset($modInstall['configPath'])
			 && isset($modInstall['version'])
			 && isset($modInstall['time'])
			 && isset($modInstall['developer'])){

			$modIsValid=true;

			$pattern="/^[a-zA-Z0-9 ]{0,30}$/";
			if (!preg_match($pattern,$modInstall['title'])){
				$modIsValid=false;
			}
			$pattern="/^[a-zA-Z0-9 .,;:&#*\(\)\-_\/']{0,500}$/";
			if (!preg_match($pattern,$modInstall['description'])){
				$modIsValid=false;
			}
			$pattern="/^[a-z-]{0,30}$/";
			if (!preg_match($pattern,$modInstall['path'])){
				$modIsValid=false;
			}
//			$pattern="/^[a-zA-Z0-9.\/_-]{0,60}$/";
//			if (!preg_match($pattern,$modInstall['configPath'])){
//				$modIsValid=false;
//			}
			$pattern="/^[0-9.]{0,30}$/";
			if (!preg_match($pattern,$modInstall['version'])){
				$modIsValid=false;
			}
			$pattern="/^[A-Z0-9:\/\+\- ]{0,30}$/";
			if (!preg_match($pattern,$modInstall['time'])){
				$modIsValid=false;
			}
			$pattern="/^[a-zA-Z0-9 .,;:&#*\(\)\-_\/']{0,250}$/";
			if (!preg_match($pattern,$modInstall['developer'])){
				$modIsValid=false;
			}

		}

		return $modIsValid;

	}

	public function getModuleSet($dbModules)
	{

		$modSet=array();
		$installedModules=array();
		$uninstalledModules=array();
		$modList=array();
		$modCbArray=array();

		$passiveList=array();

		foreach($dbModules as $content)
		{
			$installedModules[]=$content['module_name'];
		}
		$dir = "modules/";
		$contentList = scandir($dir);

		foreach($contentList as $content){
			if(!strstr($content,".")){
				$modList[]['name']=$content;
				if(!in_array($content,$installedModules)){

					$modData['name']=$content;

					$installPath="modules/".$modData['name']."/config/Install";
					$installConfig=$installPath."/install-config.php";

					$modInstall=array();
					if(file_exists($installConfig))
						include $installConfig;

					$modIsValid=$this->checkModValidity($modInstall);					

					if($modIsValid){

						$modData['title']=$modInstall['title'];
						$modData['description']=$modInstall['description'];
						$modData['path']=$this->getModPath($modData['title']);
						$modData['configPath']="modules/".$modData['name']."/config-".$modData['path'].".php";
						$modData['codePath']="";
						$modData['type']=22;
						$modData['developer']=$modInstall['developer'];

						if(isset($modInstall['version']))
							$modData['version']=$modInstall['version'];
						else
							$modData['version']="";

						$format=$this->getTimeFormat($modInstall['time']);

						$dateobj = DateTime::createFromFormat($format, $modInstall['time']);

						if ($dateobj !== false) {

						   //valid time
							$modData['time']=$dateobj->getTimestamp();

							$eventSet=$this->getEventSet($modData);
							$modData['eventSet']=$eventSet;
							$uninstalledModules[]=$modData;
							$modSet[]=$modData;
						}
						else{
						   //invalid time
						}
					}
				}
			}
		}

		for($i=0;$i<count($modSet);$i++){
			$modCbArray[$i]['id']=$i;
			$modCbArray[$i]['status']="";
		}

		$modData['modList']=$modSet;
		$modData['passiveList']=$installedModules;
		$modData['modCbArray']=$modCbArray;

		return $modData;

	}

	public function getTimeFormat($timeString)
	{

		if(strstr($timeString,"/"))
			$format = "d/m/Y H:i";
		elseif(strstr($timeString,"T")){
			$timeString=strtotime($timeString);
			$format = "Y-m-d\TH:i:sP";
		}
		else
			$format = "Y-m-d H:i:s";

		return $format;

	}

}
