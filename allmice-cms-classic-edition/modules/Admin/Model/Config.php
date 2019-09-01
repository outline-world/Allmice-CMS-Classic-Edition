<?php

class Config
{

	public $id;
	public $modName;
	public $description;
	public $uri;
	public $type;
	public $value;

	public function convertFormData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->modName = (isset($data['modName'])) ? $data['modName'] : null;
		$this->description = (isset($data['description'])) ? $data['description'] : null;
		$this->uri = (isset($data['uri'])) ? $data['uri'] : null;
		$this->type = (isset($data['type'])) ? $data['type'] : null;
		$this->value = (isset($data['value'])) ? $data['value'] : null;
	}

	public function convertDbData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->modName = (isset($data['module_name'])) ? $data['module_name'] : null;
		$this->description = (isset($data['description'])) ? $data['description'] : null;
		$this->uri = (isset($data['uri'])) ? $data['uri'] : null;
		$this->type = (isset($data['type'])) ? $data['type'] : null;
		$this->value = (isset($data['value'])) ? $data['value'] : null;
	}

}
