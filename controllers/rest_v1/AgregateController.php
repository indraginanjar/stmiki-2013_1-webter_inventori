<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';

class AgregateController extends SingleKeyController {

	private $_OtherModels;
	private $_Model;
	private $_Param;

	function __construct($pageName, $model, array $otherModels, $controllerActionIndex){
		parent::__construct($pageName, $model, $controllerActionIndex);
		$this->_Model = $this->GetModel();
		$this->_Param = $this->GetParam();
		$this->_OtherModels = $otherModels;
	}


	function HandleGet(){
		header('Content-type: application/json; charset=utf-8');
		$IdActionIndex = $this->GetActionToExecuteIndex();
		$Id = $this->_Param->GetAction($IdActionIndex);
		if($Id == NULL){
			$Statement = $this->_Model->SelectAll();
		}
		else {
			$IsSearching = (strcasecmp($Id, 'search') == 0);
			if($IsSearching){
				$SearchQuery = PageParam::GetValue('q', 'GET');
				$Statement = $this->_Model->SelectFilteredByKey($SearchQuery);
			}
			else {
				$IsAskingItem = (strcasecmp($this->_Param->GetAction($IdActionIndex + 1), 'item') == 0);
				if($IsAskingItem){
					$Statement = $this->_Model->SelectViewByKey($Id);
				}
				else {
					$Statement = $this->_Model->SelectByKey($Id);
				}
			}
		}
		if($Statement) {
			exit(json_encode($Statement->fetchAll()));
		}
		else {
			header('HTTP/1.1 404 Not Found');
			exit();
		}
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
