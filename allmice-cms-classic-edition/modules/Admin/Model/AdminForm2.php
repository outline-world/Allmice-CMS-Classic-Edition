<?php

class AdminForm2 extends Form
{

    public function __construct()
    {

		$this->add(array(
			'name' => 'uri',
			'type' => 'text',
			'value' => '',
			'label' => 'Resource identifier (uri): ',
			'required' => false,
			'validation' => 'smallTextarea',
		));

		$this->add(array(
			'name' => 'specName',
			'type' => 'text',
			'value' => '',
			'label' => 'Specific name: ',
			'required' => false,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'modName',
			'type' => 'text',
			'value' => '',
			'label' => 'Module name: ',
			'required' => false,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'level',
			'type' => 'select',
			'value' => 1,
			'label' => 'Access level: ',
			'options'  => array(
				1 => 'Default: index, follow (without tag)',
				2 => 'Noindex, nofollow',
				3 => 'Noindex, follow',
				4 => 'Index, nofollow',
				5 => 'Index, follow (with tag)',
			),
		));

		$this->add(array(
			'name' => 'type',
			'type' => 'text',
			'value' => '',
			'label' => 'Config type: ',
			'required' => false,
			'validation' => 'code',
		));

		$this->add(array(
			'name' => 'description',
			'type'  => 'textarea',
			'value' => '',
			'label' => 'Config description: ',
			'required' => false,
				'attributes'  => array(
					'id' => 'descriptionArea',
					'rows' => '4',
					'cols' => '80',
				),
			'validation' => 'smallTextarea',
		));

		$this->add(array(
			'name' => 'value',
			'type'  => 'textarea',
			'value' => '',
			'label' => 'Config value: ',
			'required' => false,
				'attributes'  => array(
					'id' => 'descriptionArea',
					'rows' => '8',
					'cols' => '80',
				),
			'validation' => 'mediumTextarea',
		));

		$this->add(array(
			'name' => 'modId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Select module: ',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
		));

		$this->add(array(
			'name' => 'typeId',
			'type' => 'select',
			'value' => 0,
			'label' => 'Select type: ',
			'attributes'  => array(
				'onchange' => 'this.form.submit()',
			),
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
     ));

		$this->add(array(
			'name' => 'save',
			'type' => 'submit',
			'value' => 'Save changes',
			'id' => 'save',
		));

		$this->add(array(
			'name' => 'modCb',
			'type' => 'checkbox',
			'value' => 0,
			'label' => '',
		));

		$this->add(array(
			'name' => 'resCb',
			'type' => 'checkbox',
			'value' => 0,
			'label' => '',
		));

    }

	public function convertAccessDbData($dbData)
	{
		$this->setValue('id',$dbData['id']);
		$this->setValue('uri',$dbData['uri']);
		$this->setValue('modName',$dbData['modName']);
		$this->setValue('specName',$dbData['specName']);
		$this->setValue('level',$dbData['level']);
	}

	public function convertConfigDbData($dbData)
	{
		$this->setValue('id',$dbData['id']);
		$this->setValue('modName',$dbData['module_name']);
		$this->setValue('description',$dbData['description']);
		$this->setValue('uri',$dbData['uri']);
		$this->setValue('type',$dbData['type']);
		$this->setValue('value',$dbData['value']);
	}


	public function getTableScript()
	{

		$script="";

$script=<<<EOT
    <script type="text/javascript">
        $(document).ready(function() {
            $('td:nth-child(1),th:nth-child(1)').hide();
            $('#btnHide').hide();
            $('#btnHide').click(function() {
	            $('td:nth-child(1),th:nth-child(1)').hide();
	            $('#btnHide').hide();
	            $('#btnShow').show();
            });
            $('#btnShow').click(function() {
                $('td:nth-child(1),th:nth-child(1)').show();
	            $('#btnHide').show();
	            $('#btnShow').hide();
            });
        });
    </script>
EOT;
		return $script;

	}

}
