<?php

class LanguageForm extends Form
{

	public function __construct()
	{

		$this->genTextRules = array(
			'min' => 0,
			'max' => 100,
			'type' => 'string',

		);

		$this->add(array(
			'name' => 'languageCode',
			'type'  => 'text',
			'label' => 'Language code: ',
			'value' => '',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'More specific unique two character code (ISO 639-1) or some other code if two character code is not unique enough for translating purposes. E.g. different English dialects may have same two character code en.',
		));

		$this->add(array(
			'name' => 'languageCode2',
			'type'  => 'text',
			'label' => 'Language code 2: ',
			'value' => '',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'General two character code (ISO 639-1) for html tags.',
		));

		$this->add(array(
			'name' => 'label',
			'type'  => 'text',
			'label' => 'Language label: ',
			'value' => '',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Label for drop-down menus or otherwise to recognize the language without abbreviation codes. E.g. English.',
		));

		$this->add(array(
			'name' => 'direction',
			'type'  => 'text',
			'label' => 'Language direction: ',
			'value' => 'ltr',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Possible values of the language directions are ltr (left to right) or rtl (right to left). This value may be used in themes as part of an html tag.',
		));

		$this->add(array(
			'name' => 'dateFormat',
			'type'  => 'text',
			'label' => 'Date format: ',
			'value' => 'Y-m-d',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Date format according to this language for the cases, if only date is needed to display, but not specific time (see also timeFormat). See http://php.net/manual/en/datetime.formats.date.php. For example "Y" is meaning 4 digit year, "m" 2 digit month, "d" 2 digit day - all with leading zeros.',
		));

		$this->add(array(
			'name' => 'timeFormat',
			'type'  => 'text',
			'label' => 'Time format: ',
			'value' => 'Y-m-d H:i:s',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Time format according to this language (see also dateFormat). See http://php.net/manual/en/datetime.formats.date.php. For example "Y" is meaning 4 digit year, "m" 2 digit month, "d" 2 digit day, "H" 2 digit 24 hours format, "i" 2 digit minutes, "s" 2 digit seconds - all with leading zeros.',
		));

		$this->add(array(
			'name' => 'numberFormat',
			'type'  => 'text',
			'label' => 'Number format: ',
			'value' => '#2#.',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Number format for the language in form: thousandsSeparator#decimals#decimalPoint. Part decimals specifies how many decimals. Part decimalPoint specifies what string to use for decimal point. Part thousandsSeparator specifies what string to use for thousands separator. If this value is empty, then the default will be used \'#2#.\'.',
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
			'name' => 'text',
			'type'  => 'text',
			'label' => 'Phrase text: ',
			'value' => '',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'The string value of the phrase.',
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
			'label' => 'Select language: ',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
			'guide' => '',
		));

		$this->add(array(
			'name' => 'langCode',
			'type' => 'select',
			'value' => 0,
			'label' => 'Language: ',
			'guide' => 'Select language for translated page.',
		));

		$this->add(array(
			'name' => 'status',
			'type' => 'select',
			'value' => 1,
			'label' => 'Status: ',
			'options'  => array(
				0 => 'Passive',
				1 => 'Active',
			),
			'guide' => 'Select status for the language.',
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
		$this->setValue('languageCode',$dbData['language_code']);
		$this->setValue('langCode',$dbData['language_code']);
		$this->setValue('moduleName',$dbData['module_name']);
		$this->setValue('modName',$dbData['module_name']);
		$this->setValue('specificName',$dbData['specific_name']);
		$this->setValue('type',$dbData['type']);
		$this->setValue('uri',$dbData['uri']);
		$this->setValue('text',$dbData['text']);
		$this->setValue('status',$dbData['status']);

	}

	public function convertLangDbData($dbData)
	{

		$this->setValue('id',$dbData['id']);
		$this->setValue('languageCode',$dbData['language_code']);
		$this->setValue('languageCode2',$dbData['language_code2']);
		$this->setValue('label',$dbData['label']);
		$this->setValue('direction',$dbData['direction']);
		$this->setValue('status',$dbData['status']);

		$this->setValue('dateFormat',$dbData['date_format']);
		$this->setValue('timeFormat',$dbData['time_format']);
		$this->setValue('numberFormat',$dbData['number_format']);

	}

}
