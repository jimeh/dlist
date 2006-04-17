<?php

class lang {

	// Language settings
	var $_language = 'svenska'; // local language name ("svenska" for swedish)...
	var $_version = '1.0.7';
	
	
	// Locale settings
	var $_locale = array('sve', 'sv_SE');
	

	// General
	var $index_of   = 'Index av';
	var $parent_dir = 'Tidigare Mapp';
	
	var $name     = 'Namn';
	var $size     = 'Storlek';
	var $mtime    = 'Datum Ändrad';
	var $atime    = 'Sisst Öppnad'; //FIXME possibly incorrect
	var $perms    = 'Rättigheter';
	var $chmod    = 'CHMOD';
	var $owner    = 'Ägare';
	var $group    = 'Grupp';
	var $owner_id = 'Ägare ID';
	var $group_id = 'Grupp ID';
	var $type     = 'Typ';
	var $ext      = 'Ext'; //FIXME incorrect translation
	
	var $icons    = 'Ikoner';
	var $details  = 'Detaljer';
	
	var $timer_string = 'Sidan genererades på %s sekunder'; // %s = seconds
	
	var $powered_by = 'Driven av dList';
	
	
	// Statistics
	var $stats_folder    = '%n mapp';
	var $stats_folders   = '%n mappar';
	var $stats_file      = '%n fil';
	var $stats_files     = '%n filer';
	var $stats_totalsize = '%s i %f';	// %s = storlek, %f = antal filer
	var $stats_template  = '%d, %f';		// %d = mappar, %f = filer
	
	
	// Date Formatting
	# check the PHP Manual for strftime() for details (http://www.php.net/manual/)
	var $standard_date_format = '%B %e, %Y, %H:%M';
	# Smart Date formatting
	var $sd_format       = '{date}, {time}';
	var $sd_date         = '%B %e, %Y';
	var $sd_time         = '%H:%M';
	
	
	// Smart Date
	var $sd_tomorrow   = 'Imorgon';
	var $sd_today      = 'Idag';
	var $sd_yesterday  = 'Igår';
	var $sd_2_days_ago = '2 dar sen';
	var $sd_3_days_ago = '3 dar sen';
	
}

?>