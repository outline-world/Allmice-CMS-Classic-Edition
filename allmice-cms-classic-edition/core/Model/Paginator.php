<?php
/*
Allmice PHP framework
Version 1.5.4 (2019-05-06)
Copyright 2016 - 2019 by Any Outline LTD
www.allmice.com/php-framework
License: GNU LESSER GENERAL PUBLIC LICENSE
https://www.gnu.org/licenses/lgpl-3.0.en.html
*/

class Paginator
{

	public $lastPage;

	public function getPaginWidget($paginData)
	{

		$url1 = $_SERVER['SERVER_NAME'];
		$url2 = $_SERVER['REQUEST_URI'];
		$curUrl="http:"."/"."/".$url1.$url2;
		$appUri="http:"."/"."/".$url1.$url2;

		$buttonStatus['left']="";
		$buttonStatus['right']="";
		if($paginData['currentPage']==0)
			$buttonStatus['left']=" disabled=\"disabled\"";
		if($paginData['currentPage']==$this->lastPage)
			$buttonStatus['right']=" disabled=\"disabled\"";

		$formWidget="";
		$formWidget.="<input type=\"submit\" name=\"pagin\" class=\"pagin\" value=\"|<<\" />\n";
		$formWidget.="<input type=\"submit\" name=\"pagin\" class=\"pagin\" value=\"<<\"".$buttonStatus['left']." />\n";
		$formWidget.="<select name=\"pagin_combo\" class=\"pagin-number\" onchange=\"this.form.submit()\">\n";
		for($i=0;$i<=($this->lastPage);$i++){
			$status="";
			if($i==$paginData['currentPage'])
				$status=" selected=\"selected\"\n";
			$formWidget.="<option class=\"pagin-number\" value=\"".$i."\" ".$status.">".($i+1)."</option>\n";
		}
		$formWidget.="</select>\n";
		$formWidget.="<input type=\"submit\" name=\"pagin\" class=\"pagin\" value=\">>\"".$buttonStatus['right']." />\n";
		$formWidget.="<input type=\"submit\" name=\"pagin\" class=\"pagin\" value=\">>|\" />\n";

		return $formWidget;

	}

	public function findPaginData($noOfAllItems)
	{

		$paginData['itemsOnPage']=3;
		$paginData['itemsOnPage']=10;
		$defaultPage=0;
		$paginData['currentPage']=$defaultPage;

		$paginData['noOfAllItems']=20;
		$paginData['noOfAllItems']=$noOfAllItems;

		if(isset($_SESSION['currentPage'])){
      	$paginData['currentPage']=$_SESSION['currentPage'];
		}else{
      	$_SESSION['currentPage']=$paginData['currentPage'];
		}

		$this->lastPage=ceil($paginData['noOfAllItems']/$paginData['itemsOnPage'])-1;

		if (isset($_POST['pagin_combo']) && $_POST['pagin_combo']!="") {
			$paginData['currentPage']=(int)$_POST['pagin_combo'];
		}

		if (isset($_POST['pagin']) && $_POST['pagin']!="") {
			switch($_POST['pagin']) {
				case '|<<':
				// button first was pressed
					$paginData['currentPage']=0;
				break;
				case '<<':
				//button previous was pressed
					$paginData['currentPage']--;
				break;
				case '>>':
				// button next was pressed
					$paginData['currentPage']++;
				break;
				case '>>|':
				// button last was pressed
					$paginData['currentPage']=$this->lastPage;
				break;
			}
		}

     	$_SESSION['currentPage']=$paginData['currentPage'];

		$formWidget=$this->getPaginWidget($paginData);

		$paginFormData['formStatus']=$paginData;
		$paginFormData['formWidget']=$formWidget;

		return $paginFormData;

	}

}
