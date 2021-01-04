<?php

class SearchForm extends Form
{

	public function __construct()
	{

		$this->genTextRules = array(
			'min' => 0,
			'max' => 100,
			'type' => 'string',

		);

		$this->add(array(
			'name' => 'title',
			'type' => 'text',
			'value' => '',
			'label' => 'Title: ',
			'guide' => 'Title of the search option for the user, who will search.',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'searchPhrase',
			'type' => 'text',
			'value' => '',
			'label' => 'Search phrase: ',
			'guide' => 'Write here the search phrase or keyword which you wish to use by searching. Characters *, % in the phrase will be used as wild characters to search for 0 or more not determined symbols in the phrase.',
			'required' => true,
			'validation' => 'mediumText',
		));

		$this->add(array(
			'name' => 'description',
			'type' => 'text',
			'value' => '',
			'label' => 'Description: ',
			'guide' => 'Description of the search option for the user, who will search.',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'modName',
			'type' => 'text',
			'value' => '',
			'label' => 'Module name: ',
			'guide' => 'Module name, which is related to the searchable table and field.',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'searchTable',
			'type' => 'text',
			'value' => '',
			'label' => 'Table name: ',
			'guide' => 'Database table name, which contains the field, that will be searched. This table name is without table prefix (e.g. mod_page).',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'searchTableField',
			'type' => 'text',
			'value' => '',
			'label' => 'Search field name: ',
			'guide' => 'Database table field name, which will be searched.',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'titleTableField',
			'type' => 'text',
			'value' => '',
			'label' => 'Title field name: ',
			'guide' => 'Database table field name, which content will be showed in search results as title of the search result.',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'searchType',
			'type' => 'select',
			'value' => 0,
			'label' => 'Search location: ',
			'guide' => 'Choose the option, which explains what sort of data will be searched.',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'uri',
			'type' => 'text',
			'value' => '/',
			'label' => 'Path for result: ',
			'guide' => 'Path for search result link in format "/[module-path]/[event-path]" (e.g. "/page/view").',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'addWhereClause',
			'type' => 'text',
			'value' => '',
			'label' => 'Additional where clause: ',
			'guide' => 'If you wish to use some other table fields too as conditions for your search, then you can add to the search type some additional SQL where clause part. There should be no AND or OR at beginning of this clause (if query has many conditions, then such words should be in the middle of clause).',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'orderClause',
			'type' => 'text',
			'value' => '',
			'label' => 'Order sorting clause: ',
			'guide' => 'If you wish to sort the search result according to some table fields, then you can add here the table fields with sorting directions as they appear in SQL query (separate the fields by commas). Do not add the words ORDER BY to this field, but only the SQL query part as it is for sorting after these words.',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'resultFieldNames',
			'type' => 'text',
			'value' => '',
			'label' => 'Result field names: ',
			'guide' => 'Database table field names (separated by commas and spaces), which will be queried from database for displaying in search result table. You can add token [result:] in front of field name meaning, that only up to 200 characters will be queried from this field. E.g.: "id, title, [result:]body".',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'resultFieldTitles',
			'type' => 'text',
			'value' => '',
			'label' => 'Result field titles: ',
			'guide' => 'Database table field titles (separated by commas and spaces), which will be displayed for the search result table. E.g.: "[skip], Path, Module name". "[skip]" means that this column will actually not be displayed in result table, it is usually for id fields to be used as parts of links.',
			'required' => false,
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'language',
			'type' => 'text',
			'value' => 'en',
			'label' => 'Language: ',
			'guide' => 'Two character code (ISO 639-1) or some other language code.',
			'required' => true,
			'validation' => 'shortText',
		));

		$this->add(array(
			'name' => 'save',
			'type' => 'submit',
			'value' => 'Save',
			'id' => 'save',
		));

		$this->add(array(
			'name' => 'search',
			'type' => 'submit',
			'value' => 'Search',
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
		$this->setValue('title',$dbData['title']);
		$this->setValue('description',$dbData['description']);
		$this->setValue('modName',$dbData['module_name']);
		$this->setValue('searchTable',$dbData['search_table']);
		$this->setValue('searchTableField',$dbData['search_table_field']);
		$this->setValue('searchType',$dbData['id']);
		$this->setValue('titleTableField',$dbData['title_table_field']);
		$this->setValue('uri',$dbData['uri']);
		$this->setValue('addWhereClause',$dbData['add_where_clause']);
		$this->setValue('orderClause',$dbData['order_clause']);
		$this->setValue('resultFieldNames',$dbData['result_field_names']);
		$this->setValue('resultFieldTitles',$dbData['result_field_titles']);
		$this->setValue('language',$dbData['language_code']);

	}

}
