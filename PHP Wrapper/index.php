<?php


// $input_data = file_get_contents('php://input');
// $input_data = file_get_contents('php://filter/convert.base64-encode/resource=index.php');
// $input_data = file_get_contents('data://text/plain;base64,' . base64_encode(file_get_contents('php://filter/convert.base64-encode/resource=index.php')));

$input_data = file_get_contents('php://filter/convert.base64-encode/resource=/var/www/html/index.php');


echo $input_data;

