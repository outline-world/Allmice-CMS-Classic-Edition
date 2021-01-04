<?php

class Alias
{

	public $id;
	public $alias;
	public $source;
	public $sourceValue;
	public $sourceStatus;
	public $depth;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->alias = (isset($data['alias'])) ? $data['alias'] : null;
		$this->source = (isset($data['source'])) ? $data['source'] : null;
		$this->sourceStatus = (isset($data['sourceStatus'])) ? $data['sourceStatus'] : null;
		$this->depth = substr_count ( $this->alias , "/");

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->alias = (isset($data['alias'])) ? $data['alias'] : null;
		$this->source = (isset($data['resource_id'])) ? $data['resource_id'] : null;
		$this->sourceStatus = (isset($data['source_status'])) ? $data['source_status'] : null;
		$this->depth = substr_count ( $this->alias , "/");

	}

}
