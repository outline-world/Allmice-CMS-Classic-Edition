<?php
/*
 * Allmice(TM) PHP Framework
 * Version 1.5.10 (2019-06-15)
 * Copyright 2019 by Any Outline LTD
 * www.allmice.com/framework
 * Allmice PHP Framework code is released under the "New BSD License".
 * See README.TXT file in the "root" directory.

 * Extendable parent class SimpleForm

 * This is a simplified version of Form class, where among other things:
 * 1) Only methods, which are sure, that were recently used and are most often used, are included.
 * 2) Radio and checkbox form elements are at the moment not included: 
 *    these elements may be needed to return as array of tags not as a string and may need more complex tag structure to add better CSS.
 * 3) For other traditional form elements (input-text, password, select, textarea, etc.) label and div tags are not included.
 * 4) The method getLabel was added to return easy label value giving input as form element name.
 */

class SimpleForm
{

	public $formMap;
	public $isValid;
	public $errorMessages;

	public function add($elArr)
	{
//Usage often in Model component *Form classes
		if(isset($elArr['type']))
			$this->formMap[($elArr['name'])]['type']=$elArr['type'];
		if(isset($elArr['label']))
			$this->formMap[($elArr['name'])]['label']=$elArr['label'];
		if(isset($elArr['value']))
			$this->formMap[($elArr['name'])]['value']=$elArr['value'];
		if(isset($elArr['id']))
			$this->formMap[($elArr['name'])]['id']=$elArr['id'];
		if(isset($elArr['attributes']))
			$this->formMap[($elArr['name'])]['attributes']=$elArr['attributes'];
		if(isset($elArr['options']))
			$this->formMap[($elArr['name'])]['options']=$elArr['options'];
		if(isset($elArr['rules']))
			$this->formMap[($elArr['name'])]['rules']=$elArr['rules'];
		if(isset($elArr['required']))
			$this->formMap[($elArr['name'])]['required']=$elArr['required'];
		if(isset($elArr['guide']))
			$this->formMap[($elArr['name'])]['guide']=$elArr['guide'];
		if(isset($elArr['validation']))
			$this->formMap[($elArr['name'])]['validation']=$elArr['validation'];
	}

	public function specialCharsCode($input){
		//Using php htmlspecialchars() function has been very complicated in the Allmice CMS system.
		//It seems that wysiwyg editor makes replacements itself and htmlspecialchars does not check by default ' chars. 
		//Above events are causing also issues, that & as part of a replacement code will be replaced itself.
		//Thus custom function for such validating is needed to have more control about replacements in this system.
		//This function checks if <, >, ', " characters exist in the string.
		//Replacement for every such character will be made only in case, if such character does exist.
		//Ampersand (&) character will not be checked and will be ignored, because it may be part of a replacement
		// and haven't found any problem, when character & will not be replaced. 
		$output=$input;

		if(strstr($output,"'")){
			$output=str_replace("'", "&#39;", $output);
		}
		if(strstr($output,'"')){
			$output=str_replace('"', '&quot;', $output);
		}
		if(strstr($output,"<")){
			$output=str_replace("<", "&lt;", $output);
		}
		if(strstr($output,">")){
			$output=str_replace(">", "&gt;", $output);
		}

		return $output;

	}

	public function specialCharsDecode($input){

		$output=$input;
		if(strstr($output,"&gt;")){
			$output=str_replace("&gt;", ">", $output);
		}
		if(strstr($output,"&lt;")){
			$output=str_replace("&lt;", "<", $output);
		}
		if(strstr($output,'&quot;')){
			$output=str_replace('&quot;', '"', $output);
		}
		if(strstr($output,"&#39;")){
			$output=str_replace("&#39;", "'", $output);
		}
		if(strstr($output,"&#92;")){
			$output=str_replace("&#92;", "\\", $output);
		}

		return $output;
	}


	public function setUrl($curUrl)
	{
//Usage often in Controller component
		$this->formMap['begin']['value']=$curUrl;
	}

	public function setValue($elName, $elValue)
	{
		$this->formMap[$elName]['value']=$elValue;
	}

	public function getValue($elName)
	{
		return $this->formMap[$elName]['value'];
	}

