<?php

class lang {
	
/*

   Finnish translation by Eric Hartin (a.k.a. Fraeon).
   http://www.fraeport.net/

*/

	// Language settings
	var $_language = 'suomi'; // local language name ("svenska" for swedish)...
	var $_version = '1.0.7';


	// Locale settings
	var $_locale = array('fi', 'fi_FI');


	// General strings
	var $index_of = 'Hakemisto';
	var $parent_dir = 'Ylähakemisto';

	var $name     = 'Tiedostonimi';
	var $size     = 'Koko';
	var $mtime    = 'Viimeksi muokattu';
	var $atime    = 'Viimeksi luettu';
	var $perms    = 'Oikeudet';
	var $chmod    = 'CHMOD';
	var $owner    = 'Omistaja';
	var $group    = 'Ryhmä';
	var $owner_id = 'Omistajan ID';
	var $group_id = 'Ryhmän ID';
	var $type     = 'Tyyppi';
	var $ext      = 'Pääte';

	var $icons    = 'Kuvakkeet';
	var $details  = 'Lisätietoa';

	var $timer_string = 'Sivu on syljetty ulos %s:ssa sekunnissa';

	var $powered_by = 'Tämä sivusto käyttää dListiä';


	// Statistics
	var $stats_folder    = '%n hakemistoa';
	var $stats_folders   = '%n hakemistot';
	var $stats_file      = '%n tiedosto';
	var $stats_files     = '%n tiedostoa';
	var $stats_totalsize = '%s, %f';	// %s = size, %f = number of files
	var $stats_template  = '%d, %f';		// %d = folders, %f = files
	
	
	// Date Formatting
	# check the PHP Manual for strftime() for details (http://www.php.net/manual/)
	var $standard_date_format = '%B %e, %Y, %H:%M';
	# Smart Date formatting
	var $sd_format       = '{date}, {time}';
	var $sd_date         = '%B %e, %Y';
	var $sd_time         = '%H:%M';


	// Smart Date
	var $sd_tomorrow   = 'Huomenna';
	var $sd_today      = 'Tänään';
	var $sd_yesterday  = 'Eilen';
	var $sd_2_days_ago = 'Kaksi päivää sitten';
	var $sd_3_days_ago = 'Kolme päivää sitten';
	
}

?>