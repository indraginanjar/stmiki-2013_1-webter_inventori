<?php
require_once dirname(__FILE__) . '/IController.php';
require_once dirname(__FILE__) . '/PageParam.php';

abstract class Controller implements IController {
	public abstract function actionIndex();

	function Run() {
		$actionString = PageParam::GetValue('a', GET, '');
		if(!empty($actionString)) {
			$actions = explode('/', $actionString);
			eval('$this->action'.$actions[0].'();');
			return;
		}
		$this->actionIndex();
	}

	function GetDb() {
		$Config = new Config();
		$dsn = 'mysql:dbname='.$config->DbName.';host='.$config->DbHost;
		try {
		    $dbh = new PDO($dsn, $Config->DbUser, $Config->DbPassword);
		} catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
		}
		return $dbh;
	}
}?>
