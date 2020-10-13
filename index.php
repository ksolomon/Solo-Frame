<?php get_header(); ?>

		<!-- content -->
		<section id="content" class="content">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<!-- Individual Post Styling -->
					<article <?php post_class(); ?> id="entry-<?php the_ID(); ?>">
                        <h2 class="pagetitle"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(array('before' => 'Permalink to: ', 'after' => '')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

						<div class="postmeta">
							<?php if (is_sticky()) : ?><h3 class="featured">Featured</h3><?php endif; ?>
							Posted <?php the_time('F jS, Y') ?> &nbsp; &mdash; &nbsp; Filed under <?php the_category(', ') ?><br />
							Tagged <?php the_tags('', ', ') ?> <?php if (comments_open() && !post_password_required()) : ?>&nbsp; &mdash; &nbsp; <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?><?php endif; ?> <?php edit_post_link('Edit this post', '&nbsp; &mdash; &nbsp; <small>', '</small>'); ?>
						</div>

						<?php the_content("Continue reading " . the_title('', '', false)); ?>

						<?php wp_link_pages(array('before' => '<div class="page-link"><span>Pages: </span>', 'after' => '</div>')); ?>

						<div class="clear"></div>
					</article>
				<?php endwhile; ?>
					<!-- Navigation -->
					<?php if ($wp_query->max_num_pages > 1) : ?>
						<?php sf_display_nav("numbar"); ?>
					<?php endif; ?>
				<?php else : ?>
					<!-- No Posts Found -->
					<section id="post-0" class="post error404 not-found">
						<h2 class="pagetitle">No news yet.</h2>
						<p>There's nothing here yet.  Check back later.</p>
					</section>
			<?php endif; ?>
		</section>
		<!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>