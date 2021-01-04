<?php

class Theme
{

	public $id;
	public $themeId;
	public $roleId;
	public $className;
	public $path;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;

		$this->className = (isset($data['className'])) ? $data['className'] : "";
		$this->type = (isset($data['type'])) ? $data['type'] : "";
		$this->roleId = (isset($data['roleId'])) ? $data['roleId'] : 0;
		$this->themeId = (isset($data['themeId'])) ? $data['themeId'] : 0;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->className = (isset($data['module_name'])) ? $data['module_name'] : null;
		$this->type = (isset($data['type'])) ? $data['type'] : null;
		$this->roleId = (isset($data['role_id'])) ? $data['role_id'] : null;
		$this->themeId = (isset($data['id'])) ? $data['id'] : null;

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

	public function checkThemeValidity($themeInstall)
	{

		$themeIsValid=false;
		if(isset($themeInstall['name'])
			 && isset($themeInstall['title'])
			 && isset($themeInstall['description'])
			 && isset($themeInstall['version'])
			 && isset($themeInstall['time'])
			 && isset($themeInstall['developer'])){

			$themeIsValid=true;
		 }

		$pattern="/^[a-zA-Z0-9 ]{0,30}$/";
		if (!preg_match($pattern,$themeInstall['name'])){
			$themeIsValid=false;
		}
		$pattern="/^[a-zA-Z0-9 ]{0,30}$/";
		if (!preg_match($pattern,$themeInstall['title'])){
			$themeIsValid=false;
		}
		$pattern="/^(.){0,500}$/";
		if (!preg_match($pattern,$themeInstall['description'])){
			$themeIsValid=false;
		}

		$pattern="/^[0-9.]{0,30}$/";
		if (!preg_match($pattern,$themeInstall['version'])){
			$themeIsValid=false;
		}
		$pattern="/^[A-Z0-9:\/\+\- ]{0,30}$/";
		if (!preg_match($pattern,$themeInstall['time'])){
			$modIsValid=false;
		}
		$pattern="/^(.){0,250}$/";
		if (!preg_match($pattern,$themeInstall['developer'])){
			$themeIsValid=false;
		}

		return $themeIsValid;

	}

	public function getThemeSet($dbThemes)
	{

		$themeCbArray=array();
		$themeSet=array();

		$installedThemes[]=array();
		foreach($dbThemes as $content)
		{
			$installedThemes[]=$content['name'];
		}
		$dir = "themes/";
		$contentList = scandir($dir);

		foreach($contentList as $content){
			if(!strstr($content,".")){
				$themeList[]['name']=$content;
				if(!in_array($content,$installedThemes)){

					$themeData['name']=$content;
					$installPath="themes/".$themeData['name']."/config/Install";
					$installConfig=$installPath."/install-config.php";

					$themeInstall=array();
					if(file_exists($installConfig))
						include $installConfig;

					$themeIsValid=$this->checkThemeValidity($themeInstall);					

					if($themeIsValid){

						$themeData['title']=$themeInstall['title'];
						$themeData['description']=$themeInstall['description'];
						$themeData['codePath']="";
						$themeData['type']=22;
						$themeData['developer']=$themeInstall['developer'];

						if(isset($themeInstall['version']))
							$themeData['version']=$themeInstall['version'];
						else
							$themeData['version']="";

						$format=$this->getTimeFormat($themeInstall['time']);

						$dateobj = DateTime::createFromFormat($format, $themeInstall['time']);
						if ($dateobj !== false) {

							$themeData['time']=$dateobj->getTimestamp();
							$themeSet[]=$themeData;

						}
						else{

						}
					}
				}
			}
		}

		$themeSet=$this->addCustomThemes($themeSet,$installedThemes);

		for($i=0;$i<count($themeSet);$i++){
			$themeCbArray[$i]['id']=$i;
			$themeCbArray[$i]['status']="";
		}
		$themeData['themeList']=$themeSet;
		$themeData['passiveList']=$installedThemes;
		$themeData['themeCbArray']=$themeCbArray;

		return $themeData;

	}

	public function addCustomThemes($themeSet,$installedThemes)
	{

		$dir = "custom/themes/";
		$contentList = scandir($dir);

		foreach($contentList as $content){
			if(!strstr($content,".")){
				$themeList[]['name']=$content;

				if(!in_array($content,$installedThemes)){

					$themeData['name']=$content;
					$installPath="custom/themes/".$themeData['name']."/config/Install";
					$installConfig=$installPath."/install-config.php";

					$themeInstall=array();
					if(file_exists($installConfig))
						include $installConfig;

					$themeIsValid=$this->checkThemeValidity($themeInstall);					

					if($themeIsValid){

						$themeData['title']=$themeInstall['title'];
						$themeData['description']=$themeInstall['description'];
						$themeData['codePath']="custom/themes/";
						$themeData['type']=22;
						$themeData['developer']=$themeInstall['developer'];

						if(isset($themeInstall['version']))
							$themeData['version']=$themeInstall['version'];
						else
							$themeData['version']="";

						$format=$this->getTimeFormat($themeInstall['time']);

						$dateobj = DateTime::createFromFormat($format, $themeInstall['time']);

						if ($dateobj !== false) {

							$themeData['time']=$dateobj->getTimestamp();
							$themeSet[]=$themeData;

						}
						else{

						}
					}
				}
			}
		}
		return $themeSet;
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
