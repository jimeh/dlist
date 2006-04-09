<?php

require_once('libs/imagethumb.lib.php');

$src = ( !empty($_GET['src']) ) ? $_GET['src'] : false ;
$w = ( !empty($_GET['w']) && preg_match("/[0-9]{1,4}/", $_GET['w']) ) ? $_GET['w'] : null ;
$h = ( !empty($_GET['h']) && preg_match("/[0-9]{1,4}/", $_GET['w']) ) ? $_GET['h'] : null ;
$q = ( !empty($_GET['q']) ) ? $_GET['q'] : false ;

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