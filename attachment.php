<?php get_header(); ?>

		<!-- content -->
		<div id="content" class="content">
			<h2 class="pagetitle">Gallery Image</h2>

			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<!-- Individual Post Styling -->
					<div class="entry" id="entry-<?php the_ID(); ?>">
						<a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image($post->ID, 'full'); ?></a>

						<div id="nav-below" class="navigation">
							<div class="left"><?php previous_image_link(array(65,65)); ?></div>
							<div class="right"><?php next_image_link(array(65,65)); ?></div>
						</div><!-- #nav-below -->
					</div>

					<?php sf_display_nav(); ?>
				<?php endwhile; else : ?>
					<!-- No Posts Found -->
					<div class="entry" id="entry-err">
						<h2 class="pagetitle">Image not found.</h2>
					</div>
			<?php endif; ?>
		</div>
		<!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>