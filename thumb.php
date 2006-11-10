<?php

/*
	
	thumb.php
	
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

require_once('libs/imagethumb.lib.php');

$src = ( !empty($_GET['src']) ) ? $_GET['src'] : false ;
$w = ( !empty($_GET['w']) && preg_match("/[0-9]{1,4}/", $_GET['w']) ) ? $_GET['w'] : null ;
$h = ( !empty($_GET['h']) && preg_match("/[0-9]{1,4}/", $_GET['w']) ) ? $_GET['h'] : null ;
$q = ( !empty($_GET['q']) && $_GET['q'] >= 0 && $_GET['q'] <= 100) ? $_GET['q'] : false ;

//TODO load sizes from config instead of from $_GET vars for security reasons...

if ( preg_match("/^\//", $src) ) {
	if ( function_exists('apache_lookup_uri') ) {
		$file = apache_lookup_uri($src);
		$file = ( is_array($file) ) ? $file['filename'] : $file->filename ;
	} else {
		$file = $_SERVER['DOCUMENT_ROOT'].$src;
	}
} else $file = $src;

$image = new imageThumb();
$image->cache_dir = 'cache/thumbnails/';
$image->quick($file, $w, $h, $q);


?>