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
if ( !empty($_REQUEST[$config->lang_cookie]) && is_readable('languages/'.$_REQUEST[$config->lang_cookie].'.lang.php')) {
	$language = $_REQUEST[$config->lang_cookie];
} elseif ( is_readable('languages/'.$config->language.'.lang.php') ) {
	$language = $config->language;
} elseif ( is_readable('languages/'.$config->default_lang.'.lang.php') ) {
	$language = $config->default_lang;
} else {
	die("ERROR: Can't open language file.");
}
include('languages/'.$language.'.lang.php');


//>Section> create_object:10
$lang = new lang();


//>Section> local_names:10
$local_names = ( is_readable($config->path_cache.'/local_names.ini') ) ? parse_ini_file($config->path_cache.'/local_names.ini') : array() ;
$language_files = glob('languages/*.lang.php');
$installed_languages = array();
foreach( $language_files as $key => $value ) {
	$lang_name = preg_replace("/languages\/(.*)\.lang\.php/", "$1", $value);
	$installed_languages[$lang_name] = ( !empty($local_names[$lang_name]) ) ? $local_names[$lang_name] : $lang_name ;
}
if ( !isset($local_names[$language]) ) {
	execHandler::write2file($config->path_cache.'/local_names.ini', "\n".$language.'='.$lang->_language, 'at');
}
// sort($installed_languages);

//>Section> warning:10
if ( $lang->_version < $config->req_lang_ver ) {
	echo 'WARNING: '.ucfirst($config->language).' language file is out of date and not fully compatible with this version of dList.';
}


//>Section> timer_string:10
if ( stristr($lang->timer_string, '%s') != false ) $timer->pattern = $lang->timer_string;


//>Section> setlocale:10
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
//TODO add date formatting options to language files
$dlist->lang_tomorrow = $lang->sd_tomorrow;
$dlist->lang_today = $lang->sd_today;
$dlist->lang_yesterday = $lang->sd_yesterday;
$dlist->lang_2_days_ago = $lang->sd_2_days_ago;
$dlist->lang_3_days_ago = $lang->sd_3_days_ago;

if ( !empty($lang->standard_date_format) ) $dlist->standard_date_format = $lang->standard_date_format;
if ( !empty($lang->sd_format) ) $dlist->smartdate = $lang->sd_format;
if ( !empty($lang->sd_date) ) $dlist->smartdate_date = $lang->sd_date;
if ( !empty($lang->sd_time) ) $dlist->smartdate_time = $lang->sd_time;



//_END;
?>