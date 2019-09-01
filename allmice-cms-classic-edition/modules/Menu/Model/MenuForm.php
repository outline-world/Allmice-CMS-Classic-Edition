<?php

class MenuForm extends Form
{

	public function __construct()
	{

		$this->add(array(
			'name' => 'id',
			'type'  => 'hidden',
		));

		$this->add(array(
			'name' => 'menuId',
			'type'  => 'hidden',
		));

		$this->add(array(
			'name' => 'code',
			'type' => 'text',
			'value' => '',
			'label' => 'Menu name for computer: ',
			'guide' => '',
			'required' => true,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'title',
			'type' => 'text',
			'value' => '',
			'label' => 'Human readable title for menu header: ',
			'guide' => '',
			'required' => true,
			'validation' => 'text60',
		));

		$this->add(array(
			'name' => 'type',
			'type' => 'select',
			'value' => 21,
			'label' => 'Menu type (horizontal, vertical): ',
			'guide' => 'The phrase "extended access" is meaning in the options, that the items of such menu can be added, edited, deleted also through another module, than Menu. In extended menus an user can change items even if his/her role has no access to change the items using Menu module, but has access rights to another module, which allows menu item managing. For example: a user may have access to change some Page module entities and by doing so can change the menu items related to such page entities as well, but such user has no access to change menu items using Menu module.',
			'options'  => array(
				11 => "Classic menu, all options open, without title",
				12 => "Classic menu, all options open, without title; extended access",
//				15 => "Drop-down Superfish Basic (horizontal)",
//				16 => "Drop-down Superfish Basic (horizontal); extended access",
				17 => "Drop-down, opens all sub-menus, (usually horizontal)",
				18 => "Drop-down, opens all sub-menus, (usually horizontal); extended access",
				21 => "Classic menu, all options open, with title (usually vertical)",
				22 => "Classic menu, all options open, with title (usually vertical); extended access",
				23 => "Active sub-menu available, (usually vertical)",
				24 => "Active sub-menu available, (usually vertical); extended access",
//				25 => "Drop-down Superfish Basic (vertical)",
//				26 => "Drop-down Superfish Basic (vertical); extended access",
				31 => "Link set without title",
				32 => "Link set without title; extended access",
				33 => "Link set with title",
				34 => "Link set with title; extended access",
				41 => "Custom type",
				42 => "Custom type; extended access",
			),
			'attributes'  => array(
				'style' => 'width:500px',
			),
		));

		$this->add(array(
			'name' => 'status',
			'type' => 'select',
			'value' => 1,
			'label' => 'Menu status (active, passive): ',
			'guide' => '',
			'options'  => array(
				1 => "Active",
				2 => "Passive",
			),
		));

		$this->add(array(
			'name' => 'roleAccess',
			'type' => 'checkbox',
			'value' => array(
				0 => 1
			),
			'label' => 'Access right for roles: ',
			'guide' => 'These access rights determine displaying access rights for Menu module method view. If you wish to determine access right for the block of this menu, then you can do it using Block module add or edit events.',
		));

		$this->add(array(
			'name' => 'caching',
			'type' => 'checkbox',
			'value' => array(),
			'label' => 'Caching for roles: ',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'saveMenu',
			'type' => 'submit',
			'value' => 'Save menu',
			'id' => 'saveMenu',
		));

		$this->add(array(
			'name' => 'label',
			'type' => 'text',
			'value' => '',
			'label' => 'Human readable label for menu item: ',
			'guide' => '',
			'required' => true,
			'validation' => 'text60',
		));

		$this->add(array(
			'name' => 'uri',
			'type' => 'text',
			'value' => '',
			'label' => 'URL, where this menu item is linking to: ',
			'guide' => '',
			'required' => true,
			'validation' => 'uri',
		));

		$this->add(array(
			'name' => 'weight',
			'type' => 'text',
			'value' => '1',
			'label' => 'Weight, an integer number, determines order of items: ',
			'guide' => '',
			'required' => true,
			'validation' => 'tinyInt',
			'rules' => $this->genTextRules,
		));

		$this->add(array(
			'name' => 'parentId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Choose item location: ',
			'guide' => '',
		));

		$this->add(array(
			'name' => 'saveMenuItem',
			'type' => 'submit',
			'value' => 'Save menu item',
			'id' => 'saveMenuItem',
		));

		$this->add(array(
			'name' => 'menuList',
			'type' => 'select',
			'value' => 1,
			'label' => 'Choose menu: ',
			'guide' => '',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'itemStatus',
			'type' => 'select',
			'value' => 1,
			'label' => 'Menu item status: ',
			'guide' => '',
			'options'  => array(
				0 => "Passive (not visible in menu)",
				1 => "Active without target property",
				2 => "Active with target property value _blank",
			),
			'attributes'  => array(
				'style' => 'width:400px',
			),
		));

		$this->add(array(
			'name' => 'modId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Select module: ',
			'guide' => 'Select, which module content you wish to show for creating the menu.',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'resCb',
			'type' => 'checkbox',
			'value' => 0,
			'label' => '',
		));

		$this->add(array(
			'name' => 'save',
			'type' => 'submit',
			'value' => 'Save menu',
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

		if(isset($dbData['id']))
			$this->setValue('id',$dbData['id']);

		if(isset($dbData['menu_id']))
			$this->setValue('menuId',$dbData['menu_id']);
		if(isset($dbData['parent_id']))
			$this->setValue('parentId',$dbData['parent_id']);

		if(isset($dbData['code']))
			$this->setValue('code',$dbData['code']);
		if(isset($dbData['status']))
			$this->setValue('status',$dbData['status']);
		if(isset($dbData['title']))
			$this->setValue('title',$dbData['title']);
		if(isset($dbData['type']))
			$this->setValue('type',$dbData['type']);

		if(isset($dbData['label']))
			$this->setValue('label',$dbData['label']);
		if(isset($dbData['weight']))
			$this->setValue('weight',$dbData['weight']);
		if(isset($dbData['uri']))
			$this->setValue('uri',$dbData['uri']);
		if(isset($dbData['itemStatus']))
			$this->setValue('itemStatus',$dbData['itemStatus']);

	}

}
