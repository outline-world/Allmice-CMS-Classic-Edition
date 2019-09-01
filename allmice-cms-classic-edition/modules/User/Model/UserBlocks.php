<?php

class UserBlocks
{

	public $dbId;
	public $tablePrefix;

	function buildUserBlock() {

		$Other=$this->otherConfig;
		$siteId=$GLOBALS['siteId'];

		$GLOBALS['userBlock']['logoutLabel']="";
		$GLOBALS['userBlock']['username']="";
		$appDb = $GLOBALS['db'];
		$this->dbId=$GLOBALS['db']['id'];
		$this->tablePrefix=$GLOBALS['db']['tablePrefix'];

		if($_SESSION[$siteId]['userData']['id']==0){

			if(isset($_POST['showLoginForm'])){

				$lang=$this->getLangSet("buildUserBlock:loginForm");

				$configData=$this->getConfigData('');
				$registerCode=htmlspecialchars_decode($configData['loginView']['registerLink']);
				if($registerCode!=""){
					$registerCode=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$registerCode);
					$registerCode=str_replace("[lang-registerLink]",$lang['registerLink'],$registerCode);
					if($lang['registerText']!="")
						$registerCode="<div class=\"link-area\">".htmlspecialchars_decode($lang['registerText'])."<br />\n".$registerCode."</div>";
//						$registerCode=htmlspecialchars_decode($lang['registerText'])."<br />\n".$registerCode;
				}

				$recoveryCode=htmlspecialchars_decode($configData['loginView']['recoveryLink']);
				if($recoveryCode!=""){
					$recoveryCode=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$recoveryCode);
					$recoveryCode=str_replace("[lang-recoveryLink]",$lang['recoveryLink'],$recoveryCode);
					if($lang['recoveryText']!="")
						$recoveryCode="<div class=\"link-area\">".htmlspecialchars_decode($lang['recoveryText'])."<br />\n".$recoveryCode."</div>";
//						$recoveryCode=htmlspecialchars_decode($lang['recoveryText'])."<br />\n".$recoveryCode;
				}

				$verifyCode=htmlspecialchars_decode($configData['loginView']['verifyLink']);
				if($verifyCode!=""){
					$verifyCode=str_replace("[baseUrl]",$GLOBALS['baseUrl'],$verifyCode);
					$verifyCode=str_replace("[lang-verifyLink]",$lang['verifyLink'],$verifyCode);
					if($lang['verifyText']!="")
						$verifyCode="<div class=\"link-area\">".htmlspecialchars_decode($lang['verifyText'])."<br />\n".$verifyCode."</div>";
//						$verifyCode=htmlspecialchars_decode($lang['verifyText'])."<br />\n".$verifyCode;
				}

				$blockView="";

				$blockView.="<div id=\"login-form-area\" class=\"login-form-area\">";
				$blockView.="<form action=\"".$GLOBALS['curUrl']."\" method=\"post\">\n";
				$blockView.="<div class=\"user-block-header\">";
				$blockView.="<div class=\"window-title\">";
				$blockView.=$lang['blockTitle'];
				$blockView.="</div>";
				$blockView.="<input name=\"closeLoginArea\" type=\"submit\" class=\"close-button\" value=\"X\" />";
//				$blockView.="<br>";
				$blockView.="</div>";
				$blockView.="<div class=\"user-block-content\">";
				$blockView.="<div class=\"form-field\">";
				$blockView.="<label><span class=\"label-text\">".$lang['usernameLabel']."</span><input name=\"username\" type=\"text\" class=\"user-block-content\" value=\"\">";
				$blockView.="</label>";
				$blockView.="</div>";
				$blockView.="<div class=\"form-field\">";
				$blockView.="<label><span class=\"label-password\">".$lang['passwordLabel']."</span><input name=\"password\" type=\"password\" class=\"user-block-content\" value=\"\">";
				$blockView.="</label>";
				$blockView.="</div>";
				$blockView.="<div class=\"form-field\">";
				$blockView.="<input name=\"login\" type=\"submit\" class=\"user-block-content\" value=\"".$lang['loginValue']."\">";
				$blockView.="</div>";
				$blockView.="<br />";
				$blockView.=$registerCode;
//				$blockView.="<br />";
				$blockView.=$recoveryCode;
//				$blockView.="<br />";
				$blockView.=$verifyCode;

				$blockView.="</div>";
				$blockView.="</form>";

				$blockView.="</div>";

				$blockScript=$this->getBlockScript();
				$GLOBALS['headTags']=$GLOBALS['headTags'].$blockScript;

			}
			elseif(isset($_POST['login'])){

				$lang=$this->getLangSet("buildUserBlock:loginAction");

				$userData=$this->getUserData($_POST['username'],$_POST['password']);
				$redirectUrl="".$GLOBALS['curUrl'];
				$blockView="";
				$blockView.="<div class=\"log-button\">";
				$blockView.="<form action=\"".$GLOBALS['curUrl']."\" method=\"post\">\n";
				$blockView.="";
				$blockView.="<input type=\"submit\" name=\"showLoginForm\" class=\"user-block\" value=\"".$lang['loginValue']."\" />";
				$blockView.="</form>";
				$blockView.="</div>";

				if(count($userData)>0 && isset($_POST['username']) && isset($userData['id']) && $userData['id']>0){

					$_SESSION[$siteId]['userData']['id']=$userData['id'];
					$_SESSION[$siteId]['userData']['roleId']=$userData['roleId'];
					$_SESSION[$siteId]['userData']['name']=$_POST['username'];

					$redirectChoice=false;

					$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"success-note\">".$lang['message1']."</div>";

					header('Location:' . $redirectUrl, true, $redirectChoice ? 301 : 302);
					exit();

				}
				else{
					$_SESSION[($GLOBALS['siteId'])]['messageList'][]="<div class=\"problem-note\">".$lang['message2']."</div>";
				}

			}
			else{
				$lang=$this->getLangSet("buildUserBlock:loginLink");

				$blockView="";
				$blockView.="<div class=\"log-button\">";
				$blockView.="<form action=\"".$GLOBALS['curUrl']."\" method=\"post\">\n";
				$blockView.="";
				$blockView.="<input type=\"submit\" name=\"showLoginForm\" class=\"user-block\" value=\"".$lang['loginValue']."\" />";
				$blockView.="</form>";
				$blockView.="</div>";

			}

		}
		else{
			$lang=$this->getLangSet("buildUserBlock:logoutLink");

			if(!isset($_SESSION[$siteId]['userData'])){
				$_SESSION[$siteId]['userData']['id']=0;
				$_SESSION[$siteId]['userData']['roleId']=2;
				$_SESSION[$siteId]['userData']['name']="";
			}

			if(isset($_SESSION[$siteId]['userData']) && $_SESSION[$siteId]['userData']['id']>0){
				$logStatus="in";
			}

			$GLOBALS['userBlock']['logoutLabel']=$lang['logoutLabel'];
			$GLOBALS['userBlock']['username']=$_SESSION[$siteId]['userData']['name'];

			$blockView="";
			$blockView.="<div class=\"log-button\">";
			$blockView.="<form action=\"".$GLOBALS['baseUrl']."/user/logout\" method=\"post\">\n";
			$blockView.="";
			$blockView.="<input type=\"submit\" name=\"logout\" class=\"user-block\" value=\"".$lang['logoutValue']."\" />";
			$blockView.="</form>";
			$blockView.="</div>";

		}

		return $blockView;
	}

	public function getUserData($name,$formPass)
	{

		$dbUserData = array();
		$userData=array();
		$userId=0;
		$userData['id']=0;
		$userData['roleId']=2;
		$userData=array();

		$sqlString="SELECT id, active_role_id AS roleId, password";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE username = :username";
		$sqlString.=" AND status = 2";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":username" => $name
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$dbUserData = $row;
		}

		if(count($dbUserData)>0){
			$reversedParts = explode('$', strrev($dbUserData['password']), 2);		
			$savedSalt=strrev($reversedParts[1]);
			$cryptedFormPass=crypt($formPass,$savedSalt);
			if($cryptedFormPass==$dbUserData['password']){
				$userData['id']=$dbUserData['id'];
				$userData['roleId']=$dbUserData['roleId'];
			}
		}

		return $userData;

	}

	public function getConfigData($typePrefix)
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'User'";
		if($typePrefix!="")
			$sqlString.=" AND type LIKE '".$typePrefix."%'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$configData[($row['type'])][($row['uri'])] = $row['value'];
		}

		return $configData;

	}

	public function getLangSet($blockCode)
	{

		$itemList=array();

		$sqlString="SELECT uri, text";
		$sqlString.=" FROM ".$this->tablePrefix."core_language";
		$sqlString.=" WHERE language_code = :langCode";
		$sqlString.=" AND specific_name = :blockCode";
		$sqlString.=" AND module_name = 'User'";
		$sqlString.=" AND type = 11";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":langCode" => $GLOBALS['langCode'],
			":blockCode" => $blockCode
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[($row['uri'])] = $row['text'];
		}

		if(count($itemList)==0){

			$sqlString="SELECT uri, text";
			$sqlString.=" FROM ".$this->tablePrefix."core_language";
			$sqlString.=" WHERE language_code = 'en'";
			$sqlString.=" AND specific_name = :blockCode";
			$sqlString.=" AND module_name = 'User'";
			$sqlString.=" AND type = 11";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":blockCode" => $blockCode
			));
			$resultSet = $stmt->fetchAll();

			foreach ($resultSet as $row) {
				$itemList[($row['uri'])] = $row['text'];
			}

		}

		return $itemList;
	}

	public function getBlockScript()
	{

		$script="";

$script=<<<EOT
<script type="text/javascript">
$(document).ready(function(){
	$(".generic-block").hide();
	$(".user-block-space").show();
});
</script>
EOT;

		return $script;

	}

}
