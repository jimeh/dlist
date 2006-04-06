<?php die();

//
//  Exec: core
//
//  Copyright © 2006 Jim Myhrberg. All rights reserved.
//  zynode@gmail.com
//

//_HEAD;
/* --- Configuration ---
Name: core
Priority: 40
Author: Jim Myhrberg
Include: output.exc.php, language.exc.php
*/
//_SCRIPT;

//==========================
//>STAGE> init
//==========================


//>Section> port_correction:20
if ( stristr($_SERVER['HTTP_HOST'], ':') !== false ) {
	$http_host = explode(':', $_SERVER['HTTP_HOST'], 2);
	$_SERVER['SERVER_PORT'] = $http_host[1];
	unset($http_host);
}
preg_match("/(.*)Port [0-9]{2,8}(.*)/i", $_SERVER['SERVER_SIGNATURE'], $serverinfo);
$_SERVER['SERVER_SIGNATURE'] = $serverinfo[1].'Port '.$_SERVER['SERVER_PORT'].$serverinfo[2];


//>Section> define_constants:30
define('DIR_URL', $dir_url);
define('DIR_PATH', $dir_path);
define('DLIST_URL', $config->dlist_url);


//>Section> dynamic_vars
$do_readdir = true;
$do_render = true;
$do_sort_items = true;
$do_sort_by = $config->default_sort;
$do_sort_reverse = false;


//==========================
//>STAGE> main
//==========================


//>Section> do_readdir
if ( $do_readdir ) {
	//>Section> readdir.start
	$dlist = new dirList();
	//>Section> readdir.options
	if ( $do_sort_items ) {
		$dlist->sort_by = $do_sort_by;
		if ( $do_sort_reverse ) $dlist->reverse = true;
	} else $dlist->sort_items = false;
	if ($config->show_hidden) $dlist->show_hidden = true;
	if ( !$config->smartdate ) $dlist->use_smartdate = false;
	//>Section> readdir.read
	$dlist->read(DIR_PATH);
	//>Section> do_readdir.end
}

//==========================
//>STAGE> render
//==========================




//_END;
?>