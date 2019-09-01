<?php

class BlockForm extends Form
{

	public function __construct()
	{

		$this->add(array(
			'name' => 'roleAccess',
			'type' => 'checkbox',
			'value' => array(
				0 => 1
			),
			'label' => 'Access right for roles',
			'guide' => 'Choose, which roles can view this block.',
		));

		$this->add(array(
			'name' => 'caching',
			'type' => 'checkbox',
			'value' => array(),
			'label' => 'Caching for roles',
			'guide' => 'Choose, for which roles this block will be cached.',
		));

		$this->add(array(
			'name' => 'blockCode',
			'type' => 'text',
			'value' => '',
			'label' => 'Block code *',
			'guide' => 'Usually same as entity code in the module, which entity this block is displaying in some region. Such entity module is determined below in the field "Type". For Menu type blocks it must be the same as menu name (menu code) to recognize, which menu this block will display.',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'rank',
			'type' => 'text',
			'value' => '1',
			'label' => 'Rank',
			'guide' => 'Rank is an integer number, which determines order of blocks in a region.',
			'required' => false,
			'validation' => 'tinyInt',
		));

		$this->add(array(
			'name' => 'regionCode',
			'type' => 'text',
			'value' => 'menuArea',
			'label' => 'Region code *',
			'guide' => 'Unique id code (name), which will be used in Region array in theme\'s layout file for the region, where this block belongs.',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'save',
			'type' => 'submit',
			'value' => 'Save',
			'id' => 'save',
		));

		$this->add(array(
			'name' => 'buildingModule',
			'type' => 'text',
			'value' => 'GlobalCore',
			'label' => 'Block building module *',
			'guide' => 'Module name, which will be used to build the block (usually GlobalCore or can be some custom module name).',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'type',
			'type' => 'text',
			'value' => 'Menu',
			'label' => 'Type *',
			'guide' => 'In most cases this is module name, which data will be displayed: e.g. Menu.',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'languageCode',
			'type' => 'select',
			'options' => array(
				'en' => 'en'
			),
			'value' => 'en',
			'label' => 'Language code: ',
			'guide' => 'Choose language code to this block. The block will be displayed only if this language is active.',
		));

		$this->add(array(
			'name' => 'displayMethod',
			'type' => 'text',
			'value' => 'buildMenuBlock',
			'label' => 'Block building method *',
			'guide' => 'Method name, which will be used to build the block (e.g. if using GlobalCore as building module for Menu type blocks, then the method is buildMenuBlock).',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'uri',
			'type' => 'text',
			'value' => '',
			'label' => 'Path',
			'guide' => 'Path to the block building class, if this class is outside GlobalCore module - if the block type is uriBased.',
			'required' => false,
		));

        $this->add(array(
			'name' => 'status',
			'type'  => 'select',
			'value'  => 1,
			'options'  => array(
				0 => 'Passive (not in use)',
				1 => 'Active (in use)',
			),
			'label' => 'Block status *',
			'guide' => 'Block status determines, whether to display this block or not.',
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

		if(isset($dbData['caching']))
			$this->setValue('caching',$dbData['caching']);
		$this->setValue('id',$dbData['id']);
		$this->setValue('blockCode',$dbData['block_code']);
		$this->setValue('rank',$dbData['rank']);
		$this->setValue('regionCode',$dbData['region_code']);
		$this->setValue('type',$dbData['type']);
		$this->setValue('displayMethod',$dbData['display_method']);
		$this->setValue('buildingModule',$dbData['building_module']);

		$this->setValue('uri',$dbData['uri']);
		$this->setValue('status',$dbData['status']);
		$this->setValue('languageCode',$dbData['language_code']);

	}

}
