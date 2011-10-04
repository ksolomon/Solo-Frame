<?php
/*
	Solo-Frame Custom excerpts functions
	
	This file is a part of the Solo-Frame WordPress theme framework.
*/

function sf_fix_excerpt($text) {
	return str_replace('[...]', '<br /><a class="more-link" href="'. get_permalink($post->ID) . '">Read More&hellip;</a>', $text);  
}

function sf_excerpt_length($length) {
	return 50;
}

add_filter('excerpt_length', 'sf_excerpt_length');

add_filter('the_excerpt', 'sf_fix_excerpt');

add_filter('get_the_excerpt', 'sf_fix_excerpt');
?>