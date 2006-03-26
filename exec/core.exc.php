<?php die();

//
//  core
//
//  Created by Jim Myhrberg on 21-Mar-2006.
//  Copyright (c) zynode.info. All rights reserved.
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
//==========================d

//>Section> init_dList
if ( $do_readdir ) {
	$dlist = new dirlist();
//	$dlist->show_hidden = true;
	$dlist->read($dir_path);
}

//==========================
//>STAGE> render
//==========================

//>Section> echo
print_r($dlist->list);


//_END;
?>