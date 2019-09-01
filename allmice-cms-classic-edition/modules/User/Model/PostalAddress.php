<?php

class PostalAddress
{

	public $id;
	public $userId;

	public $countryCode;
	public $postalAddress;

	public $addressLine1;
	public $addressLine2;
	public $addressLine3;
	public $addressLine4;

	public $postCode;

	public $comment;
	public $title;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->userId = (isset($data['userId'])) ? $data['userId'] : 0;
		$this->countryCode = (isset($data['country'])) ? $data['country'] : "";
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
