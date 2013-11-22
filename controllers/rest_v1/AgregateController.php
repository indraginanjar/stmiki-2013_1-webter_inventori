<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';

class AgregateController extends SingleKeyController {

	private $_OtherModels;

	function __construct($pageName, $model, array $otherModels, $controllerActionIndex){
		parent::__construct($pageName, $model, $controllerActionIndex);
		$this->_OtherModels = $otherModels;
	}

	function ActionIndex() {
		parent::ActionIndex();
		$Statement = $this->GetModel()->SelectViewAll();
		$Param = array('Statement' => $Statement);
		$Param = array_merge($Param, $this->GetOtherModelsSelectAllStatement());
	}

	function GetOtherModels(){
		return $this->_OtherModels;
	}

	function GetOtherModelsSelectAllStatement(){
		$Statements = array();
		foreach($this->_OtherModels as $Key => $Value) {
			$Statements = array_merge($Statements, array( ucfirst($Key) . 'Statement' => $Value->SelectAll()));
		}
		return $Statements;
	}

	function ActionEdit() {
		$Statement = $this->GetModel()->SelectByKey($this->GetAction(3));
		
		$SingleItem = $Statement->fetch(PDO::FETCH_OBJ);
		
		$Statement = $this->GetModel()->SelectViewAll();

		$Param = array('Statement' => $Statement, 'SingleItem' => $SingleItem);
		$Param = array_merge($Param, $this->GetOtherModelsSelectAllStatement());	
		$this->ShowCommonView($Param);
	}
}?>
