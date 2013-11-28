<?php

require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/AgregateModel.php';



class PenjualanModel extends AgregateModel {
	const TABLE_NAME = 'tbjual';
	const KODE_FIELD = 'nofaktur';

	function __construct() {
		$Db = new InventoriDatabase();
		$this->_DbConnection = $Db->GetConnection();
		parent::__construct(PenjualanModel::TABLE_NAME, PenjualanModel::KODE_FIELD, $this->_DbConnection, 'v_jual');
	}
	
	function InsertOrUpdate(PenjualanStruct $penjualan) {
		$sql = 'insert into '. PenjualanModel::TABLE_NAME .' ('.PenjualanModel::KODE_FIELD.'
	, kodebrg
	, kodecst
	, tanggal
	, harga
	, jumlah
) values ( :'.PenjualanModel::KODE_FIELD.'
	, :kodebrg
	, :kodecst
	, :tanggal
	, :harga
	, :jumlah
)
on duplicate key update '.PenjualanModel::KODE_FIELD.'=:'.PenjualanModel::KODE_FIELD.'
	, kodebrg=:kodebrg
	, kodecst=:kodecst
	, tanggal=:tanggal
	, harga=:harga
	, jumlah=:jumlah
';
		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$execution = $statement->execute(array(':'.PenjualanModel::KODE_FIELD => $penjualan->Nomor
					, ':kodebrg' => $penjualan->KodeBarang
					, ':kodecst' => $penjualan->KodeCustomer
					, ':tanggal' => $penjualan->Tanggal
					, ':harga' => $penjualan->Harga
					, ':jumlah' => $penjualan->Jumlah
					)
				);
		if(!$execution) die($statement->errorInfo()[2]);
	}

	function SelectViewFilteredByNomorBarangOrCustomer($kode){
		return $this->SelectViewFilteredByFields(array(PenjualanModel::KODE_FIELD, 'namabrg', 'namacst'), $kode);
	}
}

?>
