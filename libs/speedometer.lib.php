<?php

class speedometer {
	
	var $digits = 6;
	
	var $start;
	var $time;
	
	function speedometer ($digits=false) {
		if ( !empty($digits) ) $this->digits = $digits;
		$this->start = $this->getmicrotime();
	}
	
	function end () {
		$end = $this->getmicrotime();
		return $this->time = number_format( ($end - $this->start), $this->digits);
	}
	
	function getmicrotime () {
		list($usec, $sec) = explode(' ', microtime());
		$r = floatval($usec) + floatval($sec);
		return($r);
	}
}

?>