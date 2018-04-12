<?php
/*
	Solo-Frame Custom head META tags

	This file is a part of the Solo-Frame WordPress theme framework.
*/

// PHP ternary: $var = (if clause) ? if true : if false

function head_meta() {
	include (LIBPATH.'get_theme_options.php');

	$default_blog_desc = ($sf_settings['sf_blog_desc']) ? $sf_settings['sf_blog_desc'] : '';
	$default_blog_kw = ($sf_settings['sf_blog_kw']) ? $sf_settings['sf_blog_kw'] : '';

	$post_desc_length  = ($sf_settings['sf_blog_desc_len']) ? $sf_settings['sf_blog_desc_len'] : 20; // description length in # words for post/Page
	$post_use_excerpt  = ($sf_settings['sf_blog_desc_exc']) ? $sf_settings['sf_blog_desc_exc'] : 0; // 0 (zero) to force content as description for post/Page
	$custom_desc_key   = 'description'; // custom field key; if used, overrides excerpt/content
	$custom_kw_key   = 'keywords'; // custom field key; if used, overrides excerpt/content

	global $cat, $cache_categories, $wp_query, $wp_version;

	if (is_single() || is_page()) {
		$post = $wp_query->post;
		$post_custom = get_post_custom($post->ID);
		$custom_desc_value = $post_custom["$custom_desc_key"][0];
		$custom_kw_value = $post_custom["$custom_kw_key"][0];

		if ($custom_kw_value) {
			$keywords = $custom_kw_value;
		} else {
			$posttags = get_the_tags();
			if ($posttags) {
				foreach ($posttags as $tag) {
					$keywords .= $tag->name.',';
				}
			}
		}

		if ($custom_desc_value) {
			$text = $custom_desc_value;
		} elseif ($post_use_excerpt) {
			$text = strip_shortcodes($post->post_excerpt);
		} else {
			$text = strip_shortcodes($post->post_content);
		}

		$text = str_replace(array("\r\n", "\r", "\n", "  "), " ", $text);
		$text = str_replace(array("\""), "", $text);
		$text = trim(strip_tags($text));
		$text = explode(' ', $text);

		if (count($text) > $post_desc_length) {
			$l = $post_desc_length;
			$ellipsis = '...';
		} else {
			$l = count($text);
			$ellipsis = '';
		}

		$description = '';

		for ($i=0; $i<$l; $i++)
			$description .= $text[$i] . ' ';

		$description .= $ellipsis;
	} elseif (is_category()) {
		$category = $wp_query->get_queried_object();
		$description = trim(strip_tags($category->category_description));
	} else {
		$description = (empty($default_blog_desc)) ? trim(strip_tags(get_bloginfo('description'))) : $default_blog_desc;
		$keywords = $default_blog_kw;
	}

	global $post;

	$url = get_permalink();
	$title = get_the_title();
	$imageArr = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
	$image = $imageArr[0];

	echo "<!-- Meta tags built by Solo-Frame -->\n";

	echo "<meta property=\"og:url\" content=\"$url\" />\n";
	echo "<meta property=\"og:title\" content=\"$title\" />\n";

	if ($image)
		echo "<meta property=\"og:image\" content=\"$image\"/>\n";

	if ($keywords)
		echo "<meta name=\"keywords\" content=\"$keywords\" />\n";

	if ($description) {
		echo "<meta name=\"description\" content=\"$description\" />\n";
		echo "<meta property=\"og:description\" content=\"$description\" />\n";
	}
}

add_action('wp_head', 'head_meta');
?>
