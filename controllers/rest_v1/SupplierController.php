<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';
require_once dirname(__FILE__) . '/../../models/SupplierModel.php';
require_once dirname(__FILE__) . '/../../models/SupplierStruct.php';

class SupplierController extends SingleKeyController {

	private $_Model;

	function __construct($controllerActionIndex){
		$this->_Model = new SupplierModel();
		parent::__construct('Supplier', $this->_Model, $controllerActionIndex);
	}

	function ActionSupplier() {
		$this->ActionIndex();
	}

	function ActionInsert() {
		$Item = new SupplierStruct();
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
