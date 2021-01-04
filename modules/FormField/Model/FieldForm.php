<?php

class FieldForm extends Form
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
			'name' => 'module',
			'type' => 'text',
			'value' => '',
			'label' => 'Module name: ',
			'guide' => '',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'event',
			'type' => 'text',
			'value' => '',
			'label' => 'Event name: ',
			'guide' => '',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'fieldName',
			'type' => 'text',
			'value' => '',
			'label' => 'Field name: ',
			'guide' => '',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'visibility',
			'type' => 'text',
			'value' => 'visible',
			'label' => 'Visibility: ',
			'guide' => 'Choose, whether this form field will be shown; possible values are "visible" or "hidden".',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'required',
			'type' => 'text',
			'value' => 'false',
			'label' => 'Required: ',
			'guide' => 'Choose, whether this form field is required to fill or not; possible values are true or false.',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'fieldOrder',
			'type' => 'text',
			'value' => '0',
			'label' => 'Field order: ',
			'guide' => 'Choose the order of this form field on the form. This is an integer number between -127 and 127.',
			'required' => true,
			'validation' => 'tinyInt',
		));

		$this->add(array(
			'name' => 'submit1',
			'type' => 'submit',
			'value' => 'Save',
			'id' => 'submit1',
		));

		$this->add(array(
			'name' => 'defaultValue',
			'type' => 'text',
			'value' => '',
			'label' => 'Default value: ',
			'guide' => 'Submit the default value for this form field, which will be usually used on data add forms.',
			'required' => false,
			'validation' => 'text250',
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

		$this->setValue('module',$dbData['module']);
		$this->setValue('event',$dbData['event']);
		$this->setValue('fieldName',$dbData['field_name']);
		$this->setValue('visibility',$dbData['visibility']);
		$this->setValue('required',$dbData['required']);
		$this->setValue('fieldOrder',$dbData['field_order']);
		$this->setValue('defaultValue',$dbData['default_value']);

	}

}
