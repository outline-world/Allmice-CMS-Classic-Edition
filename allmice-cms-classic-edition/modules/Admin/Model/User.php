<?php

class User
{

	public $id;

	public $eMail;
	public $password;
	public $cryptedPw;
	public $username;
	public $userStatus;
	public $mainRole;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->eMail = (isset($data['eMail'])) ? $data['eMail'] : null;
		$this->password = (isset($data['password'])) ? $data['password'] : null;
		$this->username = (isset($data['username'])) ? $data['username'] : null;
		$this->userStatus = (isset($data['userStatus'])) ? $data['userStatus'] : null;
		$this->mainRole = (isset($data['mainRole'])) ? $data['mainRole'] : null;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->eMail = (isset($data['mail'])) ? $data['mail'] : null;
		$this->password = (isset($data['password'])) ? $data['password'] : null;
		$this->username = (isset($data['username'])) ? $data['username'] : null;
		$this->userStatus = (isset($data['status'])) ? $data['status'] : null;
		$this->mainRole = (isset($data['active_role_id'])) ? $data['active_role_id'] : null;

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

}
