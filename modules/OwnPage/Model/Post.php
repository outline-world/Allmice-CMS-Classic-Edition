<?php

class Post
{

	public $formWidget;

    public function __construct($appDb,$ownerId,$pageId,$siteId) { 

		$userId=$_SESSION[$siteId]['userData']['id'];
		$username=$_SESSION[$siteId]['userData']['name'];

		$itemList=array();
		$errorMessages=array();
		$isValid=true;

		$sqlString="SELECT po.id, po.content, po.creator_id, po.editor_id, po.time_created, po.time_edited, po.type";
		$sqlString.=", po.creator_name";
		$sqlString.=", u.username AS editor_name";
		$sqlString.=", pr.avatar_url AS avatar_url";
		$sqlString.=" FROM ".$appDb->tablePrefix."mod_page_post po";
		$sqlString.=", ".$appDb->tablePrefix."core_user u";
		$sqlString.=", ".$appDb->tablePrefix."mod_profile pr";
		$sqlString.=" WHERE po.origin_id = ".$pageId;
		$sqlString.=" AND u.id = po.editor_id";
		$sqlString.=" AND u.id = pr.user_id";
		$sqlString.=" AND po.type >= 20";
		$sqlString.=" AND po.type < 30";
		$sqlString.=" ORDER BY po.type, po.time_created DESC";

		$stmt = $appDb->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		$formWidget="";
		if(count($itemList)>0 && $itemList[0]['type']==21){

			$contentValue="";
			$nameValue="";
			$emailValue="";

			$captcha = new Captcha($appDb,"App","submit1",$lang);

			if (isset($_POST['submit1'])) {

				if (isset($_POST['content'])) {
					$contentValue=$_POST['content'];
					$contentValue=str_replace("\n","<br />",$contentValue);
					$contentValue=htmlspecialchars($contentValue);
				}
				if (isset($_POST['name'])) {
					$nameValue=$_POST['name'];
					$nameValue=htmlspecialchars($nameValue);
				}
				if (isset($_POST['email'])) {
					$emailValue=$_POST['email'];
					$emailValue=htmlspecialchars($emailValue);
				}

				if ($nameValue=="" && $userId>0) {
					$nameValue=$username;
				}

				$patternSet=$appDb->getValidityPatterns($GLOBALS['modName']);

				if ($userId>0) {
					 $captcha->test=true;
					$pattern=$patternSet['mediumTextarea'];
					$input=$_POST['content'];
					if (!preg_match($pattern,$input) || $input==""){
						$isValid=false;
						if(!isset($langSet['formErrorGeneral']))
							$langSet['formErrorGeneral']="* Field '[elLabel]' is invalid!";
						$errorMessages[]=str_replace("[elLabel]","content",$langSet['formErrorGeneral']);
					}

				}else{
					$formKeys=array(
						'name',
						'email',
						'content',
						'captchaText'
					);

					$validation=array(
						'name' => 'smallTextarea',
						'email' => 'email',
						'content' => 'mediumTextarea',
						'captchaText' => 'captcha'
					);

					foreach($formKeys as $elName){
						$pattern=$patternSet[($validation[$elName])];
						$input=$_POST[($elName)];
						if (!preg_match($pattern,$input) || $input==""){
							$isValid=false;
							if(!isset($langSet['formErrorGeneral']))
								$langSet['formErrorGeneral']="* Field '[elLabel]' is invalid!";
							$errorMessages[]=str_replace("[elLabel]",$elName,$langSet['formErrorGeneral']);
						}
					}

				}

				if ($isValid) {
					if ($captcha->test) {

						if ($userId>0) {

							$profileExists=false;

							$sqlString="SELECT 1";
							$sqlString.=" FROM ".$appDb->tablePrefix."mod_profile";
							$sqlString.=" WHERE user_id = ".$userId;
							$sqlString.=" LIMIT 1";

							$stmt = $appDb->dbId->prepare($sqlString);
							$stmt->execute();
							$resultSet = $stmt->fetchAll();
							foreach ($resultSet as $row) {
								$profileExists=true;
							}

							if(!$profileExists){

								$sqlString="SELECT value";
								$sqlString.=" FROM ".$appDb->tablePrefix."core_config";
								$sqlString.=" WHERE module_name = 'Profile'";
								$sqlString.=" AND uri = 'siteAvatarUrl'";
								$sqlString.=" LIMIT 1";

								$stmt = $appDb->dbId->prepare($sqlString);
								$stmt->execute();
								$resultSet = $stmt->fetchAll();
								foreach ($resultSet as $row) {
									$avatarUrl = $row['value'];
								}

								$sqlString="INSERT INTO ".$appDb->tablePrefix."mod_profile (user_id, avatar_type, avatar_url";
								$sqlString.=")";
								$sqlString.=" VALUES (";
								$sqlString.=":userId";
								$sqlString.=", 'allmice'";
								$sqlString.=", :avatarUrl";
								$sqlString.=")";

								$stmt = $appDb->dbId->prepare($sqlString);

								$stmt->execute(array(
									":userId" => $userId,
									":avatarUrl" => $avatarUrl
								));

							}
						}

						$modName="Page";
						$type=22;
						$curTime=time();
						$sqlString="INSERT INTO ".$appDb->tablePrefix."mod_page_post (origin_id, creator_id, editor_id, email";

						$sqlString.=", creator_name";
						$sqlString.=", content";
						$sqlString.=", type";
						$sqlString.=", time_created";
						$sqlString.=", time_edited";
						$sqlString.=")";
						$sqlString.=" VALUES (";
						$sqlString.=":pageId";
						$sqlString.=", :creatorId";
						$sqlString.=", :editorId";
						$sqlString.=", :email";

						$sqlString.=", :creatorName";
						$sqlString.=", :content";
						$sqlString.=", :type";
						$sqlString.=", :timeC";
						$sqlString.=", :timeE";
						$sqlString.=")";

						$stmt = $appDb->dbId->prepare($sqlString);

						$stmt->execute(array(
							":pageId" => $pageId,
							":creatorId" => $userId,
							":editorId" => $userId,
							":email" => $emailValue,

							":creatorName" => $nameValue,
							":content" => $contentValue,
							":type" => $type,
							":timeC" => $curTime,
							":timeE" => $curTime
						));

						$url=$GLOBALS['curUrl'];
						$permanent=false;
					    header('Location:' . $url, true, $permanent ? 301 : 302);
					    exit();

					}
					else{
						$errorMessages[]="Captcha code is not correct.";
					}
				}
			}

			if(count($errorMessages)>0){
				$GLOBALS['messageList']=array();
				$classStart[]="messageClassStart-red";
				$classEnd[]="messageClassEnd";
				$GLOBALS['messageList']=array_merge($classStart,$errorMessages,$classEnd);
			}
			$configData=array();
			$template = "";

			$sqlString="SELECT type, uri, value";
			$sqlString.=" FROM ".$appDb->tablePrefix."core_config";
			$sqlString.=" WHERE module_name = 'Page'";
			$sqlString.=" AND type = 'postTemplate'";

			$stmt = $appDb->dbId->prepare($sqlString);
			$stmt->execute();
			$resultSet = $stmt->fetchAll();
			foreach ($resultSet as $row) {
				$configData[($row['type'])][($row['uri'])] = $row['value'];
			}

			$itemTemplate=htmlspecialchars_decode($configData['postTemplate']['postItemView']);

			$formWidget.="<div class=\"post-header\">";
			$formWidget.=$itemList[0]['content'];
			$formWidget.="</div>";

			if($emailValue!=""){
				$gravEmail=$emailValue;
			}
			else{
				$gravEmail="none";
			}

			$gravEmail="6IOTcL9vpfT454";

			for($i=1;$i<count($itemList);$i++){

				$itemData=$itemTemplate;

				$imgCode="<img src=\"".$itemList[$i]['avatar_url']."\" alt=\"\" />";

				$itemData=str_replace("[gravatar]",$imgCode,$itemData);
				$itemData=str_replace("[content]",$itemList[$i]['content'],$itemData);

				$itemData=str_replace("[creatingTime]",gmdate("j F Y H:i", $itemList[$i]['time_created']),$itemData);
				$itemData=str_replace("[creatorName]",$itemList[$i]['creator_name'],$itemData);

				if($itemList[$i]['time_created']!=$itemList[$i]['time_edited']){
					$itemData=str_replace("[editingTime]",gmdate("j F Y H:i", $itemList[$i]['time_edited']),$itemData);
					$itemData=str_replace("[editorName]",$itemList[$i]['editor_name'],$itemData);
					$itemData=str_replace("[editDataStart]","",$itemData);
					$itemData=str_replace("[editDataEnd]","",$itemData);

				}else{
					$itemData=str_replace("[editingTime]","",$itemData);
					$itemData=str_replace("[editorName]","",$itemData);

					$tempArr=explode("[editDataStart]",$itemData,2);

					$tempArr2=explode("[editDataEnd]",$tempArr[1],2);

					$itemData=$tempArr[0].$tempArr2[1];

				}

				$formWidget.="<div class=\"post-wrap\">\n";
				$formWidget.=$itemData;
				if($userId!=0 && ($ownerId==$userId || $userId==1 || $itemList[$i]['creator_id']==$userId)){
					$url=$GLOBALS['baseUrl']."/page/edit-post/".$itemList[$i]['id'];
					$formWidget.="<a href=\"".$url."\" target=\"_blank\">Edit post</a>\n";
				}
				$formWidget.="</div>\n";

			}

			$formWidget.="<form action=\"".$GLOBALS['curUrl']."\" method=\"post\">";
			$formWidget.="<div class=\"comment\">\n";
			if($userId<1){

				$formWidget.="<div class=\"form-field\">";
				$formWidget.="<label><span class=\"label-text\">Your name *</span>";
				$formWidget.="<input type=\"text\" id=\"name\" name=\"name\" class=\"comment\" value=\"".$nameValue."\" maxlength=\"60\" />\n";
				$formWidget.="</label>";
				$formWidget.="</div>";

				$formWidget.="<div class=\"form-field\">";
				$formWidget.="<label><span class=\"label-text\">Your email *</span>";
				$formWidget.="<input type=\"text\" id=\"email\" name=\"email\" class=\"comment\" value=\"".$emailValue."\" maxlength=\"60\" />\n";
				$formWidget.="</label>";
				$formWidget.="</div>";
			}

			if($contentValue!="")
				$contentValue=str_replace("<br />","\n",$contentValue);

			$formWidget.="<div class=\"form-field\">";
			$formWidget.="<label><span class=\"label-textarea\">Your comment *</span>";
			$formWidget.="<textarea id=\"content\" name=\"content\" rows=\"10\" cols=\"80\">\n";
			$formWidget.=$contentValue;
			$formWidget.="</textarea>";
			$formWidget.="</label>";
			$formWidget.="</div>";

			if($userId<1)
				$formWidget.=$captcha->formWidget;

			$formWidget.="<input type=\"submit\" name=\"submit1\" value=\"Submit comment\" />\n";

			$formWidget.="</form>\n";
			$formWidget.="</div>\n";

		}

		if($ownerId==$userId || $userId==1){
			$url=$GLOBALS['baseUrl']."/page/manage-posting-access/".$pageId;
			$formWidget.="<a href=\"".$url."\" target=\"_blank\">Manage posting access</a>\n";

		}

		$this->formWidget=$formWidget;

    }

	function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
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

}
