<?php

class execHandler {
	
/*
	
	Class: execHandler v0.7 beta
	
	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

*/

// ==============================================
// ----- [ Configuration ] ----------------------
// ==============================================


// Caching

	var $cache_dir        = 'cache';
	var $cache_name       = 'default';
	var $cache_data       = '.data.cache.php';
	var $cache_details    = '.details.cache.php';
	var $cache_time       = '.time.cache.php';
	var $update_frequency = 0;
	var $php_opentag      = "<?php\n";
	var $php_closetag     = "\n?>";
	
	
// Execution Stage Priority

	var $default_stages = array(
		'init'    => 10,
		'main'    => 50,
		'render'  => 80,
		'term'    => 90,
	);


// Debug?

	var $debug = false;

	
// Misc. Settings
	
	var $default_priority   = 40;
	var $php_extension      = 'php';
	var $exec_extension     = 'exc';
	var $default_stage_code = 'main';
	var $escape_chars       = '/\[]{}().^$*';
	
	
// Syntax Configuration

	var $file_start = '//_HEAD;';
	var $code_delim = '//_SCRIPT;';
	var $file_end   = '//_END;';

	var $delim         = '//>';
	var $stage_delim   = 'STAGE>';
	var $section_delim = 'Section>';
	var $insert_before = 'Before>';
	var $insert_after  = 'After>';
	var $replace_delim = 'Replace>';
	
	var $priority_delim       = ':';
	var $config_comment_chars = '#|;|//';
	var $include_seperator    = ',';
	
	
// Error Messages

	var $error_cache_dir        = 'ERROR: ExecHandler could not write to cache directory.';
	var $error_read_cache_files = 'ERROR: ExecHandler count not read the specified cache files.';
	var $error_cache_update     = 'ERROR: ExecHandler cound not update cache file.';
	
	
// Data Storage Setup
	
	var $code = array();
	var $execution_order = array();
	var $files = array();
	var $order_id = array();
	var $files_to_load = array();
	var $compiled_code = false;
	var $include_file  = false;
	var $stages = array();
	
	
// Construct Function
	
	function execHandler($cache_name=false) {
		if ( !empty($cache_name) ) $this->cache_name = $cache_name;
		$this->stages = $this->default_stages;
	}
	
	
// ==============================================
// ----- [ Public Functions ] -------------------
// ==============================================
/*
	These functions are intended for use within your
	script. The other functions are internal and only
	used by execHandler itself.
*/
	
	function cache ($force=false) {
		if ( $force || $this->debug || !$this->check_cache() ) {
			echo "reloading\n";
			$this->loadFile($this->files_to_load);
			$this->compile();
			$this->save_cache();
		}
	}
	
	function addPath ($input) {
		$result = array();
		if ( is_array($input) ) {
			foreach( $input as $key => $value ) $result = array_merge($result, glob($value));
		} elseif( is_string($input) ) {
			$result = glob($input);
		}
		$result = array_filter($result);
		if ( is_array($result) ) $result = array_unique($result);
		$this->files_to_load = array_merge($this->files_to_load, $result);
	}
	
	function loadFile ($input) {
		if ( is_array($input) ) {
			foreach( $input as $file ) {
				$result = $this->load_file($file);
				if ( $result == false ) return false;
			}
		} elseif ( is_string($input) ) {
			return $this->load_file($input);
		}
	}

	function compile () {
		$this->compiled_code = '';
		$this->sort_stage_list();
		foreach( $this->stages as $stage => $stage_priority ) {
			if( $this->debug ) {
				$this->compiled_code
					.= "\n\n//==========================\n// Stage: ".$stage.":".$stage_priority."\n//==========================\n";
				$new_stage = true;
			}
			foreach( $this->execution_order[$stage] as $key => $code ) {
				if( $this->debug ) {
					$pr = explode('|', $key, 2);
					$pr = $pr[0];
					$this->compiled_code
							.= ( $new_stage ) ? "\n// Code Piece: ".$code.":".$pr."\n" : "\n\n// Code Piece: ".$code.":".$pr."\n" ;
					//$this->compiled_code .= "\n// Code Piece: ".$code."\n";
					$this->compiled_code .= $this->clean_up_code($this->code[$stage][$code]);
					$new_stage = false;
				} else {
					$this->compiled_code .= $this->code[$stage][$code];
				}
			}
		}
	}

	
// ==============================================
// ----- [ Core Functions ] ---------------------
// ==============================================
/*
	The engine that drives this thing, without these
	functions execHandler would not work. It wouldn't
	work without any of the other funtions either,
	but you get the point :P
*/

	function load_file ($file, $included=false) {
		if ( !isset($this->files[$file]) ) {
			$content = $this->rfile($file);
			if ( $content != false ) {
				$content = $this->parse($content, $file);
				$content['md5'] = md5_file($file);
				$content['file'] = $file;
				if ( $included ) $content['included'] = true;
				$this->files[$file] = $content;
				return true;
			}else return false;
		} 
	}

