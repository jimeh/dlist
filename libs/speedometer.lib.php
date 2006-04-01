<?php

class speedometer {
	
/*

	Class: Speedometer v0.1.1
	Created to simplify script execution statistics...

*/
	
	var $digits = 6;
	
	var $start;
	var $time;
	
	function speedometer ($digits=false) {
		if ( !empty($digits) ) $this->digits = $digits;
		$this->start = $this->getmicrotime();
	}
	
	function end ($digits=false) {
		$end = $this->getmicrotime();
		$digits = ( preg_match("/[0-9]{1,2}/", $digits) ) ? $digits : $this->digits ;
		return $this->time = number_format( ($end - $this->start), $digits);
	}
	
	function getmicrotime () {
		list($usec, $sec) = explode(' ', microtime());
		$r = floatval($usec) + floatval($sec);
		return($r);
	}
}

?>