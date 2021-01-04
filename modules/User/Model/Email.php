<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'modules/Message/config/vendor/PHPMailer/src/Exception.php';
	require 'modules/Message/config/vendor/PHPMailer/src/PHPMailer.php';
	require 'modules/Message/config/vendor/PHPMailer/src/SMTP.php';

class Email
{

	public $id;
	public $userId;
	public $emailAddress;
	public $memWordQuestion;
	public $memWord;
	public $verifyingCode;
	public $status;
	public $comment;
	public $username;

	function generateRandomString($length = 30) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function setVerifyingCode($verCodeList) {

		$this->verifyingCode="";
		for($i=0;$i<3;$i++){
			$verCode=$this->generateRandomString(30);
			if(!in_array($verCode,$verCodeList)){
				$i=4;
				$this->verifyingCode=$verCode;
			}
		}

	}

	public function getMesData($receiverData, $authData, $appDb, $mesCode)
	{
		$mesData=array();

			$mesTemplate=$appDb->getMesTemplate($mesCode);

			$mesSubject=$mesTemplate['subject'];
			$mesContentHtml=$mesTemplate['content_html'];
			$mesContentPlain=$mesTemplate['content_plain'];

			$senderData['email']=$authData['username'];

			$senderData['name']=$_SESSION[($GLOBALS['siteId'])]['userData']['name'];
			$replyData['email']=$authData['username'];
			$replyData['name']=$GLOBALS['siteName'];

			$mesData['auth']=$authData;
			$mesData['receiver']=$receiverData;
			$mesData['sender']=$senderData;
			$mesData['reply']=$replyData;

			if($mesCode=='verifyEmail'){
				$activationLink=$GLOBALS['baseUrl']."/user/verify-email/".$this->verifyingCode;
				$activationLinkHtml="<a href=\"".$activationLink."\">".$activationLink."</a>";

				$mesContentHtml=str_replace("[activationLink]",$activationLinkHtml,$mesContentHtml);
				$mesContentPlain=str_replace("[activationLink]",$activationLink,$mesContentPlain);
			}

			$mesSubject=str_replace("[websiteName]","\"".$GLOBALS['siteName']."\"",$mesSubject);
			$mesContentHtml=str_replace("[websiteName]","\"".$GLOBALS['siteName']."\"",$mesContentHtml);
			$mesContentPlain=str_replace("[websiteName]","\"".$GLOBALS['siteName']."\"",$mesContentPlain);

			$mesSubject=str_replace("[username]",$this->username,$mesSubject);
			$mesContentHtml=str_replace("[username]",$this->username,$mesContentHtml);
			$mesContentPlain=str_replace("[username]",$this->username,$mesContentPlain);

			$mesContentHtml=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$mesContentHtml);
			$mesContentPlain=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$mesContentPlain);

			$contactLink=$GLOBALS['baseUrl']."/user/contact-form/1";
			$contactLinkHtml="<a href=\"".$contactLink."\">".$contactLink."</a>";
			$mesContentHtml=str_replace("[contactLink]",$contactLink,$mesContentHtml);
			$mesContentPlain=str_replace("[contactLink]",$contactLink,$mesContentPlain);

			$mesContentHtml=str_replace("&amp;#39;","'",$mesContentHtml);
			$mesContentPlain=str_replace("&amp;#39;","'",$mesContentPlain);

			$mesContentHtml=str_replace("\n","<br />\n",$mesContentHtml);

			$mesData['message']['subject']=$mesSubject;
			$mesData['message']['content']['html']=$mesContentHtml;
			$mesData['message']['content']['plain']=$mesContentPlain;

		return $mesData;
	}

	public function replaceTokens($mesData, $tokenSet)
	{

		$mesContentHtml=$mesData['message']['content']['html'];
		$mesContentPlain=$mesData['message']['content']['plain'];

		$mesContentPlain=str_replace("[guestName]",$tokenSet['guestName'],$mesContentPlain);
		$mesContentPlain=str_replace("[guestEmail]",$tokenSet['guestEmail'],$mesContentPlain);
		$mesContentPlain=str_replace("[memberContactId]",$tokenSet['memberContactId'],$mesContentPlain);
		$mesContentPlain=str_replace("[contactForm]",$tokenSet['contactForm'],$mesContentPlain);
		$mesContentPlain=str_replace("[editContactForm]",$tokenSet['editContactForm'],$mesContentPlain);
		$mesContentPlain=str_replace("[myContactId]",$tokenSet['myContactId'],$mesContentPlain);

		$mesContentHtml=str_replace("[guestName]",$tokenSet['guestName'],$mesContentHtml);
		$mesContentHtml=str_replace("[guestEmail]",$tokenSet['guestEmail'],$mesContentHtml);
		$mesContentHtml=str_replace("[memberContactId]",$tokenSet['memberContactId'],$mesContentHtml);
		$mesContentHtml=str_replace("[contactForm]",$tokenSet['contactForm'],$mesContentHtml);
		$mesContentHtml=str_replace("[editContactForm]",$tokenSet['editContactForm'],$mesContentHtml);
		$mesContentHtml=str_replace("[myContactId]",$tokenSet['myContactId'],$mesContentHtml);

			$mesContentHtml=str_replace("\n","<br />\n",$mesContentHtml);

		$mesData['message']['content']['html']=$mesContentHtml;
		$mesData['message']['content']['plain']=$mesContentPlain;

		return $mesData;
	}

	public function sendMessage($mesData)
	{

		$lang=$this->getPhrases('sendMessage');

		$auth['host']=$mesData['auth']['host'];
		$auth['port']=$mesData['auth']['port'];
		$auth['username']=$mesData['auth']['username'];
		$auth['password']=$mesData['auth']['password'];

		date_default_timezone_set($mesData['timezone']);

		$subject=$mesData['message']['subject'];
		$contentHtml=$mesData['message']['content']['html'];
		$contentPlain=$mesData['message']['content']['plain'];

		$mail = new PHPMailer();

		$resMes="";

		try {

			$mail->isSMTP();

			$mail->Host = $auth['host'];

			if(isset($auth['port']) && $auth['port']==587){

				$mail->Port = $auth['port'];

				$mail->SMTPSecure = 'tls';

			}

			$mail->SMTPAuth = true;     

			$mail->Username = $auth['username'];  
			$mail->Password = $auth['password']; 

			$mail->setFrom($mesData['sender']['email'], $mesData['sender']['name']);

			$mail->AddAddress($mesData['receiver']['email'], $mesData['receiver']['name']);

//			$mail->WordWrap = 50;

			$mail->IsHTML(true);

			$mail->Subject = $subject;
//$mail->msgHTML($contentHtml);
			$mail->Body = $contentHtml;

			$mail->AltBody = $contentPlain;

			$mail->CharSet = $GLOBALS['emailEncoding']['charSet'];
			$mail->Encoding = $GLOBALS['emailEncoding']['binaryToText'];

			if($GLOBALS['emailDkim']['domainName']!=""){
				$mail->DKIM_domain = $GLOBALS['emailDkim']['domainName'];
				//$mail->DKIM_private = dirname(__FILE__).’/key.private’; // Make sure to protect the key from being publicly accessible!
				$mail->DKIM_private = $GLOBALS['emailDkim']['privateKeyPath'];
				$mail->DKIM_selector = $GLOBALS['emailDkim']['selector'];
				$mail->DKIM_passphrase = $GLOBALS['emailDkim']['passphrase'];

				if($GLOBALS['emailDkim']['identity']=="")
					$mail->DKIM_identity = $mail->From;
				else
					$mail->DKIM_identity = $GLOBALS['emailDkim']['identity'];
			}

			if(!$mail->send())
			{
				$resMes=$lang['error'];
			}else{
				$resMes=$lang['messageSent'];
			}

		} catch (phpmailerException $e) {

			$resMes=$lang['confProblem'];

		}

		return $resMes;

	}

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->userId = (isset($data['userId'])) ? $data['userId'] : 0;

		$this->emailAddress = (isset($data['emailAddress'])) ? $data['emailAddress'] : "";

		$this->memWordQuestion = (isset($data['memWordQuestion'])) ? $data['memWordQuestion'] : "";
		$this->memWord = (isset($data['memWord'])) ? $data['memWord'] : "";
		$this->verifyingCode = (isset($data['verifyingCode'])) ? $data['verifyingCode'] : "";

		$this->status = (isset($data['status'])) ? $data['status'] : "";
		$this->comment = (isset($data['comment'])) ? $data['comment'] : "";
		$this->username = (isset($data['username'])) ? $data['username'] : "";

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->userId = (isset($data['user_id'])) ? $data['user_id'] : 0;

		$this->emailAddress = (isset($data['email_address'])) ? $data['email_address'] : "";

		$this->memWordQuestion = (isset($data['mem_word_question'])) ? $data['mem_word_question'] : "";
		$this->memWord = (isset($data['mem_word'])) ? $data['mem_word'] : "";
		$this->verifyingCode = (isset($data['verifying_code'])) ? $data['verifying_code'] : "";

		$this->status = (isset($data['status'])) ? $data['status'] : "";
		$this->comment = (isset($data['comment'])) ? $data['comment'] : "";
		$this->username = (isset($data['username'])) ? $data['username'] : "";

	}

	public function getIP() { 
		$ip; 
		if (getenv("HTTP_CLIENT_IP")) 
			$ip = getenv("HTTP_CLIENT_IP"); 
		else if(getenv("HTTP_X_FORWARDED_FOR")) 
			$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if(getenv("REMOTE_ADDR")) 
			$ip = getenv("REMOTE_ADDR"); 
		else 
			$ip = "UNKNOWN";
		return $ip; 
	}


	public function getConfigData($whereClauseEnd)
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'Message'";
		if($whereClauseEnd!="")
			$sqlString.=$whereClauseEnd;

//echo $sqlString;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$configData[($row['uri'])] = $row['value'];
		}

		return $configData;

	}

	public function getPhrases($specName)
	{

		$dbId=$GLOBALS['db']['id'];
		$tablePrefix=$GLOBALS['db']['tablePrefix'];

		$langData=array();

		$sqlString="SELECT uri, text";
		$sqlString.=" FROM ".$tablePrefix."core_language";
		$sqlString.=" WHERE module_name = 'Message'";
		if($specName!="")
			$sqlString.=" AND specific_name LIKE '".$specName."'";

		$stmt = $dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$langData[($row['uri'])] = $row['text'];
		}

		return $langData;

	}

}
