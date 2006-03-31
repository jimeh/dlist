<?php

class dirList {

/*

	Class: dirList v2.0.2 beta
	
	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

*/
	
	// General settings
	var $default_sort = 'name,mtime,size';
	var $folders_first = true;
	var $show_hidden = false;
	
	// Sorting
	var $sort_items = true;
	var $reverse = false;

	// Smart date formatting
	var $use_smartdate = true;
	var $smartdate = '{date}, {time}';
	var $smartdate_date = 'F d, Y';
	var $smartdate_time = 'H:i';
	var $standard_date_format = 'F d, Y, H:i';
	
	
	// Internals
	var $error = false;
	var $parent;
	var $list = array();
	var $sort_by = array();
	
	var $stats_count = 0;
	var $stats_files = 0;
	var $stats_folders = 0;
	var $stats_totalsize = 0;
	
	// Construtor - does nothing, but is here just
	// incase it might do something in the future...
	function dirlist() {
		
	}
	
// ==============================================
// ----- [ Main Functions ] ---------------------
// ==============================================
	
	function read ($dir) {
		if(!preg_match("/\/$/", $dir)) $dir .= '/';
		$this->sort_by = explode(',', $this->default_sort);
		if($dh = @opendir($dir)) {
			$this->parent = $this->getDetails($dir);
			while(false !== ($item = readdir($dh))) {
				$hidden_item = ( $this->show_hidden ) ? false : preg_match("/^\./", $item) ;
				if( ($item != '.' && $item != '..') && !$hidden_item ) {
					$item_details  = $this->getDetails($dir.$item);
					// stats
					$this->stats_count++;
					if ( $item_details['type'] == 'file' ) {
						$this->stats_totalsize += $item_details['size_raw'];
						$this->stats_files++;
					} else {
						$this->stats_folders++;
					}
					// sorting
					if ( $this->sort_items ) {
						$list_key = ( $this->folders_first ) ? $item_details['type'].'|' : '' ;
						foreach( $this->sort_by as $v ) {
							if ( $v == 'size' ) $v = 'size_raw';
							if ( $v == 'mtime' ) $v = 'mtime_raw';
							$list_key .= ( $v == 'size_raw' || $v == 'mtime' ) ? str_pad($item_details[$v], 28, '0', STR_PAD_LEFT).'|' : $item_details[$v].'|' ;
						}
						$this->list[strtolower($list_key)] = $item_details;
					} else {
						$this->list[] = $item_details;
					}
				}
			}
			if ( $this->sort_items ) {
				( $this->reverse ) ? krsort($this->list) : ksort($this->list) ;
			}
			return true;
		}else{ $this->error = true; return false; }
		closedir($dh);
	}
	
	
	
// ==============================================
//	----- [ Internal Functions ] -----------------
// ==============================================

	function getDetails ($item) {
		$item = str_replace("\\", '/', $item);
		$return['name'] = basename($item);

	// Owner and Group
		if ( ($group = $this->getGroup($item)) != false ) $return = array_merge($return, $group);
		if ( ($owner = $this->getOwner($item)) != false ) $return = array_merge($return, $owner);

	// Last Modified
		$return['mtime_raw'] = filemtime($item);
		if ( $this->use_smartdate ) {
			$return['mtime'] = $this->smartDate($return['mtime_raw'], $this->smartdate_date, $this->smartdate_time, $this->smartdate);
		} else {
			$return['mtime'] = date($this->standard_date_format, $return['mtime_raw']);
		}
	
	// Permissions and CHMOD value
		$return['perms'] = $this->format_perms(fileperms($item));
		$return['chmod'] = substr(sprintf('%o', fileperms($item)), -4);
	
		$return['type_raw'] = filetype($item);
		
		$return['ext'] = ( preg_match("/^.*\.(.*)/", $return['name'], $ext) ) ? $ext[1] : '' ;
		
		if ( is_file($item) ) {
			$return['type'] = 'file';
			$return['size_raw'] = filesize($item);
			$return['size'] = $this->format_filesize($return['size_raw']);
		} elseif ( is_dir($item) ) {
			$return['type'] = 'dir';
			$return['size_raw'] = '';
			$return['size'] = '-';
		}
		return $return;
	}

	function getOwner ($item) {
		if ( function_exists('posix_getpwuid') ) {
			$id = fileowner($item);
			$name = posix_getpwuid($id);
			return array('ownerid'=>$id, 'owner'=>$name['name']);
		} else { return false; }
	}

	function getGroup ($item) {
		if ( function_exists('posix_getgrgid') ) {
			$id = filegroup($item);
			$name = posix_getgrgid($id);
			return array('groupid'=>$id, 'group'=>$name['name']);
		} else { return false; }
	}

	function format_filesize($bytes) {
		$types = array('bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		for($n = 0; $bytes >= 1024; $n++) $bytes = $bytes / 1024;
		$bytes = number_format($bytes, 2);
		if ( !empty($bytes[1]) ) {
			$bytes = explode('.', $bytes);
			$bytes[1] = rtrim($bytes[1], '0');
			$bytes = ( $bytes[1] != '' ) ? $bytes[0].'.'.$bytes[1] : $bytes[0] ;
		}
		return $bytes.' '.$types[$n];
	}

	function smartDate ($timestamp, $datef='jS M, Y', $timef='H:i', $mainf='{date}, {time}') {
		$array = array('Today'=>0, 'Yesterday'=>-1, '2 days ago'=>-2, '3 days ago'=>-3, 'Tomorrow'=>1);
		$now = time();
		// check if timestamp is more than 96 hours ago
		if ( $timestamp >= ($now - 345600) ) {
			$check = date("d:m:Y", $timestamp);
			foreach ( $array as $key => $value ) {
				$test = date("d:m:Y", ($now + (86400 * $value) ) );
				if( $check == $test ) {
					$return = str_replace('{date}', $key, $mainf);
					return str_replace('{time}', date($timef, $timestamp), $return);
				}
			}
		}
		$return = str_replace('{date}', date($datef, $timestamp), $mainf);
		return str_replace('{time}', date($timef, $timestamp), $return);
	}

	function format_perms($perms) {
		if (($perms & 0xC000) == 0xC000) { $info = 's';
		} elseif (($perms & 0xA000) == 0xA000) { $info = 'l';
		} elseif (($perms & 0x8000) == 0x8000) { $info = '-';
		} elseif (($perms & 0x6000) == 0x6000) { $info = 'b';
		} elseif (($perms & 0x4000) == 0x4000) { $info = 'd';
		} elseif (($perms & 0x2000) == 0x2000) { $info = 'c';
		} elseif (($perms & 0x1000) == 0x1000) { $info = 'p';
		} else { $info = 'u'; }
		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));
		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));
		// World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));
		return $info;
	}

}

?>