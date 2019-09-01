<?php

class MenuItem
{

	public $id;

	public $menuId;
	public $menuCode;
	public $menuTitle;
	public $parentId;
	public $depth;
	public $label;
	public $itemStatus;
	public $uri;
	public $weight;
	public $orderCode;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->menuId = (isset($data['menuId'])) ? $data['menuId'] : null;
		$this->menuTitle = (isset($data['menuTitle'])) ? $data['menuTitle'] : null;
		$this->menuCode = (isset($data['menuCode'])) ? $data['menuCode'] : null;
		$this->parentId = (isset($data['parentId'])) ? $data['parentId'] : null;
		$this->depth = (isset($data['depth'])) ? $data['depth'] : null;
		$this->label = (isset($data['label'])) ? $data['label'] : null;
		$this->uri = (isset($data['uri'])) ? $data['uri'] : null;
		$this->weight = (isset($data['weight'])) ? $data['weight'] : null;
		$this->orderCode = (isset($data['orderCode'])) ? $data['orderCode'] : null;
		$this->itemStatus = (isset($data['itemStatus'])) ? $data['itemStatus'] : null;

		if($data['weight'] == "")
			$this->weight = 0; 

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;

		$this->menuId = (isset($data['menu_id'])) ? $data['menu_id'] : null;
		$this->parentId = (isset($data['parent_id'])) ? $data['parent_id'] : null;
		$this->depth = (isset($data['depth'])) ? $data['depth'] : null;
		$this->label = (isset($data['label'])) ? $data['label'] : null;
		$this->uri = (isset($data['uri'])) ? $data['uri'] : null;
		$this->weight = (isset($data['weight'])) ? $data['weight'] : null;
		$this->orderCode = (isset($data['order_code'])) ? $data['order_code'] : null;
		$this->itemStatus = (isset($data['itemStatus'])) ? $data['itemStatus'] : null;

	}

	public function getParentMap($itemList) 
	{

		$optionMap[0]="First (root) level of menu";
		$labelGap="";

		for($i=0;$i<count($itemList);$i++){
			$labelGap="&nbsp;&nbsp;&nbsp;";

			for($j=1;$j<$itemList[$i]['depth'];$j++){
				$labelGap.="&nbsp;&nbsp;&nbsp;";
			}
			$optionMap[($itemList[$i]['id'])]=$labelGap.$itemList[$i]['label'];

		}
		return $optionMap;
	}

}
