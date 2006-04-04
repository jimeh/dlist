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


//>Section> sort_class.start
class Sort {
	
	//>Section> get_url
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
	
//>Section> set_parent:10
$parent = $dlist->parent;
	
//>Section> do_render.end:95
}

//_END;
?>