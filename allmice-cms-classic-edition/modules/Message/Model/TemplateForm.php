<?php

class TemplateForm extends Form
{

	public function __construct()
	{

		$this->add(array(
			'name' => 'code',
			'type' => 'text',
			'value' => '',
			'label' => 'Code: ',
			'guide' => 'A unique code (identifier) for computer as array key to use this template in modules. Suggested as camelCase string without spaces. E.g. "sendAccValCode".',
			'required' => false,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'module',
			'type' => 'text',
			'value' => '',
			'label' => 'Module: ',
			'guide' => 'Name of the module, which is using this template to compose messages.',
			'required' => false,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'type',
			'type' => 'text',
			'value' => '',
			'label' => 'Type: ',
			'guide' => 'Some type string, which helps to filter out specific templates. This type can be used to list specific templates.',
			'required' => false,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'language',
			'type' => 'text',
			'value' => 'en',
			'label' => 'Language: ',
			'guide' => 'Two character code (ISO 639-1) or some other language code.',
			'required' => false,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'subject',
			'type' => 'text',
			'value' => '',
			'label' => 'Message subject template: ',
			'guide' => 'Template for message\'s subject part.',
			'required' => false,
			'validation' => 'text255',
		));

		$this->add(array(
			'name' => 'contentHtml',
			'type' => 'textarea',
			'value' => '',
			'label' => 'HTML content template: ',
			'guide' => 'Template for message\'s HTML text content part.',
			'required' => false,
				'attributes'  => array(
					'id' => 'content',
					'rows' => '8',
					'cols' => '80',
				),
			'validation' => 'mediumTextarea',

		));

		$this->add(array(
			'name' => 'contentPlain',
			'type' => 'textarea',
			'value' => '',
			'label' => 'Plain content template: ',
			'guide' => 'Template for message\'s plain text content part.',
			'required' => false,
				'attributes'  => array(
					'id' => 'content',
					'rows' => '8',
					'cols' => '80',
				),
			'validation' => 'mediumTextarea',

		));

		$this->add(array(
			'name' => 'save',
			'type' => 'submit',
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

		$this->add(array(
			'name' => 'id',
			'type'  => 'hidden',
			'value'  => '',
		));

	}

	public function convertDbData($dbData)
	{

		$this->setValue('id',$dbData['id']);
		$this->setValue('code',$dbData['code']);
		$this->setValue('module',$dbData['module']);
		$this->setValue('type',$dbData['type']);
		$this->setValue('subject',$dbData['subject']);
		$this->setValue('contentHtml',$dbData['content_html']);
		$this->setValue('contentPlain',$dbData['content_plain']);
		$this->setValue('language',$dbData['language_code']);

	}

}
