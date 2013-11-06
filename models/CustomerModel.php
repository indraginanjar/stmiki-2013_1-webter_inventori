<?php

require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/SingleKeyModel.php';



class CustomerModel extends SingleKeyModel {
	private $_DbConnection;
	const TABLE_NAME = 'tbcustomer';
	const KODE_FIELD = 'kodecst';

	function __construct() {
		$Db = new InventoriDatabase();
		$this->_DbConnection = $Db->GetConnection();
		parent::__construct(CustomerModel::TABLE_NAME, CustomerModel::KODE_FIELD, $this->_DbConnection);
	}
	
	function InsertOrUpdate(CustomerStruct $customer) {
		$sql = 'insert into '. CustomerModel::TABLE_NAME .' ('.CustomerModel::KODE_FIELD.'
	, namacst
	, alamat
	, telp
) values ( :'.CustomerModel::KODE_FIELD.'
	, :namacst
	, :alamat
	, :telp
)
on duplicate key update '.CustomerModel::KODE_FIELD.'=:'.CustomerModel::KODE_FIELD.'
	, namacst=:namacst
	, alamat=:alamat
	, telp=:telp
';
		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$execution = $statement->execute(array(':'.CustomerModel::KODE_FIELD => $customer->Kode
					, ':namacst' => $customer->Nama
					, ':alamat' => $customer->Alamat
					, ':telp' => $customer->Telp
					)
				);

		if(!$execution) die($statement->errorInfo()[2]);
	}

	function SelectFilteredByKodeOrNama($kode){
		return $this->SelectFilteredByFields(array(CustomerModel::KODE_FIELD, 'namacst'), $kode);
	}
}
?>
