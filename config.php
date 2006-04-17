<?php

/*

	dList's main configuration file.

*/


$config = array(

	
// Main settings
	
	# leave blank to autodetect from $_SERVER['SCRIPT_NAME']
	'dlist_url' => '',
	
	# if dlist is accessable from multiple urls (installed in /dev/dlist/,
	# but also accessable via /dlist/ thanks to an alias) please specify
	# the real path(s) here as array keys
	'alt_urls' => array('/dev/dlist'),
	
	# show debug messages, exechandler to always re-parse all files
	'debug'     => true,
	
	# by default dList will sort by this, for more details, 
	# check the dirlist function in libs/dirlist.lib.php
	'default_sort' => 'name',
	

// File system settings

	# show hidden files & folders who's names begin with . (dot)
	'show_hidden' => false,
	
	# use regular expressions to filter out specific files and folders from
	# being displayed, and browseable
	'filter_out' => array(),
	
	# what info to show for each file/folder in details view, valid values are:
	# name, size, mtime, atime, perms, chmod, owner, ownerid, group, groupid, ext
	# (must at least contain "name" for basic directory listing functionality)
	'fields' => 'name,size,mtime,perms,owner',
	
// Display settings
	
	# if the corresponding language file can't be found
	# dList will default to english.
	'language'  => 'english',
	
	# show thumbnails for JPEG and PNG images?
	'thumbnails' => true,
	
	# Smart Date shows relative time stamps ("Yesterday, 09:34") when applicable
	'smartdate' => true,
	
	# name of the cookie dList will check for language settings per user
	'lang_cookie' => 'dList_language',
	

// Template & Icon settings

	'template'       => 'simple',
	'iconset'        => 'osx',
	'allow_override' => true,
	
	
// dList internal settings - don't change if you don't know what you're doing

	'default_lang' => 'english',
	'default_locale' => array('eng', 'en_US'),
	'path_plugins' => array('plugins'),
	'path_cache' => 'cache',

	'req_lang_ver' => '1.0.7',
	

	
);

?>