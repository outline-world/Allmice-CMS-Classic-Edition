<?php

class UserForm extends Form
{

	public $changeList;
	public $visibleFields;

    public function __construct()
    {

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
			'name' => 'email',
			'type' => 'text',
			'value' => '',
			'label' => 'E-mail*: ',
			'required' => true,
			'validation' => 'email',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'mainEmail',
			'type' => 'text',
			'value' => '',
			'label' => 'Main email address: ',
			'required' => true,
			'validation' => 'email',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'username',
			'type' => 'text',
			'value' => '',
			'label' => 'Username*: ',
			'required' => true,
			'validation' => 'username',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'password',
			'type' => 'password',
			'value' => '',
			'label' => 'Password: ',
			'required' => false,
			'validation' => 'password',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'password2',
			'type' => 'password',
			'value' => '',
			'label' => 'Repeat password: ',
			'required' => false,
			'validation' => 'password',
			'guide' => 'Type your password again.',
		));

		$this->add(array(
			'name' => 'emailId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Main email: ',
			'guide' => 'Choose your verified main email address.',
		));

		$this->add(array(
			'name' => 'status',
			'type' => 'select',
			'value' => 0,
			'label' => 'Main email status: ',
			'guide' => 'Change main email and user status.',
		));

		$this->add(array(
			'name' => 'userStatus',
			'type' => 'select',
			'value' => 1,
			'label' => 'User status: ',
			'guide' => 'Change user status. Possible values are active or passive. Passive means that user can not log in.',
		));

		$this->add(array(
			'name' => 'passwordStatus',
			'type' => 'select',
			'value' => 0,
			'label' => 'Password change status: ',
			'guide' => 'Whether to change password too or leave it unchanged.',
			'options'  => array(
				0 => 'No change',
				1 => 'Change password',
			),
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'firstName',
			'type' => 'text',
			'value' => '',
			'label' => 'First name*: ',
			'guide' => 'First name (forename, first given name). Please double check the first name and fill middle names field (if any) at the same time. If this field is filled, then it can not be edited later.',
			'validation' => 'text120',
			'required' => false,
		));

		$this->add(array(
			'name' => 'middleNames',
			'type' => 'text',
			'value' => '',
			'label' => 'Middle names: ',
			'guide' => 'Middle names (other given names, if any; separated by commas). Please double check the middle names and fill first name field at the same time. If this field is filled, then it can not be edited later.',
			'validation' => 'text250',
			'required' => false,
		));

		$this->add(array(
			'name' => 'lastName',
			'type' => 'text',
			'value' => '',
			'label' => 'Last name*: ',
			'guide' => 'Last name (surname). Please double check the last name. If this field is filled, then it can not be edited later.',
			'validation' => 'text120',
			'required' => false,
		));

		$this->add(array(
			'name' => 'company',
			'type' => 'text',
			'value' => '',
			'label' => 'Company: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'phone1',
			'type' => 'text',
			'value' => '',
			'label' => 'Phone: ',
			'required' => false,
			'validation' => 'phone',
			'guide' => 'Mobile or landline phone number',
		));

		$this->add(array(
			'name' => 'phone2',
			'type' => 'text',
			'value' => '',
			'label' => 'Second phone: ',
			'required' => false,
			'validation' => 'phone',
			'guide' => 'Another mobile or landline phone number',
		));

        $this->add(array(
            'name' => 'register',
            'type'  => 'submit',
            'value' => 'Register',
            'id' => 'register',
        ));

        $this->add(array(
            'name' => 'save',
            'type'  => 'submit',
            'value' => 'Save',
            'id' => 'save',
        ));

		$this->add(array(
			'name' => 'delMethod',
			'type' => 'radio_button',
			'value' => 0,
			'label' => 'Deleting method: ',
			'guide' => 'Choose in what way to delete the user account. If deleting "All user data" and there are for example pages created or edited by this user, then such pages will not be available any more. If you use "Leave reference", then such related data remains available, but instead of showing username by such data, it will be shown "Deleted user ...". Username, password, postal addresses, email addresses, contact forms, sent messages will be deleted. Other possible data will not be deleted, but its availability depends on chosen deleting method.',
			'options'  => array(
				0 => 'Leave reference',
				1 => 'All user data',
			),
			'required' => false,
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

	public function updateFields()
	{

		$this->visibleFields=array();
		$visibleFields=array();
		$fieldData=array();
		$fieldOrder=array();
		$fieldName=array();

		$changeList=$this->changeList;

		for($i=0;$i<count($changeList);$i++){

			if($changeList[$i]['required']=="true")
				$this->formMap[($changeList[$i]['field_name'])]['required']=true;
			else
				$this->formMap[($changeList[$i]['field_name'])]['required']=false;

			if($changeList[$i]['visibility']=="visible"){
				$fieldData['fieldOrder']=$changeList[$i]['field_order'];
				$fieldData['fieldName']=$changeList[$i]['field_name'];

				$visibleFields[]=$fieldData;
			}

		}

		foreach ($visibleFields as $key => $row) {
		    $fieldOrder[$key]  = $row['fieldOrder'];
		    $fieldName[$key] = $row['fieldName'];
		}

		array_multisort($fieldOrder, SORT_ASC, $fieldName, SORT_ASC, $visibleFields);

		$this->visibleFields=$visibleFields;

	}

	public function convertDbData($dbData)
	{

		$this->setValue('emailId',(isset($dbData['emailId'])) ? $dbData['emailId'] : "0");

		$this->setValue('email',(isset($dbData['email_address'])) ? $dbData['email_address'] : "");
		$this->setValue('mainEmail',(isset($dbData['main_email'])) ? $dbData['main_email'] : "");

		$this->setValue('username',(isset($dbData['username'])) ? $dbData['username'] : "");
		$this->setValue('password',(isset($dbData['password'])) ? $dbData['password'] : "");
		$this->setValue('password2',(isset($dbData['password2'])) ? $dbData['password2'] : "");
		$this->setValue('cryptedPw',(isset($dbData['cryptedPw'])) ? $dbData['cryptedPw'] : "");
		$this->setValue('mainRole',(isset($dbData['mainRole'])) ? $dbData['mainRole'] : "");

		$this->setValue('firstName',(isset($dbData['first_name'])) ? $dbData['first_name'] : "");
		$this->setValue('middleNames',(isset($dbData['middle_names'])) ? $dbData['middle_names'] : "");
		$this->setValue('lastName',(isset($dbData['last_name'])) ? $dbData['last_name'] : "");

		$this->setValue('company',(isset($dbData['company'])) ? $dbData['company'] : "");
		$this->setValue('phone1',(isset($dbData['phone1'])) ? $dbData['phone1'] : "");
		$this->setValue('phone2',(isset($dbData['phone2'])) ? $dbData['phone2'] : "");

	}

}
