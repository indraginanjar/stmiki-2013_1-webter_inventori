<?php
require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';

class SingleKeyModel {
	private $_DbConnection;
	private $_TableName;
	private $_KeyField;
	private $_FieldList;

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
		$sql = 'insert into ' . $this->_TableName . '(';
		foreach($this->_FieldList as $Field){
			$sql .= $Field . ',';
		}
		$sql = trim($sql, ',');
		$sql .= ') values ( ';
		foreach($this->_FieldList as $Field){
			$sql .= ':'.$Field . ',';
		}
		$sql .=	'on duplicate key update ';
		foreach($this->_FieldList as $Field){
			$sql .= $Field .' = :'.$Field . ',';
		}
		$sql = trim($sql, ',');
		
		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);


/*

		$execution = $statement->execute(array(':'.$this->_KeyField => $barang->Kode
					, ':barcode' => $barang->Barcode
					, ':namabrg' => $barang->Nama
					, ':satuan' => $barang->Satuan
					, ':harga' => $barang->Harga
					, ':stok' =>$barang->Stok
					)
				);

		if(!$execution) die($statement->errorInfo()[2]);


	}
*/

	function DeleteByKey($key){
		$sql = 'delete from '. $this->_TableName .' where '.$this->_KeyField.' = :'.$this->_KeyField;

		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$execution = $statement->execute(array(':'.$this->_KeyField => $key));

		if(!$execution) die($statement->errorInfo()[2]);
	}

	function SelectAll() {
		$sql = 'select * from '. $this->_TableName;
		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$execution = $statement->execute();

		if(!$execution) die($statement->errorInfo()[2]);
		return $statement;
	}

	function SelectByKey($key){
		$sql = 'select * from '. $this->_TableName .' where '.$this->_KeyField.' = :'.$this->_KeyField;
		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$execution = $statement->execute(array(':'.$this->_KeyField => $key));

		if(!$execution) die($statement->errorInfo()[2]);
		return $statement;

	}

	function SelectFilteredByKey($key){
		$sql = 'select *
from '. $this->_TableName .' 
where '.$this->_KeyField.' like :'.$this->_KeyField;

		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$key = '%' . $key . '%';

		$execution = $statement->execute(array(':'.$this->_KeyField => $key));

		if(!$execution) die($statement->errorInfo()[2]);
		return $statement;

	}

	function SelectFilteredByFields(array $fields, $value){
		$sql = 'select *
from '. $this->_TableName .' 
where ';
		foreach($fields as $Field) {
			$sql .= $Field . ' like :value or ';
		}
		$sql = rtrim($sql, ' or ');

		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$value = '%' . $value . '%';

		$execution = $statement->execute(array(':value' => $value));

		if(!$execution) die($statement->errorInfo()[2]);
		return $statement;
	}

	function GetDbConnection(){
		return $this->_DbConnection;
	}
}
?>
