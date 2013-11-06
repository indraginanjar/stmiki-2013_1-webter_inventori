<?php
require_once dirname(__FILE__) . '/../inc/InventoriDatabase.php';
require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/SingleKeyModel.php';

class BarangModel extends SingleKeyModel {
	private $_DbConnection;
	const TABLE_NAME = 'tbbarang';
	const KODE_FIELD = 'kodebrg';

	function __construct() {
		$Db = new InventoriDatabase();
		$this->_DbConnection = $Db->GetConnection();
		parent::__construct(BarangModel::TABLE_NAME, BarangModel::KODE_FIELD, $this->_DbConnection);
	}
	
	function InsertOrUpdate(BarangStruct $barang) {
		$sql = 'insert into '. BarangModel::TABLE_NAME .' ('.BarangModel::KODE_FIELD.'
	, barcode
	, namabrg
	, satuan
	, harga
	, stok
) values ( :'.BarangModel::KODE_FIELD.'
	, :barcode
	, :namabrg
	, :satuan
	, :harga
	, :stok
)
on duplicate key update '.BarangModel::KODE_FIELD.'=:'.BarangModel::KODE_FIELD.'
	, barcode=:barcode
	, namabrg=:namabrg
	, satuan=:satuan
	, harga=:harga
	, stok=:stok
';
		$statement = $this->_DbConnection->prepare($sql);

		if(!$statement) die($this->_DbConnection->errorInfo()[2]);

		$execution = $statement->execute(array(':'.BarangModel::KODE_FIELD => $barang->Kode
					, ':barcode' => $barang->Barcode
					, ':namabrg' => $barang->Nama
					, ':satuan' => $barang->Satuan
					, ':harga' => $barang->Harga
					, ':stok' =>$barang->Stok
					)
				);

		if(!$execution) die($statement->errorInfo()[2]);
	}

	function SelectFilteredByKodeBarcodeOrNama($kode){
		return $this->SelectFilteredByFields(array(BarangModel::KODE_FIELD, 'barcode', 'namabrg'), $kode);
	}
}?>
