<?php
require_once dirname(__FILE__) . '/IController.php';
require_once dirname(__FILE__) . '/PageParam.php';
require_once dirname(__FILE__) . '/../Config.php';

abstract class Controller implements IController {
	//public abstract function actionIndex();

	private $_Param;

	// menunjukkan index yang menjadi tempat controller ini
	private $_ControllerActionIndex;
	private $_ActionToExecuteIndex;
	private $_IdActionIndex;

	function __construct($controllerActionIndex) {
		$Config = new Config();
		if(strcasecmp($Config->Assert, 'DEFAULT') != 0){
			assert_options(ASSERT_ACTIVE, $Config->Assert);
		}
		$this->_Param = new PageParam();
		$this->_ControllerActionIndex = $controllerActionIndex;
		$this->_ActionToExecuteIndex = $this->_ControllerActionIndex + 1;
		$this->_IdActionIndex = $this->_ControllerActionIndex + 2;
	}
	
	function GetParam() {
		return $this->_Param;
	}

	function GetControllerActionIndex(){
		return $this->_ControllerActionIndex;
	}

	function SetControllerActionIndex($index){
		$this->_ControllerActionIndex = $index;
		$this->_ActionToExecuteIndex = $this->_ControllerActionIndex + 1;
		$this->_IdActionIndex = $this->_ControllerActionIndex + 2;
	}

	function GetActionToExecuteIndex(){
		return $this->_ActionToExecuteIndex;
	}

	function GetIdActionIndex(){
		return $this->_IdActionIndex;
	}

	function GetAction($ActionIndex) {
		return $this->_Param->GetAction($ActionIndex);
	}
	
	function Run() {
		if($this->_Param->GetActionCount() > $this->_ControllerActionIndex + 1) {
			if(method_exists($this, 'Action' . $this->_Param->GetAction($this->_ActionToExecuteIndex))){
				eval('$this->action'.$this->_Param->GetAction($this->_ActionToExecuteIndex).'();');
				return;
			}
		}
		$Method = ucfirst($_SERVER['REQUEST_METHOD']);
		if(method_exists($this, 'Handle' . $Method)){
			eval('$this->Handle'. $Method .'();');
			return;
		}
		$this->ActionIndex();
	}
}?>
