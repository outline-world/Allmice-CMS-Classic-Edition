<?php

class ProfileForm extends Form
{

	public $langFieldStatus;

	public function __construct()
	{

		$this->add(array(
			'name' => 'gravatarSource',
			'type' => 'text',
			'value' => '',
			'label' => 'Gravatar source',
			'guide' => 'Change the case (capital or lower case) of the letters of your email address and click Refresh images to get different avatar images. Gravatar service is used to compose most of the images - see https://en.gravatar.com/.',
			'required' => false,
			'validation' => 'email',
		));

		$this->add(array(
			'name' => 'personalNotes',
			'type'  => 'textarea',
			'value' => '',
			'label' => 'Personal notes',
			'guide' => 'You can write and keep here some personal notes - up to 2040 characters.',
			'required' => false,
				'attributes'  => array(
					'rows' => '4',
					'cols' => '80',
				),
			'validation' => 'mediumTextarea',
		));

		$this->add(array(
			'name' => 'imageType',
			'type' => 'radio',
			'label' => '',
			'value' => '',
		));

		$this->add(array(
			'name' => 'save',
			'type' => 'submit',
			'value' => 'Save',
			'id' => 'save',
		));

		$this->add(array(
			'name' => 'refreshImages',
			'type' => 'submit',
			'value' => 'Refresh images',
			'id' => 'refreshImages',
		));

		$this->add(array(
			'name' => 'getEmailAddress',
			'type' => 'submit',
			'value' => 'Get email address',
			'id' => 'getEmailAddress',
		));

        $this->add(array(
            'name' => 'langCode',
            'type'  => 'select',
            'value'  => 'en',
            'label' => 'Default language',
			'guide' => 'This default language may be used, if system decides in what language to send automated messages without any other information, what language would user prefer.',
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

		$this->setValue('gravatarSource',(isset($dbData['gravatar_source']) ? $dbData['gravatar_source'] : ""));
		$this->setValue('personalNotes',(isset($dbData['personal_notes']) ? $dbData['personal_notes'] : ""));
		$this->setValue('imageType',(isset($dbData['avatar_type']) ? $dbData['avatar_type'] : ""));
		$this->setValue('langCode',(isset($dbData['language_code']) ? $dbData['language_code'] : "en"));

	}

}
