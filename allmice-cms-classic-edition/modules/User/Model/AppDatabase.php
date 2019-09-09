<?php

class AppDatabase extends DatabaseCms
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

	public function getCountryList()
	{

		$template = "";
		$countryList=array();

		$sqlString="SELECT code, name_short";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_country";
		$sqlString.=" WHERE language_code = :langCode";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":langCode" => $GLOBALS['langCode']
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			if($row['code']!="1")
				$countryList[($row['code'])] = $row['name_short']." (".$row['code'].")";
			else
				$countryList[($row['code'])] = $row['name_short'];
		}

		if($GLOBALS['langCode']!="en" && count($countryList)==0){

			$sqlString="SELECT code, name_short";
			$sqlString.=" FROM ".$this->tablePrefix."mod_user_country";
			$sqlString.=" WHERE language_code = 'en'";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();
			$resultSet = $stmt->fetchAll();
			foreach ($resultSet as $row) {
				if($row['code']!="1")
					$countryList[($row['code'])] = $row['name_short']." (".$row['code'].")";
				else
					$countryList[($row['code'])] = $row['name_short'];
			}

		}

		return $countryList;

	}

	public function getMainEmailAddress($userId)
	{

		$email = "";

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
			$email=$row['mail'];
		}

		return $email;

	}

	public function getMainEmailData($userId)
	{

		$email = array();

		$sqlString="SELECT e.id AS id, u.mail AS email";
		$sqlString.=" FROM ".$this->tablePrefix."core_user u";
		$sqlString.=", ".$this->tablePrefix."mod_user_email e";
		$sqlString.=" WHERE u.id = :userId";
		$sqlString.=" AND u.mail = e.email_address";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $userId
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$email=$row;
		}

		return $email;

	}

	public function getChangeList($event)
	{

		$itemList=array();
		$template = "";

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_form_field";
		$sqlString.=" WHERE module = 'User'";
		$sqlString.=" AND event = :event";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":event" => $event
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getEmailList($paginator)
	{

		$contactList=array();

		$sqlString="SELECT e.id AS id, e.email_address AS email_address, e.mem_word_question AS mem_word_question";
		$sqlString.=", e.status AS status, u.username AS username, u.mail AS main_email";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email e";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=" WHERE u.id = e.user_id";
		$sqlString.=" ORDER BY u.username, e.email_address";
		$sqlString.=" LIMIT ".$paginator->currentPage*$paginator->itemsOnPage.",".$paginator->itemsOnPage;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$list[] = $row;
		}

		return $list;

	}

	public function getContactList($paginator)
	{

		$contactList=array();

		$sqlString="SELECT c.id AS id, c.name AS name, c.description AS description";
		$sqlString.=", c.status AS status, u.username AS username, e.email_address AS email_address";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_contact c";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=", ".$this->tablePrefix."mod_user_email e";
		$sqlString.=" WHERE u.id = c.user_id";
		$sqlString.=" AND e.id = c.email_id";
		$sqlString.=" ORDER BY u.username, c.name, e.email_address";
		$sqlString.=" LIMIT ".$paginator->currentPage*$paginator->itemsOnPage.",".$paginator->itemsOnPage;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$contactList[] = $row;
		}

		return $contactList;

	}

	public function getPostalList($paginator)
	{

		$list=array();

		$sqlString="SELECT p.id AS id, p.title AS title, p.comment AS comment";
		$sqlString.=", p.postal_address AS postal_address, u.username AS username";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_postal p";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=" WHERE u.id = p.user_id";
		$sqlString.=" ORDER BY u.username, p.title";
		$sqlString.=" LIMIT ".$paginator->currentPage*$paginator->itemsOnPage.",".$paginator->itemsOnPage;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$list[] = $row;
		}

		return $list;

	}

	public function getAnyContactDetails($id)
	{

		$contactDetails=array();

		$sqlString="SELECT c.id AS id, c.name AS contact_name, c.description AS description, e.email_address AS email_address, c.status AS status";
		$sqlString.=", c.user_id AS user_id";
		$sqlString.=", u.username AS username";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_contact c";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=", ".$this->tablePrefix."mod_user_email e";
		$sqlString.=" WHERE c.id = :id";
		$sqlString.=" AND c.user_id = u.id";
		$sqlString.=" AND e.id = c.email_id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id,
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$contactDetails = $row;
		}

		return $contactDetails;

	}

	public function checkModuleEmail($email)
	{

		$id = 0;

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email";
		$sqlString.=" WHERE email_address = '".$email."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$id = $row['id'];
		}

		return $id;

	}

	public function checkCoreEmail($email)
	{

		$id = 0;

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE mail = '".$email."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$id = $row['id'];
		}

		return $id;

	}

	public function checkUsername($username)
	{

		$id = 0;

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE username = '".$username."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$id = $row['id'];
		}

		return $id;

	}

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

	public function getRecoveryData($email)
	{

		$id = 0;

		$recoveryData=array();

		$sqlString="SELECT e.id AS id, e.user_id AS userId, e.mem_word AS mem_word";
		$sqlString.=", e.mem_word_question AS mem_word_question, u.username AS username";
		$sqlString.=", e.change_time AS change_time, e.status AS status";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email e";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=" WHERE e.email_address = '".$email."'";
		$sqlString.=" AND e.status = 'verified'";
		$sqlString.=" AND e.user_id = u.id";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$recoveryData = $row;
		}

		return $recoveryData;

	}

	public function getEmailVerifyingData($email)
	{
		$verData=array();

		$sqlString="SELECT e.id AS id, e.user_id AS user_id, e.mem_word AS mem_word";
		$sqlString.=", e.mem_word_question AS mem_word_question, u.username AS username";
		$sqlString.=", e.change_time AS change_time, e.status AS status";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email e";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=" WHERE e.email_address = '".$email."'";
		$sqlString.=" AND e.status LIKE 'created%'";
		$sqlString.=" AND e.user_id = u.id";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$verData = $row;
		}

		return $verData;

	}

	public function getVerCodeList()
	{

		$verData=array();

		$sqlString="SELECT verifying_code";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email";
		$sqlString.=" WHERE status LIKE 'created%'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row['verifying_code']) {
			$verData = $row;
		}

		return $verData;

	}

	public function processAccountRecovery($user)
	{

		try {
			$this->dbId->beginTransaction();

			$sqlString="UPDATE ".$this->tablePrefix."mod_user_email";
			$sqlString.=" SET ";
			$sqlString.=("change_time=".time()."");
			$sqlString.=" WHERE user_id = ".$user->id;

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$sqlString="UPDATE ".$this->tablePrefix."core_user";
			$sqlString.=" SET ";
			$sqlString.=("password='".$user->cryptedPw."'");
			$sqlString.=" WHERE id = ".$user->id;

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function processVerifyingCode($verifyingCode)
	{

		$id = 0;
		$userId = 0;
		$accountStatus=0;
		$activeEmail = "";
		$currentEmail = "";

		$sqlString="SELECT id, user_id, email_address";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email";
		$sqlString.=" WHERE verifying_code = :verifyingCode";
		$sqlString.=" AND status LIKE 'created%'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":verifyingCode" => $verifyingCode
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$id = $row['id'];
			$userId = $row['user_id'];
			$currentEmail = $row['email_address'];
		}

		$sqlString="SELECT mail, status";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id = :userId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $userId
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$activeEmail = $row['mail'];
			$accountStatus = $row['status'];
		}

		try {

			$this->dbId->beginTransaction();
			$sqlString="UPDATE ".$this->tablePrefix."mod_user_email";
			$sqlString.=" SET ";
			$sqlString.=("status='verified'"."");
			$sqlString.=" WHERE id = ".$id;

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			if($accountStatus!=2 && $currentEmail==$activeEmail){
				$sqlString="UPDATE ".$this->tablePrefix."core_user";
				$sqlString.=" SET ";
				$sqlString.=("status=2"."");
				$sqlString.=" WHERE id = ".$userId;

				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute();
			}

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $id;

	}

	public function getDbMesData($typePrefix)
	{

		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'Message'";
		if($typePrefix!="")
			$sqlString.=" AND type LIKE '".$typePrefix."%'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$messageData[($row['type'])][($row['uri'])] = $row['value'];
		}

		return $messageData;

	}

	public function getConfigData($typePrefix)
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'User'";
		if($typePrefix!="")
			$sqlString.=" AND type LIKE '".$typePrefix."%'";

