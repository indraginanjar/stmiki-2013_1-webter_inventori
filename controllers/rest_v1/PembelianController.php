<?php
require_once dirname(__FILE__) . '/../../models/PembelianModel.php';
require_once dirname(__FILE__) . '/../../models/BarangModel.php';
require_once dirname(__FILE__) . '/../../models/SupplierModel.php';
require_once dirname(__FILE__) . '/../../models/PembelianStruct.php';
require_once dirname(__FILE__) . '/AgregateController.php';
require_once dirname(__FILE__) . '/../../inc/DateUtil.php';

class PembelianController extends AgregateController {

	function __construct($controllerActionIndex){
		$this->_Model = new PembelianModel();
		parent::__construct('Pembelian', $this->_Model, array('Barang' => new BarangModel(), 'Supplier'=> new SupplierModel()), $controllerActionIndex);
		$this->_Param = $this->GetParam();
	}

	function ActionPembelian() {
		$this->ActionIndex();
	}

	function GetUpdateFieldsClue($id){
		$IdField = array(
				'name' => 'Nomor'
				, 'type' => 'number'
		);
		if($id != null) {
			$IdField = array_merge($IdField, array('value' => $id));
		}
		$Clue = array('fields' => array((object) $IdField
				, (object) array(
						'name' => 'Tanggal'
						, 'type' => 'text'
						)
				, (object) array(
						'name' => 'BarangList[]'
						, 'type' => 'text'
						
				, (object) array(
						'name' => 'KodeSupplier'
						, 'type' => 'text'
						)
				, (object) array(
						'name' => 'HargaList[]'
						, 'type' => 'number'
						)
				, (object) array(
						'name' => 'JumlahList[]'
						, 'type' => 'number'
						)
				));
		return $Clue;
	}
}
?>
