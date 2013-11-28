<?php
require_once dirname(__FILE__) . '/../models/PenjualanModel.php';
require_once dirname(__FILE__) . '/../models/BarangModel.php';
require_once dirname(__FILE__) . '/../models/CustomerModel.php';
require_once dirname(__FILE__) . '/../models/PenjualanStruct.php';
require_once dirname(__FILE__) . '/AgregateController.php';

class PenjualanController extends AgregateController {

	function __construct($controllerActionIndex){
		$this->_Model = new PenjualanModel();
		parent::__construct('Penjualan', $this->_Model, array('barang' => new BarangModel(), 'customer'=> new CustomerModel()), $controllerActionIndex);
	}

	function ActionPenjualan() {
		$this->ActionIndex();
	}

	function ActionInsert() {
		$Item = new PenjualanStruct();
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
		$Statement = $this->_Model->SelectViewFilteredByNomorBarangOrCustomer($SearchKeyword);
		$Param = array('Statement' => $Statement, 'SearchKeyword' => $SearchKeyword);
		$Param = array_merge($Param, $this->GetOtherModelsSelectAllStatement());
		$this->ShowCommonView($Param);
	}
}
?>
