<?php
/*
	Solo-Frame Custom excerpts functions
	
	This file is a part of the Solo-Frame WordPress theme framework.
*/

function sf_more_link() {
	return '<br /><a href="'. esc_url(get_permalink()) . '">Read More &raquo;</a>';
}

function sf_fix_excerpt($more) {
	return sf_more_link();
}

function sf_excerpt_more($output) {
	$output .= sf_more_link();
}

function sf_excerpt_length($length) {
	return 50;
}

add_filter('get_the_excerpt', 'sf_excerpt_more',1);

add_filter('excerpt_length', 'sf_excerpt_length',1);

add_filter('excerpt_more', 'sf_fix_excerpt',1);
?>
