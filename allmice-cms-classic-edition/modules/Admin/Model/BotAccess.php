<?php

class BotAccess
{

	public $id;
	public $accessLevel;

	public function convertFormData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->accessLevel = (isset($data['level'])) ? $data['level'] : null;
	}

	public function convertDbData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->accessLevel = (isset($data['level'])) ? $data['level'] : null;
	}

}
