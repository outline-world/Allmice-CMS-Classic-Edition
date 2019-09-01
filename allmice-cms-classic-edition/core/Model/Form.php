<?php
/*
 * Allmice(TM) PHP Framework
 * Version 1.5.4 (2019-05-06)
 * Copyright 2016 - 2019 by Any Outline LTD
 * www.allmice.com/framework
 * Allmice PHP Framework code is released under the "New BSD License".
 * See README.TXT file in the "root" directory.

 * Extendable parent class Form

 */

class Form
{

	public $formMap;
	public $genTextRules;
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

	public function setFormUrl($curUrl,$formName)
	{
		$this->formMap[($formName)]['value']=$curUrl;
	}

	public function setValue($elName, $elValue)
	{
		$this->formMap[$elName]['value']=$elValue;
	}

	public function getValue($elName)
	{
		return $this->formMap[$elName]['value'];
	}

	public function checkValidity()
	{

//Usage in Controller component

//More flexible alternative to this is
//	method validation($patternSet,$langSet)
// where regular expression patterns and error note phrases are as input to the method and easier to change.
// E.g. in case of many modules of Allmice CMS regular expression patterns can be saved in database core_config table
//   error phrases can be used as multilingual phrases and all this can be changed through Browser UI.

//Although current method is considered obsolete and deprecated, it will still be available for long time,
//   because many older module code of Allmice CMS Classic Edition is using this older validation approach.
//It would be a lot of work and waste of resources to change it.
  
/*
The method getData() does already most important validation in replacement way as follows: 
   1) Single quotes ' will be replaced with ascii code 39
   2) Backslashes \ will be replaced with ascii code 92
   3) For rest of the code php function htmlspecialchars will be used

This method can be used to determine length of string input and to determine allowed characters.
*/

		$formKeys=array_keys($this->formMap);
		$this->isValid=TRUE;

		$elemPattern="#text#textarea#password#";
		foreach($formKeys as $row){

			if (isset($_POST[($row)]) && $_POST[$row]!="" && strstr($elemPattern ,("#".$this->formMap[($row)]['type']."#"))) {

/*
Validity checking types can be initialized in a module's form class by defining form elements. 
In such form class the definition has for example syntax:
        $this->add(array(
				'name' => 'title',
				'type'  => 'text',
[...]
				'rules' => array(
					'min' => 1,
					'max' => 60,
					'type' => 'lengthOnly',
				),
        ));
The member 'rules'=>'type' of a form element's definition array has in current class and method following form
   ($this->formMap[($row)]['rules']['type']) 
	Let's call such types (regular expression) validity checking types.
Validity checking types are explained as follows:
	['type']=="custom": here you can define your own pattern for the regular expression 
	   and length as minimum and maximum numbers of characters must also be initialized.
	['type']=="pattern": the whole pattern for the regular expression will be written in module's form class
	['type']=="lengthOnly": here only the length as minimum and maximum characters must be initialized and used.
	['type']=="customOnly": here you can define your own pattern for the regular expression - nothing else is needed.
	['type']=="int": here only numbers and character - is allowed on string input fields.
	   and length as minimum and maximum numbers of characters must also be initialized.
	['type']=="string": English alphabet letters, numbers and some other characters are allowed
	   and length as minimum and maximum numbers of characters must also be initialized.
	['type']=="eMail": English alphabet letters, numbers and some other characters are allowed as e-mail characters
	   and length as minimum and maximum numbers of characters must also be initialized,
	   structure of the eMail string is not determined.
*/
			if (isset($this->formMap[($row)]['rules']['type'])){

				$pattern="/^(.)$/";

				if ($this->formMap[($row)]['rules']['type']=="custom"){
					$pattern="/^".$this->formMap[($row)]['rules']['pattern']."{".$this->formMap[($row)]['rules']['min'].",".$this->formMap[($row)]['rules']['max']."}$/";
				}
				elseif ($this->formMap[($row)]['rules']['type']=="pattern")
					$pattern=$this->formMap[($row)]['rules']['pattern'];
				elseif ($this->formMap[($row)]['rules']['type']=="lengthOnly")
//Checked and works
					$pattern="/^(.){".$this->formMap[($row)]['rules']['min'].",".$this->formMap[($row)]['rules']['max']."}$/";
				elseif ($this->formMap[($row)]['rules']['type']=="customOnly")
//Not checked, may not work
					$pattern="/^".$this->formMap[($row)]['rules']['pattern']."$/";
				elseif ($this->formMap[($row)]['rules']['type']=="int")
					$pattern="/^[0-9\-]{".$this->formMap[($row)]['rules']['min'].",".$this->formMap[($row)]['rules']['max']."}$/";
				elseif ($this->formMap[($row)]['rules']['type']=="string")
					$pattern="/^[a-zA-Z0-9 \.,;:\&#*\-_]{".$this->formMap[($row)]['rules']['min'].",".$this->formMap[($row)]['rules']['max']."}$/";
				elseif ($this->formMap[($row)]['rules']['type']=="eMail")
//					$pattern="/^[a-zA-Z0-9 \.,;:\&#*\-_]{".$this->formMap[($row)]['rules']['min'].",".$this->formMap[($row)]['rules']['max']."}$/";
//					$pattern="/^(.+@.+..+){".$this->formMap[($row)]['rules']['min'].",".$this->formMap[($row)]['rules']['max']."}$/";
//					$pattern="/^[a-zA-Z0-9\.\-_@]{".$this->formMap[($row)]['rules']['min'].",".$this->formMap[($row)]['rules']['max']."}$/";
					$pattern="/^(.+@.+..+)$/";

					$input=$_POST[($row)];

					if (!preg_match($pattern,$input)){
						$this->isValid=FALSE;
						$this->errorMessages[]="* Field '".$this->formMap[($row)]['label']."' is invalid!";
					}
					else{
					}
					if (strstr($row,"Date") && $this->isValid) {
						$dateFormat=$_SESSION['dateFormat'];
						$d = DateTime::createFromFormat($dateFormat, $_POST[$row]);

					    if($d && $d->format($format) == $date){
					    }
							else{
								$this->isValid=FALSE;
								$this->errorMessages[]="* Date field '".$this->formMap[($row)]['label']."' is invalid!";
					    }

					}

					if ($this->formMap[($row)]['rules']['type']=="openString"){
					}

				}
				else{
				}

			}
			if (isset($_POST[($row)]) && $_POST[$row]=="" && strstr($elemPattern ,("#".$this->formMap[($row)]['type']."#")) && $this->formMap[($row)]['required']) {
					$this->isValid=FALSE;
					$this->errorMessages[]="* Form field '".$this->formMap[($row)]['label']."' can not be empty!";
			}

		}

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

	public function getFormValues()
	{
//This method is deprecated & obsolete: use getData() instead
		$formKeys=array_keys($this->formMap);
		foreach($formKeys as $row){

			$elemPattern="#hidden#select#text#textarea#password#checkbox#select_multiple#radio#";

			if (isset($_POST[($row)]) && $_POST[$row]!="" && strstr($elemPattern ,("#".$this->formMap[($row)]['type']."#"))) {

				$fieldContent=$_POST[($row)];
				if(is_string($fieldContent)){
	//Single quote ' ascii code 39, without replacing prepared statement probably doesn't let it to record into database
					$formData[($row)]=str_replace("'","&#39;",$_POST[($row)]);
	//Backslash \ ascii code 92, may not show good creating different meaning (escaping character for \n, \t, \r, etc.)
					$formData[($row)]=str_replace("\\","&#92;",$formData[($row)]);
					$formData[($row)]=htmlspecialchars($formData[($row)]);
				}
				$formValues[($row)]=$fieldContent;
			}
			else{
				$formValues[($row)]="";

			}

		}

		return $formValues;

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
				$tagString.="\n";

			break;
			case 'end':
				$tagString.="</form>";
				$tagString.="\n";
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
				$tagString.="\n";
			break;
			case 'text':
				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<label><span class=\"label-text\">".$curElem['label']."</span>";
					$tagString.="</label>";
					$tagString.="\n";
				}
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
				$tagString.="\n";

			break;
			case 'textarea':
				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<label><span class=\"label-textarea\">".$curElem['label']."</span>";
					$tagString.="</label>";
					$tagString.="\n";
				}

