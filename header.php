<!doctype html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if (is_single() || is_page()) { ?> <link rel="canonical" href="<?php the_permalink(); ?>" /> <?php } ?>

	<?php wp_head(); ?>

	<!-- Global style reset and WP basic styles -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/reset.css?v=<?php echo filemtime(TEMPLATEPATH . '/css/reset.css'); ?>" media="screen, projection" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/wp.css?v=<?php echo filemtime(TEMPLATEPATH . '/css/wp.css'); ?>" media="screen, projection" />

	<!-- Theme-specific style -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css?v=<?php echo filemtime(TEMPLATEPATH . '/style.css'); ?>" media="screen, projection" />

	<!-- Mobile styles -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/responsive.css?v=<?php echo filemtime(TEMPLATEPATH . '/css/responsive.css'); ?>" media="screen, projection" />
</head>

<body <?php body_class(); ?>>
	<!-- wrapper -->
	<div id="wrapper">
		<header id="header" role="banner" class="pad">
			<hgroup id="logo">
				<h1 id="site-name"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>

			<nav id="nav" role="navigation">
				<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
			</nav>
		</header>