	function sort_stage_list () {
		$stages = array_flip($this->stages);
		ksort($stages, SORT_NUMERIC);
		$this->stages = array_flip($stages);
		foreach( $this->execution_order as $key => $value ) {
			if ( is_array($this->execution_order[$key]) ) ksort($this->execution_order[$key]);
		}
	}

	function parse ($string, $file) {
	// Filter Out Main Content
		$file_start = $this->addslashes($this->file_start);
		$code_delim = $this->addslashes($this->code_delim);
		$file_end = $this->addslashes($this->file_end);
		preg_match("/^".$file_start."$(.*)^".$code_delim."$(.*)^".$file_end."$/ims", $string, $code);

	// Read Settings
		$settings = $this->read_file_settings($code[1], $file);
		
	// Parse Main Code
		$code = explode($this->delim.$this->stage_delim, $code[2]);
		array_shift($code);
		
	// Stage Loop
		$n = '001';
		foreach ( $code as $value ) {
			preg_match("/^(.*?)$(?s)(.*)/im", $value, $stage_code);
			if ( preg_match("/(.*)".$this->priority_delim."([0-9]{1,2})/i", trim($stage_code[1]), $stage) ) {
				$stage_priority = $stage[2];
				$stage = $stage[1];
			} else {
				$stage = trim($stage_code[1]);
			}
			$stage_code = explode($this->delim, trim($stage_code[2]));
			
			// handle code at root of stage (not within a section)
			if ( empty($this->stages[$stage]) || (!empty($stage_priority) && $this->stages[$stage] != $stage_priority) ) {
				$this->stages[$stage] = ( !empty($stage_priority) ) ? $stage_priority : $this->default_priority ;
			}
			$stage_code[0] = $this->clean_up_code($stage_code[0]);
			if ( !empty($stage_code[0]) ) {
				$this->code[$stage][$settings['name'].'.'.$this->default_stage_code] = "\n".$stage_code[0];
				$this->execution_order[$stage][$this->default_priority.'|'.$settings['name'].':'.$n.':'.$this->default_stage_code.'__main']
						= $settings['name'].'.'.$this->default_stage_code;
				$this->order_id[$stage][$settings['name'].'.'.$this->default_stage_code]
						= $this->default_priority.'|'.$settings['name'].':'.$n.':'.'.'.$this->default_stage_code.'__main';
				$n = str_pad($n+1, 3, '0', STR_PAD_LEFT);
			}
			array_shift($stage_code);
			
		// Section Loop
			foreach( $stage_code as $value ) {
				preg_match("/^(.*?)$(?s)(.*)/im", $value, $section_code);
				if ( preg_match("/^(.*?)\s+(.*)/", trim($section_code[1]), $handler) ) {
					$section = $handler[2];
					$handler = $handler[1];
				} else {
					$section = trim($section_code[1]);
					$handler = '';
				}
				if ( preg_match("/(.*)".$this->priority_delim."(.*)/", $section, $priority) ) {
					$section = $priority[1];
					$priority = $priority[2];
				} else { $priority = $this->default_priority; }
				
				$section_code = $this->clean_up_code($section_code[2]);
				
				if ( !empty($section_code) ) {
					
					// replace
					if ( $handler == $this->replace_delim ) {
						$this->code[$stage][$section] = "\n".$section_code;
					}
					// insert before & after
					elseif ( $handler == $this->insert_before || $handler == $this->insert_after ) {
						$placement = ( $handler == $this->insert_before ) ? '___before' : '_zafter' ;
						$this->code[$stage][$settings['name'].'.'.$section] = "\n".$section_code;
						$this->execution_order[$stage][$this->order_id[$stage][$section].$placement.'|'.$priority.'|'.$settings['name'].':'.$n]
								= $settings['name'].'.'.$section;
					}
					// section
					elseif ( $handler == $this->section_delim || $handler == '' ) {
						$this->code[$stage][$settings['name'].'.'.$section] = "\n".$section_code;
						$this->execution_order[$stage][$priority.'|'.$settings['name'].':'.$n.':'.$section.'__main']
								= $settings['name'].'.'.$section;
						$this->order_id[$stage][$settings['name'].'.'.$section] = $priority.'|'.$settings['name'].':'.$n.':'.$section;
					}
				}
				$n = str_pad($n+1, 3, '0', STR_PAD_LEFT);
			}
			// END: Section Loop
			
		}
		// END: Stage Loop

		// include files
		if ( !empty($settings['include']) ) $this->include_files($settings['include'], dirname($file));
		
		return $settings;
	}
	

// Cache Functions

	function check_cache () {
		if(!preg_match("/\/$/", $this->cache_dir)) $this->cache_dir .= '/';
		
		$time_file = $this->cache_dir.$this->cache_name.$this->cache_time;
		$details_file = $this->cache_dir.$this->cache_name.$this->cache_details;
		$data_file = $this->cache_dir.$this->cache_name.$this->cache_data;
		
		if ( is_readable($time_file) && is_readable($details_file) && is_readable($data_file) ) {
			$time = $this->rfile($time_file);
			if ( time() > ($time + ($this->update_frequency * 60)) ) {
				$read_details = file($details_file);
				foreach( $read_details as $key => $value ) {
					$value = explode('=', trim($value));
					$details[$value[0]] = $value[1];
					if ( !isset($value[2]) ) $file_list[] = $value[0];
				}
				if ( $this->array_compare($this->files_to_load, $file_list) ) {
					if ( !$this->validate_files($details) ) return false;
				} else return false;
				if ( !$this->write2file($time_file, time()) ) {
					die($this->error_cache_update.' ('.$details_file.')');
				}
			}
		} else return false;
		
		$this->include_file = $data_file;
		return true;
	}

