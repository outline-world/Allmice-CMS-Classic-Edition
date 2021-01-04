<?php 
// Extend the TCPDF class to create custom Header and Footer
class CustomPdf extends TCPDF {

	public function getMimeType($filename)
	{
	    $mimetype = false;
	    if(function_exists('finfo_open')) {
	        // open with FileInfo
	    } elseif(function_exists('getimagesize')) {
	        // open with GD
	    } elseif(function_exists('exif_imagetype')) {
	       // open with EXIF
	    } elseif(function_exists('mime_content_type')) {
	       $mimetype = mime_content_type($filename);
	    }
	    return $mimetype;
	}

    public function Header() {

		$this->SetFont($GLOBALS['pdfData']['headerFontFamily'], $GLOBALS['pdfData']['headerFontStyle'], $GLOBALS['pdfData']['headerFontSize']);
		
		$this->SetY($GLOBALS['pdfData']['headerPositionFromTop']);

		if($GLOBALS['pdfData']['displayMode']=="Tcpdf"){

			$GLOBALS['pdfData']['headerText']=$GLOBALS['pdfData']['title'];

			if($GLOBALS['pdfData']['headerLogoPath']!="")
				$this->Image($GLOBALS['pdfData']['headerLogoPath'], $GLOBALS['pdfData']['headerLogoLeft'], $GLOBALS['pdfData']['headerLogoTop'], $GLOBALS['pdfData']['headerLogoWidth'], '', $GLOBALS['pdfData']['headerLogoFormat'], '', $GLOBALS['pdfData']['headerLogoVerticalAlign'], false, 300, $GLOBALS['pdfData']['headerLogoHorizontalAlign'], false, false, 0, false, false, false);

/*
	 * Puts an image in the page.
	 * The upper-left corner must be given.
	 * The dimensions can be specified in different ways:<ul>
	 * @param $file (string) Name of the file containing the image or a '@' character followed by the image data string. To link an image without embedding it on the document, set an asterisk character before the URL (i.e.: '*http://www.example.com/image.jpg').
	 * @param $x (float) Abscissa of the upper-left corner (LTR) or upper-right corner (RTL).
	 * @param $y (float) Ordinate of the upper-left corner (LTR) or upper-right corner (RTL).
	 * @param $w (float) Width of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $h (float) Height of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $type (string) Image format. Possible values are (case insensitive): JPEG and PNG (whitout GD library) and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;. If not specified, the type is inferred from the file extension.
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $align (string) Indicates the alignment of the pointer next to image insertion relative to image height. The value can be:<ul><li>T: top-right for LTR or top-left for RTL</li><li>M: middle-right for LTR or middle-left for RTL</li><li>B: bottom-right for LTR or bottom-left for RTL</li><li>N: next line</li></ul>
	 * @param $resize (mixed) If true resize (reduce) the image to fit $w and $h (requires GD or ImageMagick library); if false do not resize; if 2 force resize in all cases (upscaling and downscaling).
	 * @param $dpi (int) dot-per-inch resolution used on resize
	 * @param $palign (string) Allows to center or align the image on the current line. Possible values are:<ul><li>L : left align</li><li>C : center</li><li>R : right align</li><li>'' : empty string : left for LTR or right for RTL</li></ul>
	 * @param $ismask (boolean) true if this image is a mask, false otherwise
	 * @param $imgmask (mixed) image object returned by this function or false
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $fitbox (mixed) If not false scale image dimensions proportionally to fit within the ($w, $h) box. $fitbox can be true or a 2 characters string indicating the image alignment inside the box. The first character indicate the horizontal alignment (L = left, C = center, R = right) the second character indicate the vertical algnment (T = top, M = middle, B = bottom).
	 * @param $hidden (boolean) If true do not display the image.
	 * @param $fitonpage (boolean) If true the image is resized to not exceed page dimensions.
	 * @param $alt (boolean) If true the image will be added as alternative and not directly printed (the ID of the image will be returned).
	 * @param $altimgs (array) Array of alternate images IDs. Each alternative image must be an array with two values: an integer representing the image ID (the value returned by the Image method) and a boolean value to indicate if the image is the default for printing.
*/

			$this->Cell($GLOBALS['pdfData']['headerTextCellWidth'], $GLOBALS['pdfData']['headerTextCellHeight'], $GLOBALS['pdfData']['headerText'], 0, false, $GLOBALS['pdfData']['headerTextHorizontalAlign'], 0, '', 0, false, $GLOBALS['pdfData']['headerCellVerticalAlign'], $GLOBALS['pdfData']['headerTextVerticalAlign']);

/*
	 * Prints a cell (rectangular area) with optional borders, background color and character string. The upper-left corner of the cell corresponds to the current position. The text can be aligned or centered. After the call, the current position moves to the right or to the next line. It is possible to put a link on the text.<br />
	 * If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.
	 * @param $w (float) Cell width. If 0, the cell extends up to the right margin.
	 * @param $h (float) Cell height. Default value: 0.
	 * @param $txt (string) String to print. Default value: empty string.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul> Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ignore_min_height (boolean) if true ignore automatic minimum height value.
	 * @param $calign (string) cell vertical alignment relative to the specified Y value. Possible values are:<ul><li>T : cell top</li><li>C : center</li><li>B : cell bottom</li><li>A : font top</li><li>L : font baseline</li><li>D : font bottom</li></ul>
	 * @param $valign (string) text vertical alignment inside the cell. Possible values are:<ul><li>T : top</li><li>C : center</li><li>B : bottom</li></ul>

*/

//$this->SetLineStyle(array('width' => 0.25 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 255, 255)));
//$this->Ln();

		}else{

			$GLOBALS['pdfData']['headerStyles']=$this->decodeData($GLOBALS['pdfData']['headerStyles']);
			$GLOBALS['pdfData']['headerHtml']=$this->decodeData($GLOBALS['pdfData']['headerHtml']);
			$GLOBALS['pdfData']['logoCode']=$this->decodeData($GLOBALS['pdfData']['logoCode']);

			$GLOBALS['pdfData']['headerHtml']=str_replace("[logoCode]",$GLOBALS['pdfData']['logoCode'],$GLOBALS['pdfData']['headerHtml']);
			$GLOBALS['pdfData']['headerHtml']=str_replace("[logoPath]",$GLOBALS['pdfData']['logoPath'],$GLOBALS['pdfData']['headerHtml']);
			$GLOBALS['pdfData']['headerHtml']=str_replace("[title]",$GLOBALS['pdfData']['title'],$GLOBALS['pdfData']['headerHtml']);
			$this->writeHTML($GLOBALS['pdfData']['headerStyles'].$GLOBALS['pdfData']['headerHtml'], true, false, true, false, '');
		}

    }

