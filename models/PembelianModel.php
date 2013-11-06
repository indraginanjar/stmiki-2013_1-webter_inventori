<?php

require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/AgregateModel.php';



class PembelianModel extends AgregateModel {
	private $_DbConnection;
	const TABLE_NAME = 'tbbeli';
	const KODE_FIELD = 'nofaktur';
	private $_Model;

	function __construct() {
		$Db = new InventoriDatabase();
		$this->_DbConnection = $Db->GetConnection();
		parent::__construct(PembelianModel::TABLE_NAME, PembelianModel::KODE_FIELD, $this->_DbConnection, 'v_beli');
	}
	
	function InsertOrUpdate(PembelianStruct $pembelian) {
		$sql = 'insert into '. PembelianModel::TABLE_NAME .' ('.PembelianModel::KODE_FIELD.'
	, kodebrg
	, kodesupp
	, tanggal
	, harga
	, jumlah
) values ( :'.PembelianModel::KODE_FIELD.'
	, :kodebrg
	, :kodesupp
	, :tanggal
	, :harga
	, :jumlah
)
on duplicate key update '.PembelianModel::KODE_FIELD.'=:'.PembelianModel::KODE_FIELD.'
	, kodebrg=:kodebrg
	, kodesupp=:kodesupp
	, tanggal=:tanggal
	, harga=:harga
	, jumlah=:jumlah
';
		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$execution = $statement->execute(array(':'.PembelianModel::KODE_FIELD => $pembelian->Nomor
					, ':kodebrg' => $pembelian->KodeBarang
					, ':kodesupp' => $pembelian->KodeSupplier
					, ':tanggal' => $pembelian->Tanggal
					, ':harga' => $pembelian->Harga
					, ':jumlah' => $pembelian->Jumlah
					)
				);
		if(!$execution) die($statement->errorInfo()[2]);
	}

	function SelectViewFilteredByNomorBarangOrSupplier($kode){
		return $this->SelectViewFilteredByFields(array(PembelianModel::KODE_FIELD, 'namabrg', 'namasupp'), $kode);
	}
}

?>
