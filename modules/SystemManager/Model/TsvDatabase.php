<?php

class TsvDatabase extends Database
{

//	public $tablePrefix;

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host=localhost;dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getTsvList($tableName, $columnSet, $valueSet)
	{

		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix.$tableName;
		$sqlString.=" WHERE ".$columnSet[0]." = :key0";
		for($i=1;$i<count($columnSet);$i++){
			$sqlString.=" AND ".$columnSet[$i]." = :key".$i."";
		}
//		echo "sqlString=".$sqlString."<br>";

		$stmt = $this->dbId->prepare($sqlString);

		$stmtValueSet=array();
		$stmtValueSet[':key0']=$valueSet[0];
		for($i=1;$i<count($columnSet);$i++){
			$stmtValueSet[(':key'.$i)]=$valueSet[$i];
		}

		$stmt->execute($stmtValueSet);

		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;
	}


	public function getTableListOptions($zeroLabel)
	{

		$itemList=array();

		$sqlString = "SHOW TABLES";
		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll(PDO::FETCH_NUM);

		$itemList['none']=$zeroLabel;
		 
		foreach($resultSet as $row){
			if(strstr($row[0],$this->tablePrefix)){
				$row[0]=str_replace($this->tablePrefix,"",$row[0]);
				$itemList[($row[0])]=$row[0];
			}
		}

		return $itemList;

	}

	public function checkTsvSet($tsvSet,$keySet,$tableName)
	{

		$tsvCorrect=true;

		$sqlString="SELECT * FROM ".$this->tablePrefix.$tableName." LIMIT 0";
//		echo "sqlString=".$sqlString."<br>";

		$rs = $this->dbId->query($sqlString);
		for ($i = 0; $i < $rs->columnCount(); $i++) {
		    $col = $rs->getColumnMeta($i);
		    $columns[] = $col['name'];
		}

		foreach ($tsvSet['header'] as $row) {
			if(!in_array($row,$columns)){
				$tsvCorrect=false;
			}
		}
		foreach ($keySet as $row) {
			if(!in_array($row,$columns)){
				$tsvCorrect=false;
			}
			if(!in_array($row,$tsvSet['header'])){
				$tsvCorrect=false;
			}
		}

		if(count($keySet)<1)
			$tsvCorrect=false;

		return $tsvCorrect;

	}

	public function checkTsvSetSimple($keySet,$tableName)
	{

		$tsvCorrect=true;

		$sqlString="SELECT * FROM ".$this->tablePrefix.$tableName." LIMIT 0";

		$rs = $this->dbId->query($sqlString);
		for ($i = 0; $i < $rs->columnCount(); $i++) {
		    $col = $rs->getColumnMeta($i);
		    $columns[] = $col['name'];
		}

		foreach ($keySet as $row) {
			if(!in_array($row,$columns)){
				$tsvCorrect=false;
			}
		}

		if(count($keySet)<1)
			$tsvCorrect=false;

		return $tsvCorrect;

	}


	public function getColumnNames($tableName)
	{

		$tsvCorrect=true;

		$sqlString="SELECT * FROM ".$this->tablePrefix.$tableName." LIMIT 0";

		$rs = $this->dbId->query($sqlString);
		for ($i = 0; $i < $rs->columnCount(); $i++) {
		    $col = $rs->getColumnMeta($i);
		    $columns[] = $col['name'];
		}

		return $columns;

	}

	public function saveTsvSet($tsvSet,$keySet,$tableName)
	{

		$errorCode="noError";
		try {
			$this->dbId->beginTransaction();

			$valueField="";
			foreach ($tsvSet['header'] as $row) {
				if(!in_array($row,$keySet))
					$valueField=$row;
			}

			foreach ($tsvSet['body'] as $row) {

				$id = 0;

				$sqlString="SELECT id";
				$sqlString.=" FROM ".$this->tablePrefix.$tableName;
					$sqlString.=" WHERE ".$keySet[0]." = :key0";

				for($i=1;$i<count($keySet);$i++){

						$sqlString.=" AND ".$keySet[$i]." = :key".$i."";
				}
				$sqlString.=" LIMIT 1";


//				echo "sqlString=".$sqlString."<br>";
				$stmt = $this->dbId->prepare($sqlString);
	
				$stmtValueSet=array();
				$stmtValueSet[':key0']=$row[($keySet[0])];

				for($i=1;$i<count($keySet);$i++){

					$stmtValueSet[(':key'.$i)]=$row[($keySet[$i])];

				}
				$stmt->execute($stmtValueSet);
	
				$resultSet = $stmt->fetchAll();

				foreach ($resultSet as $row2) {
					$id = $row2['id'];
				}

				if($id>0){

					if($valueField!=""){

						$sqlString="UPDATE ".$this->tablePrefix.$tableName;
						$sqlString.=" SET ";
						$sqlString.=$valueField." = :key0";
						$sqlString.=" WHERE id = :id";
	//				echo "sqlString=".$sqlString."<br>";
	
						$stmt = $this->dbId->prepare($sqlString);
	
						$stmt->execute(array(
							":key0" => $row[($valueField)],
							":id" => $id
						));
					}
					else{
						$errorCode="noValueField";
					}

				}else{

					$sqlString="INSERT INTO ".$this->tablePrefix.$tableName." (";
					$sqlString.="".$tsvSet['header'][0]."";
					for($i=1;$i<count($tsvSet['header']);$i++){
						$sqlString.=", ".$tsvSet['header'][$i]."";
					}
					$sqlString.=")";
					$sqlString.=" VALUES (";

					$sqlString.=":key0";
					for($i=1;$i<count($tsvSet['header']);$i++){
						$sqlString.=", :key".$i."";
					}
					$sqlString.=")";

					$stmt = $this->dbId->prepare($sqlString);
		
					$stmtValueSet=array();
					$stmtValueSet[':key0']=$row[($tsvSet['header'][0])];
	
					for($i=1;$i<count($tsvSet['header']);$i++){
	
						$stmtValueSet[(':key'.$i)]=$row[($tsvSet['header'][$i])];
	
					}
	
					$stmt->execute($stmtValueSet);
	
//				echo "sqlString=".$sqlString."<br>";

				}

			}

			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
			$errorCode="transactionProblem";
		}

		return $errorCode;

	}

	public function deleteTsvSet($tsvSet,$keySet,$tableName)
	{

		try {
			 // Begin a transaction
			$this->dbId->beginTransaction();

			foreach ($tsvSet['body'] as $row) {

				$id = 0;

				$sqlString="DELETE";
				$sqlString.=" FROM ".$this->tablePrefix.$tableName;

				$sqlString.=" WHERE ".$keySet[0]." = :key0";

				for($i=1;$i<count($keySet);$i++){

						$sqlString.=" AND ".$keySet[$i]." = :key".$i."";
				}

//				echo "sqlString=".$sqlString."<br>";

				$stmt = $this->dbId->prepare($sqlString);
	
				$stmtValueSet=array();
				$stmtValueSet[':key0']=$row[($keySet[0])];
	
				for($i=1;$i<count($keySet);$i++){
					$stmtValueSet[(':key'.$i)]=$row[($keySet[$i])];
				}
	
				$stmt->execute($stmtValueSet);

			}
			$this->dbId->commit();
		} catch (Exception $e) {
			$this->dbId->rollback();
		}

	}

	public function makeQueries($sqlSet)
	{

		if(count($sqlSet)>0){

			for($i=0;$i<count($sqlSet);$i++){
				$this->dbId->query($sqlSet[$i]);
			}

		}

	}

}
