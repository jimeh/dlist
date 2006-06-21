<?php die();

/*

	Exec: icons

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
			$sizew = $config->icons_large_w;
			$sizeh = $config->icons_large_h;
		} else {
			$size = $config->icons_small;
		}
		$ext = ( preg_match("/.*\.(.*)/", $file, $ext) ) ? $ext[1] : '' ;
		$icons_path = ICONS_PATH.$size.'/';
		$icons_url = ICONS_URL.$size.'/';
		if ( $type == 'file' ) {
			if ( preg_match($config->thumb_pattern, $ext) && $thumbnail && $config->thumbnails ) {
				return DLIST_URL.'thumb.php?src='.rawurlencode(DIR_URL.$file).'&w='.$sizew.'&h='.$sizeh;
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
	
//>Section> get_thumbnail
	function get_thumbnail_url ($file, $sizew, $sizeh) {
		return DLIST_URL.'thumb.php?src='.rawurlencode(DIR_URL.$file).'&w='.$sizew.'&h='.$sizeh;
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
		global $config;
		if ( preg_match($config->thumb_pattern, $file) ) return true;
		else return false;
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