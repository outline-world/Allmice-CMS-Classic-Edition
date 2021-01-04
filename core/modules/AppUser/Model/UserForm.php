<?php

//======= Check which form file is the latest in framework development =======
// 10/03/2015

class UserForm extends Form
{

    public function __construct()
    {

	$this->genTextRules = array(
		'min' => 0,
		'max' => 100,
		'type' => 'string',
	);

  $this->add(array(
      'name' => 'id',
      'type'  => 'hidden',
  ));

  $this->add(array(
      'name' => 'login',
      'type'  => 'submit',
      'value' => 'Login',
      'id' => 'login',
  ));

  $this->add(array(
      'name' => 'logout',
      'type'  => 'submit',
      'value' => 'Logout',
      'id' => 'logout',
  ));

  $this->add(array(
      'name' => 'register',
      'type'  => 'submit',
      'value' => 'Register',
      'id' => 'register',
  ));

// Other fields - start

// User start

$this->add(array(
	'name' => 'eMail',
	'type' => 'text',
	'value' => '',
	'label' => 'E-mail: ',
	'required' => false,
	'rules' => $this->genTextRules,
));

$this->add(array(
	'name' => 'password',
	'type' => 'password',
	'value' => '',
	'label' => 'Password: ',
	'required' => false,
	'rules' => $this->genTextRules,
));

$this->add(array(
	'name' => 'saveUser',
	'type' => 'submit',
	'value' => 'Save User',
	'id' => 'saveUser',
));

$this->add(array(
	'name' => 'username',
	'type' => 'text',
	'value' => '',
	'label' => 'Username: ',
	'required' => false,
	'rules' => $this->genTextRules,
));

// User end

// Role start

$this->add(array(
	'name' => 'saveRole',
	'type' => 'submit',
	'value' => 'Save role',
	'id' => 'saveRole',
));

$this->add(array(
	'name' => 'title',
	'type' => 'text',
	'value' => '',
	'label' => 'Role title: ',
	'required' => false,
	'rules' => $this->genTextRules,
));

// Role end

// Resource start

$this->add(array(
	'name' => 'eventName',
	'type' => 'text',
	'value' => '',
	'label' => 'Event name: ',
	'required' => false,
	'rules' => $this->genTextRules,
));

$this->add(array(
	'name' => 'moduleName',
	'type' => 'text',
	'value' => '',
	'label' => 'Module name: ',
	'required' => false,
	'rules' => $this->genTextRules,
));

$this->add(array(
	'name' => 'saveResource',
	'type' => 'submit',
	'value' => 'Save resource',
	'id' => 'saveResource',
));

$this->add(array(
	'name' => 'title',
	'type' => 'text',
	'value' => '',
	'label' => 'Resource title: ',
	'required' => false,
	'rules' => $this->genTextRules,
));

$this->add(array(
	'name' => 'type',
	'type' => 'select',
	'value' => 0,
	'label' => 'Select type: ',
));

$this->add(array(
	'name' => 'updateResourceTable',
	'type' => 'submit',
	'value' => 'Update resources',
	'id' => 'updateResourceTable',
));

$this->add(array(
	'name' => 'resetPermissionTable',
	'type' => 'submit',
	'value' => 'Reset permissions',
	'id' => 'resetPermissionTable',
));

$this->add(array(
	'name' => 'url',
	'type' => 'text',
	'value' => '',
	'label' => 'Resource url: ',
	'required' => false,
	'rules' => $this->genTextRules,
));

// Permission end

// UserRole start

$this->add(array(
	'name' => 'assignRole',
	'type' => 'submit',
	'value' => 'Assign role',
	'id' => 'assignRole',
));

$this->add(array(
	'name' => 'roleId',
	'type' => 'select',
	'value' => 0,
	'label' => 'Select role: ',
));

$this->add(array(
	'name' => 'userId',
	'type' => 'select',
	'value' => 1,
	'label' => 'Select user: ',
));

// UserRole end

// RolePermission start

$this->add(array(
	'name' => 'assignPermission',
	'type' => 'submit',
	'value' => 'Assign permission',
	'id' => 'assignPermission',
));

$this->add(array(
	'name' => 'permissionId',
	'type' => 'select',
	'value' => 0,
	'label' => 'Select permission: ',
));

$this->add(array(
	'name' => 'roleId',
	'type' => 'select',
	'value' => 1,
	'label' => 'Select role: ',
));

// RolePermission end

// Other fields - end

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

	public function getCheckboxData($resList)
	{
		for($i=0;$i<count($resList);$i++){

			$row['id']=$resList[$i]['id'];
			$cbData[]=$row;
		}

		return $cbData;

	}

	public function createCheckboxes($name,$cbData)
	{
		for($i=0;$i<count($cbData);$i++){

			$this->add(array(
            'name' => $name,
            'type'  => 'checkbox',
            'value' => $cbData[$i][$id],
            'id' => $name,
			));

		}

	}
	public function convertDbData($dbData)
	{

		$this->setValue('id',$dbData['id']);

		$this->setValue('eMail',$dbData['mail']);
		$this->setValue('password',$dbData['password']);
		$this->setValue('username',$dbData['username']);

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

}
