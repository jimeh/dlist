<?php

/*
	
	dList v2.2.6 beta
	
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