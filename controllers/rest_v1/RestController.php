<?php
require_once dirname(__FILE__) . '/../../inc/IController.php';
require_once dirname(__FILE__) . '/../../inc/Controller.php';

class RestController extends Controller implements IController {

	private $_RestRoot;

	function __construct($controllerActionIndex) {
		parent::__construct($controllerActionIndex);
		$this->_RestRoot = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']; 
	}

	function ActionIndex(){
		//header('Content-type: application/vnd.siren+json');
		header('Content-type: application/json');
		//header('Content-type: text/html');
		$Response = (object) array(
				'class' => array('collection')
				, 'entities' => array(
							(object) array (
								'class' => array('collection')
								, 'href' => $this->_RestRoot . 'barang'
								)
							, (object) array (
								'class' => array('collection')
								, 'href' => $this->_RestRoot . 'supplier'
								)
							, (object) array (
								'class' => array('collection')
								, 'href' => $this->_RestRoot . 'customer'
								)
							, (object) array (
								'class' => array('collection')
								, 'href' => $this->_RestRoot . 'pembelian'
								)
							, (object) array (
								'class' => array('collection')
								, 'href' => $this->_RestRoot . 'penjualan'
								)
							, (object) array (
								'class' => array('item')
								, 'href' => $this->_RestRoot . 'version'
								)
						)
				, 'links'=> array(
						(object) array(
								'rel' => array('self')
								, 'href' => $this->_RestRoot
								)
						)
				);
		exit(json_encode($Response));
	}
	
	function ActionSupplier() {
		require_once dirname(__FILE__) . '/SupplierController.php';
		$Controller = new SupplierController($this->GetActionToExecuteIndex());
		$Controller->Run();
	}

        function ActionBarang() {
		require_once dirname(__FILE__) . '/BarangController.php';
		$Controller = new BarangController($this->GetActionToExecuteIndex());
		$Controller->Run();
		
	}
	function ActionCustomer() {
		require_once dirname(__FILE__) . '/CustomerController.php';
		$Controller = new CustomerController($this->GetActionToExecuteIndex());
		$Controller->Run();
	}

	function ActionPembelian() {
		require_once dirname(__FILE__) . '/PembelianController.php';
		$Controller = new PembelianController($this->GetActionToExecuteIndex());
		$Controller->Run();
	}

	function ActionPenjualan() {
		require_once dirname(__FILE__) . '/PenjualanController.php';
		$Controller = new PenjualanController($this->GetActionToExecuteIndex());
		$Controller->Run();
	}

	function ActionAbout(){
		$AfterMenuPart = 'views/About-AfterMenu.php';	
		include 'views/template/inventori.php';
	}

	function ActionVersion(){
		$Response = (object) array(
				'class' => array('item')
				, 'properties' => (object) array(
						'version' => '1.0'
						)
				, 'links' => array(
						(object) array(
								'rel' => array('self')
								, 'href' => $this->_RestRoot
								)
						, (object) array(
								'rel' => array('up')
								, 'href' => substr($this->_RestRoot, 0, 0 - strlen('version'))
								)
						)
				);
		exit(json_encode($Response));
	}
/*
	function ActionRest(){
		eval('$this->Action' . $this->GetParam()->GetAction($this->GetActionToExecuteIndex()) . '();');
	}
*/
}
?>
