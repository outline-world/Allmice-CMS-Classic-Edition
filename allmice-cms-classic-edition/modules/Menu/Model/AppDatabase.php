<?php

class AppDatabase extends DatabaseCms
{

	public $tablePrefix;

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getModuleResourceSet($whereClause)
	{

		$sqlString="SELECT r.id AS id, r.module_name AS module_name, r.specific_name AS specific_name";
		$sqlString.=", r.uri AS uri";
		$sqlString.=", p.id AS perId, p.access_level AS access_level, p.role_id AS role_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE r.type = 1";
		$sqlString.=" AND r.id = p.resource_id";
		$sqlString.=$whereClause;
		$sqlString.=" ORDER BY r.module_name, r.specific_name";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getModuleSet()
	{

		$sqlString="SELECT DISTINCT module_name";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" ORDER BY module_name";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getMenuList()
	{

		$itemList=array();
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getMenuListOptions()
	{

		$sqlString="SELECT id, title";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu";

		$itemList[0] = "Items of all menus";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[($row['id'])] = $row['title'];
		}

		return $itemList;

	}

	public function getMenuDetails($id)
	{

		$itemDetails=array();
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu";
		$sqlString.=" WHERE id = ";
		$sqlString.=$id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function getAccessRoleIdSet($id)
	{

		$sqlString="SELECT p.role_id AS id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu m, ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_access p";
		$sqlString.=" WHERE m.id = ";
		$sqlString.=$id;
		$sqlString.=" AND r.module_name = 'Menu'";
		$sqlString.=" AND r.source_id = m.id";
		$sqlString.=" AND p.resource_id = r.id";
		$sqlString.=" AND p.access_level = 1";

		$itemDetails = array();
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails[] = $row['id'];
		}

		return $itemDetails;

	}

	public function getCachingRoleIdSet($id)
	{

		$sqlString="SELECT c.role_id AS id";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu m, ".$this->tablePrefix."core_resource r, ".$this->tablePrefix."core_caching c";
		$sqlString.=" WHERE m.id = ";
		$sqlString.=$id;
		$sqlString.=" AND r.module_name = 'Menu'";
		$sqlString.=" AND r.source_id = m.id";
		$sqlString.=" AND c.resource_id = r.id";

		$itemDetails = array();
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails[] = $row['id'];
		}

		return $itemDetails;

	}

	public function insertMenu($menu)
	{

		$id=0;
		$sqlString="INSERT INTO ".$this->tablePrefix."mod_menu (code, status, title, type, creator_id, editor_id)";
		$sqlString.=" VALUES (";
		$sqlString.=("'".$menu->code."'");
		$sqlString.=(", ".$menu->status);
		$sqlString.=(", '".$menu->title."'");
		$sqlString.=(", ".$menu->type);
		$sqlString.=(", ".$menu->userId);
		$sqlString.=(", ".$menu->userId);
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateMenu($menu)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_menu";
		$sqlString.=" SET ";
		$sqlString.=("code='".$menu->code."'");
		$sqlString.=(", status=".$menu->status);
		$sqlString.=(", title='".$menu->title."'");
		$sqlString.=(", type=".$menu->type);
		$sqlString.=(", editor_id=".$menu->userId);
		$sqlString.=" WHERE id = ".$menu->id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function getResId($id)
	{

		$sqlString="SELECT id";
		$sqlString.=" FROM ".$this->tablePrefix."core_resource";
		$sqlString.=" WHERE source_id = ";
		$sqlString.=$id;
		$sqlString.=" AND module_name = 'Menu'";
		$sqlString.=" AND (type BETWEEN 20 AND 59)";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$resId = $row['id'];
		}

		return $resId;

	}

	public function saveMenu($menu,$resData)
	{
		$id = (int)$menu->id;

		$roleList=$this->getRoleList();
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertMenu($menu);
				$resData['uri'].=$id;
				$resId=$this->insertResource($id, $resData);
				$perId=$this->insertAccess($menu->roleAccess,$resId,$roleList);

				$this->setCaching($menu->cachingRoles, $resId, $roleList, $menu->cacheData);

				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateMenu($menu);
				$this->updateResource($id, $resData);
				$resId=$this->getResId($id);
				$this->updateAccess($menu->roleAccess,$resId,$roleList);

				$this->setCaching($menu->cachingRoles, $resId, $roleList, $menu->cacheData);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}
		return $id;

	}

