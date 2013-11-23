<?php
require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/ISingleKeyModel.php';
require_once dirname(__FILE__) . '/SingleKeyModel.php';

class AgregateModel extends SingleKeyModel {

	private $_ViewName;
	private $_KeyField;
	private $_TableName;
	private $_DbConnection;

	function __construct($tableName, $keyField, $connection, $viewName) {
		parent::__construct($tableName, $keyField, $connection);
		$this->_ViewName = $viewName;
		$this->_KeyField = $this->GetKeyField();
		$this->_TableName = $this->GetTableName();
		$this->_DbConnection = $this->GetDbConnection();
	}
	
	function SelectViewAll() {
		$Sql = 'select * from '. $this->_ViewName;
		$Statement = $this->GetDbConnection()->prepare($Sql);

		if(!$Statement) die($this->GetDbConnection()->errorInfo()[2]);

		$Execution = $Statement->execute();

		if(!$Execution) die($Statement->errorInfo()[2]);
		return $Statement;
	}

	function SelectViewByKey($key){
		$Sql = 'select * from '. $this->_ViewName .' where '.$this->_KeyField.' = :'.$this->_KeyField;
		$Statement = $this->GetDbConnection()->prepare($Sql);

		assert($Statement, $this->_DbConnection->errorInfo()[2]);
		if($this->_DbConnection->errorCode() != '00000'){
			return false;
		}

		$Execution = $Statement->execute(array(':'.$this->_KeyField => $key));

		assert($Execution, $Statement->errorInfo()[2]);
		if($Statement->errorCode() != '00000'){
			return false;
		}

		return $Statement;

	}

	function SelectViewFilteredByKey($key){
		$Sql = 'select *
from '. $this->_ViewName .' 
where '.$this->_KeyField.' like :'.$this->_KeyField;

		$Statement = $this->GetDbConnection()->prepare($Sql);

		if(!$Statement) die($this->GetDbConnection()->errorInfo()[2]);

		$key = '%' . $key . '%';

		$Execution = $Statement->execute(array(':'.$this->_KeyField => $key));

		if(!$Execution) die($Statement->errorInfo()[2]);
		return $Statement;

	}

	function SelectViewFilteredByFields(array $fields, $value){
		$Sql = 'select *
from '. $this->_ViewName .' 
where ';
		foreach($fields as $Field) {
			$Sql .= $Field . ' like :value or ';
		}
		$Sql = rtrim($Sql, ' or ');

		$Statement = $this->GetDbConnection()->prepare($Sql);

		if(!$Statement) die($this->GetDbConnection()->errorInfo()[2]);

		$value = '%' . $value . '%';

		$Execution = $Statement->execute(array(':value' => $value));

		if(!$Execution) die($Statement->errorInfo()[2]);
		return $Statement;

	}

}

?>
