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
		$eventSet=array();
		if($modData['path']!=""){

			if($modData['codePath']=="")
				$inputPath=("modules/".$modData['name']."/Controller/".$modData['name']."Controller.php");
			else
				$inputPath=($modData['codePath'].$modData['name']."/Controller/".$modData['name']."Controller.php");
				
			if(file_exists($inputPath)){
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

// Get event name from function line
						$tempArr=explode("Event",$newLines[$j]);
						$tempArr2=explode(" ",$tempArr[0]);
// Removes the last element, and returns it:
						$end = array_pop($tempArr2);

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
			}

// end of path if
		}

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

						if(isset($modInstall['requiredModules']))						
							$modData['requiredModules']=$modInstall['requiredModules'];
						else
							$modData['requiredModules']="";

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

		$modSet=$this->addCustomModules($modSet,$installedModules);

		for($i=0;$i<count($modSet);$i++){
			$modCbArray[$i]['id']=$i;
			$modCbArray[$i]['status']="";
		}

		$modData['modList']=$modSet;
		$modData['passiveList']=$installedModules;
		$modData['modCbArray']=$modCbArray;

		return $modData;

	}

	public function addCustomModules($modSet,$installedModules)
	{

		$dir = "custom/modules/";
		$contentList = scandir($dir);

		foreach($contentList as $content){
			if(!strstr($content,".")){
				if(!in_array($content,$installedModules)){

					$modData['name']=$content;

					$installPath="custom/modules/".$modData['name']."/config/Install";
					$installConfig=$installPath."/install-config.php";

					$modInstall=array();
					if(file_exists($installConfig))
						include $installConfig;

					$modIsValid=$this->checkModValidity($modInstall);					

					if($modIsValid){

						$modData['title']=$modInstall['title'];
						$modData['description']=$modInstall['description'];
						$modData['path']=$this->getModPath($modData['title']);
						$modData['configPath']="custom/modules/".$modData['name']."/config-".$modData['path'].".php";
						$modData['codePath']="custom/modules/";
						$modData['type']=22;
						$modData['developer']=$modInstall['developer'];

						if(isset($modInstall['requiredModules']))						
							$modData['requiredModules']=$modInstall['requiredModules'];
						else
							$modData['requiredModules']="";

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
		return $modSet;

	}

	public function setInstallStatus($modList,$dbModules)
	{
//For install & uninstall events

		for($i=0;$i<count($dbModules);$i++){
			$installedMod[]=$dbModules[$i]['module_name'];
		}

		for($i=0;$i<count($modList);$i++){

			$modList[$i]['status']="active";

			if($modList[$i]['requiredModules']!=""){

				$tempArr=explode(", ", $modList[$i]['requiredModules']);
				for($j=0;$j<count($tempArr);$j++){
					if(!in_array($tempArr[$j],$installedMod))
						$modList[$i]['status']="passive";
				}

			}

		}

		return $modList;

	}

	public function setUninstallStatus($dbModules)
	{
		$requiredList=array();
		$dependingList=array();

		for($i=0;$i<count($dbModules);$i++){

			if($dbModules[$i]['requiredModules']!=""){
				$depModString=trim($dbModules[$i]['requiredModules'], '#');				
				$dbModules[$i]['requiredModules']=str_replace("#", ", ", $depModString);

				$tempArr=explode("#", $depModString);
				for($j=0;$j<count($tempArr);$j++){
					if(!in_array($tempArr[$j],$dependingList))
						$dependingList[]=$tempArr[$j];
					$requiredList[($tempArr[$j])][]=$dbModules[$i]['module_name'];
				}
			}
		}

		for($i=0;$i<count($dbModules);$i++){
			$dbModules[$i]['status']="active";
			$dependingModules="";

			if(isset($requiredList[($dbModules[$i]['module_name'])])){
				$requiredData=$requiredList[($dbModules[$i]['module_name'])];

				for($j=0;$j<count($requiredData);$j++){
					if($j>0)
						$dependingModules.=", ";
					$dependingModules.=$requiredData[$j];
				}
			}
			$dbModules[$i]['dependingModules']=$dependingModules;

			if(in_array($dbModules[$i]['module_name'],$dependingList))
				$dbModules[$i]['status']="passive";

		}

		return $dbModules;

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

	public function getTableScript()
	{

		$script="";

$script=<<<EOT
    <script type="text/javascript">
        $(document).ready(function() {
            $('td:nth-child(3),th:nth-child(3)').hide();
            $('td:nth-child(4),th:nth-child(4)').hide();
            $('td:nth-child(5),th:nth-child(5)').hide();
            $('td:nth-child(6),th:nth-child(6)').hide();
            $('#btnHide').hide();
//            $('td:nth-child(2),th:nth-child(2)').show();
            $('#btnHide').click(function() {
                //$('td:nth-child(2)').hide();
                // if your table has header(th), use this
	            $('td:nth-child(3),th:nth-child(3)').hide();
	            $('td:nth-child(4),th:nth-child(4)').hide();
	            $('td:nth-child(5),th:nth-child(5)').hide();
	            $('td:nth-child(6),th:nth-child(6)').hide();
	            $('#btnShow').show();
	            $('#btnHide').hide();
//                $('td:nth-child(2),th:nth-child(2)').hide();
            });
            $('#btnShow').click(function() {
                //$('td:nth-child(2)').show();
                // if your table has header(th), use this
                $('td:nth-child(3),th:nth-child(3)').show();
                $('td:nth-child(4),th:nth-child(4)').show();
                $('td:nth-child(5),th:nth-child(5)').show();
                $('td:nth-child(6),th:nth-child(6)').show();
	            $('#btnShow').hide();
	            $('#btnHide').show();
            });
        });
    </script>
EOT;
		return $script;

	}

	public function getHelpScript()
	{

		$script="";

$script=<<<EOT
<script type="text/javascript">
$(document).ready(function(){
	$("#showHelp").show();
	$("#hideHelp").hide();
	$("#helpArea").hide();
	$('#showHelp').click(function(){
		$("#helpArea").show();
		$("#showHelp").hide();
		$("#hideHelp").show();
	});
	$('#hideHelp').click(function(){
		$("#helpArea").hide();
		$("#showHelp").show();
		$("#hideHelp").hide();
	});
});
</script>
EOT;

		return $script;

	}

}
