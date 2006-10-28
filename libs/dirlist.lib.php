<?php

class dirList {

/*

	Class: dirList v2.1.2 beta
	
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
	
	
	// General settings
	var $sort_by = 'name';
	var $folders_first = true;
	var $show_hidden = false;
	
	
	// Filtering
	
	# use regular expressions to match file & folders to hide
	# intended for dynamic changes from config files and more
	var $filter_out = '';
	
	# use regular expressions to match file & folders to show
	# regardless of other filtering patterns
	var $filter_show = '';
	
	# used by filtering to match whole directory structures
	# but needs to be set manually for now.
	var $dir_url = '';
	
	# regular expressions used to hide the script itself,
	# same as filter_out, but not intended to be modifed by
	# plugins and other means.
	var $hide_self = false;
	

	// Sorting
	var $sort_items = true;
	var $reverse = false;
	var $sort_order = array();


	// Smart date formatting
	var $use_smartdate = true;
	var $standard_date_format = '%B %e, %Y, %H:%M';
	var $smartdate = '{date}, {time}';
	var $smartdate_date = '%B %e, %Y';
	var $smartdate_time = '%H:%M';
	

	// Smart date language settings
	var $lang_tomorrow   = 'Tomorrow';
	var $lang_today      = 'Today';
	var $lang_yesterday  = 'Yesterday';
	var $lang_2_days_ago = '2 days ago';
	var $lang_3_days_ago = '3 days ago';
	
	
	// Internals
	var $error = false;
	var $parent;
	var $list = array();
	
	var $stats_count = 0;
	var $stats_files = 0;
	var $stats_folders = 0;
	var $stats_totalsize_raw = 0;
	var $stats_totalsize;
	
	// Construtor
	function dirlist() {
		// sorting orders
		$this->sort_order = array(
			'name'    => 'name,mtime,size',
			'size'    => 'size,name,mtime',
			'mtime'   => 'mtime,name,size',
			'atime'   => 'atime,name,size',
			'type'    => 'type,name,size,mtime',
			'ext'     => 'ext,name,size,mtime',
			'group'   => 'group,name,size,mtime',
			'owner'   => 'owner,name,size,mtime',
			'chmod'   => 'chmod,name,size,mtime',
			'perms'   => 'chmod,name,size,mtime',
			'groupid' => 'groupid,name,size,mtime',
			'ownerid' => 'ownerid,name,size,mtime',
		);
		
	}
	
// ==============================================
// ----- [ Main Functions ] ---------------------
// ==============================================
	
	function read ($dir) {
		if(!preg_match("/\/$/", $dir)) $dir .= '/';
		$sort_by = ( !empty($this->sort_order[$this->sort_by]) ) ? $this->sort_order[$this->sort_by] : $this->sort_order['name'] ;
		$sort_by = explode(',', $sort_by);
		if($dh = @opendir($dir)) {
			$this->parent = $this->getDetails($dir);
			while(false !== ($item = readdir($dh))) {
				if( $this->show_item($item, $dir) ) {
					$item_details  = $this->getDetails($dir.$item);
					// stats
					$this->stats_count++;
					if ( $item_details['type'] == 'file' ) {
						$this->stats_totalsize_raw += $item_details['size_raw'];
						$this->stats_files++;
					} else {
						$this->stats_folders++;
					}
					// sorting
					if ( $this->sort_items ) {
						$list_key = ( $this->folders_first ) ? $item_details['type'].'|' : '' ;
						foreach( $sort_by as $v ) {
							if ( $v == 'size' ) $v = 'size_raw';
							if ( $v == 'mtime' ) $v = 'mtime_raw';
							if ( $v == 'atime' ) $v = 'atime_raw';
							if ( $v == 'name' ) {
								$list_key .= $this->process_filename_for_sorting($item_details[$v]).'|';
							} elseif ( $v == 'size_raw' || $v == 'mtime' || $v == 'atime' ) {
								$list_key .= str_pad($item_details[$v], 28, '0', STR_PAD_LEFT).'|';
							} else {
								$list_key .= $item_details[$v].'|';
							}
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
			$this->stats_totalsize = $this->format_filesize($this->stats_totalsize_raw);
			closedir($dh);
			return true;
		}else{ $this->error = true; return false; }
	}
	
	
// ==============================================
//	----- [ Internal Functions ] -----------------
// ==============================================

	function show_item ($item, $dir='') {
		if ( !is_readable($dir.$item) ) return false;
		$hidden_item = ( $this->show_hidden ) ? false : preg_match("/^\./", $item) ;
		$filter_out = ( empty($this->filter_out) ) ? false : preg_match($this->filter_out, $this->dir_url.$item) ;
		$filter_show = ( empty($this->filter_show) ) ? false : !preg_match($this->filter_show, $this->dir_url.$item) ;
		$hide_self = ( empty($this->hide_self) ) ? false : preg_match($this->hide_self, $this->dir_url.$item) ;
		if ( $item != '.' && $item != '..' && !$hidden_item && !$filter_out && !$filter_show && !$hide_self ) return true;
		return false;
	}

	function process_filename_for_sorting ($input) {
		if ( preg_match_all("/(.*?)([0-9]+)/i", $input, $preg) ) {
			$foot = preg_replace("/^.*[0-9]+(\D*?)$/", "$1", $input);
			$newstring = '';
			foreach( $preg[1] as $key => $value ) {
				$newstring .= $value.str_pad($preg[2][$key], 6, '0', STR_PAD_LEFT);
			}
			return $newstring.$foot;
		}
		return $input;
	}

	function getDetails ($item) {
		$item = str_replace("\\", '/', $item);
		$return['name'] = basename($item);
		$return['name'] = preg_replace('/.*(?:\/|\\\\)(.*?)$/i', "$1", $item);

	// Owner and Group
		if ( ($group = $this->getGroup($item)) != false ) $return = array_merge($return, $group);
		if ( ($owner = $this->getOwner($item)) != false ) $return = array_merge($return, $owner);

	// Last Modified
		$return['mtime_raw'] = filemtime($item);
		$return['atime_raw'] = fileatime($item);
		if ( $this->use_smartdate ) {
			$return['mtime'] = $this->smartDate($return['mtime_raw'], $this->smartdate_date, $this->smartdate_time, $this->smartdate);
			$return['atime'] = $this->smartDate($return['atime_raw'], $this->smartdate_date, $this->smartdate_time, $this->smartdate);
		} else {
			$return['mtime'] = date($this->standard_date_format, $return['mtime_raw']);
			$return['atime'] = date($this->standard_date_format, $return['atime_raw']);
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
		if ( preg_match("/^([0-9]+)(\.|,)([0-9]+0)$/", $bytes, $split) ) {
			$bytes = ( ($split[3] = rtrim($split[3], '0')) == '' ) ? $split[1] : $split[1].$split[2].$split[3] ;
		}
		return $bytes.' '.$types[$n];
	}

	function smartDate ($timestamp, $datef='%B %d, %Y', $timef='%H:%M', $mainf='{date}, {time}') {
		$array = array(
			$this->lang_tomorrow   => 1,
			$this->lang_today      => 0,
			$this->lang_yesterday  => -1,
			$this->lang_2_days_ago => -2,
			$this->lang_3_days_ago => -3,
		);
		$now = time();
		// check if timestamp is more than 96 hours ago
		if ( $timestamp >= ($now - 345600) ) {
			$check = date("d:m:Y", $timestamp);
			foreach ( $array as $key => $value ) {
				$test = date("d:m:Y", ($now + (86400 * $value) ) );
				if( $check == $test ) {
					$return = str_replace('{date}', $key, $mainf);
					return str_replace('{time}', strftime($timef, $timestamp), $return);
				}
			}
		}
		$return = str_replace('{date}', strftime($datef, $timestamp), $mainf);
		return str_replace('{time}', strftime($timef, $timestamp), $return);
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