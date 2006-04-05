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
//>STAGE> functions
//==========================


	function installed_languages () {
		$return = glob('languages/*.lang.php');
		foreach( $return as $key => $value ) {
			$return[$key] = preg_replace("/languages\/(.*)\.lang\.php/", "$1", $value);
		}
		return $return;
	}


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
$dlist->lang_tomorrow = $lang->sd_tomorrow;
$dlist->lang_today = $lang->sd_today;
$dlist->lang_yesterday = $lang->sd_yesterday;
$dlist->lang_2_days_ago = $lang->sd_2_days_ago;
$dlist->lang_3_days_ago = $lang->sd_3_days_ago;



//_END;
?>