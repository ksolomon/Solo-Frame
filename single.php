<?php get_header(); ?>

		<!-- content -->
		<section id="content" class="content">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<!-- Navigation -->
					<?php sf_display_nav(); ?>

					<!-- Individual Post Styling -->
					<article <?php post_class(); ?> id="entry-<?php the_ID(); ?>">
						<h2 class="pagetitle"><?php the_title(); ?></h2>
						<div class="postmeta">
							Posted <?php the_time('F jS, Y') ?> &nbsp; &mdash; &nbsp; Filed under <?php the_category(', ') ?><br />
							Tagged <?php the_tags('', ', ') ?> &nbsp; &mdash; &nbsp; <?php comments_number('No Comments', '1 Comment', '% Comments' );?> <?php edit_post_link('Edit this post', '&nbsp; &mdash; &nbsp; <small>', '</small>'); ?>
						</div>

						<?php the_content("Continue reading " . the_title('', '', false)); ?>

						<div class="clear"></div>

						<?php wp_link_pages(array('before' => '<div class="page-link">Pages:', 'after' => '</div>')); ?>
					</article>

					<div id="comments">
						<?php comments_template('', true); ?>
					</div>
				<?php endwhile; ?>
					<!-- Navigation -->
					<?php sf_display_nav("numbar"); ?>
				<?php else : ?>
					<!-- No Posts Found -->
					<div class="entry" id="entry-err">
						<h2 class="pagetitle">Post not found.</h2>
					</div>
			<?php endif; ?>
		</section>
		<!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>