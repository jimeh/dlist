<?php die();

//
//  Exec: language
//
//  Copyright © 2006 Jim Myhrberg. All rights reserved.
//  zynode@gmail.com
//

//_HEAD;
/* --- Configuration ---
Name: language
Priority: 40
Author: Jim Myhrberg
*/
//_SCRIPT;

//==========================
//>STAGE> init
//==========================


//>Section> init:10
if ( empty($config->language) ) $config->language = 'english';

if ( is_readable('languages/'.$config->language.'.lang.php') ) {
	include('languages/'.$config->language.'.lang.php');
} elseif ( is_readable('languages/'.$config->default_lang.'.lang.php') ) {
	include('languages/'.$config->default_lang.'.lang.php');
} else {
	die("ERROR: Can't open language file.");
}

$lang = new lang();
setlocale(LC_ALL, array_merge($lang->_locale, $config->default_locale));


//==========================
//>STAGE> init
//==========================


//>After> core.define_constants
define('LANG', $lang->_language);
define('LANG_VER', $lang->_version);


//==========================
//>STAGE> main
//==========================


//>After> core.readdir.options
$dlist->lang_tomorrow = $lang->sd_tomorrow;
$dlist->lang_today = $lang->sd_today;
$dlist->lang_yesterday = $lang->sd_yesterday;
$dlist->lang_2_days_ago = $lang->sd_2_days_ago;
$dlist->lang_3_days_ago = $lang->sd_3_days_ago;



//_END;
?>