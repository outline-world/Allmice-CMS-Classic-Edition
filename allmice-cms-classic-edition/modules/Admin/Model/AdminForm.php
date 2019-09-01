<?php

class AdminForm extends Form
{

    public function __construct()
    {

		$this->add(array(
			'name' => 'alias',
			'type' => 'text',
			'value' => '',
			'label' => 'URL path for alias: ',
			'required' => true,
			'validation' => 'path',
		));

		$this->add(array(
			'name' => 'source',
			'type' => 'select',
			'value' => '1',
			'label' => 'URL path for source: ',
		));

		$this->add(array(
			'name' => 'sourceStatus',
			'type' => 'select',
			'value' => 0,
			'label' => 'Choose whether source URL as duplicate is allowed to show the content: ',
			'options'  => array(
				0 => 'Alias URL only, no source URL',
				1 => 'Both - alias URL and source URL',
			),
			'attributes'  => array(
				'style' => 'width:260px',
			),
		));

		$this->add(array(
			'name' => 'password',
			'type' => 'password',
			'value' => '',
			'label' => 'Password: ',
			'required' => false,
			'validation' => 'password',
		));

		$this->add(array(
			'name' => 'username',
			'type' => 'text',
			'value' => '',
			'label' => 'Username: ',
			'required' => false,
			'validation' => 'username',
		));

		$this->add(array(
			'name' => 'eMail',
			'type' => 'text',
			'value' => '',
			'label' => 'E-mail: ',
			'required' => false,
			'validation' => 'eMail',
		));

		$this->add(array(
			'name' => 'userStatus',
			'type' => 'select',
			'options'  => array(
				1 => 'Registered',
				2 => 'Confirmed',
			),
			'value' => 2,
			'label' => 'User status: ',
		));

		$this->add(array(
			'name' => 'title',
			'type' => 'text',
			'value' => '',
			'label' => 'Role title: ',
			'required' => false,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'userRoles',
			'type' => 'select_multiple',
			'value' => array(),
			'label' => 'Assign additional roles: ',
		));

		$this->add(array(
			'name' => 'mainRole',
			'type' => 'select',
			'value' => 3,
			'label' => 'Main role: ',
		));

		$this->add(array(
			'name' => 'begin',
			'type'  => 'begin',
			'value' => '#',
			'id' => 'begin',
			'attributes'  => array(
				'method' => 'post',
			),
		));

		$this->add(array(
			'name' => 'end',
			'type'  => 'end',
		));

     $this->add(array(
         'name' => 'id',
         'type'  => 'hidden',
     ));

		$this->add(array(
			'name' => 'save',
			'type' => 'submit',
			'value' => 'Save changes',
			'id' => 'save',
		));

    }

	public function convertUserDbData($dbData)
	{
		$this->setValue('id',$dbData['id']);
		$this->setValue('eMail',$dbData['mail']);
		$this->setValue('password',$dbData['password']);
		$this->setValue('username',$dbData['username']);
		$this->setValue('userStatus',$dbData['status']);
		$this->setValue('mainRole',$dbData['active_role_id']);
	}
	public function convertRoleDbData($dbData)
	{
		$this->setValue('id',$dbData['id']);
		$this->setValue('title',$dbData['title']);
	}
	public function convertAliasDbData($dbData)
	{
		$this->setValue('id',$dbData['id']);
		$this->setValue('alias',$dbData['alias']);
		$this->setValue('source',$dbData['resource_id']);
		$this->setValue('sourceStatus',$dbData['source_status']);
	}

}
