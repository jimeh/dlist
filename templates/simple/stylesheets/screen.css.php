<?php header('Content-type: text/css;'); ( empty($dir) && !empty($_REQUEST['dir']) ) ? $dir = $_REQUEST['dir'] : $dir = '' ; ?>
BODY {
	background-color: #FFF;
	color: #000;
	font: 11px "Lucida Grande", Tahoma, Verdana, sans-serif;
	margin: 0xp;
	padding: 18px;
}

#header {
	font: 20px "Myriad Pro", "Trebuchet MS", Verdana, sans-serif;
	padding: 15px 15px 30px 30px;
}
#header A {
	color: #000;
	text-decoration: none;
}
#header A:hover {
	text-decoration: underline;
}

#files {
	
}
/* <?=$dir?> */
/* Details View (#list) */
#list {
	background-color: #DDD;
	width: 100%;
}

/* list leaders */
#list TH {
	background-color: #EEE;
	padding: 2px 5px 2px 5px;
}
#list TH.name {
	text-align: left;
}
#list TH.icon {
	padding: 2px;
	height: 16px;
	width: 16px;
}
#list TH.size {
	width: 75px;
}
#list TH.mtime {
	width: 170px;
}
#list TH.atime {
	width: 170px;
}
#list TH.perms {
	width: 100px;
}
#list TH.owner {
	width: 85px;
}
#list TH A {
	color: #000;
	display: block;
	width: 100%;
	text-decoration: none;
}

/* list cells */
#list TD {
	background-color: #FFF;
	padding: 2px 5px 2px 5px;
}
#list TD.icon {
	padding: 2px;
}
#list TD.size {
	text-align: right;
}
#list TD.mtime {
	text-align: right;
}
#list TD.atime {
	text-align: right;
}
#list TD.perms {
	text-align: right;
}
#list TD.owner {
	text-align: right;
}
#list TD.name A {
	color: #000;
	display: block;
	width: 100%;
	text-decoration: none;
}
#list TD.name A:hover {
	text-decoration: underline;
}
#list TD.name A:visited {
	color: #555;
}


/* Icon view */
#icons {
	border: 1px solid #CCC;
	width: 100%;
}
#icons UL {
	list-style: none;
	margin-top: 5px;
	padding: 10px;
}
#icons UL A {
	color: #000;
	text-decoration: none;
}
#icons LI {
	display: block;
	float: left;
	margin: 12px 12px 12px 12px;
	width: 140px;
	height: 100px;
	text-align: center;
	vertical-align: top;
}
#icons LI .icon {
	display: block;
	padding: 0px;
	margin: 0px;
	height: 48px;
}
#icons LI .name {
	display: block;
	font-size: 12px;
	font-weight: bold;
	padding-top: 6px;
	margin: 0px;
}
#icons LI .info {
	color: #999;
	display: block;
	font-size: 10px;
	margin: 0px;
}
#sort-nav {
	color: #999;
	text-align: center;
	margin: 20px 20px 0px 20px;
}
#sort-nav A {
	color: #777;
	text-decoration: none;
}
#sort-nav A:hover {
	text-decoration: underline;
}
#sort-nav A.current {
	font-weight: bold;
}


/* misc. */
#view-nav {
	color: #999;
	font-size: 10px;
	position: absolute;
	top: 80px;
	left: 30px;
}
#view-nav A {
	color: #999;
	font-size: 10px;
	text-decoration: none;
}

#stats {
	
}

#server-info {
	color: #999;
	padding: 3px;
	font-style: italic;
	font-size: 9px;
	text-align: right;
	position: absolute;
	top: 77px;
	right: 30px;
}

#timer {
	color: #999;
	padding: 3px;
	font-style: italic;
	font-size: 9px;
	text-align: left;
	float: left;
}

#lang-select {
	color: #BBB;
	padding: 3px;
	font-style: italic;
	font-size: 9px;
	float: right;
}
#lang-select A {
	color: #BBB;
	text-decoration: none;
}
#lang-select A:hover {
	text-decoration: underline;
}




