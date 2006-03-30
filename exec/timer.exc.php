<?php die();

//
//  Exec: timer
//
//  Copyright © 2006 Jim Myhrberg. All rights reserved.
//  zynode@gmail.com
//

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


//==========================
//>STAGE> render
//==========================


//>Section> end
$timer->end();

//_END;
?>