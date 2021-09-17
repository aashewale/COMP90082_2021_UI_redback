<?php
require_once('../../../wp-load.php');

$id = $_POST['id'];

$field = $_POST['field'];

global $wpdb;
$result = $wpdb->get_results('SELECT '.$field.' FROM wp_posts WHERE ID =  '.$id);
foreach($result as $row) {
    $val = $row->$field;
}

echo $val;

?>