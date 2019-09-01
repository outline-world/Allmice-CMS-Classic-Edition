<?php

class Captcha
{
	
	public $key;
	public $code;
	public $imageUrl;
//	public $salt;

	public function setupCaptcha($installData,$installPath)
	{

		$tempArr=explode("://",$GLOBALS['baseUrl']);
		$sitePath=str_replace("/","_",$tempArr[1]);

		$inputPath=$installPath."/config.php";



					$pwSalt=$app->generateRandomString($GLOBALS['pwSaltLength']);	





	}
	public function generateRandomString($length = 16) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

/*
Captcha class
Admin mooduli osana
key
code
imageUrl

* Captcha klassi codeGenerator meetod
loeb ab-st config key väärtuse (see salvestatakse sinna Admin mooduli installimisega)
* text-image.php fail include-ib
sites/[webSitePath]/config.php faili sisse ja kasutab ab. liigipääsu andmeid et tekitada oma ühendus ja teada saada admin mooduli
captchaKey config väärtus ning muud config väärtuse (font, värvitoonid jne) captcha pildi koostamiseks



http://www.outline-world-map.com/modules/MapPaintingTool/Model/libraries/captcha/text-image.php?source=u%21%0229"
*/

}
