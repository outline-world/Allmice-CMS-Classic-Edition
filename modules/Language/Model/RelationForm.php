<?php

class RelationForm extends Form
{

	public function __construct()
	{

		$this->genTextRules = array(
			'min' => 0,
			'max' => 100,
			'type' => 'string',

		);

		$this->add(array(
			'name' => 'parentId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Main page title (origin): ',
			'guide' => 'Select related page (origin) in main language.',
		));

		$this->add(array(
			'name' => 'childId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Translated page title: ',
			'guide' => 'Select translated page.',
		));

		$this->add(array(
			'name' => 'modId',
			'type' => 'select',
			'value' => 1,
			'label' => 'Select module: ',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
			'guide' => '',
		));

		$this->add(array(
			'name' => 'langId',
			'type' => 'select',
			'value' => 1,
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
			'name' => 'modName',
			'type'  => 'text',
			'label' => 'Module name: ',
			'value' => 'Page',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Module name for the translatable item (e.g. Page).',
		));

		$this->add(array(
			'name' => 'type',
			'type'  => 'text',
			'label' => 'Type: ',
			'value' => 'page',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Type of the translatable item (e.g. page).',
		));

		$this->add(array(
			'name' => 'path',
			'type'  => 'text',
			'label' => 'Path: ',
			'value' => 'page/view',
			'required' => false,
			'rules' => $this->genTextRules,
			'guide' => 'Path (fragment of URL) for the translatable item (e.g. page/view).',
		));

        $this->add(array(
            'name' => 'save',
            'type'  => 'submit',
            'value' => 'Save',
            'id' => 'submitbutton',
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
		$this->setValue('parentId',$dbData['parent_item_id']);
		$this->setValue('childId',$dbData['child_item_id']);

		$this->setValue('modName',$dbData['module_name']);
		$this->setValue('type',$dbData['type']);
		$this->setValue('path',$dbData['path']);
		$this->setValue('langCode',$dbData['language_code']);

	}

}
