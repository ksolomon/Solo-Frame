<?php
/*
	Template Name: Home
*/
?>

<?php get_header(); ?>

		<!-- content -->
		<section id="content" class="content">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<!-- Individual Post Styling -->
					<article <?php post_class(); ?> id="entry-<?php the_ID(); ?>">
						<h2 class="pagetitle"><?php the_title(); ?></h2>

						<?php the_content("Continue reading " . the_title('', '', false)); ?>

						<div class="clear"></div>
					</article>
				<?php endwhile; else : ?>
					<!-- No Posts Found -->
					<section id="post-0" class="post error404 not-found">
						<h2 class="pagetitle">Post not found.</h2>
						<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
						<?php get_search_form(); ?>
					</section>
			<?php endif; ?>
		</section>
		<!-- /content -->

<?php get_sidebar(); ?>
		
<?php get_footer(); ?>