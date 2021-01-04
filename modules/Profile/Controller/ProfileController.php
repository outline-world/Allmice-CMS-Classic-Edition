<?php 
/*
 * Profile module for Allmice™ CMS
 * Version 1.8.1 (2020-12-26)
 * Copyright 2020 by Adeenas OÜ, Copyright 2017 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Profile module for Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.TXT file in Allmice CMS root directory for more details about the license.
 */
 ?>

<?php

include $pathCoreController."Controller.php";
include $pathCoreModel."Form.php";
include $pathModuleModel."AppDatabase.php";

include $pathModuleModel."Profile.php";
include $pathModuleModel."ProfileForm.php";

class ProfileController extends Controller
{

	public $dbConfig;
	public $modConfig;
	public $modLang;

	public function indexEvent()
	{

		$form = new ProfileForm();
		$form->setUrl($GLOBALS['curUrl']);
		$form->setLanguage($GLOBALS['localLang']['form']);

		$Database=$this->dbConfig;
		$appDb = new AppDatabase($Database['app_db']);

		$lang=$GLOBALS['localLang']['other'];

		$Other=$this->otherConfig;
		$siteId=$Other['siteId'];
		$userId=$_SESSION[$siteId]['userData']['id'];
		$username=$_SESSION[$siteId]['userData']['name'];

		$profile = new Profile();
		$profile->userId = $userId; 
		$profile->username = $username; 

		$profileData=$appDb->getProfileDetails($userId);
		$profile->email=$appDb->getEmail($userId);

		$configData=$appDb->getConfigData("indexEvent");
		$config=$configData['indexEvent'];

		$form->langFieldStatus=$config['languageSwitch'];

		$profile->avatarImageSize=$config['avatarImageSize'];
		$profile->siteAvatarUrl=$GLOBALS['baseUrl']."/".$config['siteAvatarUrl'];

		$profile->imageType="allmice";

		if(count($profileData)==0){

			$profileData['gravatar_source']=$profile->email;
			$profileData['personal_notes']="";
			$profile->status = "noProfile"; 

		}else{
			$profile->status = "profileExists"; 

		}
		$profile->convertDbData($profileData);

		$form->formMap['langCode']['options']=$appDb->getLangOptions($userId);;

		if (isset($_POST['refreshImages'])) {
			$form->updateForm();
			$formData=$form->getData();
			$profile->convertFormData($formData);
			$profile->imageType="allmice";
			$profile->setAvatarImageSet($form);
		}
		elseif (isset($_POST['getEmailAddress'])) {
			$form->updateForm();
			$formData=$form->getData();
			$profile->convertFormData($formData);
			$profile->gravatarSource=$profile->email;
			$profile->imageType="allmice";
			$profile->setAvatarImageSet($form);
			$form->setValue('gravatarSource',$profile->email);
		}
		elseif (isset($_POST['save'])) {

			$form->updateForm();

			$form->validation($appDb->getValidityPatterns($GLOBALS['modName']),$GLOBALS['localLang']['form']);

			$formData=$form->getData();
			$profile->convertFormData($formData);

			if (isset($_POST['imageType'])) {
				$profile->imageType=$_POST['imageType'];
			}

			if(strtolower($profile->gravatarSource)!=strtolower($profile->email)){
				$form->isValid=false;
				$form->errorMessages[]=$lang['message1'];
			}

			if ($form->isValid) {
				$profile->setAvatarImageSet($form);

				if($config['languageSwitch']=="off"){
					$form->formMap['langCode']['value']=$config['defaultLanguage'];
					$profile->langCode=$config['defaultLanguage'];
				}

				$appDb->saveProfile($profile);
			}
			else{
				$form->setErrorMessages();
				$profile->setAvatarImageSet($form);
			}

		}
		else{
			$form->convertDbData($profileData);
			$profile->setAvatarImageSet($form);
			$form->formMap['langCode']['value']=$profileData['language_code'];
		}

		return array(
			'form' => $form,
			'profile' => $profile,
			'lang' => $lang,
		);

	}

}
