<?php

class TsvForm extends Form
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
            'name' => 'tsvSet',
            'type'  => 'textarea',
            'label' => 'Input - Entries in TSV table: ',
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
				'name' => 'keyFields',
				'type' => 'text',
				'value' => 'module_name	uri	type	integer_value',
				'label' => 'Table key columns: ',
				'required' => false,
				'rules' => $this->genTextRules,
				'guide' => 'Enter database table column names, which are considered as identifying key columns to update the table. Separate the field names with tabs. E.g. "module_name	uri	type	integer_value".',
				'attributes'  => array(
					'style' => 'width:400px',
				),
			));

			$this->add(array(
				'name' => 'keyValues',
				'type' => 'text',
				'value' => '',
				'label' => 'Table key values: ',
				'required' => false,
				'rules' => $this->genTextRules,
				'guide' => 'Enter database table column values, which will be used to filter and list a set of database table entries. Separate the field names with tabs or with comma and space. List the values in same order, as are listed their corresponding columns in another form field.',
				'attributes'  => array(
					'style' => 'width:400px',
				),
			));

			$this->add(array(
				'name' => 'tableName',
				'type' => 'text',
				'value' => 'core_misc_data',
				'label' => 'Table name: ',
				'required' => false,
				'rules' => $this->genTextRules,
				'guide' => 'Enter database table name without prefix, which will be updated. E.g. "core_misc_data".',
			));


			$this->add(array(
				'name' => 'inputPath',
				'type' => 'text',
				'value' => '',
				'label' => 'Input path: ',
				'required' => false,
				'rules' => $this->genTextRules,
				'guide' => 'Relative path (under the /misc/input/SystemManager folder of the Allmice CMS) to the SQL file, which will be used to update the database.',
			));
	
		$this->add(array(
			'name' => 'htmlReplace',
			'type' => 'checkbox',
			'options' => array(
				0 => 'Replace HTML tag characters',
			),
			'label' => 'HTML character replace: ',

			'guide' => 'Tick the checkbox, if you wish to replace HTML tag characters &lt;, &gt;, \', &quot;. Replacements will be done in the whole TSV data - thus characters &lt;, &gt;, \', &quot; should not be in key field values of the TSV data.',
		));

		$this->add(array(
			'name' => 'tableNameList',
			'type' => 'select',
			'value' => 'none',
			'label' => 'Table name: ',
			'guide' => 'Choose a table, which entries you wish to list.',
			'options'  => array(
				0 => 'No menu',
			),
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'columnName',
			'type' => 'checkbox',
			'value' => array(),
			'label' => 'Menu item location: ',
			'guide' => 'Choose table column names, which entries you wish to list.',
			'options'  => array(
				0 => 'Option 1',
				1 => 'Option 2',
			),
			'attributes'  => array(
				'style' => 'width:400px',
			),
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
