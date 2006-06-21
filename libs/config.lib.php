<?php

class config {
	
/*

	Class: config v0.2 beta

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
	
	
	function config ($input=false) {
		if ( !empty($input) ) $this->parse($input);
	}
	
// Main function
	function parse ($input, $overwrite=true, $pad=false) {
		if ( !empty($pad) ) $this->_config_pad = $pad;
		if ( is_array($input) ) {
			$this->parse_array($input, $overwrite);
		} elseif ( is_string($input) ) {
			if ( preg_match("/.*\.php$/", $input) ) {
				$this->parse_php_file($input, 'config', $overwrite);
			} else {
				$this->parse_ini_file($input);
			}
		}
		unset($this->_config_pad);
	}
	
// Parse settings from an array
	function parse_array ($input, $overwrite=true) {
		$pad = '';
		if ( is_array($input) ) {
			foreach( $input as $key => $value ) {
				if ( is_array($value) ) {
					if ( !empty($this->_config_pad) ) $key = $this->_config_pad.$key;
					foreach( $value as $k => $v ) {
						if ( ($empty = empty($this->$key)) || $overwrite ) {
							$this->$key = ( $empty ) ? array($k=>$v) : array_merge($this->$key, array($k=>$v)) ;
						}
					}
				} else {	
					if ( !empty($this->_config_pad) ) $key = $this->_config_pad.$key;
					if ( $overwrite || empty($this->$key) ) $this->$key = $value;
				}
			}
			return true;
		} else return false;
	}

// Parse settings from a defined array inside a php file,
// $var is the name of the variable inside the php to parse.
	function parse_php_file ($file, $var='config', $overwrite=true) {
		if ( is_readable($file) ) {
			include($file);
			$this->parse_array($$var, $overwrite);
			return true;
		} else return false;
	}
	
// Parse settings from an ini file.
	function parse_ini_file ($file, $overwrite=true, $parse_sections=true) {
		if ( is_readable($file) ) {
			$this->parse_array(parse_ini_file($file, $parse_sections), $overwrite);
		}
	}
	
}

?>