<?php

/*
	
	dList Intialization
	
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

// Server configuration

$config['index_files'] = array('index.html', 'index.php');
$config['default_scheme'] = 'http';


// process requested path
if ( preg_match("/^(.*?)\?(.*)$/i", $_SERVER['REQUEST_URI'], $dir_url) ) {
	$dir_url = urldecode($dir_url[1]);
} else {
	$dir_url = urldecode($_SERVER['REQUEST_URI']);
}

if(!preg_match("/\/$/", $dir_url)) $redirect = '/';



if ( empty($redirect) ) {
	
	// path lookup
	if ( function_exists('apache_lookup_uri') ) {
		$dir_path = apache_lookup_uri($dir_url);
		$dir_path = ( is_array($dir_path) ) ? $dir_path['filename'] : $dir_path->filename ;
	} else {
		$dir_path = $_SERVER['DOCUMENT_ROOT'].$dir_url;
	}
	if(!preg_match("/\/$/", $dir_path)) $dir_path .= '/';
	
	// check for index files and redirect if found
	foreach($config['index_files'] as $what) {
		if ( file_exists($dir_path.$what) ) {
			$redirect = basename($what);
			break;
		}
	}
	
}

if ( !empty($redirect) ) {
	if(!empty($_SERVER['SCRIPT_URI'])) {
		$scheme = parse_url($_SERVER['SCRIPT_URI']);
		$scheme = $scheme['scheme'];
	} else $scheme = $config['default_scheme'];
	if( !empty($_SERVER['QUERY_STRING']) ) $query_string = '?'.$_SERVER['QUERY_STRING'];
	header("Location: ".$scheme.'://'.$_SERVER['HTTP_HOST'].$dir_url.$redirect.$query_string);
	exit;
}

?>