<?php

require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/../inc/DateUtil.php';

class PembelianStruct {
	public $Nomor;
	public $KodeBarang;
	public $KodeSupplier;
	public $Tanggal;
	public $Harga;
	public $Jumlah;

	function SetAll($nomor, $kodeBarang, $kodeSupplier, $tanggal, $harga, $jumlah){
		$this->Nomor = $nomor;
		$this->KodeBarang = $kodeBarang;
		$this->KodeSupplier = $kodeSupplier;
		$this->Tanggal = $tanggal;
		$this->Harga = $harga;
		$this->Jumlah = $jumlah;
	}

	function SetValueByPageParam($method){
		$this->Nomor = PageParam::GetValue('nomor', $method, NULL);
		$this->KodeBarang = PageParam::GetValue('barang', $method, NULL);
		$this->KodeSupplier = PageParam::GetValue('supplier', $method, NULL);
		//$this->Tanggal = DateTime::createFromFormat(INDONESIAN_DATE_FORMAT, PageParam::GetValue('tanggal', $method, NULL))->format(MYSQL_DATE_FORMAT);
		$this->Tanggal = DateUtil::ChangeStringFormat(PageParam::GetValue('tanggal', $method, NULL)
				, DateUtil::IndonesiaDefaultDateFormat
				, DateUtil::MysqlDefaultDateFormat
				);
		$this->Harga = PageParam::GetValue('harga', $method, NULL);
		$this->Jumlah = PageParam::GetValue('jumlah', $method, NULL);
	}
}?>
