<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';
require_once dirname(__FILE__) . '/../../models/BarangModel.php';
require_once dirname(__FILE__) . '/../../models/BarangStruct.php';

class BarangController extends SingleKeyController {

	function __construct($controllerActionIndex){
		$this->_Model = new BarangModel();
		parent::__construct('Barang', $this->_Model, $controllerActionIndex);
	}

	function ActionBarang(){
		$this->ActionIndex();
	}

	function GetUpdateFieldsClue($id){
		$IdField = array(
				'name' => 'kode'
				, 'type' => 'number'
		);
		if($id != null) {
			$IdField = array_merge($IdField, array('value' => $id));
		}
		$Clue = array('fields' => array((object) $IdField
				, (object) array(
						'name' => 'barcode'
						, 'type' => 'text'
						)
				, (object) array(
						'name' => 'nama'
						, 'type' => 'text'
						)
				, (object) array(
						'name' => 'satuan'
						, 'type' => 'text'
						)
				, (object) array(
						'name' => 'harga'
						, 'type' => 'number'
						)
				, (object) array(
						'name' => 'stok'
						, 'type' => 'number'
						)
				));
		return $Clue;

	}
}
?>
