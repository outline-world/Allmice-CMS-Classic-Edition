<?php

class PhraseForm extends Form
{

	public function __construct()
	{

		$this->genTextRules = array(
			'min' => 0,
			'max' => 100,
			'type' => 'string',

		);

		$this->add(array(
			'name' => 'text',
			'type'  => 'text',
			'label' => 'Phrase text: ',
			'value' => '',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'The string value of the phrase.',
		));

		$this->add(array(
			'name' => 'moduleName',
			'type'  => 'text',
			'label' => 'Module name: ',
			'value' => '',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Module name, where this phrase will be used.',
		));

		$this->add(array(
			'name' => 'specificName',
			'type'  => 'text',
			'label' => 'Specific name: ',
			'value' => '',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Event name, block name, etc.',
		));

		$this->add(array(
			'name' => 'type',
			'type' => 'select',
			'value' => 11,
			'label' => 'Select type: ',
			'options'  => array(
				11 => 'Global block',
				21 => 'Local form',
				22 => 'Local other',
			),
			'guide' => 'Integer value. Possible values are 11: global block; 21: local form; 22: local other.',
		));

		$this->add(array(
			'name' => 'uri',
			'type'  => 'text',
			'label' => 'Uri: ',
			'value' => '',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Another more specific identifier of the language phrase. Uri is meaning here shortly unique resource identifier. In current context and system uri is not refering to some strict worldwide standard.',
		));

		$this->add(array(
			'name' => 'modId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Select module: ',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
			'guide' => '',
		));

		$this->add(array(
			'name' => 'langId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Language: ',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
			'guide' => 'Select language for translated page.',
		));

		$this->add(array(
			'name' => 'langCode',
			'type' => 'select',
			'value' => 0,
			'label' => 'Language: ',
			'guide' => 'Select language for translated page.',
		));

        $this->add(array(
            'name' => 'phraseSet',
            'type'  => 'textarea',
            'label' => 'Input - Phrases in TSV table: ',
				'required' => false,
            'rules' => $this->genTextRules,
				'attributes'  => array(
					'id' => 'summaryArea',
					'rows' => '14',
					'cols' => '80',
				),
				'guide' => '',
        ));

        $this->add(array(
            'name' => 'outputString',
            'type'  => 'textarea',
            'label' => 'Output - SQL query string: ',
				'value' => '',
				'required' => false,
            'rules' => $this->genTextRules,
				'attributes'  => array(
					'id' => 'summaryArea',
					'rows' => '14',
					'cols' => '80',
				),
				'guide' => '',
        ));

        $this->add(array(
            'name' => 'save',
            'type'  => 'submit',
            'value' => 'Save',
            'id' => 'submitbutton',
        ));

        $this->add(array(
            'name' => 'submit1',
            'type'  => 'submit',
            'value' => 'Delete',
            'id' => 'submit1',
        ));

		$this->add(array(
			'name' => 'id',
			'type'  => 'hidden',
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
		$this->setValue('langId',$dbData['language_code']);
		$this->setValue('langCode',$dbData['language_code']);
		$this->setValue('moduleName',$dbData['module_name']);
		$this->setValue('specificName',$dbData['specific_name']);
		$this->setValue('type',$dbData['type']);
		$this->setValue('uri',$dbData['uri']);
		$this->setValue('text',$dbData['text']);

	}

	public function convertLangDbData($dbData)
	{

		$this->setValue('id',$dbData['id']);
		$this->setValue('langId',$dbData['language_code']);
		$this->setValue('langCode',$dbData['language_code']);
		$this->setValue('moduleName',$dbData['module_name']);
		$this->setValue('specificName',$dbData['specific_name']);
		$this->setValue('type',$dbData['type']);
		$this->setValue('uri',$dbData['uri']);
		$this->setValue('text',$dbData['text']);

	}

}
