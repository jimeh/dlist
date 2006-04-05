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
//>STAGE> functions
//==========================

//>Section> class.start
class Icon {
	
//>Section> get_url
	function get_url ($ext, $size, $type) {
		//TODO enable thumbnail support using phpThumbs
		global $config;
		if ( $size == 'large' || $size == 'big' ) {
			$size = $config->icons_large;
		} else {
			$size = $config->icons_small;
		}
		$icons_path = ICONS_PATH.$size.'/';
		$icons_url = ICONS_URL.$size.'/';
		if ( $type == 'file' ) {
			if ( file_exists($icons_path.$ext.$config->icons_ext) ) {
				return $icons_url.$ext.$config->icons_ext;
			} else {
				return $icons_url.'_file'.$config->icons_ext;
			}
		} elseif ( $type == 'dir' || $type == 'folder' ) {
			if ( file_exists($icons_path.'_folder.'.$ext.$config->icons_ext) ) {
				return $icons_url.'_folder.'.$ext.$config->icons_ext;
			} else {
				return $icons_url.'_folder'.$config->icons_ext;
			}
		}
	}
	
//>Section> get_parent
	function get_parent ($size) {
		global $config;
		if ( $size == 'large' || $size == 'big' ) {
			$size = $config->icons_large;
		} else {
			$size = $config->icons_small;
		}
		return ICONS_URL.$size.'/_parent'.$config->icons_ext;
	}
//> class.end
}


//==========================
//>STAGE> init
//==========================


//>After> core.define_constants
define('ICONS_PATH', 'icons/'.$config->iconset.'/');
define('ICONS_URL', DLIST_URL.ICONS_PATH);

//>Section> load_config:35
$config->parse(ICONS_PATH.'config.ini', true, 'icons_');


//_END;
?>