	public function deleteMenu($id)
	{

		$delStatus=false;

			try {
				$this->dbId->beginTransaction();

		$sqlString="DELETE FROM ".$this->tablePrefix."mod_menu WHERE id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$sqlString="DELETE FROM ".$this->tablePrefix."mod_menu_item WHERE menu_id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$resId=$this->getResId($id);

		$sqlString="DELETE FROM ".$this->tablePrefix."core_resource WHERE source_id = ".$id." AND module_name = 'Menu'";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$sqlString="DELETE FROM ".$this->tablePrefix."core_access WHERE resource_id = ".$resId;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$sqlString="DELETE FROM ".$this->tablePrefix."core_caching WHERE resource_id = ".$resId;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$delStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $delStatus;

	}

	public function getActiveMenuItemList($menuId)
	{
		$itemDetails=array();
		$sqlString="SELECT id, label, depth, uri, status";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" WHERE menu_id = :menuId";
		$sqlString.=" AND status > 0";
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

	public function getMenuItemList($menuId)
	{

		$itemDetails=array();
		$sqlString="SELECT id, label, depth, uri, weight";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" WHERE menu_id = ".$menuId;
		$sqlString.=" ORDER BY order_code";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails[] = $row;
		}

		return $itemDetails;

	}

	public function buildOrderCode($menuId)
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" WHERE menu_id = ".$menuId;
		$sqlString.=" ORDER BY depth, weight";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$allItems[] = $row;
		}

		$patternList=array();

