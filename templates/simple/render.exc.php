<?php die();

//
//  Exec: render
//
//  Copyright © 2006 Jim Myhrberg. All rights reserved.
//  zynode@gmail.com
//

//_HEAD;
/* --- Configuration ---
Name: render
Priority: 40
Author: Jim Myhrberg
*/
//_SCRIPT;

//==========================
//>STAGE> init
//==========================


//>After> core.define_constants
$config->parse(TPL_PATH.'settings.php', true, 'tpl_');


//==========================
//>STAGE> render
//==========================

//>Section> set_view_mode
if ( !empty($_COOKIE['dList_simple_viewMode']) && !empty($config->tpl_modes[$_COOKIE['dList_simple_viewMode']]) ) {
	$config->tpl_mode = $config->tpl_modes[$_COOKIE['dList_simple_viewMode']];
} else {
	$config->tpl_mode = $config->tpl_modes[$config->tpl_mode];
}

//>Section> include_phtml
include(TPL_PATH.'index.phtml');


//_END;
?>