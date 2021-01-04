<?php

class ContactForm extends Form
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
			'name' => 'contactName',
			'type' => 'text',
			'value' => '',
			'label' => 'Contact name: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'emailId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Email: ',
			'guide' => 'Choose your verified email address, where the messages of this contact forms will be sent to.',
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
            'name' => 'status',
            'type'  => 'select',
            'value'  => 'validated-passive',
            'label' => 'Contact status: ',
				'options' => array(
					'0' => 'Passive',
					'1' => 'Active',
				),
			'guide' => 'Active is meaning, that the form can be used by other people; passive is meaning that it can not be used.',
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
			'validation' => 'email',
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
			'name' => 'subject',
			'type' => 'text',
			'value' => '',
			'label' => 'Subject: ',
			'required' => false,
			'validation' => 'text250',
		));

        $this->add(array(
            'name' => 'userId',
            'type'  => 'select',
            'value'  => '1',
            'label' => 'Choose user: ',

				'attributes'  => array(
					'onchange' => 'this.form.submit()',
				),
				'guide' => '',
        ));

        $this->add(array(
            'name' => 'save',
            'type'  => 'submit',
            'value' => 'Save',
            'id' => 'save',
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
		$hiddenList=array();

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

				$this->formMap[($changeList[$i]['field_name'])]['value']=$changeList[$i]['default_value'];

			}else{
				$this->formMap[($changeList[$i]['field_name'])]['value']=$changeList[$i]['default_value'];
				$defaultItem['fieldName']=$changeList[$i]['field_name'];
				$defaultItem['defaultValue']=$changeList[$i]['default_value'];
				$hiddenList[]=$defaultItem;

			}
		if($changeList[$i]['field_name']=='status' && $changeList[$i]['default_value']=="active")
			$this->setValue('status',1);
		else
			$this->setValue('status',0);

		}
		foreach ($visibleFields as $key => $row) {
		    $fieldOrder[$key]  = $row['fieldOrder'];
		    $fieldName[$key] = $row['fieldName'];
		}

		array_multisort($fieldOrder, SORT_ASC, $fieldName, SORT_ASC, $visibleFields);

		$this->visibleFields=$visibleFields;

		return $hiddenList;
	}

	public function convertDbData($dbData)
	{

		$this->setValue('userId',(isset($dbData['user_id'])) ? $dbData['user_id'] : "0");
		$this->setValue('emailId',(isset($dbData['email_id'])) ? $dbData['email_id'] : "0");
		$this->setValue('contactName',(isset($dbData['name'])) ? $dbData['name'] : "");
		$this->setValue('description',(isset($dbData['description'])) ? $dbData['description'] : "");

		if(isset($dbData['status']) && $dbData['status']=="active")
			$this->setValue('status',1);
		else
			$this->setValue('status',0);

	}

}
