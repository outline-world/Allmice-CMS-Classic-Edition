<?php
/*
 * Allmice(TM) PHP Framework
 * Version 1.1.1 (07/09/2018)
 * Copyright 2018 by Any Outline LTD
 * www.allmice.com/framework
 * Allmice PHP Framework code is released under the "New BSD License".
 * See README.TXT file in the "root" directory.

 * Captcha text image builder code

 */

	$text="Test";

	$path['host'] = $_SERVER['SERVER_NAME'];
	$path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
	
	
	$tempArr=explode("/core",$path['base']);
	$sitePath=str_replace("/","_",($path['host'].$tempArr[0]));
	
	$inputPath="../../../sites/".$sitePath."/config.php";
	
	include($inputPath);

	$dbId = new PDO('mysql:host='.$Database['app_db']['dbHost'].';dbname='.$Database['app_db']['dbName'].';charset=utf8', $Database['app_db']['userName'], $Database['app_db']['userPassword']);
	$tablePrefix=$Database['app_db']['tablePrefix'];

	$typePrefix="captcha";
	$sqlString="SELECT uri, value";
	$sqlString.=" FROM ".$tablePrefix."core_config";
	$sqlString.=" WHERE type LIKE '".$typePrefix."%'";

	$configData=array();
	$stmt = $dbId->prepare($sqlString);
	$stmt->execute();
	$resultSet = $stmt->fetchAll();
	foreach ($resultSet as $row) {
		$configData[($row['uri'])] = $row['value'];
	}

	create_image($configData);
	
	exit(); 

	function convertColorHex2Dec($hexColor){
		$decColor['rDec']=hexdec(substr($hexColor, 1, 2));
		$decColor['gDec']=hexdec(substr($hexColor, 3, 2));
		$decColor['bDec']=hexdec(substr($hexColor, 5, 2));
		return $decColor;
	}

	function selfURL() {
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	}

	function strleft($s1, $s2) {
		return substr($s1, 0, strpos($s1, $s2));
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

	function create_image($configData)
	{
		$key="8I1aAMT";
		$textColorHex="#0A6432";
		$noiseColorHex="#64B48C";
		$bgColorHex="#FFFFFF";
		$fontPath="/usr/share/fonts/truetype/verdana/Verdana.ttf";
		$width=200;
		$height=40;
		$width=160;
		$height=60;
	
		$textSize=20;
		$textAngle=0;
		$textAngle=10;

		$key="8I1aAMT";
		$iv="agTn0IsEbaF4kZa3";

		$method="aes-256-ctr";

		if(count($configData)>0){
			if(isset($configData['method'])){
				$method=$configData['method'];
			}
			if(isset($configData['key'])){
				$key=$configData['key'];
			}
			if(isset($configData['key2'])){
				$iv=$configData['key2'];
			}
			if(isset($configData['width'])){
				$width=$configData['width'];
			}
			if(isset($configData['height'])){
				$height=$configData['height'];
			}
			if(isset($configData['angle'])){
				$angle=$configData['angle'];
			}
			if(isset($configData['fontSize'])){
				$fontSize=$configData['fontSize'];
			}
			if(isset($configData['fontPath'])){
				$fontPath=$configData['fontPath'];
			}
			if(isset($configData['textColor'])){
		//		$textColor=$configData['textColor'];
				$textColorHex=$configData['textColor'];
			}
			if(isset($configData['noiseColor'])){
		//		$noiseColor=$configData['noiseColor'];
				$noiseColorHex=$configData['noiseColor'];
			}
			if(isset($configData['bgColor'])){
		//		$bgColor=$configData['bgColor'];
				$bgColorHex=$configData['bgColor'];
			}
		
		}

//====================

//Start of changeable keys and other changeable properties
//... finish later

		$cipherText2 = isset($_GET['source']) ? urldecode($_GET['source']) : '0';

		$ciphers = openssl_get_cipher_methods();

		if(in_array($method,$ciphers)){

			if($iv!="")
				$code2=openssl_decrypt( $cipherText2, $method, $key, OPENSSL_RAW_DATA, $iv );
			else
				$code2=openssl_decrypt( $cipherText2, $method, $key, OPENSSL_RAW_DATA );
		}else{
			$code2 = $cipherText2 ^ $key; 
		}
		$text=$code2;

//==================================
		$im = imagecreatetruecolor($width, $height);
	
		// Create some colors
	
		$decColor=convertColorHex2Dec($bgColorHex);
		$bgColor = imagecolorallocate($im, $decColor['rDec'], $decColor['gDec'], $decColor['bDec']);
		$decColor=convertColorHex2Dec($textColorHex);
		$textColor = imagecolorallocate($im, $decColor['rDec'], $decColor['gDec'], $decColor['bDec']);
		$decColor=convertColorHex2Dec($noiseColorHex);
		$noiseColor = imagecolorallocate($im, $decColor['rDec'], $decColor['gDec'], $decColor['bDec']);
		imagefilledrectangle($im, 0, 0, $width, $height, $bgColor);
	
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($im, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noiseColor);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($im, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noiseColor);
		}
	
		$curUrl = selfURL();
	
		$textArea = imagettfbbox($textSize, $textAngle, $fontPath, $text);
		$x = ($width - $textArea[4])/2;
		$y = ($height - $textArea[5])/2;
		imagettftext($im, $textSize, $textAngle, $x, $y, $textColor, $fontPath, $text);
	
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
	
	}

?>
