<?php

class CoreDatabase extends Database
{
	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;

	public function __construct($dbData)
	{
		try {

			$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
			$this->tablePrefix=$dbData['tablePrefix'];
		} catch (Exception $e) {
//Using catch and custom error message is necessary here. 
//Otherwise - if it is showing native error message, then it may conclude whole or part of database user name and password.  

			echo "Database connection problem!";
			echo "<br>";
//Stop the script - custom error message may not be used in some following local module database class. 
			exit("Unable to connect to site.");
		}

	}

//This class uses prepared statements with parameters
// Other methods - start

	public function getUri($alias)
	{

		$itemList=array();

		$sqlString="SELECT source, source_status";
		$sqlString.=" FROM ".$this->tablePrefix."core_alias";
		$sqlString.=" WHERE alias = :alias";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":alias" => $alias
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList = $row;
		}

		return $itemList;

	}

	public function getFrontPageData()
	{

		$fpData=array();

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE type = 'frontPage'";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$fpData = $row;
		}

		return $fpData;

	}

	public function getLangConfigData()
	{

		$langData=array();

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'GlobalCore'";
		$sqlString.=" AND type = 'Language'";
//		echo "sqlString=".$sqlString."<br>";

		$resultSet=$this->dbId->query($sqlString);

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		if(isset($resultSet)){
			foreach ($resultSet as $row) {
				$langData[($row['uri'])] = $row['value'];
			}
			$langData['status']="dbOk";

		}else{
//			$langData="dbProblem";
			$langData['status']="dbProblem";
		}

		if(!isset($langData) || $langData=="")
//			$langData="dbProblem";
			$langData['status']="dbProblem";

		return $langData;
	}

	public function getSourceStatus($uri)
	{

		$sourceStatus=1;

		$sqlString="SELECT alias, source_status";
		$sqlString.=" FROM ".$this->tablePrefix."core_alias";
		$sqlString.=" WHERE source = :uri";
		$sqlString.=" LIMIT 1";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":uri" => $uri
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
//This status value is only relevant if alias exists
//   otherwise should return 1 to show in every case the source url content
			if($row['alias']!="")
				$sourceStatus=$row['source_status'];
			else
				$sourceStatus=1;
		}

		return $sourceStatus;

	}

	public function getBlockSet($userRole,$langCode)
	{

		$blockSet=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_block";
		$sqlString.=" WHERE status = 1";
		$sqlString.=" AND building_module = 'GlobalCore'";
		$sqlString.=" AND language_code = '".$langCode."'";
		$sqlString.=" ORDER BY region_code, rank";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$blockSet[] = $row;
		}

		return $blockSet;

	}

	public function getModuleData()
	{

		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_module";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$module['name'] = $row['name'];
			$module['path'] = $row['path'];
			$module['configPath'] = $row['config_path'];
			$module['codePath'] = $row['code_path'];
			$itemList[]=$module;
		}

		return $itemList;

	}

	public function getGlobalModuleData()
	{

		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_module";
		$sqlString.=" WHERE path = ''";
		$sqlString.=" AND name != 'GlobalCore'";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$module['name'] = $row['name'];
			$module['path'] = $row['path'];
			$module['configPath'] = $row['config_path'];
			$module['codePath'] = $row['code_path'];
			$itemList[]=$module;
		}

		return $itemList;

	}

	public function getLocalModuleData($path)
	{
		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_module";
		$sqlString.=" WHERE path = :path";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":path" => $path
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$module['name'] = $row['name'];
			$module['path'] = $row['path'];
			$module['configPath'] = $row['config_path'];
			$module['codePath'] = $row['code_path'];
			$itemList[]=$module;
		}

		return $itemList;

	}

	public function getAcceptedRoles($path,$type)
	{
//Important also - is level value 0, 1 or 2
//if 2 for role anonymous, then no access for SEO bots (no index no follow html tag will be set in this case)

		$roleList=array();
		$sqlString="SELECT p.role_id AS role_id, p.access_level AS access_level";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE r.id = p.resource_id";
		$sqlString.=" AND p.access_level > 0";
		$sqlString.=" AND r.uri LIKE :path";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":path" => $path
		));
		$resultSet = $stmt->fetchAll();

		$botAccess = 1;
		foreach ($resultSet as $row) {
			$roleList[] = $row['role_id'];
			if($row['role_id']==2 && $row['access_level']>=2 && $row['access_level']<=5){
//If role is anonymous (2) and
//1) access level is 1, then all bot access is granted - then no html meta tag of robots will be added 
//2) access level is 2, then no index and no follow - then html tag noindex nofollow will be added
//3) access level is 3, then no index - then html tag index nofollow will be added
//4) access level is 4, then no follow - then html tag noindex follow will be added
//5) access level is 5, then index and follow - then html tag will be added
				$botAccess = $row['access_level'];
			}
		}

		$resList['role']=$roleList;
		$resList['botAccess']=$botAccess;
		return $resList;

	}

	public function getAcceptedBlockRoles($path,$type)
	{
//Important only - is level value 0 or >0
		$sqlString="SELECT p.role_id AS role_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE r.id = p.resource_id";
		$sqlString.=" AND p.access_level > 0";
		$sqlString.=" AND r.uri LIKE :path";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":path" => $path
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row['role_id'];
		}

		return $itemList;

	}

	public function resExists($path)
	{

		$resExists = false;
		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE uri LIKE :path";
		$sqlString.=" LIMIT 1";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":path" => $path
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$resExists = true;
		}

		return $resExists;

	}

	public function getUserRoles($id)
	{

		$sqlString="SELECT role_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user_role";
		$sqlString.=" WHERE user_id = :userId";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $id
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row['role_id'];
		}

		return $itemList;

	}

	public function getUserRole($id)
	{

		$path=$module."/".$event;
		$sqlString="SELECT main_role_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";
		$sqlString.=" WHERE id = :id";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$roleId = $row['main_role_id'];
		}

		return $roleId;

	}

	public function getRoleTitle($id)
	{

		$title="";
		$sqlString="SELECT title";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";
		$sqlString.=" WHERE id = :id";
		$sqlString.=" LIMIT 1";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$title = $row['title'];
		}

		return $title;

	}

	public function checkAccess($alias)
	{
//Finds which roles have access to the resource
//Finds whether user has one of such roles
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_alias";
		$sqlString.=" WHERE alias = :alias";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":alias" => $alias
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList = $row;
		}

		return $itemList;

	}

	public function getModuleSet()
	{

		$sqlString="SELECT DISTINCT module_name";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" ORDER BY module_name";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getRegionSet()
	{

		$sqlString="SELECT name, uri, regionCode";
		$sqlString.=" FROM ".$this->tablePrefix."core_block";
		$sqlString.=" ORDER BY regionCode, rank";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList = $row;
		}

		return $itemList;

	}

	public function getActiveMenuItemList($menuCode)
	{

		$itemDetails=array();

		$sqlString="SELECT i.id AS id, i.label AS label, i.depth AS depth, i.uri AS uri, i.status AS status";
		$sqlString.=", order_code";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item i, ".$this->tablePrefix."mod_menu m";
		$sqlString.=" WHERE i.menu_id = m.id";
		$sqlString.=" AND m.code = :menuCode";
		$sqlString.=" AND i.status > 0";
		$sqlString.=" ORDER BY i.order_code";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":menuCode" => $menuCode
		));
		$resultSet = $stmt->fetchAll();

		if(isset($resultSet)) {
			foreach ($resultSet as $row) {
				$itemDetails[] = $row;
			}
		}

		return $itemDetails;

	}

	public function getAccessRight($userRole,$blockCode)
	{

		$access_level=1;
		$sqlString="SELECT a.access_level AS access_level";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access a";
		$sqlString.=" WHERE a.role_id = :userRole";
		$sqlString.=" AND r.specific_name = :blockCode";
		$sqlString.=" AND r.id = a.resource_id";
		$sqlString.=" AND r.module_name = 'Block'";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userRole" => $userRole,
			":blockCode" => $blockCode
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$access_level = $row['access_level'];
		}

		return $access_level;

	}

	public function getMenuData($blockCode)
	{

		$title=array();

		$sqlString="SELECT m.title AS title, m.type AS type";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu m";
		$sqlString.=" WHERE m.code = :blockCode";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":blockCode" => $blockCode
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$menuData = $row;
		}

		return $menuData;

	}

	public function getCacheData($userRole,$uri)
	{

		$cacheData=array();
		$sqlString="SELECT c.id AS id, c.cache_content AS content, c.last_change_time AS lastTime, c.period AS period";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_caching c";
		$sqlString.=" WHERE c.role_id = :userRole";
		$sqlString.=" AND c.resource_id = r.id";
		$sqlString.=" AND r.uri = :uri";
		$sqlString.=" AND r.module_name <> 'Block'";

//		echo "sqlString=".$sqlString."<br>";
//		echo "userRole=".$userRole."<br>";
//		echo "uri=".$uri."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userRole" => $userRole,
			":uri" => $uri
		));
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$cacheData = $row;
		}

		return $cacheData;

	}

	public function getBlockCacheData($userRole,$uri)
	{

		$cacheList=array();
		$cacheContent=array();
		$cacheTime=array();
		$cacheRes=array();

		$cacheResult=array();

		$sqlString="SELECT c.id AS id, c.cache_content AS content, c.last_change_time AS lastTime, c.period AS period";
		$sqlString.=", b.block_code AS block_code";
		$sqlString.=", r.id AS resId";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_caching c";
		$sqlString.=", ".$this->tablePrefix."core_block b";
		$sqlString.=" WHERE c.role_id = :userRole";
		$sqlString.=" AND c.resource_id = r.id";
		$sqlString.=" AND b.id = r.source_id";
		$sqlString.=" AND b.status = 1";
		$sqlString.=" AND r.module_name = 'Block'";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userRole" => $userRole
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$cacheList[] = $row['block_code'];
			$cacheContent[($row['block_code'])] = $row['content'];
			$cacheTime[($row['block_code'])] = $row['lastTime']+$row['period'];
			$cacheRes[($row['block_code'])] = $row['resId'];
		}
		$cacheResult['list']=$cacheList;
		$cacheResult['content']=$cacheContent;
		$cacheResult['time']=$cacheTime;
		$cacheResult['resId']=$cacheRes;

		return $cacheResult;

	}

	public function getThemeData($roleId)
	{

		$sqlString="SELECT t.id AS id, t.name AS name, t.code_path AS path";
		$sqlString.=" FROM ".$this->tablePrefix."core_theme t";
		$sqlString.=", ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_access a";
		$sqlString.=" WHERE a.access_level = 1";
		$sqlString.=" AND a.resource_id = r.id";
		$sqlString.=" AND a.role_id = :roleId";
		$sqlString.=" AND r.source_id = t.id";
		$sqlString.=" AND r.type = 60";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":roleId" => $roleId
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$themeData = $row;
		}

		return $themeData;

	}

	public function updateBlockCaching($cacheData)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_caching";
		$sqlString.=(" SET last_change_time = :lastTime, cache_content = :content");
		$sqlString.=" WHERE resource_id = :resId";
		$sqlString.=" AND role_id = :roleId";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":lastTime" => $cacheData['lastTime'],
			":content" => $cacheData['content'],
			":resId" => $cacheData['resId'],
			":roleId" => $cacheData['roleId']
		));

	}

	public function getLocalLang($modName,$eventName,$langCode)
	{

		$itemList=array();

		$sqlString="SELECT type, uri, text";
		$sqlString.=" FROM ".$this->tablePrefix."core_language";
		$sqlString.=" WHERE language_code = :langCode";
		$sqlString.=" AND module_name = :modName";
		$sqlString.=" AND specific_name = :eventName";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":langCode" => $langCode,
			":modName" => $modName,
			":eventName" => $eventName
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {

			if($row['type']==21){
				$item['uri']=$row['uri'];
				$item['text']=$row['text'];
				$itemList['form'][]=$item;
			}else{
				$itemList['other'][($row['uri'])]=$row['text'];
			}
		}

		return $itemList;

	}

	public function getBlockLang($blockCode,$langCode)
	{

		$itemList=array();

		$sqlString="SELECT uri, text";
		$sqlString.=" FROM ".$this->tablePrefix."core_language";
		$sqlString.=" WHERE language_code = :langCode";
		$sqlString.=" AND specific_name = :blockCode";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":langCode" => $langCode,
			":blockCode" => $blockCode
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[($row['uri'])] = $row['text'];
		}

		return $itemList;

	}

	public function getDescriptionTag($modName,$method)
	{

		$configData=array();

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = :modName";
		$sqlString.=" AND type = 'metaDescription'";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));
		$resultSet = $stmt->fetchAll();

		$default="";
		$specific="";
		foreach ($resultSet as $row) {
			$row=$this->decodeDbRow($row,array("value"));

			if($row['uri']=="default")
				$default=$row['value'];
			elseif($row['uri']==$method)
				$specific=$row['value'];
		}

		if($specific=="")
			$descTag=$default;
		else
			$descTag=$specific;

		return $descTag;

	}

	public function getConfigData($modName)
	{

		$configData=array();

		$sqlString="SELECT uri, type, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = :modName";
		$sqlString.=" ORDER BY type, uri";
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$row=$this->decodeDbRow($row,array("value"));
			$configData[($row['uri'])]=$row;
		}

		return $configData;

	}

	public function getTagSet($modName,$method,$type)
	{

		$tagSet="";
		$modSet="";
		$uriSet="";

		$sqlString="SELECT module_name, uri, value, type";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = :modName";
		$sqlString.=" AND type = :type";

//		echo "sqlString=".$sqlString."<br>";
//		echo "modName=".$modName."<br>";
//		echo "type=".$type."<br>";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":modName" => $modName,
			":type" => $type
		));

		$resultSet = $stmt->fetchAll();

		$default="";
		$specific="";

		foreach ($resultSet as $row) {

			$row=$this->decodeDbRow($row,array("value"));
			if($row['uri']=="default")
				$default=$row['value'];
			elseif($row['uri']==$method)
				$specific=$row['value'];

		}

		if($specific=="")
			$tagSet=$default;
		else
			$tagSet=$specific;

		return $tagSet;

	}

	public function bind($param, $value, $type = null){
	    if (is_null($type)) {
	        switch (true) {
	            case is_int($value):
	                $type = PDO::PARAM_INT;
	                break;
	            case is_bool($value):
	                $type = PDO::PARAM_BOOL;
	                break;
	            case is_null($value):
	                $type = PDO::PARAM_NULL;
	                break;
	            default:
	                $type = PDO::PARAM_STR;
	        }
	    }
	    $this->stmt->bindValue($param, $value, $type);
	}

