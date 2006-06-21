<?php

class speedometer {
	
/*

	Class: Speedometer v0.2
	Created to simplify script execution statistics & debugging...
	
	Copyright © 2006 Jim Myhrberg.
	zynode@gmail.com
	
	----------
	This program is free software; you can redistributeit and/or modify it
	under the terms of the GNU General Public License as published by the Free
	Software Foundation; either version 2 of the License, or (at your option)
	any later version.

	This program is distributed in the hope that it will be useful, but WITHOUT
	ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
	FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
	more details.

	You should have received a copy of the GNU General Public License along
	with this program; if not, write to the Free Software Foundation, Inc., 59
	Temple Place, Suite 330, Boston, MA 02111-1307 USA
	----------

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