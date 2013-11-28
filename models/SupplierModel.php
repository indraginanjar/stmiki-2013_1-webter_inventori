<?php

require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/SingleKeyModel.php';



class SupplierModel extends SingleKeyModel {
	const TABLE_NAME = 'tbsuplier';
	const KODE_FIELD = 'kodesupp';

	function __construct() {
		$Db = new InventoriDatabase();
		$this->_DbConnection = $Db->GetConnection();
		parent::__construct(SupplierModel::TABLE_NAME, SupplierModel::KODE_FIELD, $this->_DbConnection);
	}
	
	function InsertOrUpdate(SupplierStruct $supplier) {
		$sql = 'insert into '. SupplierModel::TABLE_NAME .' ('.SupplierModel::KODE_FIELD.'
	, namasupp
	, alamat
	, telp
) values ( :'.SupplierModel::KODE_FIELD.'
	, :namasupp
	, :alamat
	, :telp
)
on duplicate key update '.SupplierModel::KODE_FIELD.'=:'.SupplierModel::KODE_FIELD.'
	, namasupp=:namasupp
	, alamat=:alamat
	, telp=:telp
';
		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$execution = $statement->execute(array(':'.SupplierModel::KODE_FIELD => $supplier->Kode
					, ':namasupp' => $supplier->Nama
					, ':alamat' => $supplier->Alamat
					, ':telp' => $supplier->Telp
					)
				);

		if(!$execution) die($statement->errorInfo()[2]);
	}

	function SelectFilteredByKodeOrNama($kode){
		return $this->SelectFilteredByFields(array(SupplierModel::KODE_FIELD, 'namasupp'), $kode);
	}
}
?>