	public function updateForm()
	{
//Usage often in Controller component

		$formKeys=array_keys($this->formMap);
		foreach($formKeys as $row){

			$elemPattern="#hidden#select#text#textarea#password#select_multiple#radio_button#checkbox#";

			if (isset($_POST[($row)]) && $_POST[$row]!="" && strstr($elemPattern ,("#".$this->formMap[($row)]['type']."#"))) {
				$fieldContent=$_POST[($row)];

//String values need html tag character replacements
				if(is_string($fieldContent)){
					$this->formMap[($row)]['value']=$this->specialCharsCode($fieldContent);
				}else{
					$this->formMap[($row)]['value']=$fieldContent;
				}
			}
			elseif (isset($_POST[($row)]) && $_POST[$row]!="" && $this->formMap[($row)]['type']=="checkbox") {
				$this->formMap[($row)]['attributes']=array(
					'checked' => "checked"
				);
			}
			else{

			}

		}

	}

	public function getData()
	{
//Usage often in Controller component
/*
The method getData() helps to code data got from form fields, 
   appropriately before recording into database.
It is suggested to use this method every time to get data from forms
   and to prepare it to record into database. 

This method codes string data pulled from form elements in the following way:
   1) Single quotes ' will be replaced with ascii code 39
   2) Backslashes \ will be replaced with ascii code 92
   3) Characters <, >, " will be replaced in the same way as htmlspecialchars is replacing them
//   3) For rest of the code php function htmlspecialchars will be used
*/

		$formKeys=array_keys($this->formMap);
		foreach($formKeys as $row){

			$elemPattern="#hidden#select#text#textarea#password#checkbox#select_multiple#radio_button#checkbox#";

			if (isset($_POST[($row)]) && $_POST[$row]!="" && strstr($elemPattern ,("#".$this->formMap[($row)]['type']."#"))) {

				if(is_string($_POST[($row)])){
					$formData[($row)]=$_POST[($row)];
					$formData[($row)]=str_replace("\\","&#92;",$formData[($row)]);
					$formData[($row)]=$this->specialCharsCode($formData[($row)]);
				}else{
					$formData[($row)]=$_POST[($row)];
				}

			}
			else{
				$formData[($row)]="";
			}

		}

		return $formData;
	}

