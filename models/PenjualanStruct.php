<?php

require_once dirname(__FILE__) . '/../inc/PageParam.php';

class PenjualanStruct {
	public $Nomor;
	public $KodeBarang;
	public $KodeCustomer;
	public $Tanggal;
	public $Harga;
	public $Jumlah;

	function SetAll($nomor, $kodeBarang, $kodeCustomer, $tanggal, $harga, $jumlah){
		$this->Nomor = $nomor;
		$this->KodeBarang = $kodeBarang;
		$this->KodeCustomer = $kodeCustomer;
		$this->Tanggal = $tanggal;
		$this->Harga = $harga;
		$this->Jumlah = $jumlah;
	}

	function SetValueByPageParam($method){
		$this->Nomor = PageParam::GetValue('nomor', $method, NULL);
		$this->KodeBarang = PageParam::GetValue('barang', $method, NULL);
		$this->KodeCustomer = PageParam::GetValue('customer', $method, NULL);
		$this->Tanggal = DateTime::createFromFormat(INDONESIAN_DATE_FORMAT, PageParam::GetValue('tanggal', $method, NULL))->format(MYSQL_DATE_FORMAT);
		$this->Harga = PageParam::GetValue('harga', $method, NULL);
		$this->Jumlah = PageParam::GetValue('jumlah', $method, NULL);
	}
}
?>
