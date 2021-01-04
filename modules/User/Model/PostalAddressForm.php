<?php

class PostalAddressForm extends Form
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
			'guide' => 'State or province or other similar administrative region. If there was no option for your country in drop-down menu and you chose there last option "other", then please write your country here.',
		));

        $this->add(array(
            'name' => 'country',
            'type'  => 'select',
            'value'  => 'XX',
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

		$this->setValue('userId',(isset($dbData['user_id'])) ? $dbData['user_id'] : 0);
		$this->setValue('country',(isset($dbData['country_code'])) ? $dbData['country_code'] : "");

		$this->setValue('postalAddress',(isset($dbData['postal_address'])) ? $dbData['postal_address'] : "");

		$this->setValue('addressLine1',(isset($dbData['address_line1'])) ? $dbData['address_line1'] : "");
		$this->setValue('addressLine2',(isset($dbData['address_line2'])) ? $dbData['address_line2'] : "");
		$this->setValue('addressLine3',(isset($dbData['address_line3'])) ? $dbData['address_line3'] : "");
		$this->setValue('addressLine4',(isset($dbData['address_line4'])) ? $dbData['address_line4'] : "");

		$this->setValue('postCode',(isset($dbData['post_code'])) ? $dbData['post_code'] : "");
		$this->setValue('comment',(isset($dbData['comment'])) ? $dbData['comment'] : "");
		$this->setValue('title',(isset($dbData['title'])) ? $dbData['title'] : "");

	}

}
