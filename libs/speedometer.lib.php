<?php

class speedometer {
	
/*

	Class: Speedometer v0.2
	Created to simplify script execution statistics & debugging...
	
	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

*/
	
	var $digits = 6;
	var $pattern = '%s'; // must contain %s
	
	var $start;
	var $time;
	
	function speedometer ($digits=false) {
		if ( !empty($digits) ) $this->digits = $digits;
		$this->start = $this->getmicrotime();
	}
	
	// return with pattern
	function end ($digits=false, $pattern=false) {
		$end = $this->getmicrotime();
		$digits = ( preg_match("/[0-9]{1,2}/", $digits) ) ? $digits : $this->digits ;
		$pattern = ( stristr($pattern, '%s') != false ) ? $pattern : $this->pattern ;
		$this->time = number_format( ($end - $this->start), $digits);
		return str_replace('%s', $this->time, $pattern);
	}
	
	// return time only ignoring pattern
	function term ($digits=false) {
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