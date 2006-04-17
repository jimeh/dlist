<?php

class lang {

	// Language settings
	var $_language = 'english'; // local language name ("svenska" for swedish)...
	var $_version = '1.0.7';
	

	// Locale settings
	var $_locale = array('eng', 'en_US');


	// General strings
	var $index_of = 'Index of';
	var $parent_dir = 'Parent Directory';
	
	var $name     = 'Name';
	var $size     = 'Size';
	var $mtime    = 'Date Modified';
	var $atime    = 'Last Accessed';
	var $perms    = 'Permissions';
	var $chmod    = 'CHMOD';
	var $owner    = 'Owner';
	var $group    = 'Group';
	var $owner_id = 'Owner ID';
	var $group_id = 'Group ID';
	var $type     = 'Type';
	var $ext      = 'Extension';
	
	var $icons    = 'Icons';
	var $details  = 'Details';
	
	var $timer_string = 'Page generated in %s seconds'; // %s = seconds
	
	var $powered_by = 'Powered by dList';
	
	
	// Statistics
	var $stats_folder    = '%n folder';
	var $stats_folders   = '%n folders';
	var $stats_file      = '%n file';
	var $stats_files     = '%n files';
	var $stats_totalsize = '%s in %f';	// %s = size, %f = number of files
	var $stats_template  = '%d, %f';		// %d = folders, %f = files
	
	
	// Date Formatting
	# check the PHP Manual for strftime() for details (http://www.php.net/manual/)
	var $standard_date_format = '%B %e, %Y, %H:%M';
	# Smart Date formatting
	var $sd_format       = '{date}, {time}';
	var $sd_date         = '%B %e, %Y';
	var $sd_time         = '%H:%M';
	
	
	// Smart Date
	var $sd_tomorrow   = 'Tomorrow';
	var $sd_today      = 'Today';
	var $sd_yesterday  = 'Yesterday';
	var $sd_2_days_ago = '2 days ago';
	var $sd_3_days_ago = '3 days ago';
	
}

?>