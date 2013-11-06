<?php
require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/ISingleKeyModel.php';
require_once dirname(__FILE__) . '/SingleKeyModel.php';

class AgregateModel extends SingleKeyModel {

	private $_ViewName;

	function __construct($tableName, $keyField, $connection, $viewName) {
		parent::__construct($tableName, $keyField, $connection);
		$this->_ViewName = $viewName;
	}
	
	function SelectViewAll() {
		$sql = 'select * from '. $this->_ViewName;
		$statement = $this->GetDbConnection()->prepare($sql);

		if(!$statement) die($this->GetDbConnection()->errorInfo()[2]);

		$execution = $statement->execute();

		if(!$execution) die($statement->errorInfo()[2]);
		return $statement;
	}

	function SelectViewByKey($key){
		$sql = 'select * from '. $this->_ViewName .' where '.$this->_KeyField.' = :'.$this->_KeyField;
		$statement = $this->GetDbConnection()->prepare($sql);

		if(!$statement) die($this->GetDbConnection()->errorInfo()[2]);

		$execution = $statement->execute(array(':'.$this->_KeyField => $key));

		if(!$execution) die($statement->errorInfo()[2]);
		return $statement;

	}

	function SelectViewFilteredByKey($key){
		$sql = 'select *
from '. $this->_ViewName .' 
where '.$this->_KeyField.' like :'.$this->_KeyField;

		$statement = $this->GetDbConnection()->prepare($sql);

		if(!$statement) die($this->GetDbConnection()->errorInfo()[2]);

		$key = '%' . $key . '%';

		$execution = $statement->execute(array(':'.$this->_KeyField => $key));

		if(!$execution) die($statement->errorInfo()[2]);
		return $statement;

	}

	function SelectViewFilteredByFields(array $fields, $value){
		$sql = 'select *
from '. $this->_ViewName .' 
where ';
		foreach($fields as $Field) {
			$sql .= $Field . ' like :value or ';
		}
		$sql = rtrim($sql, ' or ');

		$statement = $this->GetDbConnection()->prepare($sql);

		if(!$statement) die($this->GetDbConnection()->errorInfo()[2]);

		$value = '%' . $value . '%';

		$execution = $statement->execute(array(':value' => $value));

		if(!$execution) die($statement->errorInfo()[2]);
		return $statement;

	}

}

?>
