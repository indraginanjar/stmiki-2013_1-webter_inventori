<?php
require_once dirname(__FILE__) . '/../../models/PembelianModel.php';
require_once dirname(__FILE__) . '/../../models/BarangModel.php';
require_once dirname(__FILE__) . '/../../models/SupplierModel.php';
require_once dirname(__FILE__) . '/../../models/PembelianStruct.php';
require_once dirname(__FILE__) . '/AgregateController.php';
require_once dirname(__FILE__) . '/../../inc/DateUtil.php';

class PembelianController extends AgregateController {

	private $_Model;
	private $_Param;

	function __construct($controllerActionIndex){
		$this->_Model = new PembelianModel();
		parent::__construct('Pembelian', $this->_Model, array('Barang' => new BarangModel(), 'Supplier'=> new SupplierModel()), $controllerActionIndex);
		$this->_Param = $this->GetParam();
	}

	function ActionPembelian() {
		$this->ActionIndex();
	}
}
?>
