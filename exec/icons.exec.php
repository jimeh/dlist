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
	function get_url ($file, $size, $type, $thumbnail=false) {
		global $config;
		if ( $size == 'large' || $size == 'big' ) {
			$size = $config->icons_large;
		} else {
			$size = $config->icons_small;
		}
		$ext = ( preg_match("/.*\.(.*)/", $file, $ext) ) ? $ext[1] : '' ;
		$icons_path = ICONS_PATH.$size.'/';
		$icons_url = ICONS_URL.$size.'/';
		if ( $type == 'file' ) {
			if ( preg_match("/jpg|jpeg|png/", $ext) && $thumbnail ) {
				return DLIST_URL.'thumb.php?src='.urlencode(DIR_URL.$file).'&w=48&h=48';
			} elseif ( file_exists($icons_path.$ext.$config->icons_ext) ) {
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
	
//>Section> is_image
	function is_image ($file) {
		if ( preg_match("/.*\.(jpg|jpeg|png|gif|bmp)/", $file) ) {
			return true;
		} elseif ( preg_match("/jpg|jpeg|png|gif|bmp/", $file) ) {
			return true;
		}
		return false;
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