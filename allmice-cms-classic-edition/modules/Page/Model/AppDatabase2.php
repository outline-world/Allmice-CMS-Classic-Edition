<?php
class AppDatabase2 extends DatabaseCms
{
	public $noOfAllItems;
	public $dbId;
	public $tablePrefix;

	public function __construct($dbData)	
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
		$this->dbId->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
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

}
