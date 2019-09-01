<?php
/*
 * Allmice(TM) PHP Framework
 * Version 1.5.4 (2019-05-06)
 * Copyright 2018 - 2019 by Any Outline LTD
 * www.allmice.com/framework
 * Allmice PHP Framework code is released under the "New BSD License".
 * See README.TXT file in the "root" directory.

 * Captcha class

 */

class Captcha
{

	protected $key;
	protected $method;
	protected $code;
	public $imageUrl;
	public $formWidget;
	public $test;
	public $imageSwitch;

	public function __construct($appDb,$moduleName,$submitElName,$lang) { 
		$textBoxLabel=$lang['captchaBoxLabel'];
		$newCodeButton=$lang['captchaNewCode'];
		$this->key="agTn0Is";
		$iv="agTn0IsEbaF4kZa3";
		$this->method="aes-256-ctr";

		$configUpdate=array();
//Finding new captcha code
		$this->code=$this->generateRandomString(6);
		$ciphers = openssl_get_cipher_methods();

//Captcha test: If method exists, 
//   then openssl_encrypt for code, image with encrypted code in url and captcha widget
//   otherwise check only if $_SESSION['captchaCode'] exists

//Get config data from database
		$typePrefix="captcha";
		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$appDb->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = '".$moduleName."'";
		if($typePrefix!="")
			$sqlString.=" AND type LIKE '".$typePrefix."%'";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $appDb->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$configData[($row['uri'])] = $row['value'];
		}

		$curTime=time();

		if(count($configData)>0 && $configData['displayWidgetSwitch']=="on"){
			if(isset($configData['method'])){
				$this->method=$configData['method'];
			}
			if(isset($configData['key'])){
				$this->key=$configData['key'];
			}
			if(isset($configData['key2'])){
				$iv=$configData['key2'];
			}

			if(in_array($this->method,$ciphers)){

				$this->test=$this->GetTest();

					if (isset($_POST['captchaText']) && isset($_POST['urlCode']) && !isset($_POST['getNewCode'])) {

//Passing captcha code from previous page
						$captchaText=$_POST['captchaText'];
						$urlCode=$_POST['urlCode'];

						$output=$_POST['captchaText'];
						if(strstr($output,"'")){
//							$output=str_replace("'", "&#39;", $output);
							$output=str_replace("'", "X", $output);
						}
						if(strstr($output,'"')){
//							$output=str_replace('"', '&quot;', $output);
							$output=str_replace('"', 'X', $output);
						}
						if(strstr($output,"<")){
//							$output=str_replace("<", "&lt;", $output);
							$output=str_replace("<", "X", $output);
						}
						if(strstr($output,">")){
//							$output=str_replace(">", "&gt;", $output);
							$output=str_replace(">", "X", $output);
						}
						$captchaText=$output;

					}
					else{
//Encrypting new captcha code
						$captchaText="";
						if($iv!=""){
							$cipherText = openssl_encrypt(
								$this->code,
								$this->method,
								$this->key,
								OPENSSL_RAW_DATA,
								$iv
							);
						}
						else{
							$cipherText = openssl_encrypt(
								$this->code,
								$this->method,
								$this->key,
								OPENSSL_RAW_DATA
							);
						}
						$urlCode=urlencode ( $cipherText );

					}

					$this->imageUrl=$GLOBALS['baseUrl']."/core/includes/Model/"."captcha-text-image.php?source=".$urlCode;

					if(isset($_POST['getNewCode']) || !isset($_POST[($submitElName)]))
						$_SESSION['captchaCode']=$this->code;

					$formWidget="";

					$formWidget.="<div class=\"captcha\">\n";
					$formWidget.=$textBoxLabel;
					$formWidget.="<div class=\"captcha-text\">\n";
					$formWidget.="<input type=\"text\" name=\"captchaText\" class=\"captcha\" value=\"".$captchaText."\" maxlength=\"10\" />\n";
					$formWidget.="</div>\n";
					$formWidget.="<div class=\"captcha-image\">\n";
					$formWidget.="<img src=\"".$this->imageUrl."\" alt=\"CAPTCHA\" />\n";
					$formWidget.="</div>\n";
					$formWidget.="<div class=\"captcha-button\">\n";
					$formWidget.="<input type=\"submit\" name=\"getNewCode\" class=\"captcha\" value=\"".$newCodeButton."\" />\n";
					$formWidget.="</div>\n";
					$formWidget.="<input type=\"hidden\" name=\"urlCode\" value=\"".$urlCode."\" />\n";
					$formWidget.="</div>\n";

					$this->formWidget=$formWidget;

			}
			else{
				$cipherText="";
				$urlCode="";
			}

		}
		else{
			$cipherText=""; 
			$urlCode="";
		}

		if($urlCode==""){

			if (isset($_POST[($submitElName)]) && isset($_SESSION['captchaCode'])) {
				$this->test=true;
			}else{
				$this->test=false;
			}

			$_SESSION['captchaCode']=$this->code;
		}

    }

	protected function getTest()
	{
		$captchaTest=false;
		if (isset($_POST['captchaText']) && $_POST['captchaText']!="" && isset($_SESSION['captchaCode'])
		 && $_SESSION['captchaCode']==$_POST['captchaText']) {
			$captchaTest=true;
		}
		return $captchaTest;
	}

	protected function generateRandomString($length = 16) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

}
