<?php

class lang {
	
/*

	Language: Finnish
	Translation by Eric Hartin (a.k.a. Fraeon).
   http://www.fraeport.net/

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

	// Language settings
	var $_language = 'suomi'; // local language name ("svenska" for swedish)...
	var $_version = '1.0.8';


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
	var $preview  = 'Preview'; //TODO translate this

	var $timer_string = 'Sivu on syljetty ulos %s:ssa sekunnissa';

	var $powered_by = 'Tämä sivusto käyttää dListiä';
	
	
	// Option titles
	var $opt_language = 'Language'; //TODO translate
	var $opt_sort_by  = 'Sort by'; //TODO translate
	var $opt_ascending  = 'Ascending'; //TODO translate
	var $opt_descending = 'Descending'; //TODO translate
	var $opt_sort       = 'Sort'; //TODO translate


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