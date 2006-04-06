<?php die();

//
//  Exec: output
//
//  Copyright © 2006 Jim Myhrberg. All rights reserved.
//  zynode@gmail.com
//

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
				$return .= ($key != $last) ? '<a href="'.$root.$previous.$value.'/">'.$value.'/</a>' : $value.'/';
				$previous .= $value.'/';
			}
			return $return;
		} else return false;
	}
	
	//>Section> path_class.end
}

//>Section> class_sort.start
class Sort {
	
	//>Section> sort.get_url
	function get_url ($sortby) {
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