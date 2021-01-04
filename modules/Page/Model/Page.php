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
		$this->status = (isset($data['status'])) ? $data['status'] : null;
		$this->cachingRoles = (isset($data['caching'])) ? $data['caching'] : array();
		$this->alias = (isset($data['alias'])) ? $data['alias'] : "";
		$this->roleAccess = (isset($data['roleAccess'])) ? $data['roleAccess'] : array();
		$this->botTag = (isset($data['botTag'])) ? $data['botTag'] : 1;

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
		$this->botTag = (isset($data['botTag'])) ? $data['botTag'] : 1;

	}

	public function manageSnippetSet($snippetSet,$globalSnippetSet)
	{

		$snippetClasses=array();
		$output=array();

		foreach($snippetSet as $row){

			if($row['type']==2 || $row['type']==4){

				$tempArr=explode(";",$row['content']);

				$snippetLoc="";
				$snippetLoc=$tempArr[0];
				$methodName="";
				$snippetView="";

				if(file_exists($snippetLoc) && !in_array($snippetLoc, $snippetClasses)){
					include $snippetLoc;
					$snippetClasses[]=$snippetLoc;

					$reversedParts = explode('/', strrev($snippetLoc), 2);

					$className=str_replace(".php","",strrev($reversedParts[0]));
					$snippetBuilder=new $className();

					if(isset($tempArr[1]))
						$methodName=$tempArr[1];

					if(method_exists($snippetBuilder,$methodName))
						$snippetView=$snippetBuilder->$methodName();
					else
						$snippetView="";
				}
				elseif(file_exists($snippetLoc) && in_array($snippetLoc, $snippetClasses)){

					if(isset($tempArr[1]))
						$methodName=$tempArr[1];

					if(method_exists($snippetBuilder,$methodName))
						$snippetView=$snippetBuilder->$methodName();
					else
						$snippetView="";
				}
				$row2['content']=$snippetView;
				$row2['uri']=$row['uri'];
			}else{
//				$row2['content']="";
				$row2['content']=$row['content'];
				$row2['uri']=$row['uri'];
			}
			if(isset($row2))
				$output[]=$row2;

		}

		foreach($globalSnippetSet as $row){

			if($row['integer_value']==2 || $row['integer_value']==4){

				$tempArr=explode(";",$row['value']);

				$snippetLoc="";
				$snippetLoc=$tempArr[0];
				$methodName="";
				$snippetView="";

				if(file_exists($snippetLoc) && !in_array($snippetLoc, $snippetClasses)){
					include $snippetLoc;
					$snippetClasses[]=$snippetLoc;

					$reversedParts = explode('/', strrev($snippetLoc), 2);

					$className=str_replace(".php","",strrev($reversedParts[0]));
					$snippetBuilder=new $className();

					if(isset($tempArr[1]))
						$methodName=$tempArr[1];

					if(method_exists($snippetBuilder,$methodName))
						$snippetView=$snippetBuilder->$methodName();
					else
						$snippetView="";
				}
				elseif(file_exists($snippetLoc) && in_array($snippetLoc, $snippetClasses)){

					if(isset($tempArr[1]))
						$methodName=$tempArr[1];

					if(method_exists($snippetBuilder,$methodName))
						$snippetView=$snippetBuilder->$methodName();
					else
						$snippetView="";
				}
				$row2['content']=$snippetView;
				$row2['uri']=$row['uri'];
			}
			else{
				$row2['content']=$row['value'];
				$row2['uri']=$row['uri'];
				$output[]=$row2;

			}
			$output[]=$row2;

		}

		return $output;

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
            $('td:nth-child(6),th:nth-child(6)').hide();
            $('#btnHide').hide();
            $('#btnHide').click(function() {
	            $('td:nth-child(3),th:nth-child(3)').hide();
	            $('td:nth-child(4),th:nth-child(4)').hide();
	            $('td:nth-child(5),th:nth-child(5)').hide();
	            $('td:nth-child(6),th:nth-child(6)').hide();
	            $('#btnShow').show();
	            $('#btnHide').hide();
            });
            $('#btnShow').click(function() {
                $('td:nth-child(3),th:nth-child(3)').show();
                $('td:nth-child(4),th:nth-child(4)').show();
                $('td:nth-child(5),th:nth-child(5)').show();
                $('td:nth-child(6),th:nth-child(6)').show();
	            $('#btnShow').hide();
	            $('#btnHide').show();
            });
        });
    </script>
EOT;
		return $script;

	}

}
