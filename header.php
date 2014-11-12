<!doctype html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />

	<title><?php sf_generate_title_tag(); ?></title>

	<!-- Source Sans font from Google Fonts API -->
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600italic,600' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css?v=<?php echo filemtime(TEMPLATEPATH . '/style.css'); ?>" media="screen, projection" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/lemonade.css?v=<?php echo filemtime(TEMPLATEPATH . '/css/lemonade.css'); ?>" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/print.css" media="print" />
	<!--[if lt IE 9]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie7.css" media="screen, projection" /><![endif]-->

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if (is_single() || is_page()) { ?> <link rel="canonical" href="<?php the_permalink(); ?>" /> <?php } ?>

	<?php wp_head(); ?>

	<!-- HTML5 Shim for older IE versions -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body <?php body_class(); ?>>
	<!-- wrapper -->
	<div id="wrapper" class="frame">
		<header id="header" role="banner">
			<hgroup id="logo">
				<h1 id="site-name"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>

			<nav id="nav" role="navigation">
				<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
			</nav>
		</header>
