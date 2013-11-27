<?php
require_once dirname(__FILE__) . '/../models/PembelianModel.php';
require_once dirname(__FILE__) . '/../models/BarangModel.php';
require_once dirname(__FILE__) . '/../models/SupplierModel.php';
require_once dirname(__FILE__) . '/../models/PembelianStruct.php';
require_once dirname(__FILE__) . '/AgregateController.php';
require_once dirname(__FILE__) . '/../inc/DateUtil.php';

class PembelianController extends AgregateController {

	function __construct(){
		$this->_Model = new PembelianModel();
		parent::__construct('Pembelian', $this->_Model, array('barang' => new BarangModel(), 'supplier'=> new SupplierModel()), 2);
	}

	function ActionPembelian() {
		switch($_SERVER['REQUEST_METHOD']) {
		case 'GET':
			$this->ActionIndex();
			break;
		case 'POST':
			$Method = POST;
			$Item = new PembelianStruct();
			$Item->SetValueByPageParam(POST);
			$NewNoFaktur = $this->_Model->InsertOrUpdate($Item);
			if($NewNoFaktur){
				header('HTTP/1.1 201 Created');  
				header('Location:'.$this->GetPageUrl().'/'.$NewNoFaktur);
				exit();
			}
			header('HTTP/1.1 500 Internal Server Error');  
			break;
		}
	}

	function ActionInsert() {
		$Method = POST;
		$Item = new PembelianStruct();
		$Item->SetValueByPageParam(POST);
		$this->_Model->InsertOrUpdate($Item);
		header('location:' . $this->GetPageUrl());
		exit();
	}

	function ActionSearch() {
		$SearchKeyword = $this->GetAction($this->GetActionToExecuteIndex() + 2);
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
