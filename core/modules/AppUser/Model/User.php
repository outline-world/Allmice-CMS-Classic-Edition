<?php

class User
{

	public $id;

	public $eMail;
	public $password;
	public $username;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->eMail = (isset($data['eMail'])) ? $data['eMail'] : null;
		$this->password = (isset($data['password'])) ? $data['password'] : null;
		$this->username = (isset($data['username'])) ? $data['username'] : null;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->eMail = (isset($data['mail'])) ? $data['mail'] : null;
		$this->password = (isset($data['password'])) ? $data['password'] : null;
		$this->username = (isset($data['username'])) ? $data['username'] : null;

	}

}
