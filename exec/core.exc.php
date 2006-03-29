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
*/
//_SCRIPT;

//==========================
//>STAGE> init
//==========================


//>Section> define_constants
define('DIR_URL', $dir_url);
define('DIR_PATH', $dir_path);
define('QUERY_STRING', $query_string);

define('DLIST_URL', $config['url']);
define('TEMPLATE', $config['template']);
define('TPL_URL', DLIST_URL.'templates/'.TEMPLATE.'/');


//>Section> port_correction
if ( stristr($_SERVER['HTTP_HOST'], ':') !== false ) {
	$http_host = explode(':', $_SERVER['HTTP_HOST'], 2);
	$_SERVER['SERVER_PORT'] = $http_host[1];
	unset($http_host);
}
preg_match("/(.*)Port [0-9]{2,8}(.*)/", $_SERVER['SERVER_SIGNATURE'], $serverinfo);
$_SERVER['SERVER_SIGNATURE'] = $serverinfo[1].'Port '.$_SERVER['SERVER_PORT'].$serverinfo[2];


//>Section> set_vars
$do_readdir = true;
$do_render = true;


//==========================
//>STAGE> main
//==========================


//>Section> init_dList
if ( $do_readdir ) {
	$dlist = new dirlist();
	if ($config['show_hidden']) $dlist->show_hidden = true;
	$dlist->read(DIR_PATH);
}


//==========================
//>STAGE> render
//==========================


//>Section> echo
print_r($dlist->list);


//_END;
?>