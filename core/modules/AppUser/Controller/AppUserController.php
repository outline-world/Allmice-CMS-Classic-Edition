<?php 
/*
 * Allmice™ CMS
 * Version 1.8.1 (2020-12-26)
 * Copyright 2020 by Adeenas OÜ, Copyright 2017 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>
 <?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include $pathCoreModel."Paginator.php";

include $pathModuleModel."AppDatabase.php";
include $pathModuleModel."UserForm.php";
include $pathModuleModel."User.php";

class AppUserController extends Controller
{  

	public $dbConfig;
	public $modConfig;
	public $otherConfig;

	public function indexEvent()
	{

		$loginForm = new userForm();
		$loginForm->setLanguage($GLOBALS['localLang']['form']);

		$Other=$this->otherConfig;

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);
		$modConfig=$this->modConfig;

		if(isset($Other['siteSalt']))
			$appDb->salt=$Other['siteSalt'];

		$siteId=$Other['siteId'];
		if(!isset($_SESSION[$siteId]['userData'])){
			$_SESSION[$siteId]['userData']['id']=0;
			$_SESSION[$siteId]['userData']['roleId']=2;
			$_SESSION[$siteId]['userData']['name']="";
		}
		$loginForm->setUrl(($GLOBALS ['baseUrl']."/app-user"));

		if(isset($_POST['login'])){

			$userData=$appDb->getUserData($_POST['username'],$_POST['password']);

			if(count($userData)>0 && isset($_POST['username']) && isset($userData['id']) && $userData['id']>0){

				$_SESSION[$siteId]['userData']['id']=$userData['id'];
				$_SESSION[$siteId]['userData']['roleId']=$userData['roleId'];
				$_SESSION[$siteId]['userData']['name']=$_POST['username'];

				$redirectUrl="".$GLOBALS ['baseUrl'];
				$this->redirect($redirectUrl, true);

			}

		}
		if(isset($_POST['logout'])){
			$_SESSION[$siteId]['userData']['id']=0;
			$_SESSION[$siteId]['userData']['roleId']=2;
			$_SESSION[$siteId]['userData']['name']="";
		}

		$userData=$_SESSION[$siteId]['userData'];

		return array(
			'userData' => $userData,
			'loginForm' => $loginForm,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

	public function loginEvent()
	{
		$output = $this->indexEvent();
		return $output;
	}

	public function logoutEvent()
	{

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];

		$_SESSION[$siteId]['userData']['id']=0;
		$_SESSION[$siteId]['userData']['roleId']=2;
		$_SESSION[$siteId]['userData']['name']="";

		$output="";

		$redirectUrl="".$GLOBALS ['baseUrl'];
		$this->redirect($redirectUrl, false);

		return array(
			'output' => $output,
			'lang' => $GLOBALS['localLang']['other'],
		);

	}

}
