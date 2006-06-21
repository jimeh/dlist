<?php die();

/*

	Exec: render
	
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