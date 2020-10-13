<?php
/*
	Solo-Frame Custom excerpts functions

	This file is a part of the Solo-Frame WordPress theme framework.

	On Theme Activation adds Home and News pages, sets up reading options for front page and posts page, and erases sample page and post
*/

if (isset($_GET['activated']) && is_admin()) {
	// Set Blog Description to nothing
	update_option('blogdescription', '');

	// Create pages for Home and News
	$home_title = 'Home';
	$home_content = 'Front page content';
	$news_title = 'News';
	$news_content = 'Posts will display on this page';

	$home_check = get_page_by_title($home_title);
	$news_check = get_page_by_title($news_title);

	$home = array(
		'post_type' => 'page',
		'post_title' => $home_title,
		'post_content' => $home_content,
		'post_status' => 'publish',
		'post_author' => 1,
		'menu_order' => 10,
	);

	$news = array(
		'post_type' => 'page',
		'post_title' => $news_title,
		'post_content' => $news_content,
		'post_status' => 'publish',
		'post_author' => 1,
		'menu_order' => 10,
	);

	if (!isset($home_check->ID)) {
		$home_id = wp_insert_post($home);
	}

	if (!isset($news_check->ID)) {
		$news_id = wp_insert_post($news);
	}

	// Set front page to use our page
	$home_id = get_page_by_title('Home');
	$home_id = $home_id->ID;
	update_option('show_on_front', 'page');
	update_option('page_on_front', $home_id);

	// Set the news page
	$news_id = get_page_by_title('News');
	$news_id = $news_id->ID;
	update_option('page_for_posts', $news_id);

	// Trash the samples
	wp_delete_post(1,TRUE);
	wp_delete_post(2,TRUE);
}
?>