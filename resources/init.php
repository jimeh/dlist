<?php

/*
	
	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

*/

// process requested path
if ( stristr($_SERVER['REQUEST_URI'], '?') !== false ) {
	$dir_url = explode('?', $_SERVER['REQUEST_URI']);
	$query_string = $dir_url[1];
	$dir_url = urldecode($dir_url[0]);
} else {
	$query_string = '';
	$dir_url = urldecode($_SERVER['REQUEST_URI']);
}


// path lookup
$dir_path = apache_lookup_uri($dir_url);
$dir_path = ( is_array($dir_path) ) ? $dir_path['filename'] : $dir_path->filename ;
if(!preg_match("/\/$/", $dir_path)) $dir_path .= '/';
if(!preg_match("/\/$/", $dir_url)) $redirect = '/';


// check for index files and redirect if found
if ( empty($redirect) ) {
	foreach($config['index_files'] as $what) {
		$indexsearch = glob($dir_path.$what.'.*');
		if(isset($indexsearch[0])) { $redirect = basename($indexsearch[0]); break; }
	}
}
if ( !empty($redirect) ) {
	if(!empty($_SERVER['SCRIPT_URI'])) {
		$scheme = parse_url($_SERVER['SCRIPT_URI']);
		$scheme = $scheme['scheme'];
	} else $scheme = $config['default_scheme'];
	if( !empty($query_string) ) $query_string = '?'.$query_string;
	header("Location: ".$scheme.'://'.$_SERVER['HTTP_HOST'].$dir_url.$redirect.$query_string);
	exit;
}

?>