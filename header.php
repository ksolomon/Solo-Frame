<!doctype html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css?v=<?php echo filemtime(TEMPLATEPATH . '/style.css'); ?>" media="screen, projection" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/mobile-nav.css?v=<?php echo filemtime(TEMPLATEPATH . '/css/mobile-nav.css'); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/responsive.css?v=<?php echo filemtime(TEMPLATEPATH . '/css/responsive.css'); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/print.css" media="print" />
	<!--[if lte IE 9]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie7.css" media="screen, projection" /><![endif]-->

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if (is_single() || is_page()) { ?> <link rel="canonical" href="<?php the_permalink(); ?>" /> <?php } ?>

	<?php wp_head(); ?>

	<script src="<?php bloginfo('template_url'); ?>/includes/flexibility.js"></script>

	<!-- HTML5 Shim for older IE versions -->
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body <?php body_class(); ?>>
	<div id="st-container" class="st-container">
		<!-- content push wrapper -->
		<div class="st-pusher">
			<nav class="st-menu st-effect-3" id="menu-3">
				<!-- menu content -->
				<h2 class="icon icon-lab">Menu</h2>

				<?php
				wp_nav_menu( array(
					'theme_location'    => 'mobile',
					'depth'             => 2,
					'container'         => 'div',
					'container_class'   => 'collapse navbar-collapse navbar-1-collapse',
					'menu_class'        => 'nav navbar-nav',
					'fallback_cb'       => 'sf_navwalker::fallback',
					'walker'            => new sf_navwalker())
				);
				?>
			</nav>

			<div id="st-trigger-effects"><button data-effect="st-effect-3">Menu</button></div>

			<div class="st-content"><!-- this is the wrapper for the content -->
				<div class="st-content-inner"><!-- extra div for emulating position:fixed of the menu -->
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
