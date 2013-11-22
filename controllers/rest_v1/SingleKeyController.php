<?php
require_once dirname(__FILE__) . '/../../inc/IController.php';
require_once dirname(__FILE__) . '/../../inc/Controller.php';
require_once dirname(__FILE__) . '/../../inc/PageParam.php';
require_once dirname(__FILE__) . '/../../models/SingleKeyModel.php';
require_once dirname(__FILE__) . '/../../Config.php';

class SingleKeyController extends Controller implements IController {

	private $_Config;
	private $_PageUrl;
	private $_DbConnection;
	private $_Model;
	private $_Param;
	private $_PageName;

	function __construct($pageName, $model, $controllerActionIndex){
		parent::__construct($controllerActionIndex);
		$this->_Config = new Config();
		$this->_PageName = $pageName;
		$this->_PageUrl = $this->_Config->BaseUrl . 'index.php/' . $this->_PageName;
		$this->_Model = $model;
		$this->_Param = new PageParam();
	}

	function ActionIndex() {
		header('Content-type: application/json; charset=utf-8');
		$IdActionIndex = $this->GetActionToExecuteIndex();
		switch($_SERVER['REQUEST_METHOD']) {
		case 'GET':
			$Statement = $this->_Model->SelectAll();
			$Id = $this->_Param->GetAction($IdActionIndex);
			if($Id == NULL){
				$Statement = $this->_Model->SelectAll();
			}
			else {
				$Statement = $this->_Model->SelectByKey($Id);
			}
			if($Statement) {
				exit(json_encode($Statement->fetchAll()));
			}
			else {
				header('HTTP/1.1 404 Not Found');
				exit();
			}
			break;
		case 'DELETE':
			$Statement = $this->_Model->SelectAll();
			$Id = $this->_Param->GetAction($IdActionIndex);
			if($Id == NULL){
				header('HTTP/1.1 400 Bad Request');  
				exit('{ "error" : "Missing Required Parameters" }');
			}
			$Statement = $this->_Model->DeleteByKey($Id);
			if(!$Statement){
				header('HTTP/1.1 404 Not Found');
				exit('{"error":"Specified Record Are Not found"}');
			}
			break;
		
		}
	}

	function ActionSingleKey(){
		$this->ActionIndex();
	}

	function ActionDelete() {
		$Id = $this->_Param->GetAction(3);
		if(!$this->_Model->DeleteByKey($Id)){
			header('HTTP/1.1 404 Not Found');  
		}
		exit();
	}

	function ActionEdit() {
		$Statement = $this->_Model->SelectByKey($this->_Param->GetAction(3));
		
		$SingleItem = $Statement->fetch(PDO::FETCH_OBJ);
		
		$Statement = $this->_Model->SelectAll();

		$this->ShowCommonView(array('Statement' => $Statement, 'SingleItem' => $SingleItem));
	}

	function ShowCommonView(array $viewParams) {
		$HeadEndPart = 'views/'.$this->_PageName.'-HeadEnd.php';	
		$AfterMenuPart = 'views/'.$this->_PageName.'-AfterMenu.php';	
		$BodyEndAfterScriptPart = 'views/'.$this->_PageName.'-BodyEndAfterScript.php';	
		include 'views/template/inventori.php';
	}

	function GetPageUrl() {
		return $this->_PageUrl;
	}


	function GetModel(){
		return $this->_Model;
	}

	function GetParam() {
		return $this->_Param;
	}
}
?>
