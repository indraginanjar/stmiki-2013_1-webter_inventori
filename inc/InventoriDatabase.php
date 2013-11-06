<?php
class InventoriDatabase {
	private $_Connection;
	function __construct() {
		$Config = new Config();
		$Dsn = 'mysql:dbname='. $Config->DbName.';host='. $Config->DbHost;
		try {
		    $this->_Connection = new PDO($Dsn, $Config->DbUser, $Config->DbPassword);
		} catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
		}
	}

	function GetConnection() {
		return $this->_Connection;
	}
}?>
