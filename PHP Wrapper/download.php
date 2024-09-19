<?php 

$file = $_GET['fid'];
$type = @filetype($file);
header('Content-type: '.$type);
header('Content-Disposition: attachment; filename="'.$file.'"');

include $file;

?>