//echo "sqlString=".$sqlString."<br>";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$configData[($row['type'])][($row['uri'])] = $row['value'];
		}

		return $configData;

	}

	public function getRoleId($roleName)
	{

		$template = "";

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";
		$sqlString.=" WHERE title = '".$roleName."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$roleId = $row['id'];
		}

		return $roleId;

	}

	public function getContactUserId($contactId)
	{

		$userId = 0;

		$sqlString="SELECT user_id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_contact";
		$sqlString.=" WHERE id = :contactId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":contactId" => $contactId
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$userId = $row['user_id'];
		}

		return $userId;

	}

	public function getCryptedPassword($plainPass)
	{

		$salt='$5$rounds=5000$'.$this->salt.'$';
		$cryptedPass=crypt($plainPass,$salt);
		$tempArr=explode("$",$cryptedPass);
		return $tempArr[4];

	}

	public function insertCoreUser($user)
	{

		$cryptedPass=$this->getCryptedPassword($user->password);
		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."core_user (active_role_id, mail, password, username, status)";
		$sqlString.=" VALUES (";
		$sqlString.=("".$user->mainRole."");
		$sqlString.=(", '".$user->email."'");
		$sqlString.=(", '".$user->cryptedPw."'");
		$sqlString.=(", '".$user->username."'");
		$sqlString.=(", 1");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateUser($user)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_user";
		$sqlString.=" SET ";
		$sqlString.=("password='".$user->cryptedPw."'");
		$sqlString.=(", username='".$user->username."'");
		$sqlString.=(", mail='".$user->email."'");
		$sqlString.=" WHERE id = ".$user->id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$sqlString="UPDATE ".$this->tablePrefix."mod_user";
		$sqlString.=" SET ";
		$sqlString.=("first_name='".$user->firstName."'");
		$sqlString.=(", middle_names='".$user->middleNames."'");
		$sqlString.=(", last_name='".$user->lastName."'");
		$sqlString.=(", company='".$user->company."'");
		$sqlString.=(", phone1='".$user->phone1."'");
		$sqlString.=(", phone2='".$user->phone2."'");
		$sqlString.=" WHERE user_id = ".$user->id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function insertUserRole($user,$userId)
	{

		$sqlString="INSERT INTO ".$this->tablePrefix."core_user_role (user_id, role_id)";
		$sqlString.=" VALUES (";
		$sqlString.=("".$userId);
		$sqlString.=(", ".$user->mainRole);
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function insertEmail($email)
	{

		$id=0;

		if($email->emailAddress!=""){

			$curTime=time();
			$userId = (int)$email->userId;

			$sqlString="INSERT INTO ".$this->tablePrefix."mod_user_email (";
			$sqlString.="user_id, email_address, mem_word_question, mem_word, verifying_code, status, comment, change_time)";
			$sqlString.=" VALUES (";
			$sqlString.=(":userId");
			$sqlString.=(", :emailAddress");
			$sqlString.=(", :memWordQuestion");
			$sqlString.=(", :memWord");
			$sqlString.=(", :verifyingCode");
			$sqlString.=(", :status");
			$sqlString.=(", :comment");
			$sqlString.=(", :curTime");
			$sqlString.=")";

			$stmt = $this->dbId->prepare($sqlString);

			$stmt->execute(array(
				":userId" => $email->userId,
				":emailAddress" => $email->emailAddress,
				":memWordQuestion" => $email->memWordQuestion,
				":memWord" => $email->memWord,
				":verifyingCode" => $email->verifyingCode,
				":status" => $email->status,
				":comment" => $email->comment,
				":curTime" => $curTime
			));

			$id=$this->dbId->lastInsertId();

		}

		return $id;

	}

	public function updateEmail($email)
	{

		$curTime=time();

		$sqlString="UPDATE ".$this->tablePrefix."mod_user_email";
		$sqlString.=" SET ";
		$sqlString.=("mem_word_question=:memWordQuestion");
		$sqlString.=(", mem_word=:memWord");
		$sqlString.=(", status=:status");
		$sqlString.=(", comment=:comment");
		$sqlString.=(", change_time=:curTime");
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":memWordQuestion" => $email->memWordQuestion,
			":memWord" => $email->memWord,
			":status" => $email->status,
			":comment" => $email->comment,
			":curTime" => $curTime,
			":id" => $email->id
		));

	}

	public function updateVerifyingCode($email)
	{

		$curTime=time();

		$sqlString="UPDATE ".$this->tablePrefix."mod_user_email";
		$sqlString.=" SET ";
		$sqlString.=("verifying_code=:verifyingCode");
		$sqlString.=(", status=:status");
		$sqlString.=(", change_time=:curTime");
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":verifyingCode" => $email->verifyingCode,
			":status" => $email->status,
			":curTime" => $curTime,
			":id" => $email->id
		));

	}

	public function insertContact($contact)
	{

		$userId = (int)$contact->id;

		if($contact->emailId>0){
			$sqlString="INSERT INTO ".$this->tablePrefix."mod_user_contact (";
			$sqlString.="user_id, email_id, name, description, status)";
			$sqlString.=" VALUES (";
			$sqlString.=(":userId");
			$sqlString.=(", :emailId");
			$sqlString.=(", :contactName");
			$sqlString.=(", :description");
			$sqlString.=(", :status");
			$sqlString.=")";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":userId" => $contact->userId,
				":emailId" => $contact->emailId,
				":contactName" => $contact->contactName,
				":description" => $contact->description,
				":status" => $contact->status
			));
		}

	}

	public function updateContact($contact)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_user_contact";
		$sqlString.=" SET ";
		$sqlString.=("email_id = :emailId");
		$sqlString.=(", name = :contactName");
		$sqlString.=(", description = :description");
		$sqlString.=(", status = :status");
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":emailId" => $contact->emailId,
			":contactName" => $contact->contactName,
			":description" => $contact->description,
			":status" => $contact->status,
			":id" => $contact->id
		));

	}

	public function insertPostalAddress($postalAddress)
	{

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_user_postal (";
		$sqlString.="user_id, country_code, postal_address, address_line1, address_line2, address_line3, address_line4";
		$sqlString.=", post_code, comment, title)";
		$sqlString.=" VALUES (";
		$sqlString.=(":userId");
		$sqlString.=(", :countryCode");
		$sqlString.=(", :postalAddress");
		$sqlString.=(", :addressLine1");
		$sqlString.=(", :addressLine2");
		$sqlString.=(", :addressLine3");
		$sqlString.=(", :addressLine4");
		$sqlString.=(", :postCode");
		$sqlString.=(", :comment");
		$sqlString.=(", :title");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $postalAddress->userId,
			":countryCode" => $postalAddress->countryCode,
			":postalAddress" => $postalAddress->postalAddress,
			":addressLine1" => $postalAddress->addressLine1,
			":addressLine2" => $postalAddress->addressLine2,
			":addressLine3" => $postalAddress->addressLine3,
			":addressLine4" => $postalAddress->addressLine4,
			":postCode" => $postalAddress->postCode,
			":comment" => $postalAddress->comment,
			":title" => $postalAddress->title
		));

	}

	public function updatePostalAddress($postalAddress)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_user_postal";
		$sqlString.=" SET country_code = :countryCode";
		$sqlString.=", postal_address = :postalAddress";
		$sqlString.=", address_line1 = :addressLine1";
		$sqlString.=", address_line2 = :addressLine2";
		$sqlString.=", address_line3 = :addressLine3";
		$sqlString.=", address_line4 = :addressLine4";
		$sqlString.=", post_code = :postCode";
		$sqlString.=", comment = :comment";
		$sqlString.=", title = :title";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":countryCode" => $postalAddress->countryCode,
			":postalAddress" => $postalAddress->postalAddress,
			":addressLine1" => $postalAddress->addressLine1,
			":addressLine2" => $postalAddress->addressLine2,
			":addressLine3" => $postalAddress->addressLine3,
			":addressLine4" => $postalAddress->addressLine4,
			":postCode" => $postalAddress->postCode,
			":comment" => $postalAddress->comment,
			":title" => $postalAddress->title,
			":id" => $postalAddress->id
		));

	}

	public function insertUserDetails($detailSet)
	{

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_user (";
		$sqlString.="user_id, first_name, middle_names, last_name, company, phone1, phone2, language_code)";
		$sqlString.=" VALUES (";
		$sqlString.=(":userId");
		$sqlString.=(", :firstName");
		$sqlString.=(", :middleNames");
		$sqlString.=(", :lastName");
		$sqlString.=(", :company");
		$sqlString.=(", :phone1");
		$sqlString.=(", :phone2");
		$sqlString.=(", :langCode");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":userId" => $detailSet->userId,
			":firstName" => $detailSet->firstName,
			":middleNames" => $detailSet->middleNames,
			":lastName" => $detailSet->lastName,
			":company" => $detailSet->company,
			":phone1" => $detailSet->phone1,
			":phone2" => $detailSet->phone2,
			":langCode" => $GLOBALS['langCode'],
		));

	}

	public function insertEmptyModUser($user)
	{

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_user (";
		$sqlString.="user_id, language_code)";
		$sqlString.=" VALUES (";
		$sqlString.=(":userId");
		$sqlString.=(", :langCode");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $user->id,
			":langCode" => $GLOBALS['langCode'],
		));

	}

	public function insertSignUpContactForm($userId,$emailId,$username)
	{

		$sqlString="SELECT default_value";
		$sqlString.=" FROM ".$this->tablePrefix."mod_form_field";
		$sqlString.=" WHERE module = 'User'";
		$sqlString.=" AND event = 'addContactFormEvent'";
		$sqlString.=" AND field_name = 'status'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$statusValue = $row['default_value'];
		}

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_user_contact (";
		$sqlString.="user_id, email_id, name, description, status)";
		$sqlString.=" VALUES (";
		$sqlString.=(":userId");
		$sqlString.=(", :emailId");
		$sqlString.=(", :contactName");
		$sqlString.=(", :description");
		$sqlString.=(", :status");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $userId,
			":emailId" => $emailId,
			":contactName" => $username,
			":description" => "",
			":status" => $statusValue
		));

	}

	public function saveDetailedAccount($user,$email,$signUp,$mesData)
	{
		$id = (int)$user->id;

		if ($id == 0) {

			try {
				$this->dbId->beginTransaction();
				if($user->username!="" && $user->password!=""){

					$id=$this->insertCoreUser($user);
					$user->id=$id;

					$mesData['receiverUserId']=$id;

					$email->userId=$id;
					$this->insertUserRole($user,$id);

					$emailId=$this->insertEmail($email);
					$signUp->userId = (int)$user->id;

					$this->insertSignUpContactForm($user->id,$emailId,$user->username);

					$this->insertUserDetails($signUp);
					if($signUp->countryCode!="")
						$this->insertPostalAddress($signUp);

				}
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		} else {

			try {
				$this->dbId->beginTransaction();
				$this->updateUser($user);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

		return $mesData;

	}

	public function registerAccount($user,$email,$mesData)
	{
		$id = (int)$user->id;

		if ($id == 0) {

			try {
				$this->dbId->beginTransaction();
				if($user->username!="" && $user->password!=""){
					$id=$this->insertCoreUser($user);
					$user->id=$id;
					$email->userId=$id;
					$mesData['receiverUserId']=$id;

					$this->insertEmptyModUser($user);
					$this->insertUserRole($user,$id);

					$emailId=$this->insertEmail($email);

				}
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}
		return $mesData;

	}

	public function getUserCoreData($id)
	{

		$sqlString="SELECT username, mail, status FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id = ".$id;
		$sqlString.=" LIMIT 1";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$userData = $row;
		}
		return $userData;

	}

	public function changeUserStatus($id,$status)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_user";
		$sqlString.=" SET ";
		$sqlString.=("status=".$status);
		$sqlString.=" WHERE id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function saveAccount($user)
	{
		$id = (int)$user->id;

		if ($id == 0) {

			try {
				$this->dbId->beginTransaction();
				if($user->username!="" && $user->password!=""){
					$id=$this->insertCoreUser($user);
					$user->id=$id;
					$this->insertEmptyModUser($user);
					$this->insertUserRole($user,$id);

					$this->changeUserStatus($id,2);

					$curTime=time();

					$sqlString="INSERT INTO ".$this->tablePrefix."mod_user_email (";
					$sqlString.="user_id, email_address, mem_word_question, mem_word, verifying_code, status, comment, change_time)";
					$sqlString.=" VALUES (";
					$sqlString.=(":userId");
					$sqlString.=(", :email");
					$sqlString.=(", ''");
					$sqlString.=(", ''");
					$sqlString.=(", ''");
					$sqlString.=(", 'accepted'");
					$sqlString.=(", ''");
					$sqlString.=(", :curTime");
					$sqlString.=")";

					$stmt = $this->dbId->prepare($sqlString);
					$stmt->execute(array(
						":userId" => $user->id,
						":email" => $user->email,
						":curTime" => $curTime
					));

				}
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();

				$this->updateUser($user);

				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function saveEmail($email)
	{
		$id = (int)$email->id;

		if ($id == 0) {

			try {
				$this->dbId->beginTransaction();
				$emailId=$this->insertEmail($email);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		} else {

			try {
				$this->dbId->beginTransaction();
				$this->updateEmail($email);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		}

	}

	public function saveContact($contact)
	{

		$id = (int)$contact->id;

		if ($id == 0) {

			try {
				$this->dbId->beginTransaction();
				$this->insertContact($contact);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		} else {

			try {
				$this->dbId->beginTransaction();
				$this->updateContact($contact);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		}

	}

	public function savePostalAddress($postalAddress)
	{

		$id = (int)$postalAddress->id;

		if ($id == 0) {

			try {
				$this->dbId->beginTransaction();
				$this->insertPostalAddress($postalAddress);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		} else {

			try {
				$this->dbId->beginTransaction();
				$this->updatePostalAddress($postalAddress);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		}

	}

	public function getMesTemplate($code)
	{
		$mesData=array();

		$sqlString="SELECT t.id AS id, t.subject AS subject, t.content_html AS content_html, t.content_plain AS content_plain";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message_template t";
		$sqlString.=" WHERE t.module = 'User'";
		$sqlString.=" AND t.code = :code";
		$sqlString.=" AND t.language_code = :langCode";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":code" => $code,
			":langCode" => $GLOBALS['langCode']
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$mesData = $row;
		}

		if(count($mesData)==0){

			$sqlString="SELECT t.id AS id, t.subject AS subject, t.content_html AS content_html, t.content_plain AS content_plain";
			$sqlString.=" FROM ".$this->tablePrefix."mod_message_template t";
			$sqlString.=" WHERE t.module = 'Message'";
			$sqlString.=" AND t.code = :code";
			$sqlString.=" AND t.language_code = 'en'";
			$sqlString.=" LIMIT 1";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":code" => $code
			));
			$resultSet = $stmt->fetchAll();
			foreach ($resultSet as $row) {
				$mesData = $row;
			}

		}

		return $mesData;

	}

	public function getOwnEmailOptions($userId)
	{

		$itemList=array();
		$sqlString="SELECT id, email_address";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email";
		$sqlString.=" WHERE user_id = :userId";
//		$sqlString.=" AND (status = 'verified')";
		$sqlString.=" AND (status = 'verified' OR status = 'accepted')";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $userId
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[($row['id'])] = $row['email_address'];
		}

		return $itemList;

	}

	public function getUserEmailOptions($userId)
	{

		$itemList=array();
		$sqlString="SELECT id, email_address";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email";
		$sqlString.=" WHERE user_id = :userId";
//		$sqlString.=" AND (status = 'verified')";
//		$sqlString.=" AND (status = 'verified' OR status = 'accepted')";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $userId
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[($row['id'])] = $row['email_address'];
		}

		return $itemList;

	}

	public function getUserOptions()
	{

		$itemList=array();
		$sqlString="SELECT id, username";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id != 0";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[($row['id'])] = $row['username'];
		}

		return $itemList;

	}

	public function getEmailDetails($id)
	{

		$itemDetails=array();
		$sqlString="SELECT e.id AS id, e.user_id AS user_id, e.status AS status, e.email_address AS email_address";
		$sqlString.=", e.mem_word_question AS mem_word_question, e.mem_word AS mem_word, e.comment AS comment";
		$sqlString.=", u.username AS username";
		$sqlString.=" FROM ".$this->tablePrefix."core_user u";
		$sqlString.=", ".$this->tablePrefix."mod_user_email e";
		$sqlString.=" WHERE e.id = :id";
		$sqlString.=" AND u.id = e.user_id";
		$sqlString.=" LIMIT 1";

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

	public function checkIfMainEmail($emailAddress)
	{

		$isMainEmail=false;

		$sqlString="SELECT count(*) as total";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE mail = :emailAddress";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":emailAddress" => $emailAddress
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$amount = $row['total'];
		}

		if($amount>0)
			$isMainEmail=true;

		return $isMainEmail;

	}

	public function checkIfHasContactForms($emailId)
	{

		$hasContactForms=false;

		$sqlString="SELECT count(*) as total";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_contact";
		$sqlString.=" WHERE email_id = :emailId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":emailId" => $emailId
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$amount = $row['total'];
		}

		if($amount>0)
			$hasContactForms=true;

		return $hasContactForms;

	}

	public function getPostalAddressDetails($id)
	{

		$itemDetails=array();
		$sqlString="SELECT user_id, country_code, postal_address";
		$sqlString.=", address_line1, address_line2, address_line3, address_line4";
		$sqlString.=", post_code, comment, title";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_postal";
		$sqlString.=" WHERE id = :id";
		$sqlString.=" LIMIT 1";

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

	public function deleteEmail($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_user_contact WHERE email_id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_user_email WHERE id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$delStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $delStatus;

	}

	public function deletePostalAddress($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_user_postal WHERE id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$delStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $delStatus;

	}

	public function getOwnContactList($userId,$paginator)
	{
		$itemList=array();
		$sqlString="SELECT c.id AS id, e.email_address AS email_address";
		$sqlString.=", c.name AS name";
		$sqlString.=", c.description AS description";
		$sqlString.=", c.status AS status";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_contact c";
		$sqlString.=", ".$this->tablePrefix."mod_user_email e";
		$sqlString.=" WHERE c.user_id = :userId";
		$sqlString.=" AND c.email_id = e.id";
		$sqlString.=" LIMIT ".$paginator->currentPage*$paginator->itemsOnPage.",".$paginator->itemsOnPage;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $userId
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getContactDetails($id)
	{

		$entryDetails=array();

		$sqlString="SELECT c.id AS id, c.name AS name, c.description AS description";
		$sqlString.=", c.email_id AS email_id, c.status AS status, c.user_id AS user_id";
		$sqlString.=", e.email_address AS email_address";
		$sqlString.=", u.username AS username";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_contact c";
		$sqlString.=", ".$this->tablePrefix."mod_user_email e";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=" WHERE c.id = :id";
		$sqlString.=" AND c.email_id = e.id";
		$sqlString.=" AND c.user_id = u.id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$entryDetails = $row;
		}

		return $entryDetails;

	}

	public function deleteContact($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_user_contact WHERE id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$delStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $delStatus;

	}

	public function getAccountDetails($id)
	{

		$itemDetails=array();
		$sqlString="SELECT cu.username AS username, cu.mail AS main_email";
		$sqlString.=", mu.first_name AS first_name, mu.middle_names AS middle_names, mu.last_name AS last_name";
		$sqlString.=", mu.company AS company, mu.phone1 AS phone1, mu.phone2 AS phone2";
		$sqlString.=", cu.password AS crypted_pw";
		$sqlString.=" FROM ".$this->tablePrefix."core_user cu";
		$sqlString.=", ".$this->tablePrefix."mod_user mu";
		$sqlString.=" WHERE cu.id = :id";
		$sqlString.=" AND cu.id = mu.user_id";
		$sqlString.=" LIMIT 1";

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

	public function checkModUserEntry($userId)
	{

		$modEntryId=0;
		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user";
		$sqlString.=" WHERE user_id = :userId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $userId
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$modEntryId = $row['id'];
		}

		return $modEntryId;

	}
	public function checkUpdateAccountDetails($id,$user,$email)
	{

		$modEntryId = $this->checkModUserEntry($id);

		if($modEntryId==0){
			$itemDetails=array();
			$sqlString="SELECT id, username, mail";
			$sqlString.=" FROM ".$this->tablePrefix."core_user";
			$sqlString.=" WHERE id = :id";
			$sqlString.=" LIMIT 1";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));
			$resultSet = $stmt->fetchAll();
			foreach ($resultSet as $row) {
				$userData = $row;
			}

			try {
				$this->dbId->beginTransaction();
					$user->id=$id;
					$email->userId=$id;

					$this->insertEmptyModUser($user);
					$email->emailAddress=$userData['mail'];
					$email->memWordQuestion="";
					$email->memWord="";
					$email->verifyingCode="";
					$email->status="created";
					$email->comment="";

					$emailId=$this->insertEmail($email);

				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}

		}

	}

	public function deleteAccount($id,$user,$delMethod)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_user_contact WHERE user_id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_user_postal WHERE user_id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_user_email WHERE user_id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_user WHERE user_id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_message WHERE sender_user_id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_message WHERE receiver_user_id = :id";
			$sqlString.=" AND type LIKE 'system-%'";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."core_user_role WHERE user_id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			if($delMethod=="delAll"){
				$sqlString="DELETE FROM ".$this->tablePrefix."core_user WHERE id = :id";
				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute(array(
					":id" => $id
				));

			}else{

				$sqlString="UPDATE ".$this->tablePrefix."core_user";
				$sqlString.=" SET username = 'Deleted user'";
				$sqlString.=", mail = ''";
				$sqlString.=", status = 1";
				$sqlString.=" WHERE id = :id";

				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute(array(
					":id" => $id
				));

				$sqlString="INSERT INTO ".$this->tablePrefix."core_user_role (";
				$sqlString.="user_id, role_id)";
				$sqlString.=" VALUES (";
				$sqlString.=(":id");
				$sqlString.=(", 2");
				$sqlString.=")";

				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute(array(
					":id" => $id,
				));

			}

			$delStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $delStatus;

	}

	public function checkEmail($email)
	{

		$id = 0;

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_email";
		$sqlString.=" WHERE email_address = '".$email."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$id = $row['id'];
		}

		return $id;

	}

	public function saveMessage($mesData)
	{

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_message (";
		$sqlString.="sender_user_id, sender_name, sender_email_address";
		$sqlString.=", receiver_user_id, receiver_contact_form_id, receiver_email_address";
		$sqlString.=", subject, time, content, ip_v4, type, language_code, comment)";
		$sqlString.=" VALUES (";
		$sqlString.=(":userId");
		$sqlString.=(", :senderName");
		$sqlString.=(", :senderEmail");
		$sqlString.=(", :receiverUserId");
		$sqlString.=(", :receiverContactId");
		$sqlString.=(", :receiverEmail");
		$sqlString.=(", :subject");
		$sqlString.=(", :time");
		$sqlString.=(", :content");
		$sqlString.=(", :ip_v4");
		$sqlString.=(", :type");
		$sqlString.=(", :langCode");
		$sqlString.=(", :comment");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":userId" => $mesData['userId'],
			":senderName" => $mesData['sender']['name'],
			":senderEmail" => $mesData['sender']['email'],
			":receiverUserId" => $mesData['receiverUserId'],
			":receiverContactId" => $mesData['receiver']['contactId'],
			":receiverEmail" => $mesData['receiver']['email'],
			":subject" => $mesData['message']['subject'],
			":time" => $mesData['time'],
			":content" => $mesData['message']['content']['html'],
			":ip_v4" => $mesData['ip_v4'],
			":type" => $mesData['type'],
			":langCode" => $GLOBALS['langCode'],
			":comment" => $mesData['comment']
		));

	}

	public function getUserId($contactFormId)
	{

		$userId = 0;

		$sqlString="SELECT user_id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_user_contact";
		$sqlString.=" WHERE id = :id";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $contactFormId
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$userId = $row['user_id'];
		}

		return $userId;

	}

}
