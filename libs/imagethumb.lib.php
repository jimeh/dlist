<?php

class imageThumb {
	
/*

	Class: imageThumb v0.2 beta

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

// ==============================================
// ----- [ Configuration ] ----------------------
// ==============================================
	
	var $jpg_quality = 85; // default jpg quality
	
	var $cache_dir = 'cache/images/';
	var $cache_validity = 60; // days
	var $clean_cache = 0; // hours
	
	var $output_format;
	
	var $src_file;
	var $image;
	var $type;
	var $last_modified;
	var $target_w;
	var $target_h;
	var $error = false;
	var $last_clean_file = 'imagethumb_cleanup';
	
	
	
	function imageThumb ($src=false) {
		if ( !empty($src) ) $this->load($src);
	}
	
	
// ==============================================
// ----- [ Public Functions ] -------------------
// ==============================================


	function quick ($file, $width, $height, $quality=null) {
		if ( !$this->check_cache($file, $width, $height, $quality) ) {
			$this->load($file);
			if ( $this->error == false) {
				if ( !empty($quality) ) $this->jpg_quality = $quality;
				$this->resize($width, $height);
				$this->output();
				$this->save_to_cache();
				$this->destroy();
			}
		}	
		$this->clean_cache();
	}

	function load ($file) {
		if ( is_readable($file) && preg_match("/.*\.(jpg|jpeg|jpe|png)/i", $file, $type) ) {
			$this->type = ( $type[1] == 'jpeg' || $type[1] == 'jpe' ) ? 'jpg' : $type[1] ;
			$this->image = ( $this->type == 'png' ) ? imagecreatefrompng($file) : imagecreatefromjpeg($file) ;
			$this->src_file = $file;
			$this->last_modified = filemtime($file);
		} else { $this->error = true; return false; }
	}
	
	function resize ($width=null, $height=null, $onlydown=true, $keepratio=true) {
		if ( $width != null || $height != null ) {
			$src_w = imageSX($this->image);
			$src_h = imageSY($this->image);
			if ( $width == null ) $width = 5000;
			if ( $height == null ) $height = 5000;
			$size = $this->resize_dimensions($src_w, $src_h, $width, $height, $onlydown, $keepratio);
			$image = imagecreatetruecolor($size['w'], $size['h']);
			imagecopyresampled($image, $this->image, 0, 0, 0, 0, $size['w'], $size['h'], $src_w, $src_h);
			$this->image = $image;
			$this->target_w = $width;
			$this->target_h = $height;
		}
	}
	
	function output ($file=null) {
		if ( $this->get_type() == 'png' ) {
			header('Content-type: image/png');
			header('Content-disposition: image; filename="'.basename($this->src_file).'"');
			( empty($file) ) ? imagepng($this->image) : imagepng($this->image, $file) ;
		} else {
			header('Content-type: image/jpeg');
			header('Content-disposition: image; filename="'.basename($this->src_file).'"');
			imagejpeg($this->image, $file, $this->jpg_quality);
		}
	}
	
	function destroy () {
		imagedestroy($this->image);
	}
	
// Caching Functions

	function save_to_cache () {
		if ( !preg_match("/\/$/", $this->cache_dir) ) $this->cache_dir .= '/';
		if ( is_writable($this->cache_dir) ) {
			$string = $this->src_file.$this->last_modified;
			if ( !empty($this->target_w) ) $string .= $this->target_w;
			if ( !empty($this->target_h) ) $string .= $this->target_h;
			if ( $this->get_type() == 'jpg' ) $string .= $this->jpg_quality;
			$filename = 'imgt_';
			$filename .= md5($string);
			$filename .= '.'.$this->type;
			if( !file_exists($filename) ) {
				if ( $this->type == 'png' ) {
					imagepng($this->image, $this->cache_dir.$filename);
				} else {
					imagejpeg($this->image, $this->cache_dir.$filename, $this->jpg_quality);
				}
			}
		}
	}
	
	function check_cache ($file, $target_w=null, $target_h=null, $quality=null) {
		if ( is_readable($file) ) {
			preg_match("/(?:.*\/|)(.*?)\.(.*)/i", $file, $file_pieces);
			$ext = $file_pieces[2];
			$string = $file.filemtime($file);
			if ( !empty($target_w) ) $string .= $target_w;
			if ( !empty($target_h) ) $string .= $target_h;
			if ( $ext == 'jpg' || $ext == 'jpeg' || $ext == 'jpe' ) $string .= $quality;
			$filename = 'imgt_';
			$filename .= md5($string);
			$filename .= '.'.$ext;
			if ( is_readable($this->cache_dir.$filename) ) {
				//TODO possibly redirect instead of loading image in script
 				// header('Location: '.dirname($_SERVER['SCRIPT_URL']).'/'.$this->cache_dir.$filename);
 				// return true;
				( $ext == 'png' ) ? header('Content-type: image/png') : header('Content-type: image/jpeg');
				header('Content-disposition: image; filename="'.$file_pieces[1].'_thumb.'.$file_pieces[2].'"');
				print($this->rfile($this->cache_dir.$filename));
				return true;
			}
		}
		return false;
	}
	
	function clean_cache () {
		if ( is_readable($this->cache_dir.$this->last_clean_file) ) {
			$last_clean = $this->rfile($this->cache_dir.$this->last_clean_file);
		} else { $last_clean = 0; }
		
		$clean_cache = $this->clean_cache * 3600;
		$cache_validity = $this->cache_validity * 86400;
		if ( time() > ($last_clean + $clean_cache) ) {
			$this->write2file($this->cache_dir.$this->last_clean_file, time());
			$glob = glob($this->cache_dir.'*');
			foreach( $glob as $key => $value ) {
				if ( preg_match("/(?:.*\/|)(imgt_.*?\.(jpg|jpeg|png))/i", $value) && (fileatime($value) + $cache_validity) < time() ) {
					unlink($value);
				}
			}
		}
	}
	
	
// ==============================================
// ----- [ Internal Functions ] -----------------
// ==============================================

	
	function get_type () {
		return ( empty($this->output_format) ) ? $this->type : $this->output_format ;
	}
	
	function rfile ($file){
		if (!isset($file)) return false;
		if (is_file($file)) {
			if (!($fh = fopen($file,'r'))) return false;
			$file_data = fread($fh, filesize($file));
			fclose($fh);
		} else { return false; }
		return $file_data;
	}
	
	function write2file($file, $string, $mode="wt", $lock=2){
		if ( !isset($file) ) return false;
		$fp = fopen($file, $mode);
		if ($fp != false) {
			flock($fp,$lock);
			$re = fwrite($fp,$string);
			$re2 = fclose($fp);
			if ($re != false && $re2 != false) return true;
		}
		return false;
	}
	
	function resize_dimensions ($src_w, $src_h, $w, $h, $onlydown=true, $keepratio=true) {
		$img_w = ( $w >= $src_w && $onlydown ) ? $src_w : $w ;
		$img_h = ( $h >= $src_h && $onlydown ) ? $src_h : $h ;

		if ( $keepratio ) {
			$ratio = $src_w / $src_h;
			if ( $ratio > ($img_w / $img_h) ) {
				$img_h = $src_h / ($src_w / $img_w);
			} elseif ( $ratio < ($img_w / $img_h) ) {
				$img_w = $src_w / ($src_h / $img_h);
			}
		}
		return array('w'=>$img_w, 'h'=>$img_h);
	}
	
}

?>