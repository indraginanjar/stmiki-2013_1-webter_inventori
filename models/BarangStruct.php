<?php
class BarangStruct {
	public $Kode;
	public $Barcode;
	public $Nama;
	public $Satuan;
	public $Harga;
	public $Stok; 

	function SetAll($kode, $barcode, $nama, $satuan, $harga, $stok){
		$this->Kode = $kode;
		$this->Barcode = $barcode;
		$this->Nama = $nama;
		$this->Satuan = $satuan;
		$this->Harga = $harga;
		$this->Stok = $stok;
	}

	function SetValueByPageParam($method = POST){
		$this->Kode = PageParam::GetValue('kode', $method, NULL);
		$this->Barcode = PageParam::GetValue('barcode', $method, NULL);
		$this->Nama = PageParam::GetValue('nama', $method, NULL);
		$this->Satuan = PageParam::GetValue('satuan', $method, NULL);
		$this->Harga = PageParam::GetValue('harga', $method, NULL);
		$this->Stok = PageParam::GetValue('stok', $method, NULL);
	}
}?>
