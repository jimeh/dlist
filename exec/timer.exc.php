<?php die();

//
//  Exec: timer
//
//  Copyright © 2006 Jim Myhrberg. All rights reserved.
//  zynode@gmail.com
//


/*

	Intializes $timer at beginning of exec code, use
	$timer->end(); in your template to get script
	execution time.

*/


//_HEAD;
/* --- Configuration ---
Name: timer
Priority: 10
Author: Jim Myhrberg
*/
//_SCRIPT;

//==========================
//>STAGE> init
//==========================


//>Section> start
$timer = new speedometer();


//_END;
?>