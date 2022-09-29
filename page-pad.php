<?php /* Template Name: Padded Page with Sidebar */ ?>

<?php get_header(); ?>

		<!-- content -->
		<div id="content" class="pad">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<!-- Individual Post Styling -->
					<div class="entry" id="entry-<?php the_ID(); ?>">
						<h2 class="PageTitle"><?php the_title(); ?></h2>

						<?php the_content("Continue reading " . the_title('', '', false)); ?>

						<div class="clear"></div>
					</div>
				<?php endwhile; else : ?>
					<!-- No Posts Found -->
					<div class="entry" id="entry-err">
						<h2 class="PageTitle">Page not found.</h2>
					</div>
			<?php endif; ?>
		</div>
		<!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>