<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'functions.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
		die ('No access!');
	}

	// Theme framework setup
	define('LIBPATH',TEMPLATEPATH.'/includes/');

	$themename = "SoloFrame";
	$shortname = "sf";

	include (LIBPATH.'theme_options.php');

	// Delete core pages, add new pages, and set up static front page
	include (LIBPATH.'activation.php');

	// Load framework libraries
	// Generic functions
	require (LIBPATH.'library.php');

	// Custom post types and taxonomies
	require (LIBPATH.'post-types.php');

	// Widgets positions
	require (LIBPATH.'widgets.php');

	// Custom excerpt functions
	require (LIBPATH.'excerpts.php');

	// Custom comment functions
	require (LIBPATH.'comments.php');

	// Custom search functions
	require (LIBPATH.'search.php');

	// Per-post/page <head> meta tags via custom fields
	require (LIBPATH.'head_meta.php');

	// Widget Logic plugin
	require (LIBPATH.'widget_logic.php');

	// Show Active Template plugin
	require (LIBPATH.'show-template.php');
?>