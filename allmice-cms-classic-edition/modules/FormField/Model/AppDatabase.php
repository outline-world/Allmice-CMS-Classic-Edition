<?php

class AppDatabase extends DatabaseCms
{

	public $tablePrefix;

	public function __construct($dbData)
	{
		$this->dbId = new PDO('mysql:host='.$dbData['dbHost'].';dbname='.$dbData['dbName'].';charset=utf8', $dbData['userName'], $dbData['userPassword']);
		$this->tablePrefix=$dbData['tablePrefix'];
	}

	public function getFieldList()
	{

		$itemList=array();

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_form_field";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute();
		$resultSet = $stmt->fetchAll();
		foreach ($resultSet as $row) {
			$itemList[] = $row;
		}

		return $itemList;

	}

	public function getFieldDetails($id)
	{

		$sqlString="SELECT *";
		$sqlString.=" FROM ".$this->tablePrefix."mod_form_field";
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

	public function insertField($field)
	{

		$id=0;

		$sqlString="INSERT INTO ".$this->tablePrefix."mod_form_field (module, event, field_name";
		$sqlString.=", visibility, required, field_order, default_value)";
		$sqlString.=" VALUES (";
		$sqlString.=(":module");
		$sqlString.=(", :event");
		$sqlString.=(", :fieldName");
		$sqlString.=(", :visibility");
		$sqlString.=(", :required");
		$sqlString.=(", :fieldOrder");
		$sqlString.=(", :defaultValue");
		$sqlString.=")";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":module" => $field->module,
			":event" => $field->event,
			":fieldName" => $field->fieldName,
			":visibility" => $field->visibility,
			":required" => $field->required,
			":fieldOrder" => $field->fieldOrder,
			":defaultValue" => $field->defaultValue
		));

		$id=$this->dbId->lastInsertId();

		return $id;

	}

	public function updateField($field)
	{

		$sqlString="UPDATE ".$this->tablePrefix."mod_form_field";
		$sqlString.=" SET ";
		$sqlString.=("module = :module");
		$sqlString.=(", event = :event");
		$sqlString.=(", field_name = :fieldName");
		$sqlString.=(", visibility = :visibility");
		$sqlString.=(", required = :required");
		$sqlString.=(", field_order = :fieldOrder");
		$sqlString.=(", default_value = :defaultValue");
		$sqlString.=" WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);

		$stmt->execute(array(
			":module" => $field->module,
			":event" => $field->event,
			":fieldName" => $field->fieldName,
			":visibility" => $field->visibility,
			":required" => $field->required,
			":fieldOrder" => $field->fieldOrder,
			":defaultValue" => $field->defaultValue,
			":id" => $field->id
		));

	}

	public function saveField($field)
	{
		$id = (int)$field->id;
		if ($id == 0) {
			try {
				$this->dbId->beginTransaction();
				$id=$this->insertField($field);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		} else {
			try {
				$this->dbId->beginTransaction();
				$this->updateField($field);
				$this->dbId->commit();
			} catch (Exception $e) {
				$this->dbId->rollback();
			}
		}

	}

	public function deleteField($id)
	{

		$delStatus=false;

		$sqlString="DELETE FROM ".$this->tablePrefix."mod_form_field WHERE id = :id";

		$stmt = $this->dbId->prepare($sqlString);
		$stmt->execute(array(
			":id" => $id
		));

		$delStatus=true;

		return $delStatus;

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
		$resultSet = $stmt->fetchAll();

		foreach ($resultSet as $row) {
			$itemList[($row['uri'])] = $row['value'];
		}

		return $itemList;

	}

}
