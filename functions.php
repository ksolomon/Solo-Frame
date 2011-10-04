<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'functions.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
		die ('No access!');
	}

	// Theme framework setup
	define('LIBPATH',TEMPLATEPATH.'/includes/');

	$themename = "Solo-Frame";
	$shortname = "sf";

	include (LIBPATH.'theme_options.php');

	// Load framework libraries
	// Generic functions
	require (LIBPATH.'library.php');

	// Widgets
	require (LIBPATH.'widgets.php');

	// Custom excerpt functions
	require (LIBPATH.'excerpts.php');

	// Custom comment functions
	require (LIBPATH.'comments.php');

	// Custom search functions
	require (LIBPATH.'search.php');

	// Per-post/page <head> meta tags via custom fields
	require (LIBPATH.'head_meta.php');

	// Drag & drop page ordering
	require (LIBPATH.'pageorder.php');

	// Sitemap generator
	require (LIBPATH.'sitemap_generator.php');

	// Widget Logic plugin
	require (LIBPATH.'widget_logic.php');
?>