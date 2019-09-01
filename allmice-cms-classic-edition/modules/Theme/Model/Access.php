<?php

class Access
{

	public $id;

	public $resId;
	public $accessLevel;
	public $levelValue;
	public $roleId;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->resId = (isset($data['resId'])) ? $data['resId'] : null;
		$this->accessLevel = (isset($data['accessLevel'])) ? $data['accessLevel'] : null;
		$this->levelValue = (isset($data['levelValue'])) ? $data['levelValue'] : null;
		$this->roleId = (isset($data['roleId'])) ? $data['roleId'] : null;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->resId = (isset($data['resource_id'])) ? $data['resource_id'] : null;
		$this->accessLevel = (isset($data['access_level'])) ? $data['access_level'] : null;
		$this->levelValue = (isset($data['access_level'])) ? $data['access_level'] : null;
		$this->roleId = (isset($data['role_id'])) ? $data['role_id'] : null;

	}

	public function getPermissionList($resList)
	{

		$newI=0;
		for($i=0;$i<count($resList);$i++){

				for($j=0;$j<count($newLines[$i]);$j++){

				}
				$newI++;
		}

		return $dbData2;

	}
}
