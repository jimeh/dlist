<?php

/*
	
	dList Intialization
	
	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

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