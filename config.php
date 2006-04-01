<?php

/*

	dList's main configuration file.

*/


$config = array(

	
// Main settings
	
	# leave blank to autodetect from $_SERVER['SCRIPT_NAME']
	'dlist_url' => '',
	
	# show debug messages, for exechandler to always re-parse all files
	'debug'     => true,
	

// File system settings

	# show hidden files & folders who's names begin with . (dot)
	'show_hidden' => false,
	
// Display settings
	
	# if the corresponding language file can't be found
	# dList will default to english.
	'language'  => 'english',
	
	# Smart Date shows relative time stamps ("Yesterday, 09:34") when applicable
	'smartdate' => true,
	

// Template & Icon settings

	'template'       => 'simple',
	'iconset'        => 'osx',
	'allow_override' => true,
	
	
// dList internal settings - don't change if you don't know what you're doing

	'default_lang' => 'english',
	'default_locale' => array('en', 'en_US'),
	'path_plugins' => array('plugins'),
	'path_cache' => 'cache',
	

	
);

?>