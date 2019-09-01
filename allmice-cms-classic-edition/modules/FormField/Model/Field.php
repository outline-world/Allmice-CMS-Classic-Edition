<?php

class Field
{

	public $id;

	public $module;
	public $event;
	public $fieldName;
	public $visibility;
	public $required;
	public $fieldOrder;
	public $defaultValue;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;

		$this->module = (isset($data['module'])) ? $data['module'] : "";
		$this->event = (isset($data['event'])) ? $data['event'] : "";
		$this->fieldName = (isset($data['fieldName'])) ? $data['fieldName'] : "";
		$this->visibility = (isset($data['visibility'])) ? $data['visibility'] : "";
		$this->required = (isset($data['required'])) ? $data['required'] : "";
		$this->fieldOrder = (isset($data['fieldOrder'])) ? $data['fieldOrder'] : "";
		$this->defaultValue = (isset($data['defaultValue'])) ? $data['defaultValue'] : "";

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;

		$this->module = (isset($data['module'])) ? $data['module'] : "";
		$this->event = (isset($data['event'])) ? $data['event'] : "";
		$this->fieldName = (isset($data['field_name'])) ? $data['field_name'] : "";
		$this->visibility = (isset($data['visibility'])) ? $data['visibility'] : "";
		$this->required = (isset($data['required'])) ? $data['required'] : "";
		$this->fieldOrder = (isset($data['field_order'])) ? $data['field_order'] : "";
		$this->defaultValue = (isset($data['default_value'])) ? $data['default_value'] : "";

	}

}
