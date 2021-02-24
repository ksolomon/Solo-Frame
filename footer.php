<?php include (TEMPLATEPATH.'/includes/get_theme_options.php'); ?>

						<!-- footer -->
						<div id="footer">
							<div id="footer-credits" class="left"><?php sf_copyright(); ?></div>

							<div id="footer-meta" class="right"><a href="http://wordpress.org">Powered by WordPress</a></div>

							<div class="clear"></div>
						</div>
						<!-- /footer -->
					</div>
					<!-- /wrapper -->
				</div><!-- /st-content-inner -->
			</div><!-- /st-content -->
		</div><!-- /st-pusher -->
	</div><!-- /st-container -->

	<script src="<?php bloginfo('template_url'); ?>/includes/scripts.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/includes/classie.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/includes/sidebarEffects.js"></script>

	<?php if ($sf_settings['sf_analytics']) { echo html_entity_decode($sf_settings['sf_analytics'])."\n"; } ?>

	<!-- Plugin Hook -->
	<?php wp_footer(); ?>
</body>
</html>
