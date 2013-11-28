<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';
require_once dirname(__FILE__) . '/../models/CustomerModel.php';
require_once dirname(__FILE__) . '/../models/CustomerStruct.php';

class CustomerController extends SingleKeyController {

	function __construct($controllerActionIndex){
		$this->_Model = new CustomerModel();
		parent::__construct('Customer', $this->_Model, $controllerActionIndex);
	}

	function ActionCustomer() {
		$this->ActionIndex();
	}

	function ActionInsert() {
		$Item = new CustomerStruct();
		$Item->SetValueByPageParam(POST);
		$this->_Model->InsertOrUpdate($Item);
		header('location:' . $this->GetPageUrl());
		exit();
	}

	function ActionSearch() {
		$SearchKeyword = $this->GetAction(3);
		if(empty($SearchKeyword)){
			$this->ActionIndex();
			return;
		}
		$Statement = $this->_Model->SelectFilteredByKodeOrNama($SearchKeyword);
		
		$this->ShowCommonView(array('Statement' => $Statement, 'SearchKeyword' => $SearchKeyword));
	}
}
?>
