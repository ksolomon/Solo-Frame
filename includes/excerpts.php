<?php
/*
	Solo-Frame Custom excerpts functions
	
	This file is a part of the Solo-Frame WordPress theme framework.
*/

function sf_fix_excerpt($more) {
	return '<br /><a class="more-link" href="'. get_permalink($post->ID) . '">Read More &raquo;</a>';
}

function sf_excerpt_length($length) {
	return 50;
}

add_filter('excerpt_length', 'sf_excerpt_length');

add_filter('excerpt_more', 'sf_fix_excerpt');
?>
