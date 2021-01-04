<?php
/*
 * Allmice(TM) PHP Framework
 * Version 1.5.4 (2019-05-06)
 * Copyright 2016 - 2019 by Any Outline LTD
 * www.allmice.com/framework
 * Allmice PHP Framework code is released under the "New BSD License".
 * See README.TXT file in the "root" directory.

 * Extendable parent class Database

 */

class Database
{

	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;

	public function __construct($dbData)	
	{
	}

	public function decodeDbRow($dbRow,$fieldNames)
	{
/*
The method decodeViewData($dbData,$fieldNames) helps to decode data read from database, 
   which was validated and coded appropriately before recording into database.

Parent class Form has a method getData(), which codes string data pulled from form elements in the following way to store such coded data into database:
   1) Single quotes ' will be replaced with ascii code 39
   2) Backslashes \ will be replaced with ascii code 92
   3) For rest of the code php function htmlspecialchars will be used

Current method can be used to view such database string data on screen in an html document.
   This method simply decodes such string data in reverse order into its initial format-state 
   as it was by getting it from some form fields.

The attribute $fieldNames is an array containing database field names, which you wish to decode.
   If the attribute $fieldNames is an empty array, then all field names, will be checked if they are strings and then decoded.
*/

			if(count($fieldNames)==0)
				$fieldNames=array_keys($dbRow);

			foreach($fieldNames as $fieldName){

				if(is_string($dbRow[($fieldName)])){

					$dbRow[($fieldName)]=htmlspecialchars_decode($dbRow[($fieldName)]);		
	//Backslash \ ascii code 92, may not show good creating different meaning (escaping character for \n, \t, \r, etc.)
					$dbRow[($fieldName)]=str_replace("&#92;","\\",$dbRow[($fieldName)]);
	//Single quote ' ascii code 39, without replacing prepared statement probably doesn't let it to record into database
					$dbRow[($fieldName)]=str_replace("&#39;","'",$dbRow[($fieldName)]);
				}
			}

		return $dbRow;
	}

}
