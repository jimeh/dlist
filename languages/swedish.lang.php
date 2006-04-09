<?php

class lang {

	// Language settings
	var $_language = 'svenska'; // local language name ("svenska" for swedish)...
	var $_version = '1.0.5';
	
	
	// Locale settings
	var $_locale = array('sve', 'sv_SE');
	

	// General
	var $index_of = 'Index av';
	var $parent_dir = 'Tidigare Mapp';
	
	var $name = 'Namn';
	var $size = 'Storlek';
	var $mtime = 'Datum Ändrad';
	var $atime = 'Sisst Öppnad'; //FIXME possibly incorrect
	var $perms = 'Rättigheter';
	var $chmod = 'CHMOD';
	var $owner = 'Ägare';
	var $group = 'Grupp';
	var $owner_id = 'Ägare ID';
	var $group_id = 'Grupp ID';
	var $type     = 'Typ';
	var $ext      = 'Ext'; //FIXME incorrect translation
	
	var $timer_string = 'Sidan genererades på %s sekunder';
	
	var $icons    = 'Ikoner';
	var $details  = 'Detaljer';
	
	var $powered_by = 'Driven av dList';
	
	
	// Smart Date
	var $sd_tomorrow   = 'Imorgon';
	var $sd_today      = 'Idag';
	var $sd_yesterday  = 'Igår';
	var $sd_2_days_ago = '2 dar sen';
	var $sd_3_days_ago = '3 dar sen';
	
}

?>