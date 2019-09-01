<?php

class InstallForm extends Form
{

    public function __construct()
    {

		$this->genTextRules = array(
					'min' => 0,
					'max' => 100,
					'type' => 'string',
		);
    // check if name only contains letters and whitespace
//    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {

		$this->add(array(
         'name' => 'id',
         'type'  => 'hidden',
     ));

		$this->add(array(
         'name' => 'install',
         'type'  => 'submit',
         'value' => 'Submit',
         'id' => 'install',
     ));

		$siteNameRules = array(
			'min' => 0,
			'max' => 60,
			'type' => 'lengthOnly',
		);
		$this->add(array(
			'name' => 'siteName',
			'type' => 'text',
			'value' => '',
			'label' => 'Website name *',
			'guide' => '',
			'required' => true,

			'rules' => $siteNameRules,
		));

		$adminPasswordRules = array(
			'min' => 6,
			'max' => 30,
			'type' => 'string',
		);
		$this->add(array(
			'name' => 'adminPassword',
			'type' => 'password',
			'value' => '',
			'label' => 'Admin user password *',
			'guide' => 'Password for default user admin - at least 6 characters.',
			'required' => true,
			'rules' => $adminPasswordRules,
		));

		$eMailRules = array(
			'min' => 6,
			'max' => 250,
			'type' => 'eMail',
		);
		$this->add(array(
			'name' => 'eMail',
			'type' => 'text',
			'value' => 'example@allmice.com',
			'label' => 'Admin user e-mail *',
			'guide' => 'Replace the example e-mail address with your real e-mail address for user admin.',
			'required' => true,
			'rules' => $eMailRules,
		));

		$dbNameRules = array(
			'min' => 1,
			'max' => 50,
			'type' => 'string',
		);
		$this->add(array(
			'name' => 'dbName',
			'type' => 'text',
			'value' => '',
			'label' => 'Database name *',
			'guide' => '',
			'required' => true,
			'rules' => $dbNameRules,
		));

		$dbUserNameRules = array(
			'min' => 1,
			'max' => 50,
			'type' => 'string',
		);
		$this->add(array(
			'name' => 'dbUserName',
			'type' => 'text',
			'value' => '',
			'label' => 'Database user name *',
			'guide' => '',
			'required' => true,
			'rules' => $dbUserNameRules,
		));

		$dbUserPasswordRules = array(
			'min' => 6,
			'max' => 50,
			'type' => 'string',
		);
		$this->add(array(
			'name' => 'dbUserPassword',
			'type' => 'password',
			'value' => '',
			'label' => 'Database user password *',
			'guide' => 'At least 6 characters.',
			'required' => true,
			'rules' => $dbUserPasswordRules,
		));

		$dbHostRules = array(
			'min' => 1,
			'max' => 50,
			'type' => 'string',
		);
		$this->add(array(
			'name' => 'dbHost',
			'type' => 'text',
			'value' => 'localhost',
			'label' => 'Database host *',
			'guide' => '',
			'required' => true,
			'rules' => $dbHostRules,
		));

		$tablePrefixRules = array(
			'min' => 0,
			'max' => 20,
			'type' => 'string',
		);
		$this->add(array(
			'name' => 'tablePrefix',
			'type' => 'text',
			'value' => '',
			'label' => 'Table prefix',
			'guide' => '',
			'required' => false,
			'rules' => $tablePrefixRules,
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

	public function convertMesData($mesArray)
	{
		$mesString="";
		foreach($mesArray as $row){
			$mesString.=($row."<br />\n");
		}

		return $mesString;

	}

}
