<?php

class AppDatabase
{

	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;
	public $salt;

	public function __construct($dbData)
	{

		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];

	}

//This class uses prepared statements with parameters

	public function getUserData($name,$formPass)
	{

		$dbUserData = array();
		$userData=array();
		$userId=0;
		$userData['id']=0;
		$userData['roleId']=2;
		$userData=array();

		$sqlString="SELECT id, active_role_id AS roleId, password";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE username = :username";
		$sqlString.=" AND status = 2";
		$sqlString.=" LIMIT 1";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":username" => $name
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$dbUserData = $row;
		}

		if(count($dbUserData)>0){
			$reversedParts = explode('$', strrev($dbUserData['password']), 2);		
			$savedSalt=strrev($reversedParts[1]);

			$cryptedFormPass=crypt($formPass,$savedSalt);

			if($cryptedFormPass==$dbUserData['password']){
				$userData['id']=$dbUserData['id'];
				$userData['roleId']=$dbUserData['roleId'];
			}

		}

		return $userData;
	}

	public function getUserList()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getUserDetails($id)
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id = :id";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

}
