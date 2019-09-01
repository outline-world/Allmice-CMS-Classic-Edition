<?php

class VisitorForm extends Form
{

	public function __construct()
	{

		$this->add(array(
			'name' => 'fileName',
			'type' => 'radio',
			'value' => '',
			'label' => '',
			'checked' => '',
			'required' => false,
		));

		$this->add(array(
			'name' => 'ip',
			'type' => 'text',
			'value' => '',
			'label' => 'IP address',
			'guide' => 'IP address of the visitor.',
			'required' => true,
			'validation' => 'code',
		));

        $this->add(array(
				'name' => 'agentData',
            'type'  => 'textarea',
				'label' => 'User agent data',
				'guide' => 'Visitor\'s browser and operating system information (i.e. user agent data, device data).',
				'required' => false,
				'attributes'  => array(
					'id' => 'descriptionArea',
					'rows' => '6',
					'cols' => '80',
				),

				'validation' => 'smallTextarea',
        ));

		$this->add(array(
			'name' => 'save',
			'type' => 'submit',
			'value' => 'Save',
			'id' => 'save',
		));

		$this->add(array(
			'name' => 'openArchive',
			'type' => 'submit',
			'value' => 'Open archive',
			'id' => 'save',
		));

		$this->add(array(
			'name' => 'optOut',
			'type' => 'submit',
			'value' => 'Opt-out data',
			'id' => 'save',
		));

        $this->add(array(
			'name' => 'status',
			'type'  => 'select',
			'value'  => 1,
			'options'  => array(
				0 => 'Consent unknown',
				1 => 'Consent signal registered',
				2 => 'Consent signal opt-out request',
			),
			'label' => 'Consent signal status',
			'guide' => 'Consent signal status determines, whether visitor\'s consent is unknown, confirmed through an event (consent signal registered) or opted out.',
        ));

        $this->add(array(
			'name' => 'consentType',
			'type'  => 'select',
			'value'  => 1,
			'options'  => array(
				1 => 'Using',
				2 => 'Continuing',
				3 => 'Submit',
			),
			'label' => 'Consent type',
			'guide' => 'Block status determines, whether to display this block or not.',
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
			'value'  => '',
		));

	}

	public function convertDbData($dbData)
	{

		$this->setValue('id',$dbData['id']);

		$this->setValue('ip',$dbData['ip']);
		$this->setValue('agentData',$dbData['device_data']);
		$this->setValue('status',$dbData['status']);

	}

}
