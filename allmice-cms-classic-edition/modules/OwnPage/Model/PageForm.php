<?php

class PageForm extends Form
{

	public $accessFieldStatus;
	public $cacheFieldStatus;
	public $botTagStatus;

	public function __construct()
	{

        $this->add(array(
            'name' => 'id',
            'type'  => 'hidden',
        ));

        $this->add(array(
            'name' => 'creatorId',
            'type'  => 'hidden',
        ));

        $this->add(array(
            'name' => 'menuItemId',
            'type'  => 'hidden',
        ));

        $this->add(array(
				'name' => 'title',
				'type'  => 'text',
				'label' => 'Title*: ',
				'guide' => 'Title of the page (usually used for html title tag and in h1 tag). This field should not be empty',
				'required' => true,
				'validation' => 'shortText',
				'attributes'  => array(
					'style' => 'width:400px',
				),

        ));

        $this->add(array(
            'name' => 'descriptionArea',
            'type'  => 'textarea',
            'label' => 'Description meta tag: ',
				'guide' => 'Description of the page for html description meta tag. Helps Search Engine Optimizing. If field is empty, then default site wide, default Page module or default view method description will be used.',
				'required' => false,
				'attributes'  => array(
					'id' => 'descriptionArea',
					'rows' => '6',
					'cols' => '80',
				),

				'validation' => 'smallTextarea',
        ));

        $this->add(array(
            'name' => 'bodyArea',
            'type'  => 'textarea',
            'label' => 'Body: ',
				'guide' => 'Main content of the page.',
				'required' => false,
				'attributes'  => array(
					'id' => 'bodyArea',
					'rows' => '10',
					'cols' => '80',
				),
        ));

        $this->add(array(
            'name' => 'alias',
            'type'  => 'text',
            'label' => 'URL alias: ',
				'guide' => 'Use a SEO friendly URL starting with slash (/) instead of the default url \'/page/view/[id]\' to view this page. If this field is empty, then no alias will be used. If alias is used, then other default url will not be used.',
				'required' => false,
				'validation' => 'path',
				'attributes'  => array(
					'style' => 'width:400px',
				),
        ));

        $this->add(array(
            'name' => 'status',
            'type'  => 'radio_button',
            'value'  => 1,
            'label' => 'Page status: ',
				'guide' => 'Choose, whether this page is published or not. Good to use this option if page is not ready yet or in other occasions.',
				'options' => array(
					1 => "Published",
					2 => "Not published",
				),
        ));

		$this->add(array(
			'name' => 'caching',
			'type' => 'checkbox',
			'value' => array(),
			'label' => 'Caching for roles: ',
			'guide' => 'Choose, for which roles this page will be cached. Hold down Ctrl key to check multiple roles.',
		));

		$this->add(array(
			'name' => 'roleAccess',
			'type' => 'checkbox',
			'value' => array(
				0 => 1,
			),
			'label' => 'Access right for roles: ',
			'guide' => 'Choose, which roles can view this page. Hold down Ctrl key to check multiple roles.',
		));

		$this->add(array(
			'name' => 'botTag',
			'type' => 'select',
			'options' => array(
				1 => 'No tag (default - index, follow)',
				2 => 'Noindex, nofollow',
				3 => 'Noindex, follow',
				4 => 'Index, nofollow',
				5 => 'Index, follow (with tag)',
			),
			'attributes'  => array(
				'style' => 'width:260px',
			),
			'value' => 1,
			'label' => 'Robot meta tag: ',
			'guide' => 'Html meta tag for robots.',
		));

        $this->add(array(
            'name' => 'submit1',
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

		$this->add(array(
			'name' => 'label',
			'type' => 'text',
			'value' => '',
			'label' => 'Menu item label: ',
			'guide' => 'Human readable label for menu item (if this field is empty, then no menu item will be used for this page).',
			'required' => false,
			'attributes'  => array(
				'style' => 'width:400px',
			),

			'validation' => 'shortText',
		));

		$this->add(array(
			'name' => 'menuId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Menu: ',
			'guide' => 'Choose menu, where this item belongs to (if no menu is chosen, then no menu item will be used for this page).',
			'options'  => array(
				0 => 'No menu',
			),
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'weight',
			'type' => 'text',
			'value' => '1',
			'label' => 'Weight: ',
			'guide' => 'Weight is an integer number, which determines order of menu items.',
			'required' => false,
			'validation' => 'smallInt',
			'attributes'  => array(
				'style' => 'width:40px',
			),

		));

		$this->add(array(
			'name' => 'parentId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Menu item location: ',
			'guide' => 'Choose parent item in the menu for the current menu item.',
			'options'  => array(
				0 => 'Option 1',
				1 => 'Option 2',
			),
			'attributes'  => array(
				'style' => 'width:400px',
			),
		));

		$this->add(array(
			'name' => 'language',
			'type' => 'text',
			'value' => 'en',
			'label' => 'Language: ',
			'guide' => 'Two character code (ISO 639-1) or some other language code.',
			'required' => false,
			'validation' => 'code',
		));

    }

	public function convertPageDbData($dbData)
	{

		$this->setValue('id',$dbData['id']);
		$this->setValue('creatorId',$dbData['creatorId']);
		$this->setValue('title',$dbData['title']);
		$this->setValue('descriptionArea',$dbData['description']);
		$this->setValue('bodyArea',$dbData['body']);
		$this->setValue('status',$dbData['status']);
		$this->setValue('caching',$dbData['caching']);
		$this->setValue('roleAccess',$dbData['roleAccess']);
		$this->setValue('alias',$dbData['alias']);
		$this->setValue('botTag',$dbData['botTag']);

	}   

	public function convertMenuDbData($dbData)
	{

		if(count($dbData)==0){
			$dbData['id']=0;
			$dbData['label']="";
			$dbData['weight']=1;
			$dbData['menuId']=0;
			$dbData['parentId']=0;
			$dbData['depth']=0;
			$dbData['uri']="";
			$dbData['accessLevel']="";
		}

		$this->setValue('menuItemId',$dbData['id']);
		$this->setValue('menuId',$dbData['menuId']);
		$this->setValue('parentId',$dbData['parentId']);
		$this->setValue('depth',$dbData['depth']);
		$this->setValue('label',$dbData['label']);
		$this->setValue('uri',$dbData['uri']);
		$this->setValue('weight',$dbData['weight']);

	}   

}
