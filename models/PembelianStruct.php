<?php

require_once dirname(__FILE__) . '/../inc/PageParam.php';
require_once dirname(__FILE__) . '/../inc/DateUtil.php';

class PembelianStruct {
	public $Nomor;
	public $KodeBarangList;
	public $KodeSupplier;
	public $Tanggal;
	public $HargaList;
	public $JumlahList;

	function SetAll($nomor, $kodeBarangList, $kodeSupplier, $tanggal, $hargaList, $jumlahList){
		$this->Nomor = $nomor;
		$this->KodeBarangList = $kodeBarangList;
		$this->KodeSupplier = $kodeSupplier;
		$this->Tanggal = $tanggal;
		$this->HargaList = $hargaList;
		$this->JumlahList = $jumlahList;
	}

	function SetValueByPageParam($method = POST){
		$this->Nomor = PageParam::GetValue('Nomor', $method);
		$this->Tanggal = DateUtil::ChangeStringFormat(PageParam::GetValue('Tanggal', $method, NULL)
				, DateUtil::IndonesiaDefaultDateFormat
				, DateUtil::MysqlDefaultDateFormat
				);
		$this->KodeBarangList = PageParam::GetValue('BarangList', $method, Array());
		$this->KodeSupplier = PageParam::GetValue('Supplier', $method);
		$this->HargaList = PageParam::GetValue('HargaList', $method, Array());
		$this->JumlahList = PageParam::GetValue('JumlahList', $method, Array());
	}
	
	function GetItemCount(){
		return count($this->KodeBarangList);
	}	
}?>
