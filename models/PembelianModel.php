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
		$Row = $this->_DbConnection->query('select max(nofaktur) as nofaktur from '. PembelianModel::TABLE_NAME);
		if(!$Row) {
			return false;
		}
		$pembelian->Nomor = $Row->fetchObject()->nofaktur + 1;
		$Sql = 'insert into '. PembelianModel::TABLE_NAME .' ('.PembelianModel::KODE_FIELD.'
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
		$this->_DbConnection->beginTransaction();
		$Statement = $this->_DbConnection->prepare($Sql);
		assert($Statement, $this->_DbConnection->errorInfo()[2]);
		if($this->_DbConnection->errorCode() != '00000'){
			return false;
		}
		$this->_DbConnection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_DbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$Count = $pembelian->GetItemCount();
		for($i = 0; $i < $Count; $i++){
			$Parameter = array(':'.PembelianModel::KODE_FIELD => $pembelian->Nomor
						, ':kodebrg' => $pembelian->KodeBarangList[$i]
						, ':kodesupp' => $pembelian->KodeSupplier
						, ':tanggal' => $pembelian->Tanggal
						, ':harga' => $pembelian->HargaList[$i]
						, ':jumlah' => $pembelian->JumlahList[$i]
						);

			$Execution = $Statement->execute($Parameter);

			assert($Execution, $Statement->errorInfo()[2]);
			if($Statement->errorCode() != '00000'){
				return false;
			}
		}
		$this->_DbConnection->commit();
		return $pembelian->Nomor;
	}

	function SelectViewFilteredByNomorBarangOrSupplier($kode){
		return $this->SelectViewFilteredByFields(array(PembelianModel::KODE_FIELD, 'namabrg', 'namasupp'), $kode);
	}

	function SelectAll(){
		$Sql = 'select nofaktur
	, tanggal
	, tbbeli.kodesupp
	, namasupp
	, sum(harga * jumlah) as nilai
from '. PembelianModel::TABLE_NAME .'
left join tbsuplier
	on tbsuplier.kodesupp = tbbeli.kodesupp
group by nofaktur
	, kodesupp
	, tanggal
';
		return $this->_DbConnection->query($Sql);
	}

	function SelectByNoFaktur($noFaktur){
		$Sql = 'select nofaktur
	, tanggal
	, tbbeli.kodesupp
	, namasupp
	, sum(harga * jumlah) as nilai
from '. PembelianModel::TABLE_NAME .'
left join tbsuplier
	on tbsuplier.kodesupp = tbbeli.kodesupp
where nofaktur = :nofaktur
group by nofaktur
	, kodesupp
	, tanggal
';
		$Parameter = array(':nofaktur' => $noFaktur);
		$Statement = $this->_DbConnection->prepare($Sql);
		$Execution = $Statement->execute($Parameter);
		assert($Execution, $Statement->errorInfo()[2]);
		if($Statement->errorCode() != '00000'){
			return false;
		}
		if($Statement->rowCount() < 1) {
			assert(false, str_replace(array_keys($Parameter), array_values($Parameter), $Sql));
			return false;
		}
		return $Statement;
	}
}

?>
