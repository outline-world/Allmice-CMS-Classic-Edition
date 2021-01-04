<?php
//session_start();
/*
http://ee2.php.net/manual/en/function.imagettftext.php

*/

// Set the content-type
header('Content-type: image/png');

$crypto = isset($_GET['source']) ? urldecode($_GET['source']) : '0';


$key="8I1aAMT";

$randCode = $crypto ^ $key;
//$randCode = "Test";
// Create the image

function selfURL() {
 $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
  $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
   $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	 return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	  }
function strleft($s1, $s2) {
return substr($s1, 0, strpos($s1, $s2));
}

$width=200;
$height=40;
$im = imagecreatetruecolor($width, $height);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
//$grey = imagecolorallocate($im, 128, 128, 128);
//$black = imagecolorallocate($im, 0, 0, 0);
$textCol = imagecolorallocate($im, 10, 100, 50);
$noiseCol = imagecolorallocate($im, 100, 180, 140);
imagefilledrectangle($im, 0, 0, $width, $height, $white);

		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($im, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noiseCol);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($im, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noiseCol);
		}

// The text to draw
//$text = 'Testing...';

$text = $randCode;
$text = "Test";


$text = $_SESSION['captcha']['code'];
//$text = "WWWWWWW";
// Replace path by your own font path
//$font = 'arial.ttf';
//$font = 'VERDANA.TTF';
//$font = 'Acidic.ttf';
//$font = 'AcidDreamer.ttf';
//$font = 'aardvark-cafe.ttf';
//$font = 'Aapex.ttf';
//$font = '/usr/share/fonts/truetype/verdana/Verdana.ttf';
$font = '/usr/share/fonts/truetype/verdana/Verdana.ttf';
$curUrl = selfURL();
//echo "curUrl=".$curUrl."<br/>";
/*
if ( preg_match("/:\/\/localhost/", $curUrl)){
	$font = 'Verdana.ttf';
//$url2="http://localhost/outline-world-map";
$url2="http://localhost/a-cms/outline-world-map";
//	$font = $url2."/sites/all/themes/flexy3_map_system/libraries/captcha/".'Verdana.ttf';
//$path3=$url."/sites/all/themes/flexy3_map_system/libraries/captcha/";
//echo "font=".$font."<br/>";
}
*/
		$textsize = imagettfbbox(20, 0, $font, $text);
		$x = ($width - $textsize[4])/2;
		$y = ($height - $textsize[5])/2;
imagettftext($im, 20, 0, $x, $y, $textCol, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);

?>