//Session methods

	public function open(){
//        print "Session opened.\n";
		if($this->dbId){
			return true;
		}
		else{
			return false;
		}
/*
	//	else{
			return false;
	//	}
*/
	}
	public function close(){
	// Close the database connection
	// If successful
		return true;
	}

	public function read($id){

		$data="";
		$stmt = $this->dbId->prepare('SELECT data FROM '.$this->tablePrefix.'core_session WHERE id = :id');

		$stmt->execute(array(':id' => $id));

		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {

			$data=$row['data'];

		}

		return $data;

	}

	public function write($id, $data){

		$access = time();

		// Set query
		$stmt = $this->dbId->prepare('REPLACE INTO '.$this->tablePrefix.'core_session VALUES (:id, :access, :data)');

		try {
			$stmt->execute(array(
			':id' => $id,
			':access' => $access,
			':data' => $data
			));
			return true;
		} catch (Exception $e) {
			return false;
		}

	}

	public function destroy($id){

		$stmt = $this->dbId->prepare('DELETE FROM '.$this->tablePrefix.'core_session WHERE id = :id');

		try {
			$stmt->execute(array(':id' => $id));
			return true;
		} catch (Exception $e) {
			return false;
		}

	} 

	public function gc($max){
		// Calculate what is to be deemed old

		$old = time() - $max;

		// Set query
		$stmt = $this->dbId->prepare('DELETE * FROM '.$this->tablePrefix.'core_session WHERE access < :old');

		try {
			$stmt->execute(array(':old' => $old));
			return true;
		} catch (Exception $e) {
			return false;
		}

	}

	public function cleanSessData($period){
		//This is an alternative to previous public function gc($max).
		//Current method is executed independently from session_set_save_handler.
		//The goal is to have control, not to let the core_session table to get too big.

		$old=time()-$period;

		$sqlString="DELETE FROM ".$this->tablePrefix."core_session WHERE access < :old";
//			echo "sqlString=".$sqlString."<br>";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":old" => $old
		));

	} 

	public function updateMainCaching($cacheData)
	{

		$resId=$this->getResId($cacheData['path']);

		$content=str_replace("'","&#39;",$cacheData['content']);
//Backslash \ ascii code 92, may not show good creating different meaning (escaping character for \n, \t, \r, etc.)
		$content=str_replace("\\","&#92;",$content);

		$sqlString="UPDATE ".$this->tablePrefix."core_caching";
		$sqlString.=(" SET last_change_time = ".$cacheData['lastTime'].", cache_content = '".$content."'");
		$sqlString.=" WHERE resource_id = ".$resId;
		$sqlString.=" AND role_id = ".$cacheData['roleId'];

//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function getResId($uri)
	{
		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE uri = :uri";
		$sqlString.=" LIMIT 1";

//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":uri" => $uri
		));
			$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$resId = $row['id'];
		}

		return $resId;

	}

}
