<?php

class config {
	
/*

	Class: config v0.1 beta

	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

*/
	
	
	function config ($input=false) {
		if ( !empty($input) ) $this->parse($input);
	}
	
	function parse ($input, $overwrite=true) {
		if ( is_array($input) ) {
			$this->parse_array($input, $overwrite);
		} elseif ( is_string($input) ) {
			if ( preg_match("/.php$/", $input) ) {
				$this->parse_php_file($input, 'config', $overwrite);
			} else {
				$this->parse_ini_file($input);
			}
		}
	}
	
	function parse_array ($input, $overwrite=true) {
		if ( is_array($input) ) {
			foreach( $input as $key => $value ) {
				if ( is_array($value) ) {
					foreach( $value as $k => $v ) {
						if ( ($empty = empty($this->$key)) || $overwrite ) {
							$this->$key = ( $empty ) ? array($k=>$v) : array_merge($this->$key, array($k=>$v)) ;
						}
					}
				} else {
					if ( $overwrite || empty($this->$key) ) $this->$key = $value;
				}
			}
			return true;
		} else return false;
	}
	
	function parse_php_file ($file, $var='config', $overwrite=true) {
		if ( is_readable($file) ) {
			include($file);
			$this->parse_array($$var, $overwrite);
			return true;
		} else return false;
	}
	
	function parse_ini_file ($file, $overwrite=true) {
		if ( is_readable($file) ) {
			$this->parse_array(parse_ini_file($file, true), $overwrite);
		}
	}
	
}

?>