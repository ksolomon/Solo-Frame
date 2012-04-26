<?php
/*
	Solo-Frame Widgets Functions
	
	This file is a part of the Solo-Frame WordPress theme framework.
*/

function sf_register_widgets() {
	register_sidebar(array(
		'name'=>'Primary Sidebar',
		'id' => 'primary',
		'description' => 'Sidebar widget area for regular pages.',
		'before_widget' => '<div class="widgetblock %2$s" id="%1$s" >',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
}

add_action('init', 'sf_register_widgets');
?>