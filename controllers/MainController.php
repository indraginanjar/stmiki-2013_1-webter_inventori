<?php
require_once dirname(__FILE__) . '/../inc/IController.php';
require_once dirname(__FILE__) . '/../inc/Controller.php';

class MainController extends Controller implements IController {

	function actionIndex() {
		$this->actionBarang();	
	}

	function actionBarang() {
		require_once dirname(__FILE__) . '/BarangController.php';
		$controller = new BarangController();
		$controller->Run();
		
	}
	
	function actionSupplier() {
		require_once dirname(__FILE__) . '/SupplierController.php';
		$controller = new SupplierController();
		$controller->Run();
	}

	function actionCustomer() {
		require_once dirname(__FILE__) . '/CustomerController.php';
		$controller = new CustomerController();
		$controller->Run();
	}

	function actionPembelian() {
		require_once dirname(__FILE__) . '/PembelianController.php';
		$controller = new PembelianController();
		$controller->Run();
	}

	function actionPenjualan() {
		require_once dirname(__FILE__) . '/PenjualanController.php';
		$controller = new PenjualanController();
		$controller->Run();
	}

	function actionAbout(){
		$AfterMenuPart = 'views/About-AfterMenu.php';	
		include 'views/template/inventori.php';
	}
}
?>
