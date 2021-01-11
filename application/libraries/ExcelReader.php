<?php 

class ExcelReader {
	private $CI;

	public function __construct() {
		$this->CI =& get_instance();
	}

	function readExcel($file) {
		
		require_once(APPPATH."libraries/simplexlsx/src/SimpleXLSX.php");
		if ($xlsx=SimpleXLSX::parse($file) ) {
			return $xlsx->rows();
		} else {
			echo SimpleXLSX::parseError();
			die();
		}
	}
}

?>