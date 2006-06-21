<?php die();

/*

	Exec: output

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



//_HEAD;
/* --- Configuration ---
Name: output
Priority: 40
Author: Jim Myhrberg
*/
//_SCRIPT;

//==========================
//>STAGE> functions
//==========================

//>Section> class_path.start
class Path {
	
	//>Section> path.url2links
	function url2links ($path, $root='') {
		if ( !empty($path) ) {
			$return = '';
			$previous = '';
			$path = str_replace("\\", '/', $path);
			$path = explode('/', rtrim($path, '/'));
			$last = count($path)-1;
			foreach( $path as $key => $value ) {
				$return .= ($key != $last) ? '<a href="'.$root.$previous.$value.'/" title="'.$root.$previous.$value.'/">'.$value.'/</a>' : $value.'/';
				$previous .= $value.'/';
			}
			return $return;
		} else return false;
	}
	
	//>Section> path.stats
	function stats ($files=0, $folders=0, $totalsize=false) {
		global $lang;
		if ( !empty($folders) ) {
			$r_folders = ( $folders > 1 ) ? str_replace('%n', $folders, $lang->stats_folders) : str_replace('%n', $folders, $lang->stats_folder) ;
		}
		if ( !empty($files) ) {
			$r_files = ( $files > 1 ) ? str_replace('%n', $files, $lang->stats_files) : str_replace('%n', $files, $lang->stats_file) ;
			if ( !empty($totalsize) ) {
				$r_files = str_replace('%f', $r_files, $lang->stats_totalsize);
				$r_files = str_replace('%s', $totalsize, $r_files);
			}
		}
		if ( !empty($r_folders) && !empty($r_files) ) {
			$return = str_replace('%d', $r_folders, $lang->stats_template);
			return str_replace('%f', $r_files, $return);
		} elseif ( !empty($r_folders) ) {
			return $r_folders;
		} elseif ( !empty($r_files) ) {
			return $r_files;
		}
	}
	
	//>Section> path_wordwrap
	function wordbreak ($input, $length, $break=" ") {
		if (preg_match("/(.*)\.(.*)/", $input, $preg) ) {
			$words = explode(' ', $preg[1]);
			$ext = '.'.$preg[2];
		} else {
			$words = explode(' ', $input);
			$ext = '';
		}
		
		foreach( $words as $key => $value ) {
			$words[$key] = wordwrap($value, $length, $break, 1);
		}
		return implode(' ', $words).$ext;
	}
	
	//>Section> path_class.end
}

//>Section> class_sort.start
class Sort {
	
	//>Section> sort.get_url
	function get_url ($sortby, $desc=false) {
		global $config;
		$return = array();
		$current_sort = ( empty($_REQUEST['sort']) ) ? $config->default_sort : $_REQUEST['sort'] ;
		
		if ( $sortby == $current_sort ) {
			if ($sortby != $config->default_sort) $return[] = 'sort='.$sortby;
			if ( empty($_REQUEST['order']) || $_REQUEST['order'] != 'desc' ) {
				$return[] = 'order=desc';
			}
		} else {
			if ($sortby != $config->default_sort) {
				$return[] = 'sort='.$sortby;
				if ( $desc == true ) $return[] = 'order=desc';
			}
		}
		
		if ( empty($return) ) {
			return DIR_URL;
		} else {
			$return = implode('&', $return);
			return '?'.$return;
		}
	}
	
	//Section sort_class.end	
}
	

//==========================
//>STAGE> init
//==========================


//>After> core.define_constants:30
define('TEMPLATE', $config->template);
define('TPL_PATH', 'templates/'.TEMPLATE.'/');
define('TPL_URL', DLIST_URL.TPL_PATH);
define('SERVER_INFO', strip_tags($_SERVER['SERVER_SIGNATURE']));

//>After> core.dynamic_vars
if ( !empty($_REQUEST['order']) && $_REQUEST['order'] == 'desc' ) $do_sort_reverse = true;
if ( !empty($_REQUEST['sort']) ) $do_sort_by = $_REQUEST['sort'];
$is_root = ( DIR_URL != '' && DIR_URL != '/' ) ? false : true;


//==========================
//>STAGE> main
//==========================





//==========================
//>STAGE> render
//==========================

//>Section> do_render:5
if ( $do_render ) {
	
//>Section> set_vars:10
$parent = $dlist->parent;
if ( !empty($_REQUEST['sort']) && !empty($dlist->sort_order[strtolower($_REQUEST['sort'])]) ) {
	$current_sort = $_REQUEST['sort'];
} else {
	$current_sort = $config->default_sort;
}
//>Section> set_fields:10
$fields = explode(',', $config->fields);
foreach( $fields as $key => $value ) $fields[$key] = trim($value);
$fields = array_flip(array_filter($fields));

	
//>Section> do_render.end:95
}


//_END;
?>