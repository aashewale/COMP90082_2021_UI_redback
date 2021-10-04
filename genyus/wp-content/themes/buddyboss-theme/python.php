<?php

ini_set('set_time_limit', 6000);
//#var_dump($_POST);
$temp = $_POST['post_content'];
//
$handle = popen('/Users/alishashewale/opt/anaconda3/bin/python python.py '.$temp, 'r');
$input = fread($handle, 1024);
$output = substr($input, strpos($input, 'Final Text'));
echo $output;
//#var_dump($output);
pclose($handle);
?>