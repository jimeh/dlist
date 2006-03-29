<?php

/*
	
	dList v0.7 beta
	
	Copyright © 2006 Jim Myhrberg. All rights reserved.
	zynode@gmail.com

*/

require_once('config.php');
require_once('resources/init.php');
require_once('libs/speedometer.lib.php');
require_once('libs/dirlist.lib.php');
require_once('libs/exechandler.lib.php');

$time = new speedometer();


$exec = new execHandler();
$exec->cache_dir = 'cache/exec/';
if ( $config['debug'] ) {
	$exec->debug = true;
	$exec->update_frequency = 0;
}
$exec->addPath(
	array(
		'exec/core.exc.php',
		'templates/'.$config['template'].'/render.exc.php',
		'plugins/*.exc.php',
	)
);
$exec->cache();
include($exec->include_file);

print_r($exec->execution_order);


$time->end();
if ($config['debug']) echo "<br />\npage generated in ".$time->time." sec.<br />\n";

?>