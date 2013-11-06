<?php
require_once dirname(__FILE__) . '/../models/PembelianModel.php';
require_once dirname(__FILE__) . '/../models/BarangModel.php';
require_once dirname(__FILE__) . '/../models/SupplierModel.php';
require_once dirname(__FILE__) . '/../models/PembelianStruct.php';
require_once dirname(__FILE__) . '/AgregateController.php';

class PembelianController extends AgregateController {

	private $_Model;

	function __construct(){
		$this->_Model = new PembelianModel();
		parent::__construct('Pembelian', $this->_Model, array('barang' => new BarangModel(), 'supplier'=> new SupplierModel()));
	}

	function ActionPembelian() {
		$this->ActionIndex();
	}

	function ActionInsert() {
		$Item = new PembelianStruct();
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
		$Statement = $this->_Model->SelectViewFilteredByNomorBarangOrSupplier($SearchKeyword);
		$Param = array('Statement' => $Statement, 'SearchKeyword' => $SearchKeyword);
		$Param = array_merge($Param, $this->GetOtherModelsSelectAllStatement());
		$this->ShowCommonView($Param);
	}
}
?>
