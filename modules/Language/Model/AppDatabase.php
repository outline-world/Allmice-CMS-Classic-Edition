<?php

class AppDatabase extends DatabaseCms
{

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getPhraseList($modName, $langCode)
	{
		$whereClause="";
		if($modName!="" && $modName!="[All]")
			$whereClause=" WHERE module_name = '".$modName."'";

		if($whereClause=="" && $langCode!="" && $langCode!="[All]"){
			$whereClause=" WHERE language_code = '".$langCode."'";
		}
		elseif($whereClause!="" && $langCode!="" && $langCode!="[All]")
			$whereClause.=" AND language_code = '".$langCode."'";

		$itemList=array();

		if($modName!="" && $langCode!=""){

			$sqlString="SELECT *";
			$sqlString.=" FROM ".$this->tablePrefix."core_language";
			$sqlString.=$whereClause;
			$sqlString.=" ORDER BY module_name, specific_name, type, uri";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$itemList[] = $row;
			}

		}

		return $itemList;
	}

	public function getRelationList($modName, $langCode)
	{
		$whereClause="";
		if($modName!="" && $modName!="[All]")
			$whereClause=" WHERE module_name = '".$modName."'";

		if($whereClause=="" && $langCode!="" && $langCode!="[All]"){
			$whereClause=" WHERE language_code = '".$langCode."'";
		}
		elseif($whereClause!="" && $langCode!="" && $langCode!="[All]")
			$whereClause.=" AND language_code = '".$langCode."'";

		if($modName!="" && $modName!="[All]")
			$whereClause=" AND r.module_name = '".$modName."'";

		if($whereClause=="" && $langCode!="" && $langCode!="[All]"){
			$whereClause=" AND r.language_code = '".$langCode."'";
		}
		elseif($whereClause!="" && $langCode!="" && $langCode!="[All]")
			$whereClause.=" AND r.language_code = '".$langCode."'";

		$itemList=array();

		if($modName!="" && $langCode!=""){

			$sqlString="SELECT *";
			$sqlString.=" FROM ".$this->tablePrefix."mod_language_item";
			$sqlString.=$whereClause;
			$sqlString.=" ORDER BY module_name, language_code";

			$sqlString="SELECT r.id AS id, r.child_item_id AS childId, r.parent_item_id AS parentId";
			$sqlString.=", pc.title AS childTitle, pp.title AS parentTitle";
			$sqlString.=", r.language_code AS langCode";
			$sqlString.=" FROM ".$this->tablePrefix."mod_language_item r";
			$sqlString.=", ".$this->tablePrefix."mod_page pc";
			$sqlString.=", ".$this->tablePrefix."mod_page pp";
			$sqlString.=" WHERE r.child_item_id = pc.id";
			$sqlString.=" AND r.parent_item_id = pp.id";
			$sqlString.=$whereClause;
			$sqlString.=" ORDER BY r.language_code";

			$stmt = $this->dbId->prepare($sqlString);
			$stmt->execute();

			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($resultSet as $row) {
				$itemList[] = $row;
			}

		}

		return $itemList;
	}

	public function getRelationDetails($id)
	{
		$relData=array();

		$sqlString="SELECT i.id AS id, i.child_item_id AS child_item_id, i.parent_item_id AS parent_item_id";
		$sqlString.=", pc.title AS childTitle, pp.title AS parentTitle";
		$sqlString.=", i.language_code AS language_code";
		$sqlString.=", i.module_name AS module_name";
		$sqlString.=", i.type AS type";
		$sqlString.=", i.path AS path";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language_item i";
		$sqlString.=", ".$this->tablePrefix."mod_page pc";
		$sqlString.=", ".$this->tablePrefix."mod_page pp";
		$sqlString.=" WHERE i.child_item_id = pc.id";
		$sqlString.=" AND i.parent_item_id = pp.id";
		$sqlString.=" AND i.id = :id";
		$sqlString.=" ORDER BY i.language_code";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":id" => $id
		));

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {

			$relData = $row;
		}

		return $relData;
	}

	public function savePhraseSet($phraseSet)
	{

		try {

			$this->dbId->beginTransaction();

			foreach ($phraseSet as $phrase) {

				$id = 0;

				$sqlString="SELECT id";
				$sqlString.=" FROM ".$this->tablePrefix."core_language";
				$sqlString.=" WHERE language_code = '".$phrase['language_code']."'";
				$sqlString.=" AND type = ".$phrase['type'];
				$sqlString.=" AND module_name = '".$phrase['module_name']."'";
				$sqlString.=" AND specific_name = '".$phrase['specific_name']."'";
				$sqlString.=" AND uri = '".$phrase['uri']."'";
				$sqlString.=" LIMIT 1";

			$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

			$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($resultSet as $row) {
					$id = $row['id'];
				}
				if($id>0){

					$sqlString="UPDATE ".$this->tablePrefix."core_language";
					$sqlString.=" SET ";
					$sqlString.="text = :text";
					$sqlString.=" WHERE id = :id";

					$stmt = $this->dbId->prepare($sqlString);

					$stmt->execute(array(
						":text" => $phrase['text'],
						":id" => $id
					));

				}else{

					$sqlString="INSERT INTO ".$this->tablePrefix."core_language (language_code";
					$sqlString.=", type";
					$sqlString.=", module_name";
					$sqlString.=", specific_name";
					$sqlString.=", uri";
					$sqlString.=", text";
					$sqlString.=")";
					$sqlString.=" VALUES (";
					$sqlString.=":langCode";
					$sqlString.=", :type";
					$sqlString.=", :modName";
					$sqlString.=", :specName";
					$sqlString.=", :uri";
					$sqlString.=", :text";
					$sqlString.=")";

					$stmt = $this->dbId->prepare($sqlString);

					$stmt->execute(array(
						":langCode" => $phrase['language_code'],
						":type" => $phrase['type'],
						":modName" => $phrase['module_name'],
						":specName" => $phrase['specific_name'],
						":uri" => $phrase['uri'],
						":text" => $phrase['text']
					));

				}

			}

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function deletePhraseSet($phraseSet)
	{

		try {

			$this->dbId->beginTransaction();

			foreach ($phraseSet as $phrase) {

				$id = 0;

				$sqlString="DELETE";
				$sqlString.=" FROM ".$this->tablePrefix."core_language";
				$sqlString.=" WHERE language_code = '".$phrase['language_code']."'";
				$sqlString.=" AND type = ".$phrase['type'];
				$sqlString.=" AND module_name = '".$phrase['module_name']."'";
				$sqlString.=" AND specific_name = '".$phrase['specific_name']."'";
				$sqlString.=" AND uri = '".$phrase['uri']."'";

				$stmt = $this->dbId->prepare($sqlString);
				$stmt->execute();
			}
			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function getPhraseDetails($id)
	{
		$itemDetails=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."core_language";
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

	public function insertPhrase($phrase)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."core_language (";
		$sqlString.="language_code";
		$sqlString.=", type";
		$sqlString.=", module_name";
		$sqlString.=", specific_name";
		$sqlString.=", uri";
		$sqlString.=", text";
		$sqlString.=")";
		$sqlString.=" VALUES (";
		$sqlString.=(":languageCode");
		$sqlString.=(", :type");
		$sqlString.=(", :moduleName");
		$sqlString.=(", :specificName");
		$sqlString.=(", :uri");
		$sqlString.=(", :text");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":languageCode" => $phrase->langCode,
			":type" => $phrase->type,
			":moduleName" => $phrase->moduleName,
			":specificName" => $phrase->specificName,
			":uri" => $phrase->uri,
			":text" => $phrase->text
		));
		$id=$this->dbId->lastInsertId();

		return $id;
	}

	public function updatePhrase($phrase)
	{

		$sqlString="UPDATE ".$this->tablePrefix."core_language";
		$sqlString.=" SET ";
		$sqlString.="language_code = :languageCode";
		$sqlString.=", type = :type";
		$sqlString.=", module_name = :moduleName";
		$sqlString.=", specific_name = :specificName";
		$sqlString.=", uri = :uri";
		$sqlString.=", text = :text";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":languageCode" => $phrase->langCode,
			":type" => $phrase->type,
			":moduleName" => $phrase->moduleName,
			":specificName" => $phrase->specificName,
			":uri" => $phrase->uri,
			":text" => $phrase->text,
			":id" => $phrase->id
		));

	}

	public function savePhrase($phrase)
	{
		$id = (int)$phrase->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertPhrase($phrase);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updatePhrase($phrase);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function deletePhrase($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();
			$sqlString="DELETE FROM ".$this->tablePrefix."core_language WHERE id = :id";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			"id" => $id
		));
			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		$delStatus=true;

		return $delStatus;

	}

	public function getCoreLangModSet()
	{
		$itemList=array();

		$sqlString="SELECT DISTINCT m.name AS modName, m.title AS modTitle, m.id AS modId";
		$sqlString.=" FROM ".$this->tablePrefix."core_language l";
		$sqlString.=", ".$this->tablePrefix."core_module m";
		$sqlString.=" WHERE l.module_name=m.name";
		$sqlString.=" ORDER BY m.name";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getRelLangModSet()
	{
		$itemList=array();

		$sqlString="SELECT DISTINCT m.name AS modName, m.title AS modTitle, m.id AS modId";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language_item r";
		$sqlString.=", ".$this->tablePrefix."core_module m";
		$sqlString.=" WHERE r.module_name=m.name";
		$sqlString.=" ORDER BY m.name";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getLanguageSet()
	{
		$itemList=array();

		$sqlString="SELECT DISTINCT id, language_code, label";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";
		$sqlString.=" ORDER BY language_code";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

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

	public function getPageDetails($id)
	{

		$pageDetails=array();

		$sqlString="SELECT p.id AS id, p.title AS title, p.description AS description";
		$sqlString.=", SUBSTR(p.body,1,200) AS bodyPart, p.status AS status";
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
			$row=$this->decodeDbRow($row,array("title","description","bodyPart"));
			$pageDetails = $row;
		}

		return $pageDetails;

	}

	public function insertRelation($relation)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_language_item (";
		$sqlString.="child_item_id";
		$sqlString.=", parent_item_id";
		$sqlString.=", language_code";
		$sqlString.=")";
		$sqlString.=" VALUES (";
		$sqlString.=(":childId");
		$sqlString.=(", :parentId");
		$sqlString.=(", :langCode");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":childId" => $relation->childId,
			":parentId" => $relation->parentId,
			":langCode" => $relation->langCode
		));
		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateRelation($relation)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_language_item";
		$sqlString.=" SET ";
		$sqlString.="child_item_id = :childId";
		$sqlString.=", parent_item_id = :parentId";
		$sqlString.=", language_code = :langCode";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":childId" => $relation->childId,
			":parentId" => $relation->parentId,
			":langCode" => $relation->langCode,
			":id" => $relation->id
		));

	}

	public function saveRelation($relation)
	{
		$id = (int)$relation->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertRelation($relation);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateRelation($relation);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function deleteRelation($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();
			$sqlString="DELETE FROM ".$this->tablePrefix."mod_language_item WHERE id = :id";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			"id" => $id
		));
			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		$delStatus=true;

		return $delStatus;

	}

	public function getLangList()
	{

		$langList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";
		$sqlString.=" ORDER BY label, language_code";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$langList[] = $row;
		}

		return $langList;

	}

	public function getLangDetails($id)
	{

		$langData=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_language";
		$sqlString.=" WHERE id = :id";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));

		$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($resultSet as $row) {
			$langData = $row;
		}

		return $langData;

	}

	public function insertLanguageDetails($language)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_language (";
		$sqlString.="language_code";
		$sqlString.=", language_code2";
		$sqlString.=", label";
		$sqlString.=", status";
		$sqlString.=", direction";
		$sqlString.=", date_format";
		$sqlString.=", time_format";
		$sqlString.=", number_format";
		$sqlString.=")";
		$sqlString.=" VALUES (";
		$sqlString.=(":languageCode");
		$sqlString.=(", :languageCode2");
		$sqlString.=(", :label");
		$sqlString.=(", :status");
		$sqlString.=(", :direction");
		$sqlString.=(", :dateFormat");
		$sqlString.=(", :timeFormat");
		$sqlString.=(", :numberFormat");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":languageCode" => $language->languageCode,
			":languageCode2" => $language->languageCode2,
			":label" => $language->label,
			":status" => $language->status,
			":direction" => $language->direction,
			":dateFormat" => $language->dateFormat,
			":timeFormat" => $language->timeFormat,
			":numberFormat" => $language->numberFormat,
		));
		$id=$this->dbId->lastInsertId();

		return $id;
	}

	public function makeQueries($sqlSet)
	{

		if(count($sqlSet)>0){

			for($i=0;$i<count($sqlSet);$i++){
				$this->dbId->query($sqlSet[$i]);
			}
		}

	}

	public function updateLanguageDetails($language)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_language";
		$sqlString.=" SET ";
		$sqlString.="language_code = :languageCode";
		$sqlString.=", language_code2 = :languageCode2";
		$sqlString.=", label = :label";
		$sqlString.=", status = :status";
		$sqlString.=", direction = :direction";
		$sqlString.=", date_format = :dateFormat";
		$sqlString.=", time_format = :timeFormat";
		$sqlString.=", number_format = :numberFormat";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":languageCode" => $language->languageCode,
			":languageCode2" => $language->languageCode2,
			":label" => $language->label,
			":status" => $language->status,
			":direction" => $language->direction,
			":dateFormat" => $language->dateFormat,
			":timeFormat" => $language->timeFormat,
			":numberFormat" => $language->numberFormat,
			":id" => $language->id
		));

	}

	public function saveLanguageDetails($language)
	{
		$id = (int)$language->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertLanguageDetails($language);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateLanguageDetails($language);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function deleteLanguageDetails($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();
			$sqlString="DELETE FROM ".$this->tablePrefix."mod_language WHERE id = :id";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			"id" => $id
		));
			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		$delStatus=true;

		return $delStatus;

	}

}
