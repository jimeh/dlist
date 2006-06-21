<?php

class lang {
	
/*

	Language: Swedish

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
	var $_language = 'svenska'; // local language name ("svenska" for swedish)...
	var $_version = '1.0.8';
	
	
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
	var $preview  = 'Förhandsgranskning';
	
	var $timer_string = 'Sidan genererades på %s sekunder'; // %s = seconds
	
	var $powered_by = 'Driven av dList';
	
	
	// Option titles
	var $opt_language = 'Språk';
	var $opt_sort_by  = 'Sortera efter';
	var $opt_ascending  = 'A-Z';
	var $opt_descending = 'Z-A';
	var $opt_sort       = 'Sortera';
	
	
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