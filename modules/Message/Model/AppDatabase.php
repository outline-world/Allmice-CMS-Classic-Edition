<?php
class AppDatabase extends DatabaseCms
{

	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;

	public function __construct($dbData)	
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getTemplateList($whereClause)
	{
		$itemList=array();
		$sqlString="SELECT id";
		$sqlString.=", code";
		$sqlString.=", subject";
		$sqlString.=", module";
		$sqlString.=", type";
		$sqlString.=", language_code";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message_template";

		$sqlString.=" ORDER BY code, subject";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getTemplateDetails($id)
	{
		$itemDetails=array();
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message_template";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
				":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function insertTemplate($template)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_message_template (code, module, type";
		$sqlString.=", subject";
		$sqlString.=", content_html";
		$sqlString.=", content_plain";
		$sqlString.=", language_code)";
		$sqlString.=" VALUES (";
		$sqlString.=":code";
		$sqlString.=", :module";
		$sqlString.=", :type";
		$sqlString.=", :subject";
		$sqlString.=", :contentHtml";
		$sqlString.=", :contentPlain";
		$sqlString.=", :language";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":code" => $template->code,
			":module" => $template->module,
			":type" => $template->type,
			":subject" => $template->subject,
			":contentHtml" => $template->contentHtml,
			":contentPlain" => $template->contentPlain,
			":language" => $template->language,
		));

