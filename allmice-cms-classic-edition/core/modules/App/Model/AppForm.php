<?php

class AppForm extends Form
{

    public function __construct()
    {

		$this->genTextRules = array(
					'min' => 0,
					'max' => 100,
					'type' => 'string',
//					'pattern' => '/^[a-z]{1,40}$/',
		);
    // check if name only contains letters and whitespace
//    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {

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

		$this->add(array(
			'name' => 'roleId',
			'type' => 'select',
			'value' => 3,
			'label' => 'Select role: ',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'modId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Select module: ',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'modCb',
			'type' => 'checkbox',
			'value' => 0,
			'label' => '',
		));

		$this->add(array(
			'name' => 'resCb',
			'type' => 'checkbox',
			'value' => 0,
			'label' => '',
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

    }

	public function convertDbData($dbData)
	{

		$this->setValue('id',$dbData['id']);

		$this->setValue('title',$dbData['title']);

		$this->setValue('eventName',$dbData['event_name']);
		$this->setValue('moduleName',$dbData['module_name']);
		$this->setValue('title',$dbData['title']);
		$this->setValue('type',$dbData['type']);
		$this->setValue('url',$dbData['url']);

		$this->setValue('roleId',$dbData['role_id']);
		$this->setValue('userId',$dbData['user_id']);

		$this->setValue('permissionId',$dbData['permission_id']);
		$this->setValue('roleId',$dbData['role_id']);

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

}
