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
