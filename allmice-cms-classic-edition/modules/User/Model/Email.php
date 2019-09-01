<?php

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

		$auth['host']=$mesData['auth']['host'];
		$auth['port']=$mesData['auth']['port'];
		$auth['username']=$mesData['auth']['username'];
		$auth['password']=$mesData['auth']['password'];

		date_default_timezone_set($mesData['timezone']);

		$subject=$mesData['message']['subject'];
		$contentHtml=$mesData['message']['content']['html'];
		$contentPlain=$mesData['message']['content']['plain'];

		require("modules/Message/config/vendor/PHPMailer/PHPMailerAutoload.php");

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

			$mail->WordWrap = 50;

			$mail->IsHTML(true);

			$mail->Subject = $subject;
$mail->msgHTML($contentHtml);
			$mail->AltBody = $contentPlain;

			if(!$mail->send())
			{
				$resMes="Message could not be sent. There is some PHPMailer error.";
			}else{
				$resMes="Message has been sent.";
			}

		} catch (phpmailerException $e) {

			$resMes="Message could not be sent. There is some PHPMailer configuration problem.";

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

}
