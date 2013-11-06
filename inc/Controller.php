<?php
require_once dirname(__FILE__) . '/IController.php';
require_once dirname(__FILE__) . '/PageParam.php';
require_once dirname(__FILE__) . '/../Config.php';

abstract class Controller implements IController {
	//public abstract function actionIndex();

	private $_Param;
	function __construct() {
		$this->_Param = new PageParam();
	}

	function Run() {
		if($this->_Param->GetActionCount() > 1) {
			eval('$this->action'.$this->_Param->GetAction(1).'();');
			return;
		}
		$this->actionIndex();
	}
}?>
