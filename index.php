<?php

/*
	
	dList v2.2.5 beta
	
	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

*/

// initialization script - checks for index files
require_once('resources/init.php');

// initialize config object
require_once('libs/config.lib.php');
$config = new config($config);
$config->parse_php_file('config.php');

// include required libs
require_once('libs/speedometer.lib.php');
require_once('libs/dirlist.lib.php');
require_once('libs/exechandler.lib.php');


// initialize $timer
$timer = new speedometer();


// autodetect dList's install URL if not set
if ( empty($config->dlist_url) ) $config->dlist_url = preg_replace("/(.*)\/(.*?)$/i", "$1/", $_SERVER['SCRIPT_NAME']);


// initialize execHandler and main scripts
$exec = new execHandler();
$exec->update_frequency = 0; //TODO remove this once done developing


// configure cache dir for compiled code
$exec->cache_dir = $config->path_cache.'/exec/';

// debug?
if ( $config->debug ) $exec->debug = true;

// paths to load
$exec->addPath(
	array(
		'exec/core.exec.php',
		'exec/*.exec.php',
		'templates/'.$config->template.'/*.exec.php',
	)
);
foreach( $config->path_plugins as $key => $value ) {
	$exec->addPath($value.'/*.exec.php');
}
$exec->cache();
include($exec->include_file);


/*TODO uncomment debug timer once done developing
if ($config->debug) {
	echo "<br />\npage generated in ".$timer->term(8)." sec.<br />\n";
}
*/


?>