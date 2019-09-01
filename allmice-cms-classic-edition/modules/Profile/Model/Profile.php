<?php

class Profile
{

	public $userId;
	public $username;
	public $email;
	public $gravatarSource;
	public $personalNotes;
	public $avatarImageSet;
	public $avatarImageSize;

	public $avatarUrl;
	public $siteAvatarUrl;
	public $imageType;
	public $status;
	public $langCode;

	function getGravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	    $url = 'https://www.gravatar.com/avatar/';
	    $url .= md5( trim( $email ) );
	    $url .= "?s=$s&d=$d&r=$r";
	    if ( $img ) {
	        $url = '<img src="' . $url . '"';
	        foreach ( $atts as $key => $val )
	            $url .= ' ' . $key . '="' . $val . '"';
	        $url .= ' />';
	    }
	    return $url;
	}

	public function setAvatarImageSet($form)
	{

		$avatarImageSet=array();

		$typeArr=array(
			0=>"allmice",
			1=>"monsterid",
			2=>"mm",
			3=>"identicon",
			4=>"wavatar",
			5=>"retro",
			6=>"robohash"
		);

		for($i=0;$i<7;$i++){

			$buttonStatus="";

			$checkedString="";

			if($this->imageType==$typeArr[$i]){
				$checkedString=" checked=\"checked\"";
				$form->formMap['imageType']['attributes']=array(
					'checked' => 'checked'
				);
				if($i==0)
					$this->avatarUrl=$this->siteAvatarUrl;
				else
					$this->avatarUrl=$this->getGravatar($this->gravatarSource,$this->avatarImageSize,$typeArr[$i]);

			}else{
				$form->formMap['imageType']['attributes']=array();
			}

			$form->setValue('imageType',$typeArr[$i]);
			$radioTag=$form->get('imageType');

			$radioTag="";
			$radioTag.="<label class=\"radio-set2\">";
			$radioTag.="<input class=\"radio-button2\" value=\"".$typeArr[$i]."\" type=\"radio\" name=\"imageType\"".$checkedString.">";
			$radioTag.="<span class=\"radio-mark2\"></span></label>\n";

			if($i==0){
				$itemAvatarUrl=$this->siteAvatarUrl;

			}else{

				$itemAvatarUrl=$this->getGravatar($this->gravatarSource,$this->avatarImageSize,$typeArr[$i]);
			}

			$imgTag="<img src=\"".$itemAvatarUrl."\" alt=\"".$typeArr[$i]."\" />";

			$avatarImageSet[$i]=$imgTag.$radioTag;

		}
		$this->avatarImageSet=$avatarImageSet;

	}

	public function convertFormData($data)
	{

		$this->gravatarSource = (isset($data['gravatarSource'])) ? $data['gravatarSource'] : '';
		$this->personalNotes = (isset($data['personalNotes'])) ? $data['personalNotes'] : '';
		$this->imageType = (isset($data['imageType'])) ? $data['imageType'] : 'allmice';
		$this->langCode = (isset($data['langCode'])) ? $data['langCode'] : 'en';

	}

	public function convertDbData($data)
	{

		$this->gravatarSource = (isset($data['gravatar_source'])) ? $data['gravatar_source'] : 0;
		$this->personalNotes = (isset($data['personal_notes'])) ? $data['personal_notes'] : 0;
		$this->imageType = (isset($data['avatar_type'])) ? $data['avatar_type'] : "siteImage";
		$this->langCode = (isset($data['language_code'])) ? $data['language_code'] : "en";

	}

}
