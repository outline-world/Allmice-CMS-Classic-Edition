<?php

class Caching
{

	public $dbId;
	public $tablePrefix;

	public function updateCacheData($cacheData)
	{

		$this->dbId=$GLOBALS['db']['id'];
		$this->tablePrefix=$GLOBALS['db']['tablePrefix'];
		$resId=$this->getResId($cacheData['path']);

		$sqlString="UPDATE ".$this->tablePrefix."core_caching";
		$sqlString.=(" SET last_change_time = ".$cacheData['lastTime'].", cache_content = '".$cacheData['content']."'");
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
