<?php
define('POST', 'POST');
define('GET', 'GET');
define('post', 'post');
define('get', 'get');
define( 'SESSION' , 'SESSION' );

define('MYSQL_DATE_FORMAT', 'Y-m-d');
define('INDONESIAN_DATE_FORMAT', 'd/m/Y');
require_once dirname(__FILE__) . '/../Config.php';

class PageParam {

	private $_Actions;
	
	/**
	 * Mengambil nilai page parameter
	 * @param string $nama - Nama paramater yang dibaca
	 * @param string $tipe - Form method dari parameter
	 * @param $default - Nilai yang akan dihasilkan jika paramater gagal dibaca
	 * contoh:
	 * PageParam.GetValue('nama', POST, NULL);
	 */
	static function GetValue($name, $type, $default = NULL){
	    switch( $type ) {
	    case GET :
		if( isset( $_GET[ $name ] ) ) {
		    return $_GET[ $name ];
		}
		break;
	    case POST :
		if( isset( $_POST[ $name ] ) ) {
		    return $_POST[ $name ];
		}
		break;
	    case SESSION : 
		if( isset( $_SESSION[ $name ] ) ) {
		    return $_SESSION[ $name ];
		}
		break;
	    }
	    return $default;
	}

	function __construct() {
		$Config = new Config();
		$actionString = substr($_SERVER['REQUEST_URI'], strlen($Config->BaseUrl . 'index.php') - 1);
		$actionString = rtrim($actionString, '/');
		if(!empty($actionString)) {
			$this->_Actions = explode('/', $actionString);
			return;
		}
		$this->_Actions = array();
	}

	function GetAction($index){
		if($index + 1 > count($this->_Actions)){
			return NULL;
		}
		return $this->_Actions[$index];
	}

	function GetActionCount(){
		return count($this->_Actions);
	}

	function GetActionList(){
		return $this->_Actions;
	}
}?>
