<?php

/*
	
	dList v0.7 beta
	
	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

*/

require_once('config.php');
require_once('resources/init.php');
require_once('libs/speedometer.lib.php');
require_once('libs/config.lib.php');
require_once('libs/dirlist.lib.php');
require_once('libs/exechandler.lib.php');


// initialize config object
$config = new config($config);


// initialize debug stopwatch
if ($config->debug) $debug_time = new speedometer();


// initialize execHandler and main scripts
$exec = new execHandler();
$exec->cache_dir = 'cache/exec/';

// debug?
if ( $config->debug ) $exec->debug = true;

// paths to load
$exec->addPath(
	array(
		'exec/core.exc.php',
		'exec/*',
		'templates/'.$config->template.'/render.exc.php',
		'plugins/*.exc.php',
	)
);
$exec->cache();
include($exec->include_file);



if ($config->debug) {
	$debug_time->end();
	echo "<br />\npage generated in ".$debug_time->time." sec.<br />\n";
}



?>