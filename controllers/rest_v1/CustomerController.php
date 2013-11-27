<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';
require_once dirname(__FILE__) . '/../../models/CustomerModel.php';
require_once dirname(__FILE__) . '/../../models/CustomerStruct.php';

class CustomerController extends SingleKeyController {

	function __construct($controllerActionIndex){
		$this->_Model = new CustomerModel();
		parent::__construct('Customer', $this->_Model, $controllerActionIndex);
	}

	function ActionCustomer() {
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

}
?>
