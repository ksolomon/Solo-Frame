<?php get_header(); ?>

		<!-- content -->
		<section id="content" class="content">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<!-- Individual Post Styling -->
					<article <?php post_class(); ?> id="entry-<?php the_ID(); ?>">
						<h2 class="pagetitle"><a href="<?php the_permalink() ?>" rel="bookmark" title='Click to read: "<?php strip_tags(the_title()); ?>"'><?php the_title(); ?></a></h2>
						<div class="postmeta">
							Posted <?php the_time('F jS, Y') ?> &nbsp; &mdash; &nbsp; Filed under <?php the_category(', ') ?><br />
							Tagged <?php the_tags('', ', ') ?> &nbsp; &mdash; &nbsp; <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> <?php edit_post_link('Edit this post', '&nbsp; &mdash; &nbsp; <small>', '</small>'); ?>
						</div>

						<?php the_content("Continue reading " . the_title('', '', false)); ?>

						<div class="clear"></div>
					</article>
				<?php endwhile; ?>
					<!-- Navigation -->
					<?php sf_display_nav(); ?>
				<?php else : ?>
					<!-- No Posts Found -->
					<section class="entry" id="entry-err">
						<h2 class="pagetitle">Post not found.</h2>
					</section>
			<?php endif; ?>
		</section>
		<!-- /content -->

<?php get_sidebar(); ?>
		
<?php get_footer(); ?>