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

	public function getSearchFormData()
	{

		$searchFormData=array();
		$template = "";
		$sqlString="SELECT id, title, description, search_table_field, search_table, module_name";
		$sqlString.=" FROM ".$this->tablePrefix."mod_search";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$searchFormData[] = $row;
		}

		return $searchFormData;

	}

	public function getTypeDetails($id)
	{

		$itemDetails=array();
		$sqlString="SELECT id, title, description, search_table_field, search_table, module_name, title_table_field, uri";
		$sqlString.=", add_where_clause, order_clause, result_field_names, result_field_titles, language_code";
		$sqlString.=" FROM ".$this->tablePrefix."mod_search";
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));

		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemDetails = $row;
		}

		return $itemDetails;

	}

	public function insertSearchType($search)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_search (title, description, search_table_field";
		$sqlString.=", search_table, module_name";
		$sqlString.=", title_table_field, uri";
		$sqlString.=", add_where_clause, order_clause, result_field_names, result_field_titles";
		$sqlString.=", language_code";
		$sqlString.=")";
		$sqlString.=" VALUES (";
		$sqlString.=":title";
		$sqlString.=", :description";
		$sqlString.=", :searchTableField";
		$sqlString.=", :searchTable";
		$sqlString.=", :modName";
		$sqlString.=", :titleTableField";
		$sqlString.=", :uri";
		$sqlString.=", :addWhereClause";
		$sqlString.=", :orderClause";
		$sqlString.=", :resultFieldNames";
		$sqlString.=", :resultFieldTitles";
		$sqlString.=", :langCode";
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":title" => $search->title,
			":description" => $search->description,
			":searchTableField" => $search->searchTableField,
			":searchTable" => $search->searchTable,
			":modName" => $search->modName,
			":titleTableField" => $search->titleTableField,
			":uri" => $search->uri,
			":addWhereClause" => $search->addWhereClause,
			":orderClause" => $search->orderClause,
			":resultFieldNames" => $search->resultFieldNames,
			":resultFieldTitles" => $search->resultFieldTitles,
			":langCode" => $search->language
		));

		$id=$this->dbId->lastInsertId();
		return $id;

	}

	public function updateSearchType($search)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_search";
		$sqlString.=" SET ";
		$sqlString.=("title = :title");
		$sqlString.=(", description = :description");
		$sqlString.=(", search_table_field = :searchTableField");
		$sqlString.=(", search_table = :searchTable");
		$sqlString.=(", module_name = :modName");
		$sqlString.=(", title_table_field = :titleTableField");
		$sqlString.=(", uri = :uri");
		$sqlString.=(", add_where_clause = :addWhereClause");
		$sqlString.=(", order_clause = :orderClause");
		$sqlString.=(", result_field_names = :resultFieldNames");
		$sqlString.=(", result_field_titles = :resultFieldTitles");
		$sqlString.=(", language_code = :langCode");
		$sqlString.=" WHERE id = :id";

//echo "sqlString=".$sqlString."<br>";
//echo "search->orderClause=".$search->orderClause."<br>";
		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":title" => $search->title,
			":description" => $search->description,
			":searchTableField" => $search->searchTableField,
			":searchTable" => $search->searchTable,
			":modName" => $search->modName,
			":titleTableField" => $search->titleTableField,
			":uri" => $search->uri,
			":addWhereClause" => $search->addWhereClause,
			":orderClause" => $search->orderClause,
			":resultFieldNames" => $search->resultFieldNames,
			":resultFieldTitles" => $search->resultFieldTitles,
			":langCode" => $search->language,
			":id" => $search->id
		));

	}

	public function saveSearchType($search)
	{
		$id = (int)$search->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertSearchType($search);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();

			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$id=$this->updateSearchType($search);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function getTemplate($uri)
	{
		$template = "";
		$sqlString="SELECT value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'Page'";
		$sqlString.=" AND type = 'viewTemplate'";
		$sqlString.=" AND uri = '".$uri."'";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$template = $row['value'];
		}

		return $template;

	}

	public function getPageDetails($id)
	{
		$pageDetails=array();
		$sqlString="SELECT p.id AS id, p.title AS title, p.description AS description, p.body AS body, p.status AS status";
		$sqlString.=", p.creator_id AS creatorId";
		$sqlString.=" FROM ".$this->tablePrefix."mod_page p";
		$sqlString.=" WHERE p.id = ";
		$sqlString.=$id;

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
		$sqlString.=" WHERE p.id = ";
		$sqlString.=$id;
		$sqlString.=" AND p.creator_id = cu.id";
		$sqlString.=" AND p.editor_id = eu.id";
		$sqlString.=" LIMIT 1";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();

		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$pageDetails = $row;
		}

		return $pageDetails;

	}

	public function deleteSearchType($id)
	{

		$delStatus=false;

		try {
			$this->dbId->beginTransaction();

			$sqlString="DELETE FROM ".$this->tablePrefix."mod_search WHERE id = :id";

			$stmt = $this->dbId->prepare($sqlString);

			$stmt->execute(array(
				":id" => $id
			));

			$delStatus=true;

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

		return $delStatus;

	}

	public function getActiveRole($userId)
	{
		$activeRole=0;

		$sqlString="SELECT active_role_id";
		$sqlString.=" FROM ".$this->tablePrefix."core_user";

		$sqlString.=" WHERE id = :userId";  
		$sqlString.=" LIMIT 1";  

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":userId" => $userId
		));

		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$activeRole = $row['active_role_id'];
		}

		return $activeRole;
	}

	public function getAccessRight($uri, $roleId)
	{

		$sqlString="SELECT a.access_level AS access_level";
		$sqlString.=" FROM ".$this->tablePrefix."core_access a";
		$sqlString.=", ".$this->tablePrefix."core_resource r";
		$sqlString.=", ".$this->tablePrefix."mod_search s";
		$sqlString.=" WHERE r.id = a.resource_id";  
		$sqlString.=" AND r.uri = s.uri";  
		$sqlString.=" AND s.uri = :uri";  
		$sqlString.=" AND a.role_id = :roleId";  

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":uri" => $uri,
			":roleId" => $roleId
		));

		$accessRight = $stmt->fetchColumn();

		return $accessRight;
	}

	public function getConfigData($whereClauseEnd)
	{

		$configData=array();
		$template = "";

		$sqlString="SELECT type, uri, value";
		$sqlString.=" FROM ".$this->tablePrefix."core_config";
		$sqlString.=" WHERE module_name = 'Search'";
		if($whereClauseEnd!="")
			$sqlString.=$whereClauseEnd;

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$configData[($row['type'])][($row['uri'])] = $row['value'];
		}

		return $configData;

	}


}
