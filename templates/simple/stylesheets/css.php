<?php

header('Content-type: text/css;');
$dir = ( empty($dir) && !empty($_REQUEST['dir']) ) ? $_REQUEST['dir'] : '' ;
if ( !empty($_REQUEST['src']) && preg_match("/\.css$/", $_REQUEST['src']) ) include($_REQUEST['src']);

?>