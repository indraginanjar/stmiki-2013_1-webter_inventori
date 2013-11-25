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
		global $BaseUrl;
		$this->_PageName = $pageName;
		$this->_PageUrl = $BaseUrl . 'index.php/' . $this->_PageName;
		$this->_Model = $model;
		$this->_Param = new PageParam();
	}

	function ActionSingleKey(){
		$this->ActionIndex();
	}

	function HandleGet(){
		header('Content-type: application/json; charset=utf-8');
		$IdActionIndex = $this->GetActionToExecuteIndex();
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
	}

	function HandleDelete(){
		header('Content-type: application/json; charset=utf-8');
		$IdActionIndex = $this->GetActionToExecuteIndex();
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
