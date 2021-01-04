<?php

class UriAlias
{

	public $id;
	public $resourceId;
	public $pageId;
	public $source;
	public $alias;
	public $depth;
	public $sourceStatus;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->resourceId = (isset($data['resourceId'])) ? $data['resourceId'] : null;
		$this->pageId = (isset($data['pageId'])) ? $data['pageId'] : null;
		$this->source = (isset($data['source'])) ? $data['source'] : null;
		$this->alias = (isset($data['alias'])) ? $data['alias'] : "";
		$this->depth = (isset($data['depth'])) ? $data['depth'] : null;
		$this->sourceStatus = (isset($data['sourceStatus'])) ? $data['sourceStatus'] : null;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->resourceId = (isset($data['resourceId'])) ? $data['resourceId'] : null;
		$this->pageId = (isset($data['pageId'])) ? $data['pageId'] : null;
		$this->source = (isset($data['source'])) ? $data['source'] : null;
		$this->alias = (isset($data['alias'])) ? $data['alias'] : null;
		$this->depth = (isset($data['depth'])) ? $data['depth'] : null;
		$this->sourceStatus = (isset($data['source_status'])) ? $data['source_status'] : null;

	}

}
