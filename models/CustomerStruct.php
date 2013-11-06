<?php

class CustomerStruct {
	public $Kode;
	public $Nama;
	public $Alamat;
	public $Telp;

	function SetAll($kode, $nama, $alamat, $telp){
		$this->Kode = $kode;
		$this->Nama = $nama;
		$this->Alamat = $alamat;
		$this->Telp = $telp;
	}

	function SetValueByPageParam($method = POST){
		$this->Kode = PageParam::GetValue('kode', $method, NULL);
		$this->Nama = PageParam::GetValue('nama', $method, NULL);
		$this->Alamat = PageParam::GetValue('alamat', $method, NULL);
		$this->Telp = PageParam::GetValue('telp', $method, NULL);
	}
}

?>
