<?php

class EmailForm extends Form
{

    public function __construct()
    {

        $this->add(array(
            'name' => 'id',
            'type'  => 'hidden',
        ));

		$this->add(array(
			'name' => 'emailAddress',
			'type' => 'text',
			'value' => '',
			'label' => 'Email address*: ',
			'required' => true,
			'validation' => 'email',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'memWord',
			'type' => 'text',
			'value' => '',
			'label' => 'Memorable word: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => 'If you see the form field Memorable word, then this means, that your e-mail address is related to such word and you must submit both (your email address and such a word) to ask for a new password and username.',
		));

		$this->add(array(
			'name' => 'memWord2',
			'type' => 'password',
			'value' => '',
			'label' => 'Memorable word: ',
			'required' => false,
			'validation' => 'text250',
			'guide' => 'Please enter your memorable word, which you have related to this email address.',
		));

		$this->add(array(
			'name' => 'memWordQuestion',
			'type' => 'text',
			'value' => '',
			'label' => 'Memorable word question',
			'required' => false,
			'validation' => 'text250',
			'guide' => 'Question to remind the memorable word.',
		));

     $this->add(array(
         'name' => 'comment',
         'type'  => 'textarea',
         'label' => 'Comment:',
			'required' => false,
			'attributes'  => array(
				'rows' => '6',
				'cols' => '60',
			),
			'validation' => 'mediumTextarea',
			'guide' => 'Any comment, which you wish to add.',
     ));

		$this->add(array(
			'name' => 'status',
			'type' => 'select',
			'value' => 0,
			'label' => 'Email address status: ',
			'guide' => 'Change the status of current email address.',
			'options'  => array(
				0 => 'created',
				1 => 'verified',
				2 => 'created-recent',
			),
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
            'name' => 'submitEmail',
            'type'  => 'submit',
            'value' => 'Send email address',
            'id' => 'save',
        ));
        $this->add(array(
            'name' => 'submitWord',
            'type'  => 'submit',
            'value' => 'Send word',
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

	public function convertDbData($dbData)
	{

		$this->setValue('emailAddress',(isset($dbData['email_address'])) ? $dbData['email_address'] : "0");
		$this->setValue('userId',(isset($dbData['user_id'])) ? $dbData['user_id'] : "0");

		$this->setValue('status',(isset($dbData['status'])) ? $dbData['status'] : "created");
		$this->setValue('memWord',(isset($dbData['mem_word'])) ? $dbData['mem_word'] : "");
		$this->setValue('memWordQuestion',(isset($dbData['mem_word_question'])) ? $dbData['mem_word_question'] : "");
		$this->setValue('comment',(isset($dbData['comment'])) ? $dbData['comment'] : "");
		$this->setValue('username',(isset($dbData['username'])) ? $dbData['username'] : "");

	}

}
