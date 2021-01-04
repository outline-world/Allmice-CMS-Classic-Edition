<?php

class Page 
{

	public $id;
	public $creatorId;
	public $title;
	public $descriptionArea;
	public $bodyArea;
	public $status;
	public $roleAccess;
	public $alias;

	public $userId;
	public $created;
	public $edited;
	public $cacheData;
	public $cachingRoles;
	public $botTag;

	public function convertFormData($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->creatorId = (isset($data['creatorId'])) ? $data['creatorId'] : null;
		$this->title = (isset($data['title'])) ? $data['title'] : "";
		$this->descriptionArea = (isset($data['descriptionArea'])) ? $data['descriptionArea'] : "";
		$this->bodyArea = (isset($data['bodyArea'])) ? $data['bodyArea'] : "";
		$this->status = (isset($data['status'])) ? $data['status'] : 0;
		$this->cachingRoles = (isset($data['caching'])) ? $data['caching'] : array();
		$this->alias = (isset($data['alias'])) ? $data['alias'] : "";
		$this->roleAccess = (isset($data['roleAccess'])) ? $data['roleAccess'] : array();
		$this->botTag = (isset($data['botTag'])) ? $data['botTag'] : null;

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->creatorId = (isset($data['creatorId'])) ? $data['creatorId'] : null;
		$this->title = (isset($data['title'])) ? $data['title'] : null;
		$this->descriptionArea = (isset($data['descriptionArea'])) ? $data['description'] : null;
		$this->bodyArea = (isset($data['body'])) ? $data['body'] : null;
		$this->status = (isset($data['status'])) ? $data['status'] : null;
		$this->cachingRoles = (isset($data['caching'])) ? $data['caching'] : array();
		$this->alias = (isset($data['alias'])) ? $data['alias'] : null;
		$this->roleAccess = (isset($data['roleAccess'])) ? $data['roleAccess'] : array();
		$this->botTag = (isset($data['botTag'])) ? $data['botTag'] : null;

	}

	public function getTableScript()
	{

		$script="";

$script=<<<EOT
    <script type="text/javascript">
        $(document).ready(function() {
            $('td:nth-child(3),th:nth-child(3)').hide();
            $('td:nth-child(4),th:nth-child(4)').hide();
            $('td:nth-child(5),th:nth-child(5)').hide();
            $('#btnHide').hide();
            $('#btnHide').click(function() {
	            $('td:nth-child(3),th:nth-child(3)').hide();
	            $('td:nth-child(4),th:nth-child(4)').hide();
	            $('td:nth-child(5),th:nth-child(5)').hide();
	            $('#btnShow').show();
	            $('#btnHide').hide();
            });
            $('#btnShow').click(function() {
                $('td:nth-child(3),th:nth-child(3)').show();
                $('td:nth-child(4),th:nth-child(4)').show();
                $('td:nth-child(5),th:nth-child(5)').show();
	            $('#btnShow').hide();
	            $('#btnHide').show();
            });
        });
    </script>
EOT;
		return $script;

	}

}
