<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';
require_once dirname(__FILE__) . '/../../models/BarangModel.php';
require_once dirname(__FILE__) . '/../../models/BarangStruct.php';

class BarangController extends SingleKeyController {

	private $_Model;

	function __construct($controllerActionIndex){
		$this->_Model = new BarangModel();
		parent::__construct('Barang', $this->_Model, $controllerActionIndex);
	}

	function ActionBarang(){
		$this->ActionIndex();
	}
}
?>
