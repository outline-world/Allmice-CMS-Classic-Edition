<?php

class Role
{

	public $id;
	public $title;

	public function convertFormData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->title = (isset($data['title'])) ? $data['title'] : null;
	}

	public function convertDbData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->title = (isset($data['title'])) ? $data['title'] : null;
	}

}
