<?php

class AppDatabase
{

	public $tablePrefix;

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getEmail($userId)
	{
		$itemDetails="";
		$sqlString="SELECT mail";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id = :userId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
				":userId" => $userId
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemDetails = $row['mail'];
		}

		return $itemDetails;

	}

	public function getProfileDetails($userId)
	{
		$itemDetails=array();
		$sqlString="SELECT gravatar_source, avatar_type, avatar_url";
		$sqlString.=" FROM ".$this->tablePrefix."mod_profile";
		$sqlString.=" WHERE user_id = :userId";
		$sqlString.=" LIMIT 1";

		$sqlString="SELECT p.gravatar_source AS gravatar_source, p.avatar_type AS avatar_type, p.avatar_url AS avatar_url";
		$sqlString.=", u.language_code AS language_code";
		$sqlString.=" FROM ".$this->tablePrefix."mod_profile p, ".$this->tablePrefix."mod_user u";
		$sqlString.=" WHERE p.user_id = :userId";
		$sqlString.=" AND u.user_id = p.user_id";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
				":userId" => $userId
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function getLangOptions()
	{
		$langOptions=array();
		$sqlString="SELECT language_code, label";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";
		$sqlString.=" WHERE status = 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$langOptions[($row['language_code'])] = $row['label'];
		}

		return $langOptions;

	}

	public function insertProfile($profile)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_profile (user_id, avatar_type";
		$sqlString.=", gravatar_source, avatar_url, personal_notes)";
		$sqlString.=" VALUES (";
		$sqlString.=":userId";
		$sqlString.=", :imageType";
		$sqlString.=", :gravatarSource";
		$sqlString.=", :avatarUrl";
		$sqlString.=", :personalNotes";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $profile->userId,
			":imageType" => $profile->imageType,
			":gravatarSource" => $profile->gravatarSource,
			":avatarUrl" => $profile->avatarUrl,
			":personalNotes" => $profile->personalNotes,
		));

		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateProfile($profile)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_profile";
		$sqlString.=" SET ";
		$sqlString.=("avatar_type = :imageType");
		$sqlString.=(", gravatar_source = :gravatarSource");
		$sqlString.=(", avatar_url = :avatarUrl");
		$sqlString.=(", personal_notes = :personalNotes");
		$sqlString.=" WHERE user_id = :userId";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":imageType" => $profile->imageType,
			":gravatarSource" => $profile->gravatarSource,
			":avatarUrl" => $profile->avatarUrl,
			":personalNotes" => $profile->personalNotes,
			":userId" => $profile->userId,
		));

	}

	public function updateUser($profile)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_user";
		$sqlString.=" SET ";
		$sqlString.=("language_code = :langCode");
		$sqlString.=" WHERE user_id = :userId";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":langCode" => $profile->langCode,
			":userId" => $profile->userId,
		));

	}

	public function saveProfile($profile)
	{
		if ($profile->status == "noProfile") {
			try {
				$id=$this->insertProfile($profile);
				$this->updateUser($profile);
			} catch (Exception $e) {
			}
		} else {
			try {
				$this->updateProfile($profile);
				$this->updateUser($profile);
			} catch (Exception $e) {
			}
		}

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

	public function getConfigData($typePrefix)
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'Profile'";
		if($typePrefix!="")
			$sqlString.=" AND type LIKE '".$typePrefix."%'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$configData[($row['type'])][($row['uri'])] = $row['value'];
		}

		return $configData;

	}

}
