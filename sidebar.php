<!-- sidebar -->
<aside id="sidebar" class="sidebar">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Primary Sidebar')) : else : ?>
		<section class="widgetblock" id="search">
			<h3 class="widgettitle">Site Search</h3>

			<?php get_search_form(); ?>
		</section>

		<section class="widgetblock" id="pages">
			<h3 class="widgettitle">Pages</h3>

			<ul>
				<?php wp_list_pages('title_li='); ?>
			</ul>
		</section>

		<section class="widgetblock" id="categories">
			<h3 class="widgettitle">Categories</h3>

			<ul>
				<?php wp_list_categories('title_li='); ?>
			</ul>
		</section>

		<section class="widgetblock" id="archives">
			<h3 class="widgettitle">Archives</h3>

			<ul>
				<?php wp_get_archives('type=monthly&limit=12&show_post_count=1'); ?>
			</ul>
		</section>

		<section class="widgetblock" id="calendar">
			<h3 class="widgettitle">Calendar</h3>

			<?php get_calendar(); ?>
		</section>
	<?php endif; ?>
</aside>
<!-- /sidebar -->