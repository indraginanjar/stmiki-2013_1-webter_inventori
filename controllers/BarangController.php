<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';
require_once dirname(__FILE__) . '/../models/BarangModel.php';
require_once dirname(__FILE__) . '/../models/BarangStruct.php';

class BarangController extends SingleKeyController {

	function __construct($controllerActionIndex){
		$this->_Model = new BarangModel();
		parent::__construct('Barang', $this->_Model, $controllerActionIndex);
	}

	function ActionBarang(){
		$this->ActionIndex();
	}

	function ActionInsert() {
		$Item = new BarangStruct();
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
		$Statement = $this->_Model->SelectFilteredByKodeBarcodeOrNama($SearchKeyword);
		
		$this->ShowCommonView(array('Statement' => $Statement, 'SearchKeyword' => $SearchKeyword));
	}
}
?>
