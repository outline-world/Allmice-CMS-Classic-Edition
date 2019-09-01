<?php

class SignUpForm extends Form
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
            'name' => 'userId',
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
			'name' => 'firstName',
			'type' => 'text',
			'value' => '',
			'label' => '',
			'guide' => '',
			'validation' => 'text120',
			'required' => false,
		));

		$this->add(array(
			'name' => 'middleNames',
			'type' => 'text',
			'value' => '',
			'label' => 'Middle names: ',
			'guide' => 'Middle names (other given names, if any, then separated by commas).',
			'validation' => 'text250',
			'required' => false,
		));

		$this->add(array(
			'name' => 'lastName',
			'type' => 'text',
			'value' => '',
			'label' => 'Last name*: ',
			'guide' => 'Last name (surname).',
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
         'name' => 'postalAddress',
         'type'  => 'textarea',
         'label' => 'Postal address*:',
			'required' => true,
			'attributes'  => array(
				'rows' => '6',
				'cols' => '60',
			),
			'validation' => 'mediumTextarea',
			'guide' => 'Whole postal address as it appears on official letters in your country. Your local official address format.',
			'changeable' => 'yes',
     ));

     $this->add(array(
         'name' => 'comment',
         'type'  => 'textarea',
         'label' => 'Comment:',
			'required' => true,
			'attributes'  => array(
				'rows' => '6',
				'cols' => '60',
			),
			'validation' => 'mediumTextarea',
			'guide' => 'Any additional comment, which you wish to submit.',
     ));

     $this->add(array(
         'name' => 'title',
         'type'  => 'text',
			'value' => '',
         'label' => 'Postal address title:',
			'required' => false,
			'validation' => 'text120',
			'guide' => 'Unique (human readable) title to distinguish postal addresses from one another.',
     ));

		$this->add(array(
			'name' => 'addressLine1',
			'type' => 'text',
			'value' => '',
			'label' => 'Street, house, flat: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => 'Street, house number or name, flat number (if any).',
		));

		$this->add(array(
			'name' => 'addressLine2',
			'type' => 'text',
			'value' => '',
			'label' => 'City / Town / Village: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => 'City or town or village or other similar administrative division.',
		));

		$this->add(array(
			'name' => 'addressLine3',
			'type' => 'text',
			'value' => '',
			'label' => 'County: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => 'County.',
		));

		$this->add(array(
			'name' => 'addressLine4',
			'type' => 'text',
			'value' => '',
			'label' => 'State / Province / Region: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => 'State or province or other similar administrative region.',
		));

        $this->add(array(
            'name' => 'country',
            'type'  => 'select',
            'value'  => 'GB',
            'label' => 'Country*: ',
			'required' => true,
			'guide' => 'If your country is not in the list, then please choose the closest country (or last option Other) and describe your country name in comment field.',
        ));

		$this->add(array(
			'name' => 'postCode',
			'type' => 'text',
			'value' => '',
			'label' => 'Postal code: ',
			'required' => false,
			'validation' => 'postalCode',
			'guide' => 'Postal code or zip code or other similar code.',
		));

		$this->add(array(
			'name' => 'email',
			'type' => 'text',
			'value' => '',
			'label' => 'E-mail*: ',
			'required' => true,
			'validation' => 'eMail',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'memWord',
			'type' => 'password',
			'value' => '',
			'label' => 'Memorable word: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => 'Memorable word, which is needed by requiring a new password, if the old one has been forgotten. It is not mandatory, but if you add a memorable word to your verified email address, then new password can be required any time (otherwise there is a configurable delay between every such possible request).',
		));

		$this->add(array(
			'name' => 'memWordQuestion',
			'type' => 'text',
			'value' => '',
			'label' => 'Memorable word question',
			'required' => true,
			'validation' => 'text250',
			'guide' => 'Question to remind about the memorable word.',
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
			'guide' => 'Another mobile or landline phone number.',
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
			'name' => 'contactName',
			'type' => 'text',
			'value' => '',
			'label' => 'Contact name: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'password',
			'type' => 'password',
			'value' => '',
			'label' => 'Password*: ',
			'required' => false,
			'validation' => 'password',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'password2',
			'type' => 'password',
			'value' => '',
			'label' => 'Repeat password*: ',
			'required' => false,
			'validation' => 'password',
			'guide' => 'Type your password again.',
		));

        $this->add(array(
            'name' => 'status',
            'type'  => 'select',
            'value'  => 'validated-passive',
            'label' => 'Contact status: ',
				'options' => array(
					'validated-passive' => 'Passive, not public',
					'validated-public' => 'Public',
				),
			'guide' => '',
        ));

        $this->add(array(
            'name' => 'description',
            'type'  => 'textarea',
            'label' => 'Contact form description: ',
				'required' => false,
				'attributes'  => array(
					'rows' => '10',
					'cols' => '60',
				),
				'validation' => 'mediumTextarea',
			'guide' => '',
        ));

        $this->add(array(
            'name' => 'agreement',
            'type'  => 'checkbox',
            'value'  => 'i-agree',
            'label' => '',
				'required' => true,
				'guide' => '',
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
            'name' => 'submitEmail',
            'type'  => 'submit',
            'value' => 'Check email',
            'id' => 'save',
			'validation' => 'eMail',
        ));

        $this->add(array(
            'name' => 'submitWord',
            'type'  => 'submit',
            'value' => 'Send',
            'id' => 'save',
        ));

		$this->add(array(
			'name' => 'senderName',
			'type' => 'text',
			'value' => '',
			'label' => 'Your name: ',
			'required' => false,
			'validation' => 'text250',
		));

		$this->add(array(
			'name' => 'senderEmail',
			'type' => 'text',
			'value' => '',
			'label' => 'Your e-mail: ',
			'required' => false,
			'validation' => 'eMail',
		));

		$this->add(array(
			'name' => 'subject',
			'type' => 'text',
			'value' => '',
			'label' => 'Subject: ',
			'required' => false,
			'validation' => 'text250',
		));

        $this->add(array(
            'name' => 'message',
            'type'  => 'textarea',
            'label' => 'Message: ',
				'required' => false,
				'attributes'  => array(
					'rows' => '16',
					'cols' => '80',
				),
				'validation' => 'mediumTextarea',
        ));

        $this->add(array(
            'name' => 'send',
            'type'  => 'submit',
            'value' => 'Send',
            'id' => 'send',
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

		$this->setValue('email',$dbData['email']);
		$this->setValue('username',$dbData['username']);

		$this->setValue('description',$dbData['description']);
		$this->setValue('status',$dbData['status']);
		$this->setValue('contactName',$dbData['contactName']);
		$this->setValue('memWord',$dbData['mem_word']);
		$this->setValue('memWordQuestion',$dbData['mem_word_question']);

	}

	public function convertPostalDbData($dbData)
	{

		$this->setValue('userId',(isset($dbData['user_id'])) ? $dbData['user_id'] : 0);
		$this->setValue('countryCode',(isset($dbData['country_code'])) ? $dbData['country_code'] : "");

		$this->setValue('postalAddress',(isset($dbData['postal_address'])) ? $dbData['postal_address'] : "");

		$this->setValue('addressLine1',(isset($dbData['address_line1'])) ? $dbData['address_line1'] : "");
		$this->setValue('addressLine2',(isset($dbData['address_line2'])) ? $dbData['address_line2'] : "");
		$this->setValue('addressLine3',(isset($dbData['address_line3'])) ? $dbData['address_line3'] : "");
		$this->setValue('addressLine4',(isset($dbData['address_line4'])) ? $dbData['address_line4'] : "");

		$this->setValue('postCode',(isset($dbData['post_code'])) ? $dbData['post_code'] : "");
		$this->setValue('comment',(isset($dbData['comment'])) ? $dbData['comment'] : "");
		$this->setValue('title',(isset($dbData['title'])) ? $dbData['title'] : "");

	}

	public function convertDetailSetDbData($dbData)
	{

		$this->setValue('id',$dbData['id']);

		$this->setValue('userId',$dbData['user_id']);
		$this->setValue('country',$dbData['country_code']);
		$this->setValue('firstName',$dbData['first_name']);
		$this->setValue('middleNames',$dbData['middle_names']);
		$this->setValue('lastName',$dbData['last_name']);
		$this->setValue('company',$dbData['company']);
		$this->setValue('phone1',$dbData['phone1']);
		$this->setValue('phone2',$dbData['phone2']);

		$this->setValue('postalAddress',$dbData['postal_address']);
		$this->setValue('addressLine1',$dbData['address_line1']);
		$this->setValue('addressLine2',$dbData['address_line2']);
		$this->setValue('addressLine3',$dbData['address_line3']);
		$this->setValue('addressLine4',$dbData['address_line4']);
		$this->setValue('postCode',$dbData['post_code']);

		$this->setValue('comment',$dbData['comment']);
		$this->setValue('title',$dbData['title']);

	}

}
