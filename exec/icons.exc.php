<?php die();

//
//  Exec: icons
//
//  Copyright © 2006 Jim Myhrberg. All rights reserved.
//  zynode@gmail.com
//

//_HEAD;
/* --- Configuration ---
Name: icons
Priority: 40
Author: Jim Myhrberg
*/
//_SCRIPT;

//==========================
//>STAGE> init
//==========================


//>After> core.define_constants
define('ICONS_PATH', '/icons/'.$config->iconset.'/');
define('ICONS_URL', DLIST_URL.ICONS_PATH);




//_END;
?>