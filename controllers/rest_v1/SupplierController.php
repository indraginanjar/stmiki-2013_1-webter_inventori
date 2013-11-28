<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';
require_once dirname(__FILE__) . '/../../models/SupplierModel.php';
require_once dirname(__FILE__) . '/../../models/SupplierStruct.php';

class SupplierController extends SingleKeyController {

	function __construct($controllerActionIndex){
		$this->_Model = new SupplierModel();
		parent::__construct('Supplier', $this->_Model, $controllerActionIndex);
	}

	function ActionSupplier() {
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
						'name' => 'nama'
						, 'type' => 'text'
						)
				, (object) array(
						'name' => 'alamat'
						, 'type' => 'text'
						)
				, (object) array(
						'name' => 'telp'
						, 'type' => 'text'
						)
				));
		return $Clue;
	}

	function WriteJsonSearch($query, array $updateParams = NULL){
		$Statement = $this->_Model->SelectFilteredByKodeOrNama($query);
		$this->WriteJsonMultipleItem($Statement, $updateParams);
	}
}
?>
