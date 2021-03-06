<?php
require_once dirname(__FILE__) . '/../inc/IController.php';
require_once dirname(__FILE__) . '/../inc/Controller.php';
require_once dirname(__FILE__) . '/../Config.php';

class MainController extends Controller implements IController {

	function __construct(){
		parent::__construct(0);
	}

	function ActionIndex() {
		$this->ActionBarang();	
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
	
	function ActionRest() {
		require_once dirname(__FILE__) . '/rest_v1/RestController.php';
		$Controller = new RestController($this->GetActionToExecuteIndex());
		$Controller->Run();
	}

	function ActionAbout(){
		$AfterMenuPart = 'views/About-AfterMenu.php';	
		include 'views/template/inventori.php';
	}
}
?>
