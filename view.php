<?php

/*
	
	dList v2.0 beta
	
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


// initialize debug stopwatch
if ($config->debug) $debug_timer = new speedometer();


// initialize execHandler and main scripts
$exec = new execHandler();
$exec->update_frequency = 0;
$exec->show_debug_msg = false;


// configure cache dir for compiled code
$exec->cache_dir = $config->path_cache.'/exec/';

// debug?
if ( $config->debug ) $exec->debug = true;

// paths to load
$exec->addPath(
	array(
		'exec/core.exc.php',
		'exec/*',
		'templates/'.$config->template.'/*.exc.php',
	)
);
foreach( $config->path_plugins as $key => $value ) {
	$exec->addPath($value.'/*.exc.php');
}
$exec->cache();
include($exec->include_file);




if ($config->debug) {
	$debug_timer->end();
	echo "<br />\npage generated in ".$debug_timer->time." sec.<br />\n";
}



?>