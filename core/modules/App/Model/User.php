<?php
class User
{

	public $id;

	public $eMail;
	public $password;
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
		$this->mainRole = (isset($data['main_role_id'])) ? $data['main_role_id'] : null;

	}

}
