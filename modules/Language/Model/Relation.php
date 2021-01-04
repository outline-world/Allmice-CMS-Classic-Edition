<?php

class Relation
{
	public $id;
	public $parentId;
	public $childId;
	public $modName;
	public $type;
	public $path;
	public $langCode;

	public function getPageOptions($pageList)
	{
		$pageOptions=array();

		foreach ($pageList as $row) {
			$pageOptions[($row['id'])] = $row['title'];
		}

		return $pageOptions;

	}

	public function getLangOptions($langList)
	{
		$langOptions=array();

		foreach ($langList as $row) {
			$langOptions[($row['language_code'])] = ($row['label']." (".$row['language_code'].")");
		}

		return $langOptions;

	}

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->parentId = (isset($data['parentId'])) ? $data['parentId'] : 0;
		$this->childId = (isset($data['childId'])) ? $data['childId'] : 0;
		$this->modName = (isset($data['modName'])) ? $data['modName'] : "";
		$this->type = (isset($data['type'])) ? $data['type'] : "";
		$this->path = (isset($data['path'])) ? $data['path'] : "";
		$this->langCode = (isset($data['langCode'])) ? $data['langCode'] : "";

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->parentId = (isset($data['parent_item_id'])) ? $data['parent_item_id'] : 0;
		$this->childId = (isset($data['child_item_id'])) ? $data['child_item_id'] : 0;

		$this->modName = (isset($data['module_name'])) ? $data['module_name'] : "";
		$this->type = (isset($data['type'])) ? $data['type'] : "";
		$this->path = (isset($data['path'])) ? $data['path'] : "";
		$this->langCode = (isset($data['language_code'])) ? $data['language_code'] : "";

	}

}
