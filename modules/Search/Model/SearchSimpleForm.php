<?php

class SearchSimpleForm extends SimpleForm
{

	public function __construct()
	{

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

}
