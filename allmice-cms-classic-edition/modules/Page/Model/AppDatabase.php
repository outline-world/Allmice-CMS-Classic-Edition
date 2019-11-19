<?php

class AppDatabase extends DatabaseCms
{

	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;

	public function __construct($dbData)	
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getAllPagesList()
	{

		$pageList=array();
		$sqlString="SELECT p.id AS id, p.title AS title";
		$sqlString.=", p.created AS created, p.edited AS edited";
		$sqlString.=", u.username AS creator";
		$sqlString.=", p.status AS status";
		$sqlString.=", SUBSTR(p.body,1,200) AS bodyPart";
		$sqlString.=", a.alias AS alias";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=", ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_alias a";
		$sqlString.=" WHERE r.id = a.resource_id";
		$sqlString.=" AND r.source_id = p.id";
		$sqlString.=" AND u.id = p.creator_id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			if(strstr($row['bodyPart']," ")){
				$tempArr=explode(" ",strrev($row['bodyPart']),2);
				$row['bodyPart']=strrev($tempArr[1])."";
			}
			$pageList[] = $row;
		}

		return $pageList;

	}

	public function getOwnPagesList($userId)
	{

		$pageList=array();
		$sqlString="SELECT p.id AS id, p.title AS title";
		$sqlString.=", p.created AS created, p.edited AS edited";
		$sqlString.=", p.status AS status";
		$sqlString.=", SUBSTR(p.body,1,200) AS bodyPart";
		$sqlString.=", a.alias AS alias";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=", ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_alias a";
		$sqlString.=" WHERE r.id = a.resource_id";
		$sqlString.=" AND r.source_id = p.id";
		$sqlString.=" AND p.creator_id = u.id";
		$sqlString.=" AND u.id = :userId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $userId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			if(strstr($row['bodyPart']," ")){
				$tempArr=explode(" ",strrev($row['bodyPart']),2);
				$row['bodyPart']=strrev($tempArr[1])."";
			}
			$pageList[] = $row;
		}

		return $pageList;

	}

	public function getTemplate($uri)
	{

		$template = "";

		$sqlString="SELECT value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'Page'";
		$sqlString.=" AND type = 'viewTemplate'";
		$sqlString.=" AND uri = :uri";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":uri" => $uri
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$template = $row['value'];
		}

		return $template;

	}

	public function getConfigData($whereClauseEnd)
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'Page'";
		if($whereClauseEnd!="")
			$sqlString.=$whereClauseEnd;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$configData[($row['type'])][($row['uri'])] = $row['value'];
		}

		return $configData;

	}

	public function getPageDetails($id)
	{

		$pageDetails=array();
		$sqlString="SELECT p.id AS id, p.title AS title, p.description AS description, p.body AS body, p.status AS status";
		$sqlString.=", p.creator_id AS creatorId";
		$sqlString.=", p.editor_id AS editorId";
		$sqlString.=", p.created AS created";
		$sqlString.=", p.edited AS edited";
		$sqlString.=", cu.username AS creator";
		$sqlString.=", eu.username AS editor";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p";
		$sqlString.=", ".$this->tablePrefix."core_user cu";
		$sqlString.=", ".$this->tablePrefix."core_user eu";
		$sqlString.=" WHERE p.id = :id";
		$sqlString.=" AND p.creator_id = cu.id";
		$sqlString.=" AND p.editor_id = eu.id";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$pageDetails = $row;
		}

		return $pageDetails;

	}

	public function getOwnPageDetails($id,$userId)
	{
		$pageDetails=array();

		$sqlString="SELECT p.id AS id, p.title AS title, p.description AS description, p.body AS body, p.status AS status";
		$sqlString.=", p.creator_id AS creatorId";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p";
		$sqlString.=" WHERE p.id = :id";
		$sqlString.=" AND p.creator_id = :userId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id,
			":userId" => $userId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$pageDetails = $row;
		}

		return $pageDetails;

	}

	public function getPostDetails($id)
	{

		$postDetails=array();
		$sqlString="SELECT id, content, status";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page_post";
		$sqlString.=" WHERE id = :id";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$postDetails = $row;
		}

		return $postDetails;

	}

	public function insertPage($page)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_page (creator_id, title, description, body";
		$sqlString.=", status, created, edited, editor_id)";
		$sqlString.=" VALUES (:userId";
		$sqlString.=", :title";
		$sqlString.=", :descriptionArea";
		$sqlString.=", :bodyArea";
		$sqlString.=", :status";
		$sqlString.=", :created";
		$sqlString.=", :edited";
		$sqlString.=", :userId";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":userId" => $page->userId,
			":title" => $page->title,
			":descriptionArea" => $page->descriptionArea,
			":bodyArea" => $page->bodyArea,
			":status" => $page->status,
			":created" => $page->created,
			":edited" => $page->edited
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updatePage($pageData)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_page";
		$sqlString.=" SET title = :title";
		$sqlString.=", description = :descriptionArea";
		$sqlString.=", body = :bodyArea";
		$sqlString.=", status = :status";
		$sqlString.=", edited = :edited";
		$sqlString.=", editor_id = :userId";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":title" => $pageData->title,
			":descriptionArea" => $pageData->descriptionArea,
			":bodyArea" => $pageData->bodyArea,
			":status" => $pageData->status,
			":edited" => $pageData->edited,
			":userId" => $pageData->userId,
			":id" => $pageData->id
		));

	}

	public function savePage($page,$uri,$menuItem)
	{

		$id = (int)$page->id;

		$roleList=$this->getRoleList();

		$curSource="/page/view/".$page->id;
		$aliasExists=$this->checkAlias($uri->alias,$curSource);
		$pathExists=$this->checkPath($uri->alias);

		if($aliasExists<1 && $pathExists<1){

			if ($id == 0) {
	
					try {
	
						$this->dbId->beginTransaction();
	
						$page->id=$this->insertPage($page);
	
						$resId=$this->insertResource($page);
						$this->setCaching($page->cachingRoles, $resId, $roleList, $page->cacheData);
						$this->setMenuItem($menuItem,$page);
	
						$perId=$this->insertPermission($page->roleAccess,$resId,$roleList,$page->botTag);
	
						if($uri->alias=="")
							$uri->sourceStatus=1;
						else
							$uri->sourceStatus=0;
	
						$uri->pageId=$page->id;
						$uri->source="/page/view/".$page->id;
						$uri->resourceId=$resId;
						$uriId=$this->insertAlias($uri);
	
						$this->dbId->commit();
					} catch (Exception $e) {
						$this->dbId->rollback();
					}
	
			} else {
	
				$aliasId = 0;
	
				$resId=$this->getResId($page->id);
	
				$sqlString="SELECT id";
				$sqlString.=" FROM ".$this->tablePrefix."core_alias";
				$sqlString.=" WHERE resource_id = :resId";
	
				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute(array(
					":resId" => $resId
				));
				$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($resultSet as $row) {
					$aliasId = $row['id'];
				}
	
				try {
	
					$this->dbId->beginTransaction();
	
					$this->updatePage($page);
					$uri->pageId=$page->id;
					$uri->source="/".$uri->source."/view/".$uri->pageId;
	
					$uri->resourceId=$resId;
					if($aliasId==0){
						$aliasId=$this->insertAlias($uri);
					}
					$this->updateAlias($uri);
					$this->setCaching($page->cachingRoles, $resId, $roleList, $page->cacheData);
					$this->setMenuItem($menuItem,$page);
	
					$resId=$this->getResId($page->id);
	
					if(isset($page->roleAccess) && count($page->roleAccess)>0)
						$this->updatePermission($page->roleAccess,$resId,$roleList,$page->botTag);
					elseif(isset($page->roleAccess) && count($page->roleAccess)==0)
						$this->updatePermission($page->roleAccess,$resId,$roleList,$page->botTag);
	
					$this->dbId->commit();
				} catch (Exception $e) {
					$this->dbId->rollback();
				}
	
			}

		}else{

			$GLOBALS['aliasProblem']="aliasProblem";

		}

	}

	public function deletePage($id)
	{

		$delStatus=false;
		$uriData = $this->getUriDetails($id);
		$itemData['id']=0;
		if($uriData['alias']!="")
			$itemData = $this->getMenuItemByUri($uriData['alias']);
		else
			$itemData = $this->getMenuItemByUri(("/page/view/".$id));

		if(count($itemData)==0)
			$itemData['id']=0;

		$resId=$this->getResIdByUri(("/page/view/".$id));

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_page WHERE id = :id";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."core_resource WHERE source_id = :id AND module_name = 'Page' AND specific_name = 'view'";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."core_alias WHERE resource_id = :resId";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":resId" => $resId
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."core_access WHERE resource_id = :resId";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":resId" => $resId
			));

			$sqlString="DELETE FROM ".$this->tablePrefix."core_caching WHERE resource_id = :resId";
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":resId" => $resId
			));

			if($itemData['id']>0)
				$this->deleteMenuItem($itemData['id']);

			$delStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $delStatus;

	}

	public function getUriDetails($pageId)
	{

		$resId=$this->getResId($pageId);

		$sqlString="SELECT a.source AS source, a.alias AS alias, a.depth AS depth";
		$sqlString.=", a.resource_id AS resource_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_alias a";
		$sqlString.=" WHERE a.resource_id = :resId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":resId" => $resId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$pageDetails = $row;
		}

		return $pageDetails;

	}

	public function checkAlias($alias,$curSource)
	{

		$amount = 0;

		$sqlString="SELECT COUNT(id) AS amount";
		$sqlString.=" FROM ".$this->tablePrefix."core_alias a";
		$sqlString.=" WHERE alias = :alias";
		$sqlString.=" AND source != :curSource";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":alias" => $alias,
			":curSource" => $curSource
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$amount = $row['amount'];
		}

		return $amount;

	}

	public function checkPath($alias)
	{

		$amount = 0;

		$tempArr=explode("/",$alias,3);

		if(isset($tempArr[1]) && $tempArr[0]=="" && $tempArr[1]!=""){
//First check: To check alias more, it must have only one leading / and must not be empty after leading /.
			$resUriStart="/".$tempArr[1]."/";
	
			$sqlString="SELECT COUNT(id) AS amount";
			$sqlString.=" FROM ".$this->tablePrefix."core_resource";
			$sqlString.=" WHERE uri LIKE '".$resUriStart."%'";
	
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array());
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$amount = $row['amount'];
			}
		}
		elseif($alias!=""){
//Alias is not correct - probably leading slash is missing, there are many leading slashes or nothing after the the leading slash.
			$amount = 1;
		}

		return $amount;

	}

	public function insertAlias($uri)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."core_alias (resource_id, source, alias, depth";
		$sqlString.=", source_status";
		$sqlString.=")";
		$sqlString.=" VALUES (:resourceId, :source, :alias, :depth, :sourceStatus";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":resourceId" => $uri->resourceId,
			":source" => $uri->source,
			":alias" => $uri->alias,
			":depth" => $uri->depth,
			":sourceStatus" => $uri->sourceStatus
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateAlias($uriData)
	{

		$resId=$this->getResId($uriData->pageId);

		$sqlString="UPDATE ".$this->tablePrefix."core_alias";
		$sqlString.=" SET source = :source, alias = :alias, depth = :depth";
		$sqlString.=" WHERE resource_id = :resId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":source" => $uriData->source,
			":alias" => $uriData->alias,
			":depth" => $uriData->depth,
			":resId" => $resId
		));

	}

	public function setCaching($cachingRoles, $resId, $roleList, $cacheData)
	{

		for($i=0;$i<count($roleList);$i++){

			$sqlString="SELECT id";
			$sqlString.=" FROM ".$this->tablePrefix."core_caching c";
			$sqlString.=" WHERE c.resource_id = :resId";
			$sqlString.=" AND c.role_id = :roleId";

			$id = 0;
			$cacheExists = false;
			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":resId" => $resId,
				":roleId" => $roleList[$i]['id']
			));
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$id = $row['id'];
				$cacheExists = true;
			}

			if(is_array($cachingRoles) && in_array($roleList[$i]['id'],$cachingRoles)){

				if($cacheExists){

					$sqlString="UPDATE ".$this->tablePrefix."core_caching";
					$sqlString.=" SET ";
					$sqlString.=("period = :period");
					$sqlString.=" WHERE resource_id = :resId";
					$sqlString.=" AND role_id = :roleId";

				}else{

					$sqlString="INSERT INTO ".$this->tablePrefix."core_caching (resource_id, role_id, cache_content, last_change_time, period)";
					$sqlString.=" VALUES (";
					$sqlString.=(":resId");
					$sqlString.=(", :roleId");
					$sqlString.=(", "."''");
					$sqlString.=(", 0");
					$sqlString.=(", :period");
					$sqlString.=(")");

				}

				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute(array(
					":period" => $cacheData['period'],
					":resId" => $resId,
					":roleId" => $roleList[$i]['id']
				));

			}else{
				if($cacheExists){

					$sqlString="DELETE FROM ".$this->tablePrefix."core_caching WHERE id = :id";

					$stmt = $this->dbId->prepare($sqlString);
					$stmt->execute(array(
						":id" => $id
					));

				}
			}
		}

	}

	public function getCachingRoleIdSet($id)
	{

		$itemDetails=array();
		$sqlString="SELECT c.role_id AS id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p, ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_caching c";
		$sqlString.=" WHERE p.id = :id";
		$sqlString.=" AND r.module_name = 'Page'";
		$sqlString.=" AND r.source_id = p.id";
		$sqlString.=" AND c.resource_id = r.id";

		$itemDetails = array();
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails[] = $row['id'];
		}
		return $itemDetails;

	}

	public function getMenuAccessDetails($id)
	{

		$sqlString="SELECT p.role_id AS id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu m, ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE m.id = :id";
		$sqlString.=" AND r.source_id = m.id";
		$sqlString.=" AND p.resource_id = r.id";
		$sqlString.=" AND p.access_level = 1";

		$itemDetails = array();
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails[] = $row['id'];
		}

		return $itemDetails;

	}

	public function setMenuItem($menuItem,$page)
	{

		$parentData=$this->getParentItemData($menuItem);
		$menuItem->depth = $parentData['depth']+1; 

		if($menuItem->label!="" && $menuItem->menuId>0){

			if($page->alias==""){
				$menuItem->uri="/page/view/".$page->id;
			}

			if($menuItem->id>0)
				$this->updateMenuItem($menuItem);
			else
				$this->insertMenuItem($menuItem);

			$this->buildOrderCode($menuItem->menuId);

		}else{
			if($menuItem->id>0)
				$this->deleteMenuItem($menuItem->id);
		}

	}

	public function getMenuItemList($menuId)
	{

		$itemDetails=array();
		$sqlString="SELECT id, label, depth, uri, weight";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" WHERE menu_id = :menuId";
		$sqlString.=" ORDER BY order_code";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":menuId" => $menuId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails[] = $row;
		}

		return $itemDetails;

	}

	public function getMenuItemByUri($uri)
	{

		$itemDetails=array();
		$sqlString="SELECT i.id AS id, i.label AS label, i.depth AS depth, i.uri AS uri, i.weight AS weight";
		$sqlString.=", i.parent_id AS parentId";
		$sqlString.=", m.id AS menuId";
		$sqlString.=", m.type AS type";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item i";
		$sqlString.=", ".$this->tablePrefix."mod_menu m";
		$sqlString.=" WHERE i.menu_id = m.id";
		$sqlString.=" AND i.uri = :uri";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":uri" => $uri
		));

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			if($row['type']%2==0)
				$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function getMenuListOptions($zeroLabel)
	{

		$sqlString="SELECT id, title, type";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu";
		$sqlString.=" WHERE status = 1";

		$menuList[0] = $zeroLabel;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			if($row['type']%2==0)
				$menuList[($row['id'])] = $row['title'];
		}

		return $menuList;

	}

	public function getParentItemData($menuItem)
	{

		$parentData['depth']=0;

		$sqlString="SELECT depth";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" WHERE id = :parentId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":parentId" => $menuItem->parentId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$parentData = $row;
		}

		return $parentData;

	}

	public function buildOrderCode($menuId)
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" WHERE menu_id = :menuId";
		$sqlString.=" ORDER BY depth, weight";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":menuId" => $menuId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$allItems[] = $row;
		}

		$patternList=array();

		for($i=0;$i<count($allItems);$i++){

			$sqlString="SELECT COUNT(id) AS noc";
			$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
			$sqlString.=" WHERE parent_id = :parentId";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":parentId" => $allItems[$i]['id']
			));
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($resultSet as $row) {
				$noOfChildren = $row['noc'];
			}
			$curItem['hasChildren']=0;
			if($noOfChildren>0){
				$curItem['hasChildren']=1;
			}

			if($allItems[$i]['depth']==1){
				$curItem['id']=$allItems[$i]['id'];
				$curItem['label']=$allItems[$i]['label'];

				$curItem['code']="";
				if($i<9)
					$curItem['code'].="0";
				if($i<99)
					$curItem['code'].="0";
				$curItem['code'].=($i+1);

				$parentList[($curItem['id'])]=$curItem;
				$patternList[]=$curItem;
			}else{
				$curItem['id']=$allItems[$i]['id'];
				$curItem['label']=$allItems[$i]['label'];
				$parentItem['code']=$parentList[($allItems[$i]['parent_id'])]['code'];

				$curItem['code']="".$parentItem['code'];
				$curItem['code'].="-";
				if($i<9)
					$curItem['code'].="0";
				if($i<99)
					$curItem['code'].="0";
				$curItem['code'].=($i+1);

				$parentList[($curItem['id'])]=$curItem;
				$patternList[]=$curItem;
			}

		}

		for($i=0;$i<count($patternList);$i++){

			$sqlString="UPDATE ".$this->tablePrefix."mod_menu_item";
			$sqlString.=" SET ";
			$sqlString.=("order_code = :orderCode");
			$sqlString.=(", has_children = :hasChildren");
			$sqlString.=" WHERE id = :id";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":orderCode" => $patternList[$i]['code'],
				":hasChildren" => $patternList[$i]['hasChildren'],
				":id" => $patternList[$i]['id']
			));

		}

	}

	public function insertMenuItem($menuItem)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_menu_item (depth, parent_id, label, menu_id, uri, weight, creator_id, editor_id)";
		$sqlString.=" VALUES (";
		$sqlString.=(":depth");
		$sqlString.=(", :parentId");
		$sqlString.=(", :label");
		$sqlString.=(", :menuId");
		$sqlString.=(", :uri");
		$sqlString.=(", :weight");
		$sqlString.=(", :userId");
		$sqlString.=(", :userId");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":depth" => $menuItem->depth,
			":parentId" => $menuItem->parentId,
			":label" => $menuItem->label,
			":menuId" => $menuItem->menuId,
			":uri" => $menuItem->uri,
			":weight" => $menuItem->weight,
			":userId" => $menuItem->userId
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateMenuItem($menuItem)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" SET ";
		$sqlString.=("depth = :depth");
		$sqlString.=(", parent_id = :parentId");
		$sqlString.=(", label = :label");
		$sqlString.=(", menu_id = :menuId");
		$sqlString.=(", uri = :uri");
		$sqlString.=(", weight = :weight");
		$sqlString.=(", editor_id = :userId");
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":depth" => $menuItem->depth,
			":parentId" => $menuItem->parentId,
			":label" => $menuItem->label,
			":menuId" => $menuItem->menuId,
			":uri" => $menuItem->uri,
			":weight" => $menuItem->weight,
			":userId" => $menuItem->userId,
			":id" => $menuItem->id
		));

	}

	public function deleteMenuItem($id)
	{

		$delStatus=false;

		$sqlString="DELETE FROM ".$this->tablePrefix."mod_menu_item WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$delStatus=true;

		return $delStatus;

	}

	public function insertResource($page)
	{

		$id=0;
		$uri="/page/view/".$page->id;

		$sqlString="INSERT INTO ".$this->tablePrefix."core_resource (uri, source_id, module_name, specific_name, type)";
		$sqlString.=" VALUES (:uri, :pageId, 'Page', 'view', 21)";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":uri" => $uri,
			":pageId" => $page->id
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function insertPermission($roleAccess, $resId, $roleList, $botTag)
	{

		for($i=0;$i<count($roleList);$i++){
			if(in_array($roleList[$i]['id'],$roleAccess) && $roleList[$i]['id']==2){
				$accessRight=$botTag;
			}
			elseif(in_array($roleList[$i]['id'],$roleAccess)){
				$accessRight=1;
			}
			else{
				$accessRight=0;
			}

			if($roleList[$i]['id']==1){
				$accessRight=1;
			}

			$sqlString="INSERT INTO ".$this->tablePrefix."core_access (role_id, resource_id, access_level)";
			$sqlString.=" VALUES (";
			$sqlString.=(":roleId");
			$sqlString.=(", :resId");
			$sqlString.=(", :accessRight");
			$sqlString.=")";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":roleId" => $roleList[$i]['id'],
				":resId" => $resId,
				":accessRight" => $accessRight
			));

		}

	}

	public function updatePermission($roleAccess, $resId, $roleList, $botTag)
	{

		for($i=0;$i<count($roleList);$i++){

			if(in_array($roleList[$i]['id'],$roleAccess) && $roleList[$i]['id']==2){
				$accessRight=$botTag;
			}
			elseif(in_array($roleList[$i]['id'],$roleAccess)){
				$accessRight=1;
			}else{
				$accessRight=0;
			}

			if($roleList[$i]['id']==1){
				$accessRight=1;
			}

			$sqlString="UPDATE ".$this->tablePrefix."core_access";
			$sqlString.=" SET ";
			$sqlString.=("access_level = :accessLevel");
			$sqlString.=" WHERE resource_id = :resId";
			$sqlString.=" AND role_id = :roleId";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":accessLevel" => $accessRight,
				":resId" => $resId,
				":roleId" => $roleList[$i]['id']
			));

		}

	}

	public function getRoleOptions()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			if($row['title']!='admin')
				$itemList[($row['id'])] = $row['title'];
		}

		return $itemList;

	}

	public function getRoleSet()
	{
		$itemList=array();
		$sqlString="SELECT id, title";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			if($row['title']!='admin')
				$itemList[] = $row;
		}

		return $itemList;

	}

	public function getRoleList()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getResId($id)
	{

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE source_id = :id";
		$sqlString.=" AND module_name = 'Page'";
		$sqlString.=" AND (type BETWEEN 20 AND 59)";

//echo "sqlString=".$sqlString."<br>";
//echo "id=".$id."<br>";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$resId = $row['id'];
		}

		return $resId;

	}

	public function getResIdByUri($uri)
	{

		$resId=0;
		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE uri = :uri";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":uri" => $uri
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$resId = $row['id'];
		}

		return $resId;

	}

	public function getAccessRoleIdSet($id)
	{

		$sqlString="SELECT a.role_id AS id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p, ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access a";
		$sqlString.=" WHERE p.id = :id";
		$sqlString.=" AND r.module_name = 'Page'";
		$sqlString.=" AND r.source_id = p.id";
		$sqlString.=" AND a.resource_id = r.id";
		$sqlString.=" AND a.access_level >= 1";
		$sqlString.=" AND a.access_level <= 5";

		$itemDetails = array();
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails[] = $row['id'];
		}

		return $itemDetails;

	}

	public function getBotAccessLevel($id)
	{

		$accessLevel=1;
		$itemDetails = array();

		$sqlString="SELECT a.access_level AS level";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p, ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access a";
		$sqlString.=" WHERE p.id = :id";
		$sqlString.=" AND r.module_name = 'Page'";
		$sqlString.=" AND r.source_id = p.id";
		$sqlString.=" AND a.resource_id = r.id";
		$sqlString.=" AND a.access_level >=1";
		$sqlString.=" AND a.access_level <=5";
		$sqlString.=" AND a.role_id =2";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$accessLevel = $row['level'];
		}

		return $accessLevel;

	}

	public function getValidityPatterns($modName)
	{

		$itemList=array();

		$sqlString="SELECT uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE type = 'formValidationRegEx'";
		$sqlString.=" AND module_name = :modName";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":modName" => $modName
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[($row['uri'])] = $row['value'];
		}

		return $itemList;

	}

	public function updatePost($id,$siteId,$form)
	{

		$curTime=time();
		$userId=$_SESSION[$siteId]['userData']['id'];

		$contentValue=$_POST['postContent'];
		$contentValue=$form->replaceSpecialChars($contentValue);
		$contentValue=str_replace("\n","<br />",$contentValue);

		if(isset($_POST['postStatus'])){
			$statusValue=$_POST['postStatus'];
			$sqlString="UPDATE ".$this->tablePrefix."mod_page_post";
			$sqlString.=" SET ";
			$sqlString.=("content = :content");
			$sqlString.=(", status = ".$statusValue);
			$sqlString.=(", editor_id = :editorId");
			$sqlString.=(", time_edited = :editingTime");
			$sqlString.=" WHERE id = :id";
		}else{
			$sqlString="UPDATE ".$this->tablePrefix."mod_page_post";
			$sqlString.=" SET ";
			$sqlString.=("content = :content");
			$sqlString.=(", editor_id = :editorId");
			$sqlString.=(", time_edited = :editingTime");
			$sqlString.=" WHERE id = :id";
		}

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":content" => $contentValue,
			":editorId" => $userId,
			":editingTime" => $curTime,
			":id" => $id
		));

	}

	public function getIntroPostData($pageId)
	{
			$itemData=array();

			$sqlString="SELECT p.id, p.content, p.origin_id, p.type";
			$sqlString.=" FROM ".$this->tablePrefix."mod_page_post p";
			$sqlString.=", ".$this->tablePrefix."core_user u";
			$sqlString.=" WHERE p.origin_id = ".$pageId;
			$sqlString.=" AND p.type >= 20 AND p.type <= 21";
			$sqlString.=" AND u.id = p.creator_id";
			$sqlString.=" ORDER BY p.type";
			$sqlString.=" LIMIT 1";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();
			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$itemData = $row;
			}

		return $itemData;

	}

	public function saveAccessChange($postData)
	{

		$email="";
		$name="";
		$type=21;
		$statusValue=2;

		try {
			$this->dbId->beginTransaction();

			if(isset($_POST['postStatus']))
				$statusValue=$_POST['postStatus'];

			if($postData['sqlType']=="update"){

				$sqlString="UPDATE ".$this->tablePrefix."mod_page_post";
				$sqlString.=" SET ";
				$sqlString.=("type = :type");
				$sqlString.=(", content = :postingIntro");
				$sqlString.=(", status = ".$statusValue);
				$sqlString.=" WHERE type = 20 OR type = 21 AND origin_id = :pageId";

				$stmt = $this->dbId->prepare($sqlString);

				$stmt->execute(array(
					":type" => $postData['type'],
					":postingIntro" => $postData['postingIntro'],
					":pageId" => $postData['pageId']
				));

			}
			else{

				$curTime=time();
				$sqlString="INSERT INTO ".$this->tablePrefix."mod_page_post (origin_id, creator_id, editor_id, email";
				$sqlString.=", content";
				$sqlString.=", type";
				$sqlString.=", status";
				$sqlString.=", time_created";
				$sqlString.=", time_edited";
				$sqlString.=")";
				$sqlString.=" VALUES (";
				$sqlString.=":pageId";
				$sqlString.=", :creatorId";
				$sqlString.=", :editorId";
				$sqlString.=", :email";
				$sqlString.=", :content";
				$sqlString.=", :type";
				$sqlString.=(", ".$statusValue);
				$sqlString.=", :timeC";
				$sqlString.=", :timeE";
				$sqlString.=")";

				$stmt = $this->dbId->prepare($sqlString);

				$stmt->execute(array(
					":pageId" => $postData['pageId'],
					":creatorId" => $postData['userId'],
					":editorId" => $postData['userId'],
					":email" => $email,
					":content" => $postData['postingIntro'],
					":type" => $type,
					":timeC" => $curTime,
					":timeE" => $curTime,
				));
			}

				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();

			}
	}

	public function getPageSnippetSet($pageId)
	{
		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page_snippet";
		$sqlString.=" WHERE page_id = :pageId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":pageId" => $pageId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getGlobalSnippetSet()
	{
		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_misc_data";
		$sqlString.=" WHERE type = 'globalSnippet'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array());
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getPageSnippetShortSet($pageId)
	{
		$itemList=array();

		$sqlString="SELECT id, uri, SUBSTR(content,1,100) AS content";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page_snippet";
		$sqlString.=" WHERE page_id = :pageId";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":pageId" => $pageId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getPostShortDetails($id)
	{
		$itemData=array();

		$sqlString="SELECT id, creator_name, time_created, SUBSTR(content,1,100) AS content";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page_post";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemData = $row;
		}

		return $itemData;

	}

	public function getPageCutDetails($pageId)
	{

		$pageDetails=array();
		$sqlString="SELECT p.id AS id, p.title AS title";
		$sqlString.=", p.created AS created, p.edited AS edited";
		$sqlString.=", p.status AS status";
		$sqlString.=", SUBSTR(p.body,1,200) AS bodyPart";
		$sqlString.=", a.alias AS alias";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p";
		$sqlString.=", ".$this->tablePrefix."core_user u";
		$sqlString.=", ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_alias a";
		$sqlString.=" WHERE r.id = a.resource_id";
		$sqlString.=" AND r.source_id = p.id";
		$sqlString.=" AND p.creator_id = u.id";
		$sqlString.=" AND p.id = ".$pageId;
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":pageId" => $pageId
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			if(strstr($row['bodyPart']," ")){
				$tempArr=explode(" ",strrev($row['bodyPart']),2);
				$row['bodyPart']=strrev($tempArr[1])."";
			}
			$pageDetails = $row;
		}

		return $pageDetails;

	}

	public function insertSnippet($pageId)
	{

		$id=0;

		$itemList=array();

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page_snippet";
		$sqlString.=" WHERE uri = :uri";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":uri" => $_POST['snippetCode']
		));

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$id = $row ['id'];
		}

		if($id==0){
			$sqlString="INSERT INTO ".$this->tablePrefix."mod_page_snippet (page_id, uri, content, type)";
			$sqlString.=" VALUES (:pageId";
			$sqlString.=", :uri";
			$sqlString.=", :content";
			$sqlString.=", :type";
			$sqlString.=")";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":pageId" => $pageId,
				":uri" => $_POST['snippetCode'],
				":content" => $_POST['snippetContent'],
				":type" => $_POST['snippetType']
			));
			$id=$this->dbId->lastInsertId();
		}

		return $id;

	}

	public function getPageId($snippetId)
	{

		$id=0;

		$sqlString="SELECT page_id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page_snippet";
		$sqlString.=" WHERE id = :snippetId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":snippetId" => $snippetId
		));

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$id = $row ['page_id'];
		}

		return $id;

	}

	public function getPageIdByPost($postId)
	{

		$id=0;

		$sqlString="SELECT origin_id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page_post";
		$sqlString.=" WHERE id = :postId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":postId" => $postId
		));

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$id = $row ['origin_id'];
		}

		return $id;

	}

	public function getSnippetDetails($snippetId)
	{

		$itemData=array();

		$sqlString="SELECT id, uri, content, type";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page_snippet";
		$sqlString.=" WHERE id = :snippetId";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":snippetId" => $snippetId
		));

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemData = $row;
		}

		return $itemData;

	}

	public function updateSnippet($snippetId,$pageId)
	{

				$sqlString="UPDATE ".$this->tablePrefix."mod_page_snippet";
				$sqlString.=" SET ";
				$sqlString.=("content = :content");
				$sqlString.=(", type = :type");
				$sqlString.=" WHERE id = :snippetId";

				$stmt = $this->dbId->prepare($sqlString);

				$stmt->execute(array(
					":content" => $_POST['snippetContent'],
					":type" => $_POST['snippetType'],
					":snippetId" => $snippetId
				));

	}

	public function deleteSnippet($id)
	{

		$delStatus=false;

		$sqlString="DELETE FROM ".$this->tablePrefix."mod_page_snippet WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$delStatus=true;

		return $delStatus;

	}

	public function getRoleIdList($roleList)
	{

		$roleIdList=array();

		$sqlString="SELECT id, title";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {

			if (in_array($row['title'],$roleList)){
				$roleIdList[]=$row['id'];
			}

		}

		return $roleIdList;

	}

	public function deletePost($id)
	{

		$delStatus=false;

		try {

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_page_post WHERE id = :id";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute(array(
				":id" => $id
			));

			$delStatus=true;
		} catch (Exception $e) {
		}

		return $delStatus;

	}

}