	function save_cache ($force_compile=false) {
		if(!preg_match("/\/$/", $this->cache_dir)) $this->cache_dir .= '/';
		if ( is_writeable($this->cache_dir) ) {
			$cache_details = '';
			foreach( $this->files as $key => $value ) {
				$cache_details .= $value['file'].'='.$value['md5'];
				if ( isset($value['included']) ) $cache_details .= '=included';
				$cache_details .= "\n";
			}
			
			if ( !empty($this->compiled_code) || $force_compile ) $this->compile();
			
			$time_write = $this->write2file($this->cache_dir.$this->cache_name.$this->cache_time, time());
			$details_write = $this->write2file($this->cache_dir.$this->cache_name.$this->cache_details, $cache_details);
			$data_write
					= $this->write2file($this->cache_dir.$this->cache_name.$this->cache_data, $this->php_opentag.$this->compiled_code.$this->php_closetag);
			if ( $time_write && $details_write && $data_write ) {
				$this->include_file = $this->cache_dir.$this->cache_name.$this->cache_data;
				return(true); 
			} else die($this->error_cache_dir);
		} else die($this->error_cache_dir);
	}
	
	
// ==============================================
// ----- [ Internal Functions ] -----------------
// ==============================================
/*
	I do believe its pretty obvious what these
	functions do. At least what they are for, their
	exact role within execHandler can seem weird
	or useless by soley looking at the functions :P
*/
	
// Filesystem

	function rfile ($file){
		if (!isset($file)) return false;
		if (is_file($file)) {
			if (!($fh = fopen($file,'r'))) return false;
			$file_data = fread($fh, filesize($file));
			fclose($fh);
		} else { return false; }
		return $file_data;
	}
	
	function write2file($file, $string, $mode="wb", $lock=2){
		if ( !isset($file) ) return false;
		$fp = fopen($file, $mode);
		if ($fp != false) {
			flock($fp,$lock);
			$re = fwrite($fp,$string);
			$re2 = fclose($fp);
			if ($re != false && $re2 != false) return true;
		}
		return false;
	}


// Parsing
	
	function addslashes ($string) {
		return addcslashes($string, $this->escape_chars);
	}

	function get_script_name ($file) {
		$filename = explode('.', basename($file));
		while ( $filename[count($filename)-1] == $this->php_extension || $filename[count($filename)-1] == $this->exec_extension ) {
			array_pop($filename);
		}
		return implode('.', $filename);
	}
	
	function read_file_settings ($input, $file) {
		preg_match_all("/^(.*?):(.*)$/Um", $input, $array);
		while( list($k,$v) = each($array[1]) ) {
			if(!preg_match("/^(".$this->addslashes($this->config_comment_chars).")/", $v)) $return[strtolower($v)] = trim($array[2][$k]);
		}
		if ( empty($return['name']) ) $return['name'] = $this->get_script_name($file);
		return $return;
	}

	function include_files ($input, $dirname='.') {
		$include_files = explode($this->include_seperator, $input);
		foreach( $include_files as $key => $value ) {
			if ( $dirname == '.' && is_readable($value) ) {
				$this->load_file($value, true);
			} elseif ( is_readable($dirname.'/'.$value) ) {
				$this->load_file($dirname.'/'.$value, true);
			}
		}
	}


// Compiling

	function clean_up_code ($string, $comments=true, $emptylines=true) {
		if ( $comments ) $string = $this->remove_comments($string);
		if ( $emptylines ) $string = $this->remove_empty_lines($string);
		return trim($string);
	}
	
	function remove_comments ($string) {
		$string = preg_replace("/\/\*.*?\*\//ms", '', $string);
		$string = preg_replace("/^(\/\/|#).*$/m", '', $string);
		return $string;
	}
	
	function remove_empty_lines ($string) {
		$string = str_replace("\r", "\n", $string);
		$string = preg_replace("/\n+/m", "\n", $string);
		return $string;
	}


// Cache
	
	function validate_files ($input) {
		if ( is_array($input) ) {
			foreach( $input as $key => $value ) {
				if ( $value != md5_file($key) ) return false;
			}
		}
		return true;
	}
	
	function array_compare ($array1, $array2, $mode='value') {
		if ( $mode == 'value' ) {
			$array1 = array_values($array1);
			$array2 = array_values($array2);
		} elseif ( $mode == 'key' ) {
			$array1 = array_flip($array1);
			$array2 = array_flip($array2);
		}
		sort($array1);
		sort($array2);
		if ( implode('', $array1) != implode('', $array2) ) return false;
		return true;
	}


}

?>