    public function Footer() {
/*
//If trying to center the footer horizontally, then it is not centered compared with header.
//   This problem seems to be caused because of using function getAliasNumPage or getAliasNbPages.
//To resolve this issue (at least to make it better):
// 1) If mode is Tcpdf, then there is in config entry tcpdfVariousSettings a key spacesBeforeFooter,
//    which determines how many spaces to add before Footer content.
// 2) If mode is HtmlCss, then there are table cells with style attributes
//    before and after content cell in config entry tcpdfVariousSettings.
*/

		$curPage=strval($this->getAliasNumPage());

		$allPages=strval($this->getAliasNbPages());
		$curPage=trim($curPage);
		$allPages=trim($allPages);

		$this->SetFont($GLOBALS['pdfData']['footerFontFamily'], $GLOBALS['pdfData']['footerFontStyle'], $GLOBALS['pdfData']['footerFontSize']);
		
		$this->SetX($GLOBALS['pdfData']['footerPositionFromLeft']);
		$this->SetY($GLOBALS['pdfData']['footerPositionFromBottom']);

		if($GLOBALS['pdfData']['displayMode']=="Tcpdf"){

			$gapString=str_repeat(" ",$GLOBALS['pdfData']['spacesBeforeFooter']);
			$footerText=$gapString.$GLOBALS['pdfData']['footerText'].$curPage."/".$allPages;
			$this->Cell($GLOBALS['pdfData']['footerTextCellWidth'], $GLOBALS['pdfData']['footerTextCellHeight'], $footerText, 0, false, $GLOBALS['pdfData']['footerTextHorizontalAlign'], 0, '', 0, false, $GLOBALS['pdfData']['footerCellVerticalAlign'], $GLOBALS['pdfData']['footerTextVerticalAlign']);

		}else{

			$gapString=str_repeat(" ",$GLOBALS['pdfData']['spacesBeforeFooter']);
			$footerText=$gapString.$GLOBALS['pdfData']['footerText'].$curPage."/".$allPages;

			$GLOBALS['pdfData']['footerStyles']=$this->decodeData($GLOBALS['pdfData']['footerStyles']);
			$GLOBALS['pdfData']['footerHtml']=$this->decodeData($GLOBALS['pdfData']['footerHtml']);

			$GLOBALS['pdfData']['footerHtml']=str_replace("[footerText]",$GLOBALS['pdfData']['footerText'],$GLOBALS['pdfData']['footerHtml']);
			$GLOBALS['pdfData']['footerHtml']=str_replace("[currentPage]",$curPage,$GLOBALS['pdfData']['footerHtml']);
			$GLOBALS['pdfData']['footerHtml']=str_replace("[allPages]",$allPages,$GLOBALS['pdfData']['footerHtml']);

			$this->writeHTML($GLOBALS['pdfData']['footerStyles'].$GLOBALS['pdfData']['footerHtml'], true, false, true, false, '');

		}

	} 

	public function setPdfSettings($config) {
	
		$tempArr=explode("\n",$config);
		
		foreach ($tempArr as $row) {
			if($row!=""){
				$tempArr2=explode("=",$row,2);
			}
			$GLOBALS['pdfData'][($tempArr2[0])]=trim($tempArr2[1]);
		}
	
	} 

	public function decodeData($encodedData)
	{

		$processedData=htmlspecialchars_decode($encodedData);		
		//Backslash \ ascii code 92, may not show good creating different meaning (escaping character for \n, \t, \r, etc.)
		$processedData=str_replace("&#92;","\\",$processedData);
		//Single quote ' ascii code 39, without replacing prepared statement probably doesn't let it to record into database
		$processedData=str_replace("&#39;","'",$processedData);

		return $processedData;
	}

}
