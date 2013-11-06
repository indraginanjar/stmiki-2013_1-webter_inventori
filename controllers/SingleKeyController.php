<?php
require_once dirname(__FILE__) . '/../inc/IController.php';
require_once dirname(__FILE__) . '/../inc/Controller.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/../models/SingleKeyModel.php';
require_once dirname(__FILE__) . '/../Config.php';

class SingleKeyController extends Controller implements IController {

	private $_Config;
	private $_PageUrl;
	private $_DbConnection;
	private $_Model;
	private $_Param;
	private $_PageName;

	function __construct($pageName, $model){
		$this->_Config = new Config();
		$this->_PageName = $pageName;
		$this->_PageUrl = $this->_Config->BaseUrl . 'index.php/' . $this->_PageName;
		$this->_Model = $model;
		$this->_Param = new PageParam();
	}

	function ActionIndex() {
		$Statement = $this->_Model->SelectAll();
		$this->ShowCommonView(array('Statement' => $Statement));	
	}

	function ActionSingleKey(){
		$this->ActionIndex();
	}

	function ActionDelete() {
		$this->_Model->DeleteByKey($this->_Param->GetAction(3));
		header( 'location:' . $this->_PageUrl);
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

	function GetAction($ActionIndex) {
		return $this->_Param->GetAction($ActionIndex);
	}

	function GetModel(){
		return $this->_Model;
	}

	function Run() {
		switch($this->_Param->GetActionCount()){
		case 2:
			eval('$this->Action'.$this->_Param->GetAction(1).'();');
			break;
		case 3:
			eval('$this->Action'.$this->_Param->GetAction(2).'();');
			break;
		case 4:
			eval('$this->Action'.$this->_Param->GetAction(2).'();');
			break;
		default:
			$this->ActionIndex();
		}
	}
}
?>
