<?php

class MessageForm extends Form
{

	public function __construct()
	{

		$this->add(array(
			'name' => 'username',
			'type' => 'text',
			'value' => '',
			'label' => 'Username: ',
			'guide' => '',
			'required' => false,
			'validation' => 'username',
		));

		$this->add(array(
			'name' => 'receiverName',
			'type' => 'text',
			'value' => '',
			'label' => 'Receiver Name: ',
			'guide' => '',
			'required' => false,
			'validation' => 'personName',
		));

		$this->add(array(
			'name' => 'receiverEmail',
			'type' => 'text',
			'value' => '',
			'label' => 'Receiver Email: ',
			'guide' => '',
			'required' => false,
			'validation' => 'eMail',
		));

		$this->add(array(
			'name' => 'senderName',
			'type' => 'text',
			'value' => '',
			'label' => 'Sender Name: ',
			'guide' => '',
			'required' => false,
			'validation' => 'personName',
		));

		$this->add(array(
			'name' => 'senderEmail',
			'type' => 'text',
			'value' => '',
			'label' => 'Sender Email: ',
			'guide' => '',
			'required' => false,
			'validation' => 'eMail',
		));

		$this->add(array(
			'name' => 'subject',
			'type' => 'text',
			'value' => '',
			'label' => 'Subject: ',
			'guide' => '',
			'required' => false,
			'validation' => 'text255',
		));

		$this->add(array(
			'name' => 'content',
			'type' => 'textarea',
			'value' => '',
			'label' => 'Content: ',
			'guide' => '',
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
			'name' => 'send',
			'type' => 'submit',
			'value' => 'Send',
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
		$this->setValue('time',$dbData['time']);
		if(!isset($dbData['receiverName']) || $dbData['receiverName']==""){
			$this->setValue('receiverName',$dbData['recipientName']);
		}else{
			$this->setValue('receiverName',$dbData['receiverName']);
		}
		$this->setValue('senderName',$dbData['senderName']);
		$this->setValue('subject',$dbData['subject']);
		$this->setValue('content',$dbData['content']);

	}

}