				$tagString.="<textarea name=\"".$elName."\"";

				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}

				$tagString.=">";
				$tagString.="\n";
				if(isset($curElem['value']))
					$tagString.=$curElem['value'];
				$tagString.="</textarea>";
				$tagString.="\n";

			break;
			case 'password':
				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<label><span class=\"label-password\">".$curElem['label']."</span>";
					$tagString.="</label>";
					$tagString.="\n";
				}

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
				$tagString.="\n";

			break;
			case 'file':
				$tagString.="<input name=\"".$elName."\"";
				$tagString.=" type=\"hidden\" name=\"MAX_FILE_SIZE\"";
				$tagString.=" value=\"".$curElem['value']."\"";
				$tagString.=">";

				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<label><span class=\"label-file\">".$curElem['label']."</span>";
					$tagString.="</label>";
					$tagString.="\n";
				}

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
				$tagString.="\n";
			break;
			case 'select':

				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<label class=\"label-select\"><span>".$curElem['label']."</span>";
					$tagString.="\n";
					$tagString.="</label>";
					$tagString.="\n";
				}

				$tagString.="<div class=\"select-single\">\n";
				$tagString.="<select class=\"single\" name=\"".$elName."\"";

				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}

				$tagString.=">";
				$tagString.="\n";

				$optKeys=array_keys($curElem['options']);

				foreach($optKeys as $row){
					$tagString.="<option value=\"".$row."\"";
					if($row==$curElem['value'])
						$tagString.=" selected=\"selected\"";
					$tagString.=">".$curElem['options'][$row]."</option>";
					$tagString.="\n";
				}

				$tagString.="</select>";
				$tagString.="\n";
				$tagString.="</div>\n";

			break;
			case 'checkbox':

				if(isset($curElem['options'])){

	/*
	Problem with PHP checkboxes:
	PHP let's checkboxes to be processed as arrays (name includes [] in this case); 
	javascript may have conflict, if checkbox name includes [].
	The type 'checkbox' in this class has square brackets in checkbox names.
	(See line: $tagString.="<input name=\"".$elName."[]\"";)
	If the checkbox names are needed without [], then ideas are to add another type to this class in the future e.g. checkbox2
	or to manage such checkboxes outside of this class.

	Some other considerations to solve the conflict:
	//https://stackoverflow.com/questions/3207469/use-brackets-in-checkbox-name-when-using-php-and-javascript
	PHP has an unusual system for handling multiple form controls with the same name, it expects the names to include [] but it doesn't use them in the variable name.
	JavaScript doesn't have that issue. The property will still have the brackets.
	Of course, square brackets have special meaning in JS, so you can't use dot notation to access the property.
	f['type[]'][i].checked
	---
	In javascript, you could use f['type[]'] instead of f.type. It's only php that changes [] to array.
	*/

					$optKeys=array_keys($curElem['options']);
					if(isset($curElem['label']) && $curElem['label']!=""){
						$tagString.="<div class=\"label-checkboxes\">";
						$tagString.=$curElem['label'];
						$tagString.="</div>";
						$tagString.="\n";
					}
					foreach($optKeys as $row){
					$tagString.="<label class=\"check-set\"><span>".$curElem['options'][$row]."</span>";
						$tagString.="<input class=\"checkbox\" name=\"".$elName."[]\"";
						$tagString.=" type=\"".$curElem['type']."\"";

						$tagString.=" value=\"".$row."\"";
						if(is_array($curElem['value']) && in_array($row,$curElem['value']))
							$tagString.=" checked=\"checked\"";
						$tagString.=">";
						$tagString.="<span class=\"check-mark\">";
						$tagString.="</span>";
					$tagString.="</label>";
						$tagString.="\n";
					}

				}
				else{
					if(isset($curElem['label']) && $curElem['label']!=""){
						$tagString.="<label class=\"check-set2\"><span>".$curElem['label']."</span>";
					}
					$tagString.="<input class=\"checkbox2\" name=\"".$elName."[]\"";
					$tagString.=" type=\"".$curElem['type']."\"";
					$tagString.=" value=\"".$curElem['value']."\"";
					if(isset($curElem['attributes'])){
						$attrKeys=array_keys($curElem['attributes']);
						foreach($attrKeys as $row){

							$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");

						}
					}
					$tagString.=">";
					$tagString.="\n";
					$tagString.="<span class=\"check-mark2\">";
					$tagString.="</span>";
					if(isset($curElem['label']) && $curElem['label']!=""){
						$tagString.="</label>";
					}
					$tagString.="\n";

				}

			break;
			case 'select_multiple':

				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<label class=\"label-select-multiple\"><span>".$curElem['label']."</span>";
					$tagString.="\n";
					$tagString.="</label>";
					$tagString.="\n";
				}

				$tagString.="<div class=\"select-multiple\">\n";
				$tagString.="<select class=\"multiple\" name=\"".$elName."[]\"";

				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}

				$tagString.=" multiple=\"multiple\">";
				$tagString.="\n";

				$optKeys=array_keys($curElem['options']);

				foreach($optKeys as $row){
					$tagString.="<option value=\"".$row."\"";
					if(is_array($curElem['value']) && in_array($row,$curElem['value']))
						$tagString.=" selected=\"selected\"";
					$tagString.=">".$curElem['options'][$row]."</option>";
					$tagString.="\n";
				}

				$tagString.="</select>";
				$tagString.="\n";
				$tagString.="</div>\n";

			break;
			case 'radio_button':

				$optKeys=array_keys($curElem['options']);

				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<div class=\"label-radio-buttons\"><span>".$curElem['label']."</span>";
					$tagString.="</div>";
					$tagString.="\n";
				}

				foreach($optKeys as $row){
				$tagString.="<label class=\"radio-set\"><span>".$curElem['options'][$row]."</span>";
				$tagString.="<input class=\"radio-button\" value=\"".$row."\" type=\"radio\" name=\"".$elName."\"";
					if($row==$curElem['value'])
						$tagString.=(" checked=\"checked\"");
					$tagString.=">";
					$tagString.="<span class=\"radio-mark\">";
					$tagString.="</span>";
				$tagString.="</label>";
					$tagString.="\n";
				}

			break;

			default:
			break;
		}

		return $tagString;

	}

	public function getItem($elName,$id)
	{
//Use this method to display form elements, which have the same name and many parts,
//   but are are separated from each other by some other html code.
//This method is suitable for check boxes and radio buttons.
		$tagString="";
		$tagString.="\n";
		$curElem=$this->formMap[$elName];

		switch($curElem['type']){
			case 'checkbox':
				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<label class=\"label-checkbox\"><span>".$curElem['label']."</span>";
				}
				$tagString.="<input name=\"".$elName."[]\"";
				$tagString.=" type=\"".$curElem['type']."\"";
				$tagString.=" value=\"".$curElem['value']."\"";
				$attrKeys=array_keys($curElem['attributes']);
				if(isset($curElem['attributes'])){
					foreach($attrKeys as $row){

						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");

					}
				}

				$tagString.=">";
				$tagString.="\n";
				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="</label>";
					$tagString.="\n";
				}
			break;

			case 'radio':
				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="<label class=\"label-radio\"><span>".$curElem['label']."</span>";
				}
				$tagString.="\n";
				$tagString.="<input class=\"radio\" type=\"radio\" name=\"".$elName."\"";
				if(isset($curElem['attributes'])){
					$attrKeys=array_keys($curElem['attributes']);
					foreach($attrKeys as $row){
						$tagString.=(" ".$row."=\"".$curElem['attributes'][$row]."\"");
					}
				}
				$tagString.=" value=\"".$curElem['options'][($id)]."\"";
				if($curElem['options'][($id)]==$curElem['value'])
					$tagString.=" checked=\"checked\"";
				$tagString.=">";
				$tagString.="\n";
				if(isset($curElem['label']) && $curElem['label']!=""){
					$tagString.="</label>";
				}
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

   public function getComboOptions($unitResultArray)
   {

		foreach ($unitResultArray as $row) {
			$resultArraySet[]=$row['typeDesc'];
		}
		return $resultArraySet;

	}

   public function setSelectOptions($elName,$optionsFromDb)
   {

		foreach ($optionsFromDb as $row) {
			$optList[($row['id_type'])]=$row['typeDesc'];
		}

		$this->formMap[($elName)]['options']=$optList;

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
