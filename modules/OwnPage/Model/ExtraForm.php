<?php

class ExtraForm extends Form
{

    public function __construct()
    {

        $this->add(array(
            'name' => 'id',
            'type'  => 'hidden',
        ));

        $this->add(array(
            'name' => 'postContent',
            'type'  => 'textarea',
            'label' => 'Post content: ',
				'guide' => 'Content of the post.',
				'required' => false,
				'attributes'  => array(
					'rows' => '6',
					'cols' => '80',
				),
				'validation' => 'mediumTextarea',
        ));

        $this->add(array(
            'name' => 'postStatus',
            'type'  => 'radio_button',
            'value'  => 1,
            'label' => 'Post status: ',
				'guide' => 'Choose, whether this post is published or not.',
				'options' => array(
					1 => "Published",
					2 => "Not published",
				),
        ));

        $this->add(array(
            'name' => 'snippetCode',
            'type'  => 'text',
            'label' => 'Unique snippet code: ',
				'guide' => 'An unique code to identify this snippet from all the other snippets of the current page.',
				'required' => true,
				'validation' => 'text60',
        ));

        $this->add(array(
            'name' => 'snippetType',
            'type'  => 'radio_button',
            'value'  => 1,
            'label' => 'Snippet type: ',
				'guide' => 'If type is php code, then the content form field should include location to the php code class, which will return the actual snippet content. If type is plain text, then the content form field should include text, which will be displayed in snippet.',
				'options' => array(
					1 => "Plain text",
					2 => "PHP code",
				),
        ));

        $this->add(array(
            'name' => 'snippetContent',
            'type'  => 'textarea',
            'label' => 'Snippet content: ',
				'guide' => 'Content of the snippet.',
				'required' => false,
				'attributes'  => array(
					'rows' => '6',
					'cols' => '80',
				),
				'validation' => 'mediumTextarea',
        ));

        $this->add(array(
            'name' => 'postingIntro',
            'type'  => 'textarea',
            'label' => 'Posting introduction: ',
				'guide' => 'Write some introduction to let people know, that they can post comments to this page.',
				'required' => false,
				'attributes'  => array(
					'rows' => '6',
					'cols' => '80',
				),
				'validation' => 'smallTextarea',
        ));

        $this->add(array(
            'name' => 'postingAccess',
            'type'  => 'checkbox',
            'value'  => 'postingAccessGranted',
            'label' => 'Posting access: ',
				'guide' => 'Tick this box to allow posting by other visitors on the corresponding page or untick it, if you wish not to allow such posting!',
        ));

        $this->add(array(
            'name' => 'save',
            'type'  => 'submit',
            'value' => 'Save',
            'id' => 'submitbutton',
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

}
