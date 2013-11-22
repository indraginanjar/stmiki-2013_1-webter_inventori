<?php
class Config {
	// Jangan masukkan ikut sertakan nama/domain host/server kedalam $BaseUrl
	public $BaseUrl = '/kuliah/2013-1%20Web%20Terapan/20131020/www/';
	public $DbHost = '127.0.0.1';
	public $DbUser = 'root';
	public $DbPassword = 'root';
	public $DbName = 'webter_inventori';
	// Hanya set $Assert ke TRUE saat debugging program, nilai yang disarankan FALSE
	// Jika di nilainya DEFAULT, aplikasi akan mengikuti settingan dari server
	public $Assert = TRUE;
}?>