		for($i=0;$i<count($allItems);$i++){

			$sqlString="SELECT COUNT(id) AS noc";
			$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
			$sqlString.=" WHERE parent_id = ".$allItems[$i]['id'];

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
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
			$sqlString.=("order_code='".$patternList[$i]['code']."'");
			$sqlString.=(", has_children=".$patternList[$i]['hasChildren']."");
			$sqlString.=" WHERE id = ".$patternList[$i]['id'];
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		}

	}

	public function getAllMenuItems()
	{

		$itemList=array();
		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" ORDER BY menu_id, order_code";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}
		return $itemList;

	}

	public function getMenuItemDetails($id)
	{

		$itemDetails=array();
		$sqlString="SELECT id, menu_id, parent_id, label, uri, depth, weight, order_code, status as itemStatus, has_children";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" WHERE id = ";
		$sqlString.=$id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function insertMenuItem($menuItem)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_menu_item (depth, parent_id, label, menu_id, uri, weight, creator_id, editor_id, status)";
		$sqlString.=" VALUES (";
		$sqlString.=("".$menuItem->depth."");
		$sqlString.=(", ".$menuItem->parentId."");
		$sqlString.=(", '".$menuItem->label."'");
		$sqlString.=(", ".$menuItem->menuId);
		$sqlString.=(", '".$menuItem->uri."'");
		$sqlString.=(", ".$menuItem->weight);
		$sqlString.=(", ".$menuItem->userId);
		$sqlString.=(", ".$menuItem->userId);
		$sqlString.=(", ".$menuItem->itemStatus);
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateMenuItem($menuItem)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" SET ";
		$sqlString.=("depth=".$menuItem->depth."");
		$sqlString.=(", parent_id=".$menuItem->parentId."");
		$sqlString.=(", label='".$menuItem->label."'");
		$sqlString.=(", uri='".$menuItem->uri."'");
		$sqlString.=(", weight=".$menuItem->weight);
		$sqlString.=(", editor_id=".$menuItem->userId);
		$sqlString.=(", status=".$menuItem->itemStatus);

		$sqlString.=" WHERE id = ".$menuItem->id;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

	}

	public function getParentItemData($menuItem)
	{

		$parentData['depth']=0;

		$sqlString="SELECT depth";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu_item";
		$sqlString.=" WHERE id = ".$menuItem->parentId;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$resultSet=$this->dbId->query($sqlString);
		foreach ($resultSet as $row) {
			$parentData = $row;
		}

		return $parentData;

	}

	public function saveMenuItem($menuItem)
	{
		$id = (int)$menuItem->id;

		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertMenuItem($menuItem);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateMenuItem($menuItem);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function deleteMenuItem($id)
	{

		$delStatus=false;

		$sqlString="DELETE FROM ".$this->tablePrefix."mod_menu_item WHERE id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$delStatus=true;

		return $delStatus;

	}

	public function getRoleOptions()
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_role";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {

			$itemList[($row['id'])] = $row['title'];
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

	public function insertResource($menuId,$resData)
	{

		$sqlString="INSERT INTO ".$this->tablePrefix."core_resource (module_name, specific_name, uri, type, source_id)";
		$sqlString.=" VALUES (";
		$sqlString.=("'".$resData['modName']."'");
		$sqlString.=(", '".$resData['specName']."'");
		$sqlString.=(", '".$resData['uri']."'");
		$sqlString.=(", 41");
		$sqlString.=(", ".$menuId);
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resId=$this->dbId->lastInsertId();

		return $resId;

	}

	public function updateResource($menuId,$resData)
	{
		$sqlString="UPDATE ".$this->tablePrefix."core_resource";
		$sqlString.=" SET ";
		$sqlString.=("specific_name='".$resData['specName']."'");
		$sqlString.=" WHERE source_id = ".$menuId;
		$sqlString.=" AND type = 41";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
	}

	public function insertAccess($roleAccess, $resId, $roleList)
	{

		for($i=0;$i<count($roleList);$i++){
			if(in_array($roleList[$i]['id'],$roleAccess)){
				$accessRight=1;
			}else{
				$accessRight=0;
			}

			$sqlString="INSERT INTO ".$this->tablePrefix."core_access (role_id, resource_id, access_level)";
			$sqlString.=" VALUES (";
			$sqlString.=("".$roleList[$i]['id']."");
			$sqlString.=(", ".$resId);
			$sqlString.=(", ".$accessRight);

			$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		}

	}

	public function updateAccess($roleAccess, $resId, $roleList)
	{

		for($i=0;$i<count($roleList);$i++){

			if(in_array($roleList[$i]['id'],$roleAccess)){
				$accessRight=1;
			}else{
				$accessRight=0;
			}

			$sqlString="UPDATE ".$this->tablePrefix."core_access";
			$sqlString.=" SET ";
			$sqlString.=("access_level=".$accessRight."");
			$sqlString.=" WHERE resource_id = ".$resId;
			$sqlString.=" AND role_id = ".$roleList[$i]['id'];
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		}

	}

	public function setCaching($cachingRoles, $resId, $roleList, $cacheData)
	{

		for($i=0;$i<count($roleList);$i++){

			$sqlString="SELECT id";
			$sqlString.=" FROM ".$this->tablePrefix."core_caching c";
			$sqlString.=" WHERE c.resource_id = ".$resId;
			$sqlString.=" AND c.role_id = ".$roleList[$i]['id'];

			$id = 0;
			$cacheExists = false;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$id = $row['id'];
				$cacheExists = true;
			}

			if(in_array($roleList[$i]['id'],$cachingRoles)){

				if($cacheExists){
					$sqlString="UPDATE ".$this->tablePrefix."core_caching";
					$sqlString.=" SET ";
					$sqlString.=("period=".$cacheData['period']."");
					$sqlString.=" WHERE resource_id = ".$resId;
					$sqlString.=" AND role_id = ".$roleList[$i]['id'];
				}else{
					$sqlString="INSERT INTO ".$this->tablePrefix."core_caching (resource_id, role_id, cache_content, last_change_time, period)";
					$sqlString.=" VALUES (";
					$sqlString.=("".$resId);
					$sqlString.=(", ".$roleList[$i]['id']);
					$sqlString.=(", "."''");
					$sqlString.=(", 0");
					$sqlString.=(", ".$cacheData['period']);
					$sqlString.=(")");

				}

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

			}else{
				if($cacheExists){
					$sqlString="DELETE FROM ".$this->tablePrefix."core_caching WHERE id = ".$id;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

				}
			}
		}
	}

	public function getMenuData($id)
	{

		$menuData=array();

		$sqlString="SELECT m.title AS title, m.type AS type, m.type AS type";
		$sqlString.=" FROM ".$this->tablePrefix."mod_menu m";
		$sqlString.=" WHERE m.id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$menuData = $row;
		}

		return $menuData;

	}

	public function saveLocalMenuSet($resSet,$userId)
	{

		$lastMod="";
		$menuId=0;
		$id=0;

		try {
			$this->dbId->beginTransaction();

			$sqlString="SELECT id";
			$sqlString.=" FROM ".$this->tablePrefix."mod_menu";
			$sqlString.=" WHERE code = '";
			$sqlString.=$resSet[0]['module_name']."'";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$id = $row['id'];
			}

			if($id==0){

				$sqlString="INSERT INTO ".$this->tablePrefix."mod_menu (code, title, type, status, creator_id, editor_id)";
				$sqlString.=" VALUES (";
				$sqlString.=("'eventLinks'");
				$sqlString.=(", 'Event Links'");
				$sqlString.=(", 21");
				$sqlString.=(", 1");
				$sqlString.=(", ".$userId);
				$sqlString.=(", ".$userId);
				$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
				$menuId=$this->dbId->lastInsertId();

				for($i=0;$i<count($resSet);$i++){

					if($resSet[$i]['access_level']==1){

						$tempArr=explode("/",$resSet[$i]['uri']);
						$tempArr2=explode("-",$tempArr[2]);

						$evLabel=ucfirst($tempArr2[0]);
						for($j=1;$j<count($tempArr2);$j++){
								$evLabel.=(" ".ucfirst($tempArr2[$j]));
						}

						if ($lastMod!=$resSet[$i]['module_name']) {
							$tempArr3=explode("-",$tempArr[1]);
							$modLabel=ucfirst($tempArr3[0]);
							if($i==0)
								$menuLabel=$modLabel;							

							for($j=1;$j<count($tempArr3);$j++){
								$modLabel.=(" ".ucfirst($tempArr3[$j]));
							}

							$id=0;

							$lastMod=$resSet[$i]['module_name'];

							$sqlString="INSERT INTO ".$this->tablePrefix."mod_menu_item (menu_id, parent_id, label, uri, depth, weight, order_code, status, has_children, creator_id, editor_id)";
							$sqlString.=" VALUES (";
							$sqlString.=("".$menuId."");
							$sqlString.=(", "."0"."");
							$sqlString.=(", '".$modLabel."'");
							$sqlString.=(", '/".$tempArr[1]."'");
							$sqlString.=(", 1");
							$sqlString.=(", ".($i+1));
							$sqlString.=(", ''");
							$sqlString.=(", 1");
							$sqlString.=(", 1");
							$sqlString.=(", ".$userId);
							$sqlString.=(", ".$userId);
							$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
							$parentId=$this->dbId->lastInsertId();

						}

						if($resSet[$i]['access_level']==1 && $id==0){

							$sqlString="INSERT INTO ".$this->tablePrefix."mod_menu_item (menu_id, parent_id, label, uri, depth, weight, order_code, status, has_children, creator_id, editor_id)";
							$sqlString.=" VALUES (";
							$sqlString.=("".$menuId."");
							$sqlString.=(", ".$parentId."");
							$sqlString.=(", '".$evLabel."'");
							$sqlString.=(", '".$resSet[$i]['uri']."'");
							$sqlString.=(", 2");
							$sqlString.=(", ".($i+1));
							$sqlString.=(", ''");
							$sqlString.=(", 1");
							$sqlString.=(", 0");
							$sqlString.=(", ".$userId);
							$sqlString.=(", ".$userId);
							$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
							$id2=$this->dbId->lastInsertId();

						}

					}

				}
				$this->buildOrderCode($menuId);

				if(!isset($menuLabel))
					$menuLabel="New".$menuId;
				$sqlString="UPDATE ".$this->tablePrefix."mod_menu";
				$sqlString.=" SET ";
				$sqlString.=("code='".strtolower($menuLabel)."Menu'");
				$sqlString.=(", title='".$menuLabel." Menu'");
				$sqlString.=" WHERE id = ".$menuId;
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

				$roleList=$this->getRoleList();
				$resData['modName']=$GLOBALS['modName'];
				$resData['specName']=strtolower($menuLabel)."Menu";
				$resData['uri']="/menu/view/";
				$resData['type']=3;
				$resData['uri'].=$menuId;
				$resData['caching']=0;
				$roleAccess=array(1);

				$resId=$this->insertResource($menuId, $resData);
				$this->insertAccess($roleAccess,$resId,$roleList);

			}

			$this->dbId->commit();

		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $menuId;

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

}
