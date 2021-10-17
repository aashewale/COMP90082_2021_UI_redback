<?php
require_once('../../../wp-load.php');

$id = $_POST['id'];
$author = $_POST['author'];
$title = $_POST['title'];
$reportname = $_POST['name'];
$reportmsg = $_POST['msg'];

global $wpdb;

// add report details to table
$results = $wpdb->insert('wp_aphasia_feedback', array(
	'report_id' => null,
	'post_id' => $id,
	'author_id' => $author,
	'post_title' => $title,
	'report_user' => $reportname,
	'report_message' => $reportmsg,
));

//update user_is_unsure in post meta
update_post_meta( $id, 'user_is_unsure', '1' );

//add notifications
$post = get_post($id);
$author_id = $post->post_author;
do_action('custom_hooks', $post->ID, $author_id);


