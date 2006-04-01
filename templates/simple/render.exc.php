<?php die();

//
//  Exec: render/simple
//
//  Copyright © 2006 Jim Myhrberg. All rights reserved.
//  zynode@gmail.com
//

//_HEAD;
/* --- Configuration ---
Name: simple/render
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


//>Section> include_phtml
include(TPL_PATH.'index.phtml');


//_END;
?>