	public function get($elName)
	{
//Usage often in View component
		$tagString="";
		$tagString.="\n";
		$curElem=$this->formMap[$elName];

		switch($curElem['type']){
			case 'begin':
				$tagString.="<form";
				$tagString.=" action=\"".$curElem['value']."\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=">";
			break;
			case 'end':
				$tagString.="</form>";
			break;
			case 'hidden':
				$tagString.="<input name=\"".$elName."\"";
				if(isset($curElem['type']))
					$tagString.=" type=\"".$curElem['type']."\"";
				if(isset($curElem['value']))
					$tagString.=" value=\"".$curElem['value']."\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=">";
			break;
			case 'text':
				$tagString.="<input name=\"".$elName."\"";
				$tagString.=" type=\"".$curElem['type']."\"";
				if(isset($curElem['value']))
					$tagString.=" value=\"".$curElem['value']."\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=">";
			break;
			case 'textarea':
				$tagString.="<textarea name=\"".$elName."\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=">";
				if(isset($curElem['value']))
					$tagString.=$curElem['value'];
				$tagString.="</textarea>";
			break;
			case 'password':
				$tagString.="<input name=\"".$elName."\"";
				$tagString.=" type=\"".$curElem['type']."\"";
				$tagString.=" value=\"".$curElem['value']."\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=">";
			break;
			case 'file':
				$tagString.="<input name=\"".$elName."\"";
				$tagString.=" type=\"hidden\" name=\"MAX_FILE_SIZE\"";
				$tagString.=" value=\"".$curElem['value']."\"";
				$tagString.=">";

				$tagString.="<input name=\"".$elName."\"";
				$tagString.=" type=\"".$curElem['type']."\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=">";
				$tagString.="\n";
			break;
			case 'submit':
				$tagString.="<input name=\"".$elName."\"";
				$tagString.=" type=\"".$curElem['type']."\"";
				$tagString.=" value=\"".$curElem['value']."\"";
				if(isset($curElem['attributes'])){
				$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=">";
			break;
			case 'select':
				$tagString.="<select name=\"".$elName."\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=">";

				$optKeys=array_keys($curElem['options']);

				foreach($optKeys as $row){
					$tagString.="<option value=\"".$row."\"";
					if($row==$curElem['value'])
						$tagString.=" selected=\"selected\"";
					$tagString.=">".$curElem['options'][$row]."</option>";
					$tagString.="\n";
				}

				$tagString.="</select>";

			break;
			case 'select_multiple':
				$tagString.="<select name=\"".$elName."[]\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=" multiple=\"multiple\">";
				$optKeys=array_keys($curElem['options']);
				foreach($optKeys as $row){
					$tagString.="<option value=\"".$row."\"";
					if(is_array($curElem['value']) && in_array($row,$curElem['value']))
						$tagString.=" selected=\"selected\"";
					$tagString.=">".$curElem['options'][$row]."</option>";
				}
				$tagString.="</select>";
			break;

			default:
			break;
		}

		return $tagString;

	}

	public function getGuide($elName)
	{
//Usage often in View component
		$tagString="";
		$curElem=$this->formMap[$elName];

		if(isset($curElem['guide']) && $curElem['guide']!=""){
			$tagString.=$curElem['guide'];
			$tagString.="\n";
		}
		return $tagString;
	}

	public function getLabel($elName)
	{
//Usage often in View component
		$tagString="";
		$curElem=$this->formMap[$elName];
		if(isset($curElem['label']) && $curElem['label']!=""){
			$tagString.=$curElem['label'];
		}
		return $tagString;
	}

   public function setLanguage($langData)
   {

		foreach ($langData as $langItem) {

			$tempArr=explode("/",$langItem['uri']);
			if($tempArr[0]=="label"){
				$this->formMap[($tempArr[1])]['label']=$langItem['text'];
			}
			elseif($tempArr[0]=="value"){
				$this->formMap[($tempArr[1])]['value']=$langItem['text'];
			}
			elseif($tempArr[0]=="guide"){
				$this->formMap[($tempArr[1])]['guide']=$langItem['text'];
			}
		}

	}

	public function setErrorMessages()
	{
		$GLOBALS['messageList']=array();
		$classStart[]="messageClassStart-red";
		$classEnd[]="messageClassEnd";
		$GLOBALS['messageList']=array_merge($classStart,$this->errorMessages,$classEnd);
	}

	public function validation($patternSet,$langSetInit)
	{

		$langSet=array();
		foreach($langSetInit as $row){
			if (strstr($row['uri'],"formError")) {
				$langSet[($row['uri'])]=$row['text'];
			}
		}

		$formKeys=array_keys($this->formMap);
		$this->isValid=TRUE;

		$elemPattern="#text#textarea#password#";
		foreach($formKeys as $elName){
			if (isset($_POST[($elName)]) && $_POST[$elName]!="" && strstr($elemPattern ,("#".$this->formMap[($elName)]['type']."#"))) {
				if ( isset($this->formMap[($elName)]['validation']) && isset($patternSet[($this->formMap[($elName)]['validation'])]) ){
					$patternRaw=$patternSet[($this->formMap[($elName)]['validation'])];

					$pattern=(string)$patternRaw;
					$input=$_POST[($elName)];


					if (!preg_match($pattern,$input)){
						$this->isValid=FALSE;
						if(!isset($langSet['formErrorGeneral']))
							$langSet['formErrorGeneral']="* Field '[elLabel]' is invalid!";
						$this->errorMessages[]=str_replace("[elLabel]",$this->formMap[($elName)]['label'],$langSet['formErrorGeneral']);
					}
					if (strstr($elName,"Date") && $this->isValid) {
						$dateFormat=$_SESSION['dateFormat'];
						$d = DateTime::createFromFormat($dateFormat, $_POST[$elName]);

						if($d && $d->format($format) == $date){
						}
						else{
								$this->isValid=FALSE;
								if(!isset($langSet['formErrorDate']))
									$langSet['formErrorDate']="* Date field '[elLabel]' is invalid!";
								$this->errorMessages[]=str_replace("[elLabel]",$this->formMap[($elName)]['label'],$langSet['formErrorDate']);
						}

					}

				}

			}
			if (isset($_POST[($elName)]) && $_POST[$elName]=="" && strstr($elemPattern ,("#".$this->formMap[($elName)]['type']."#")) && $this->formMap[($elName)]['required']) {
				$this->isValid=FALSE;
				if(!isset($langSet['formErrorEmpty'])){
					$langSet['formErrorEmpty']="* Form field '[elLabel]' can not be empty!";
				}
				$this->errorMessages[]=str_replace("[elLabel]",$this->formMap[($elName)]['label'],$langSet['formErrorEmpty']);
			}
		}

	}

}
