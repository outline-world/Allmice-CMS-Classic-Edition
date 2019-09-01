<?php

class Block
{

	public $id;

	public $caching;
	public $blockCode;
	public $name;
	public $rank;
	public $regionCode;
	public $type;
	public $buildingModule;
	public $displayMethod;
	public $uri;
	public $status;
	public $languageCode;

	public $roleAccess;
	public $cachingRoles;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->caching = (isset($data['caching'])) ? $data['caching'] : '';
		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->blockCode = (isset($data['blockCode'])) ? $data['blockCode'] : '';
		$this->rank = (isset($data['rank'])) ? $data['rank'] : '';
		$this->regionCode = (isset($data['regionCode'])) ? $data['regionCode'] : '';
		$this->type = (isset($data['type'])) ? $data['type'] : '';
		$this->buildingModule = (isset($data['buildingModule'])) ? $data['buildingModule'] : '';
		$this->displayMethod = (isset($data['displayMethod'])) ? $data['displayMethod'] : '';
		$this->roleAccess = (isset($data['roleAccess'])) ? $data['roleAccess'] : '';
		$this->uri = (isset($data['uri'])) ? $data['uri'] : '';
		$this->status = (isset($data['status'])) ? $data['status'] : '';
		$this->languageCode = (isset($data['languageCode'])) ? $data['languageCode'] : '';

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;

		$this->caching = (isset($data['caching'])) ? $data['caching'] : '';
		$this->blockCode = (isset($data['block_code'])) ? $data['block_code'] : '';
		$this->rank = (isset($data['rank'])) ? $data['rank'] : '';
		$this->regionCode = (isset($data['region_code'])) ? $data['region_code'] : '';
		$this->type = (isset($data['type'])) ? $data['type'] : '';
		$this->sourceModule = (isset($data['building_module'])) ? $data['building_module'] : '';
		$this->displayMethod = (isset($data['display_method'])) ? $data['display_method'] : '';
		$this->roleAccess = (isset($data['role_id'])) ? $data['role_id'] : '';
		$this->uri = (isset($data['uri'])) ? $data['uri'] : '';
		$this->status = (isset($data['status'])) ? $data['status'] : '';
		$this->languageCode = (isset($data['languageCode'])) ? $data['language_code'] : '';

	}
}
