<?php
require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';

class SingleKeyModel {
	protected $_DbConnection;
	protected $_TableName;
	protected $_KeyField;
	protected $_FieldList;

	function __construct($tableName, $keyField, $connection) {
		$this->_DbConnection = $connection;
		$this->_TableName = $tableName;
		$this->_KeyField = $keyField;
	}

/*
	function __construct($tableName, $keyField, $fieldList, $connection) {
		$this->_DbConnection = $connection;
		$this->_TableName = $tableName;
		$this->_KeyField = $keyField;
		$this->_FieldList = $fieldList;
	}
*/
/*	
	function InsertOrUpdate(array $values) {
		$Sql = 'insert into ' . $this->_TableName . '(';
		foreach($this->_FieldList as $Field){
			$Sql .= $Field . ',';
		}
		$Sql = trim($Sql, ',');
		$Sql .= ') values ( ';
		foreach($this->_FieldList as $Field){
			$Sql .= ':'.$Field . ',';
		}
		$Sql .=	'on duplicate key update ';
		foreach($this->_FieldList as $Field){
			$Sql .= $Field .' = :'.$Field . ',';
		}
		$Sql = trim($Sql, ',');
		
		$Statement = $this->_DbConnection->prepare($Sql);

		if(!$Statement) die($this->_DbConnection->errorInfo()[2]);


/*

		$Execution = $Statement->execute(array(':'.$this->_KeyField => $barang->Kode
					, ':barcode' => $barang->Barcode
					, ':namabrg' => $barang->Nama
					, ':satuan' => $barang->Satuan
					, ':harga' => $barang->Harga
					, ':stok' =>$barang->Stok
					)
				);

		if(!$Execution) die($Statement->errorInfo()[2]);


	}
*/

	function DeleteByKey($key){
		$Sql = 'delete from '. $this->_TableName .' where '.$this->_KeyField.' = :'.$this->_KeyField;

		$Statement = $this->_DbConnection->prepare($Sql);

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

	function SelectAll() {
		$Sql = 'select * from '. $this->_TableName;
		$Statement = $this->_DbConnection->prepare($Sql);

		assert($Statement, $this->_DbConnection->errorInfo()[2]);
		if($this->_DbConnection->errorCode() != '00000'){
			return false;
		}
		$Execution = $Statement->execute();

		assert($Execution, $Statement->errorInfo()[2]);
		if($Statement->errorCode() != '00000'){
			return false;
		}
		return $Statement;
	}

	function SelectByKey($key){
		$Sql = 'select * from '. $this->_TableName .' where '.$this->_KeyField.' = :'.$this->_KeyField;
		$Statement = $this->_DbConnection->prepare($Sql);

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

	function SelectFilteredByKey($key){
		$Sql = 'select *
from '. $this->_TableName .' 
where '.$this->_KeyField.' like :'.$this->_KeyField;

		$Statement = $this->_DbConnection->prepare($Sql);

		assert($Statement, $this->_DbConnection->errorInfo()[2]);
		if($this->_DbConnection->errorCode() != '00000'){
			return false;
		}

		$key = '%' . $key . '%';

		$Parameter = array(':'.$this->_KeyField => $key);
		$Execution = $Statement->execute($Parameter);

		assert($Execution, $Statement->errorInfo()[2]);
		if($Statement->errorCode() != '00000'){
			return false;
		}
		assert($Statement->rowCount() > 0, str_replace(array_keys($Parameter), array_values($Parameter), $Sql));
		return $Statement;

	}

	function SelectFilteredByFields(array $fields, $value){
		$Sql = 'select *
from '. $this->_TableName .' 
where ';
		foreach($fields as $Field) {
			$Sql .= $Field . ' like :value or ';
		}
		$Sql = rtrim($Sql, ' or ');

		$Statement = $this->_DbConnection->prepare($Sql);

		if(!$Statement) die($this->_DbConnection->errorInfo()[2]);

		$value = '%' . $value . '%';

		$Execution = $Statement->execute(array(':value' => $value));

		if(!$Execution) die($Statement->errorInfo()[2]);
		return $Statement;
	}

	function GetDbConnection(){
		return $this->_DbConnection;
	}

	function GetKeyField(){
		return $this->_KeyField;
	}

	function GetTableName(){
		return $this->_TableName;
	}
}
?>
