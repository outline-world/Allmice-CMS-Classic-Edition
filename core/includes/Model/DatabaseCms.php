<?php
/*
 * Allmice(TM) CMS
 * Version 1.5.4 (2019-05-06)
 * Copyright 2016 - 2019 by Any Outline LTD
 * www.allmice.com/cms
 * Allmice CMS code is released under the "General Public License".
 * See README.TXT file in the "root" directory.

 * Extendable Database parent class

 */

class DatabaseCms
{

	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;

	public function __construct($dbData)	
	{
	}

//==> Start of access right checking ==================

	public function getAccessRight($userData,$path)
	{

			$accessRight=false;
			$resData=$this->getAcceptedRoles($path);
			$resRoles=$resData['role'];

			$userRole=$userData['roleId'];
			$userRoles=$this->getUserRoles($userData['id']);

			if(count($userRoles)>1){
//Access, if multiple roles - if count($userRoles)>1 - should not be very much slower, 
//   because in practical cases one user still will not have usually too many roles 
//   (if more than 1, then usually probably not more than 3). E.g. a user may have roles authenticated & client.
				foreach ($userRoles as $checkRole) {
					if(in_array($checkRole, $resRoles)){
						$accessRight=true;
					}
				}
			}
			else{
//Access, if only one role - easier and faster logic.
//   In most cases it is enough, if one user has only one role - 
//   this is the case, if in database in table core_user the field value count($userRoles)>1.
				if(in_array($userRole, $resRoles)){
					$accessRight=true;
				}
			}

		return $accessRight;

	}

	public function getUserRoles($id)
	{

		$sqlString="SELECT role_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user_role";
		$sqlString.=" WHERE user_id = :userId";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $id
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row['role_id'];
		}

		return $itemList;

	}

	public function getAcceptedRoles($path)
	{

		$roleList=array();
		$sqlString="SELECT p.role_id AS role_id, p.access_level AS access_level";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE r.id = p.resource_id";
		$sqlString.=" AND p.access_level > 0";
		$sqlString.=" AND r.uri LIKE :path";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":path" => $path
		));
		$resultSet = $stmt->fetchAll();

		$botAccess = 1;
		foreach ($resultSet as $row) {
			$roleList[] = $row['role_id'];
			if($row['role_id']==2 && $row['access_level']>=2 && $row['access_level']<=5){
//If role is anonymous (2) and
//1) access level is 1, then all bot access is granted - then no html meta tag of robots will be added 
//2) access level is 2, then no index and no follow - then html tag noindex nofollow will be added
//3) access level is 3, then no index - then html tag index nofollow will be added
//4) access level is 4, then no follow - then html tag noindex follow will be added
//5) access level is 5, then index and follow - then html tag will be added
				$botAccess = $row['access_level'];
			}
		}

		$resList['role']=$roleList;
		$resList['botAccess']=$botAccess;
		return $resList;

	}

//<== End of access right ==================

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

	public function getValidityPatterns($modName)
	{

		$itemList=array();

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE type = 'formValidationRegEx'";
		$sqlString.=" AND module_name = :modName";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[($row['uri'])] = $row['value'];
		}

		return $itemList;

	}

	public function getModuleEventSet($whereClause)
	{

		$sqlString="SELECT r.specific_name AS specific_name";
		$sqlString.=", r.uri AS uri";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE r.type = 1";
		$sqlString.=" AND r.id = p.resource_id";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY r.module_name, r.specific_name";

//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

}