		$id=$this->dbId->lastInsertId();
		return $id;

	}

	public function updateTemplate($template)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_message_template";
		$sqlString.=" SET ";
		$sqlString.=("code = :code");
		$sqlString.=(", module = :module");
		$sqlString.=(", type = :type");
		$sqlString.=(", subject = :subject");
		$sqlString.=(", content_html = :contentHtml");
		$sqlString.=(", content_plain = :contentPlain");
		$sqlString.=(", language_code = :language");
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":code" => $template->code,
			":module" => $template->module,
			":type" => $template->type,
			":subject" => $template->subject,
			":contentHtml" => $template->contentHtml,
			":contentPlain" => $template->contentPlain,
			":id" => $template->id,
			":language" => $template->language,
		));

	}

	public function saveTemplate($template)
	{
		$id = (int)$template->id;

		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertTemplate($template);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();

			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$id=$this->updateTemplate($template);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function deleteTemplate($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_message_template WHERE id = :id";

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

	public function getMessageList($whereClause)
	{
		$itemList=array();
		$sqlString="SELECT id";
		$sqlString.=", subject";
		$sqlString.=", time";
		$sqlString.=", type";
		$sqlString.=", sender_name";
		$sqlString.=", receiver_user_id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY time, subject";

		$whereClause=" WHERE m.receiver_user_id = u.id";

		$itemList=array();
		$sqlString="SELECT m.id AS id";
		$sqlString.=", m.subject AS subject";
		$sqlString.=", m.time AS time";
		$sqlString.=", m.sender_name AS senderName";
		$sqlString.=", m.status_for_sender AS statusForSender";
		$sqlString.=", m.status_for_receiver AS statusForReceiver";
		$sqlString.=", m.type AS type";
		$sqlString.=", m.receiver_name AS receiverName";
		$sqlString.=", u.username AS recipientName";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message m";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY u.username, m.time, m.subject";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {

			if(!isset($row['receiverName']) || $row['receiverName']==""){

				$row['receiverName']=$row['recipientName'];
			}else{
				$row['recipientName']=$row['receiverName'];
			}

			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getMessageInList($whereClause)
	{
		$itemList=array();
		$sqlString="SELECT id";
		$sqlString.=", subject";
		$sqlString.=", time";
		$sqlString.=", type";
		$sqlString.=", sender_name";
		$sqlString.=", receiver_user_id";
		$sqlString.=", sender_user_id";
		$sqlString.=", status_for_receiver AS statusForReceiver";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY time, subject";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {

			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getMessageOutList($whereClause)
	{
		$itemList=array();
		$sqlString="SELECT m.id AS id";
		$sqlString.=", m.subject AS subject";
		$sqlString.=", m.time AS time";
		$sqlString.=", m.sender_name AS senderName";
		$sqlString.=", m.type AS type";
		$sqlString.=", m.receiver_name AS receiverName";
		$sqlString.=", u.username AS recipientName";
		$sqlString.=", m.status_for_sender AS statusForSender";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message m";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY time, subject";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			if(!isset($row['receiverName']) || $row['receiverName']==""){

				$row['receiverName']=$row['recipientName'];
			}else{
				$row['recipientName']=$row['receiverName'];
			}
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getMessageDetails($whereClause)
	{

		$mesData=array();

		$sqlString="SELECT m.id AS id";
		$sqlString.=", m.subject AS subject";
		$sqlString.=", m.time AS time";
		$sqlString.=", m.sender_name AS senderName";
		$sqlString.=", m.type AS type";
		$sqlString.=", m.content AS content";
		$sqlString.=", m.sender_user_id AS senderId";
		$sqlString.=", m.receiver_user_id AS receiverId";
		$sqlString.=", m.status_for_receiver AS statusForReceiver";
		$sqlString.=", m.status_for_sender AS statusForSender";
		$sqlString.=", m.receiver_name AS receiverName";
		$sqlString.=", u.username AS recipientName";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message m";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=$whereClause;
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$mesData = $row;
		}

		return $mesData;

	}

	public function insertMessage($message)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_message (";
		$sqlString.="sender_user_id";
		$sqlString.=", sender_name";
		$sqlString.=", sender_email_address";
		$sqlString.=", receiver_user_id";
		$sqlString.=", receiver_name";
		$sqlString.=", receiver_email_address";
		$sqlString.=", subject";
		$sqlString.=", time";
		$sqlString.=", content";
		$sqlString.=", status_for_sender";
		$sqlString.=", status_for_receiver";
		$sqlString.=", ip_v4";
		$sqlString.=", type";
		$sqlString.=", language_code";
		$sqlString.=", parent_id";
		$sqlString.=")";
		$sqlString.=" VALUES (";
		$sqlString.=(":senderUserId");
		$sqlString.=(", :senderName");
		$sqlString.=(", :senderEmailAddress");
		$sqlString.=(", :receiverUserId");
		$sqlString.=(", :receiverName");
		$sqlString.=(", :receiverEmailAddress");
		$sqlString.=(", :subject");
		$sqlString.=(", :time");
		$sqlString.=(", :content");
		$sqlString.=(", :statusForSender");
		$sqlString.=(", :statusForReceiver");
		$sqlString.=(", :ipv4");
		$sqlString.=(", :type");
		$sqlString.=(", :langCode");
		$sqlString.=(", :parentId");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":senderUserId" => $message->senderId,
			":senderName" => $message->senderName,
			":senderEmailAddress" => $message->senderEmail,
			":receiverUserId" => $message->receiverId,
			":receiverName" => $message->receiverName,
			":receiverEmailAddress" => $message->receiverEmail,
			":subject" => $message->subject,
			":time" => $message->time,
			":content" => $message->content,
			":statusForSender" => $message->statusForSender,
			":statusForReceiver" => $message->statusForReceiver,
			":ipv4" => $message->ipv4,
			":type" => $message->type,
			":langCode" => $GLOBALS['langCode'],
			":parentId" => $message->parentId
		));
		$id=$this->dbId->lastInsertId();

		return $id;
	}

	public function updateMessage($message)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_message";
		$sqlString.=" SET ";
		$sqlString.="sender_email_address = :senderEmailAddress";
		$sqlString.=", receiver_user_id = :receiverUserId";
		$sqlString.=", receiver_name = :receiverName";
		$sqlString.=", receiver_email_address = :receiverEmailAddress";
		$sqlString.=", subject = :subject";
		$sqlString.=", time = :time";
		$sqlString.=", content = :content";
		$sqlString.=", status_for_sender = :statusForSender";
		$sqlString.=", status_for_receiver = :statusForReceiver";
		$sqlString.=", ip_v4 = :ipv4";
		$sqlString.=", language_code = :langCode";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":senderEmailAddress" => $message->senderEmail,
			":receiverUserId" => $message->receiverId,
			":receiverName" => $message->receiverName,
			":receiverEmailAddress" => $message->receiverEmail,
			":subject" => $message->subject,
			":time" => $message->time,
			":content" => $message->content,
			":statusForSender" => $message->statusForSender,
			":statusForReceiver" => $message->statusForReceiver,
			":ipv4" => $message->ipv4,
			":langCode" => $GLOBALS['langCode'],
			":id" => $message->id
		));

	}

	public function saveMessage($message)
	{
		$id = (int)$message->id;

		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertMessage($message);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateMessage($message);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

		return $id;

	}

	public function checkRecipient($recipientName, $senderData)
	{

		$recipientId=0;
		$dataSet=array();

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE username = '".$recipientName."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$recipientId = $row['id'];
		}

		$blString="";
		$sqlString="SELECT value";
		$sqlString.=" FROM ".$this->tablePrefix."core_misc_data";
		$sqlString.=" WHERE integer_value = ".$recipientId;
		$sqlString.=" AND module_name = 'Message'";
		$sqlString.=" AND uri = 'userBlockingList'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$blString = $row['value'];
		}

		if($blString!=""){
			$dataSet=unserialize($blString);
		}

		if(in_array($senderData,$dataSet))
			$recipientId=0;

		return $recipientId;

	}

	public function getBlockingList($userId)
	{
		$dataSet=array();
		$valueString="";

		$sqlString="SELECT value";
		$sqlString.=" FROM ".$this->tablePrefix."core_misc_data ";
		$sqlString.=" WHERE integer_value = ".$userId;
		$sqlString.=" AND module_name = 'Message'";
		$sqlString.=" AND uri = 'userBlockingList'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$valueString = $row['value'];
		}

		if($valueString!=""){
			$dataSet=unserialize($valueString);
		}

		return $dataSet;

	}

	public function getUserId($username)
	{

		$userId=0;

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE username = '".$username."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$userId = $row['id'];
		}

		return $userId;
	}

	public function insertBlockingList($curUserId, $dataList)
	{

		$valueString=serialize($dataList);

		$sqlString="INSERT INTO ".$this->tablePrefix."core_misc_data (uri";
		$sqlString.=", value";
		$sqlString.=", integer_value";
		$sqlString.=", module_name";
		$sqlString.=", type)";
		$sqlString.=" VALUES (";
		$sqlString.="'userBlockingList'";
		$sqlString.=", :value";
		$sqlString.=", :userId";
		$sqlString.=", 'Message'";
		$sqlString.=", 'User'";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":value" => $valueString,
			":userId" => $curUserId
		));

	}

	public function updateBlockingList($curUserId, $dataList)
	{

		$valueString=serialize($dataList);
		$sqlString="UPDATE ".$this->tablePrefix."core_misc_data";
		$sqlString.=" SET ";
		$sqlString.="value = :value";
		$sqlString.=" WHERE integer_value = :userId";
		$sqlString.=" AND module_name = 'Message'";
		$sqlString.=" AND uri = 'userBlockingList'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":value" => $valueString,
			":userId" => $curUserId
		));

	}

	public function deleteBlockingList($userId)
	{

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."core_misc_data";
			$sqlString.=" WHERE integer_value = :userId";
			$sqlString.=" AND module_name = 'Message'";
			$sqlString.=" AND uri = 'userBlockingList'";

			$stmt = $this->dbId->prepare($sqlString);

			$stmt->execute(array(
				":userId" => $userId
			));

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function getActiveEmail($userId)
	{

		$email="";

		$sqlString="SELECT mail";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id = ".$userId."";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$email = $row['mail'];
		}

		return $email;
	}

	public function getParentId($messageId)
	{

		$parentId = 0;

		$sqlString="SELECT parent_id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message";
		$sqlString.=" WHERE id = :messageId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":messageId" => $messageId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$parentId = $row['parent_id'];
		}

		if($parentId==0)
			$parentId=$messageId;
		return $parentId;

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
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$messageData[($row['type'])][($row['uri'])] = $row['value'];
		}

		$GLOBALS['emailDkim']=$messageData['emailDkim'];
		$GLOBALS['emailEncoding']=$messageData['emailEncoding'];

		return $messageData;

	}

	public function getMesTemplate($code)
	{
		$mesData=array();

		$sqlString="SELECT t.id AS id, t.subject AS subject, t.content_html AS content_html, t.content_plain AS content_plain";
		$sqlString.=" FROM ".$this->tablePrefix."mod_message_template t";
		$sqlString.=" WHERE t.module = 'Message'";
		$sqlString.=" AND t.code = :code";
		$sqlString.=" AND t.language_code = :langCode";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":code" => $code,
			":langCode" => $GLOBALS['langCode']
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$mesData = $row;
			}

		}

		return $mesData;

	}

	public function markMessageSent($message)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_message";
		$sqlString.=" SET ";
		$sqlString.="sender_email_address = :senderEmailAddress";
		$sqlString.=", receiver_email_address = :receiverEmailAddress";
		$sqlString.=", status_for_sender = :statusForSender";
		$sqlString.=", status_for_receiver = :statusForReceiver";
		$sqlString.=", ip_v4 = :ipv4";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":senderEmailAddress" => $message->senderEmail,
			":receiverEmailAddress" => $message->receiverEmail,
			":statusForSender" => $message->statusForSender,
			":statusForReceiver" => $message->statusForReceiver,
			":ipv4" => $message->ipv4,
			":id" => $message->id
		));

	}

	public function markMessageDeleted($message)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_message";
		$sqlString.=" SET ";
		$sqlString.="status_for_sender = :statusForSender";
		$sqlString.=", status_for_receiver = :statusForReceiver";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":statusForSender" => $message->statusForSender,
			":statusForReceiver" => $message->statusForReceiver,
			":id" => $message->id
		));

	}

	public function deleteMessage($mesId)
	{

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_message";
			$sqlString.=" WHERE id = :mesId";

			$stmt = $this->dbId->prepare($sqlString);

			$stmt->execute(array(
				":mesId" => $mesId
			));

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function changeStatus4Receiver($mesId, $status)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_message";
		$sqlString.=" SET ";
		$sqlString.="status_for_receiver = :statusForReceiver";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":statusForReceiver" => $status,
			":id" => $mesId
		));

	}

}
