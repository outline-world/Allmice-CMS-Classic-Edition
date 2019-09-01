<?php

class Contact
{

	public $id;
	public $userId;
	public $emailId;
	public $contactName;
	public $description;
	public $status;
	public $emailAddress;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->userId = (isset($data['userId'])) ? $data['userId'] : 0;
		$this->emailId = (isset($data['emailId'])) ? $data['emailId'] : 0;

		$this->contactName = (isset($data['contactName'])) ? $data['contactName'] : "";
		$this->description = (isset($data['description'])) ? $data['description'] : "";
		$this->emailAddress = (isset($data['emailAddress'])) ? $data['emailAddress'] : "";

		if(isset($data['status']) && $data['status']==1)
			$this->status = "active";
		else
			$this->status = "passive";

	}

	public function convertFormData2($data,$dbData)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->userId = (isset($data['userId'])) ? $data['userId'] : $dbData['user_id'];
		$this->emailId = (isset($data['emailId'])) ? $data['emailId'] : $dbData['email_id'];

		$this->contactName = (isset($data['contactName'])) ? $data['contactName'] : $dbData['name'];
		$this->description = (isset($data['description'])) ? $data['description'] : $dbData['description'];
		$this->emailAddress = (isset($data['emailAddress'])) ? $data['emailAddress'] : $dbData['email_address'];

		if(isset($data['status']) && $data['status']==1)
			$this->status = "active";
		elseif(isset($data['status']) && $data['status']==0)
			$this->status = "passive";
		else
			$this->status = $dbData['status'];

	}

	public function convertDefaultData($defaultValues)
	{

		foreach ($defaultValues as $field) {

			echo "print_r(field)=";
			print_r($field);
			echo "<br>";
			$name=$field['fieldName'];
			$this->$name=$field['defaultValue'];

		}

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->userId = (isset($data['user_d'])) ? $data['user_id'] : 0;
		$this->emailId = (isset($data['emailId'])) ? $data['emailId'] : 0;

		$this->contactName = (isset($data['name'])) ? $data['name'] : "";
		$this->description = (isset($data['description'])) ? $data['description'] : "";
		$this->emailAddress = (isset($data['email_address'])) ? $data['email_address'] : "";
		$this->status = (isset($data['status'])) ? $data['status'] : "";

	}

}
