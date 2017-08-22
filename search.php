<?php get_header(); ?>

		<!-- content -->
		<div id="content" class="content">
			<?php if (have_posts()) : ?>
				<h2 class="pagetitle">Search Results for "<em><?php the_search_query() ?></em>"</h2>

				<!-- Navigation -->
				<?php sf_display_nav(); ?>

				<?php while (have_posts()) : the_post(); ?>
					<!-- Individual Post Styling -->
					<div class="entry" id="entry-<?php the_ID(); ?>">
						<?php
							$title = get_the_title();
							$keys = explode(" ",$s);
							$title = preg_replace('/('.implode('|', $keys) .')/iu',
								'<strong class="search-term">\0</strong>',
								$title);
						?>

						<h2 class="pagetitle"><a href="<?php the_permalink() ?>" rel="bookmark" title='Click to read: "<?php strip_tags(the_title()); ?>"'><?php the_title(); ?></a></h2>
						<div class="postmeta">
							Posted <?php the_time('F jS, Y') ?> &nbsp; &mdash; &nbsp; Filed under <?php the_category(', ') ?><br />
							Tagged <?php the_tags('', ', ') ?> &nbsp; &mdash; &nbsp; <?php comments_number('No Comments', '1 Comment', '% Comments' );?> <?php edit_post_link('Edit this post', '&nbsp; &mdash; &nbsp; <small>', '</small>'); ?>
						</div>

						<?php the_excerpt(); ?>

						<div class="clear"></div>
					</div>
				<?php endwhile; ?>
					<!-- Navigation -->
					<?php if ($wp_query->max_num_pages > 1) : ?>
						<?php sf_display_nav("numbar"); ?>
					<?php endif; ?>
				<?php else : ?>
					<!-- No Posts Found -->
					<h2 class="pagetitle">No results found.</h2>

					<p>Sorry, but we were unable to find any posts matching your criteria, please try your search again.  If you are still unable to find what you're looking for, please try browsing our archives.  You can also <a href="<?php bloginfo('url'); ?>">return home</a>.</p>
			<?php endif; ?>
		</div>
		<!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>