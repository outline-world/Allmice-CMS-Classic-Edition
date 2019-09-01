<?php

class SignUp
{

	public $id;
	public $userId;
	public $countryCode;
	public $firstName;
	public $middleNames;
	public $lastName;

	public $company;
	public $phone1;
	public $phone2;
	public $postalAddress;

	public $addressLine1;
	public $addressLine2;
	public $addressLine3;
	public $addressLine4;

	public $postCode;

	public $comment;
	public $title;

	function generateRandomString($length = 30) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function getRandomString($length = 16) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function sendMessage($mesData)
	{

		$auth['host']=$mesData['auth']['host'];
		$auth['port']=$mesData['auth']['port'];
		$auth['username']=$mesData['auth']['username'];
		$auth['password']=$mesData['auth']['password'];

		$receiver['email']=$mesData['receiver']['email'];
		$receiver['name']=$mesData['receiver']['name'];

		$sender=$mesData['sender'];

		date_default_timezone_set('Europe/London');

		require("modules/User/config/vendor/PHPMailer/PHPMailerAutoload.php");

		$mail = new PHPMailer();

		$mail->Host = $auth['host'];

		if(isset($auth['port']) && $auth['port']==587){

			$mail->Port = $auth['port'];

			$mail->SMTPSecure = 'tls';

		}

		$mail->SMTPAuth = true;     

		$mail->Username = $auth['username'];  
		$mail->Password = $auth['password']; 

		$mail->From = $sender['email'];

		$mail->AddAddress($receiver['email'], $receiver['name']);

		$mail->WordWrap = 50;

		$mail->IsHTML(true);

		$mail->Subject = $mesData['content']['subject'];
		$mail->Body    = $mesData['content']['message'];
		$mail->AltBody = $mesData['content']['plain'];

		$resMes="";

		if(!$mail->send())
		{
			$resMes="Message could not be sent."." Mailer Error: " . $mail->ErrorInfo;
		}else{
			$resMes="Message has been sent";
		}

	    return $resMes;

	}

	public function setEmptyValues()
	{

		$this->id = 0;

		$this->userId = 0;
		$this->countryCode = "";
		$this->firstName = "";
		$this->middleNames = "";
		$this->lastName = "";
		$this->company = "";
		$this->phone1 = "";
		$this->phone2 = "";

		$this->postalAddress = "";
		$this->addressLine1 = "";
		$this->addressLine2 = "";
		$this->addressLine3 = "";
		$this->addressLine4 = "";
		$this->postCode = "";

		$this->comment = "";
		$this->type = "";

	}

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;

		$this->userId = (isset($data['userId'])) ? $data['userId'] : 0;
		$this->countryCode = (isset($data['country'])) ? $data['country'] : "";
		$this->firstName = (isset($data['firstName'])) ? $data['firstName'] : "";
		$this->middleNames = (isset($data['middleNames'])) ? $data['middleNames'] : "";
		$this->lastName = (isset($data['lastName'])) ? $data['lastName'] : "";
		$this->company = (isset($data['company'])) ? $data['company'] : "";
		$this->phone1 = (isset($data['phone1'])) ? $data['phone1'] : "";
		$this->phone2 = (isset($data['phone2'])) ? $data['phone2'] : "";

		$this->postalAddress = (isset($data['postalAddress'])) ? $data['postalAddress'] : "";
		$this->addressLine1 = (isset($data['addressLine1'])) ? $data['addressLine1'] : "";
		$this->addressLine2 = (isset($data['addressLine2'])) ? $data['addressLine2'] : "";
		$this->addressLine3 = (isset($data['addressLine3'])) ? $data['addressLine3'] : "";
		$this->addressLine4 = (isset($data['addressLine4'])) ? $data['addressLine4'] : "";
		$this->postCode = (isset($data['postCode'])) ? $data['postCode'] : "";

		$this->comment = (isset($data['comment'])) ? $data['comment'] : "";
		$this->title = (isset($data['title'])) ? $data['title'] : "";

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;

		$this->userId = (isset($data['user_id'])) ? $data['user_id'] : 0;
		$this->countryCode = (isset($data['country_code'])) ? $data['country_code'] : "";
		$this->firstName = (isset($data['first_name'])) ? $data['first_name'] : "";
		$this->middleNames = (isset($data['middle_names'])) ? $data['middle_names'] : "";
		$this->lastName = (isset($data['last_name'])) ? $data['last_name'] : "";
		$this->company = (isset($data['company'])) ? $data['company'] : "";
		$this->phone1 = (isset($data['phone1'])) ? $data['phone1'] : "";
		$this->phone2 = (isset($data['phone2'])) ? $data['phone2'] : "";

		$this->postalAddress = (isset($data['postal_address'])) ? $data['postal_address'] : "";
		$this->addressLine1 = (isset($data['address_line1'])) ? $data['address_line1'] : "";
		$this->addressLine2 = (isset($data['address_line2'])) ? $data['address_line2'] : "";
		$this->addressLine3 = (isset($data['address_line3'])) ? $data['address_line3'] : "";
		$this->addressLine4 = (isset($data['address_line4'])) ? $data['address_line4'] : "";
		$this->postCode = (isset($data['post_code'])) ? $data['post_code'] : "";

		$this->comment = (isset($data['comment'])) ? $data['comment'] : "";
		$this->title = (isset($data['title'])) ? $data['title'] : "";

	}

}
