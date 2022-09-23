<?php include (TEMPLATEPATH.'/includes/get_theme_options.php'); ?>

		<!-- footer -->
		<div id="footer">
			<div id="footCredits" class="left"><p><?php sf_copyright(); ?></p></div>

			<nav id="footNav" class="right" role="navigation">
				<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
			</nav>

			<div class="clear"></div>
		</div>
		<!-- /footer -->
	</div>
	<!-- /wrapper -->

	<script src="<?php bloginfo('template_url'); ?>/includes/scripts.js"></script>

	<?php if ($sf_settings['sf_analytics']) { echo html_entity_decode($sf_settings['sf_analytics'])."\n"; } ?>

	<!-- Plugin Hook -->
	<?php wp_footer(); ?>
</body>
</html>
