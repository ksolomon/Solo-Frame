<?php include (TEMPLATEPATH.'/includes/get_theme_options.php'); ?>

		<!-- footer -->
		<div id="footer">
			<?php if ($sf_footer_text) { ?>
				<p id="footer-credits" class="left"><?php echo $sf_footer_text; ?></p>
			<?php } else { ?>
				<p id="footer-credits" class="left"><?php sf_copyright(); ?></p>

				<ul id="footer-meta" class="right">
					<li><a href="http://wordpress.org">Powered by WordPress</a></li>
				</ul>
			<?php } ?>

			<!-- Plugin Hook -->
			<?php wp_footer(); ?>

			<div class="clear"></div>
		</div>
		<!-- /footer -->
	</div>
	<!-- /wrapper -->

	<script src="<?php bloginfo('template_url'); ?>/includes/scripts.js"></script>

	<?php if ($sf_analytics) { echo $sf_analytics; } ?>
</body>
</html>
