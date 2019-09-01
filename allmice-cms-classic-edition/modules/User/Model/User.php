<?php

class User
{

	public $id;

	public $email;
	public $mainEmail;
	public $emailId;
	public $password;
	public $password2;
	public $cryptedPw;
	public $username;
	public $mainRole;

	public $firstName;
	public $middleNames;
	public $lastName;

	public $company;
	public $phone1;
	public $phone2;

	function getRandomString($length = 16) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->emailId = (isset($data['emailId'])) ? $data['emailId'] : 0;

		$this->email = (isset($data['email'])) ? $data['email'] : "";
		$this->mainEmail = (isset($data['mainEmail'])) ? $data['mainEmail'] : "";
		$this->password = (isset($data['password'])) ? $data['password'] : "";
		$this->cryptedPw = (isset($data['cryptedPw'])) ? $data['cryptedPw'] : "";
		$this->username = (isset($data['username'])) ? $data['username'] : "";
		$this->mainRole = (isset($data['mainRole'])) ? $data['mainRole'] : "";

		$this->firstName = (isset($data['firstName'])) ? $data['firstName'] : "";
		$this->middleNames = (isset($data['middleNames'])) ? $data['middleNames'] : "";
		$this->lastName = (isset($data['lastName'])) ? $data['lastName'] : "";

		$this->company = (isset($data['company'])) ? $data['company'] : "";
		$this->phone1 = (isset($data['phone1'])) ? $data['phone1'] : "";
		$this->phone2 = (isset($data['phone2'])) ? $data['phone2'] : "";

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->emailId = (isset($data['email_id'])) ? $data['email_id'] : 0;

		$this->email = (isset($data['email_address'])) ? $data['email_address'] : "";
		$this->mainEmail = (isset($data['main_email'])) ? $data['main_email'] : "";
		$this->password = (isset($data['password'])) ? $data['password'] : "";
		$this->cryptedPw = (isset($data['crypted_pw'])) ? $data['crypted_pw'] : "";
		$this->username = (isset($data['username'])) ? $data['username'] : "";

		$this->firstName = (isset($data['first_name'])) ? $data['first_name'] : "";
		$this->middleNames = (isset($data['middle_names'])) ? $data['middle_names'] : "";
		$this->lastName = (isset($data['last_name'])) ? $data['last_name'] : "";

		$this->company = (isset($data['company'])) ? $data['company'] : "";
		$this->phone1 = (isset($data['phone1'])) ? $data['phone1'] : "";
		$this->phone2 = (isset($data['phone2'])) ? $data['phone2'] : "";

	}

}
