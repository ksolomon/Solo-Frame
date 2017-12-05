<?php
/*
	Solo-Frame Generic Function Library

	This file is a part of the Solo-Frame WordPress theme framework.
*/

// Disable Admin Bar
add_filter('show_admin_bar', '__return_false');

// Enqueue jQuery
wp_enqueue_script("jquery");

// Add theme support features
add_theme_support('automatic_feed_links');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('html5', array('comment-list', 'comment-form', 'gallery', 'search-form'));

// Set up shortcode support for text widgets
add_filter('widget_text', 'do_shortcode');

// Menu Support
register_nav_menus(array(
	'primary' => 'Main Navigation',
	'mobile' => 'Mobile Navigation',
));

// Post thumbnails
set_post_thumbnail_size(96, 96, true);

function sf_thumbs() {
    if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
	    // If WordPress 2.9 or above and a Post Thumbnail has been specified
        the_post_thumbnail('thumbnail', array('alt' => ''.get_the_title().''));
    } else {
	    // Or if Post Thumbnail image hasn't been specified
        echo '<img src="'.get_bloginfo('template_url').'/images/placeholder.png" alt="'.get_the_title().'" />';
    }
}

// Make captions responsive
function sf_responsive_caption($val, $attr, $content = null) {
	extract(shortcode_atts(array(
		'id' => '',
		'align' => '',
		'width' => '',
		'caption' => ''
		), $attr
	));

	if (1 > (int) $width || empty($caption) )
		return $val;

	$new_caption = sprintf('<div id="%1$s" class="wp-caption %2$s" style="max-width:100%% !important;height:auto;width:%3$dpx;">%4$s<p class="wp-caption-text">%5$s</p></div>',
		esc_attr($id),
		esc_attr($align),
		(10 + (int) $width),
		do_shortcode($content),
		$caption
	);

	return $new_caption;
}

add_filter('img_caption_shortcode', 'sf_responsive_caption', 10, 3);

// Make embeds responsive
function div_wrapper($content) {
    // match any iframes
    $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        // wrap matched iframe with div
        $wrappedframe = '<div class="embed">' . $match . '</div>';

        //replace original iframe with new in content
        $content = str_replace($match, $wrappedframe, $content);
    }

    return $content;
}

add_filter('the_content', 'div_wrapper');

// Generate title tag with extra SEO love.  Wrap function call in header.php with <title></title>.
function sf_generate_title_tag() {
	if (is_single()) : bloginfo('name'); wp_title('|', true, 'left');
		echo (' - ');
		echo bloginfo('description');

	elseif (is_page() || is_paged()) : bloginfo('name');
		wp_title('|', true, 'left'); echo (' - ');
		echo bloginfo('description');

	elseif (is_author()) : bloginfo('name');
		echo (' | '); wp_title('Archives for ', true, 'right');
		echo (' - ');
		echo bloginfo('description');

	elseif (is_archive()) : bloginfo('name');
		echo (' | '); wp_title('Archives for ', true, 'right');
		echo (' - ');
		echo bloginfo('description');

	elseif (is_search()) : bloginfo('name');
		echo (' | '); wp_title('Search Results ', true, 'right');
		echo (' - ');
		echo bloginfo('description');

	elseif (is_404()) : bloginfo('name');
		echo (' | '); wp_title('Page Not Found ', true, 'right ');
		echo (' - ');
		echo bloginfo('description');

	else : bloginfo('name'); echo '&nbsp;'; wp_title('&raquo;', true, 'right');
		echo (' - ');
		echo bloginfo('description');
	endif;
}

// Core navigation functions
function sf_corenav() {
	global $wp_query, $wp_rewrite;

	$pages = '';
	$max = $wp_query->max_num_pages;

	if (!$current = get_query_var('paged')) $current = 1;

	$a['base'] = ($wp_rewrite->using_permalinks()) ? user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged') : @add_query_arg('paged','%#%');

	if (!empty($wp_query->query_vars['s'])) $a['add_args'] = array('s' => get_query_var('s'));

	$a['total'] = $max;
	$a['current'] = $current;

	$total = 1; //1 - display the text "Page N of N", 0 - not display
	$a['mid_size'] = 5; //how many links to show on the left and right of the current
	$a['end_size'] = 1; //how many links to show in the beginning and end
	$a['prev_text'] = '&laquo; Previous'; //text of the "Previous page" link
	$a['next_text'] = 'Next &raquo;'; //text of the "Next page" link

	if ($max > 1) echo '<div class="pb-nav">';

	if ($total == 1 && $max > 1) $pages = '<span class="pages">Page ' . $current . ' of ' . $max . '</span>'."\r\n";

	echo $pages . paginate_links($a);

	if ($max > 1) echo '</div>';
}

// Display context-aware post/page navigation elements. Default div ID: "previous-next".
function sf_display_nav($navstyle="nextprev",$class="navigation") {
	if (is_single()) {
		echo '<div class="' . $class . '"> <!-- BEGIN .' . $class . ' -->';
		echo '<div class="left">';
		previous_post_link();
		echo '</div>';
		echo '<div class="right">';
		next_post_link();
		echo '</div>';
		echo '</div> <!-- END .' . $class . ' -->';
	} else {
		$_SERVER['REQUEST_URI']  = preg_replace("/(.*?).php(.*?)&(.*?)&(.*?)&_=/","$2$3", $_SERVER['REQUEST_URI']);
		echo '<div class="' . $class . '"> <!-- BEGIN .' . $class . ' -->';

		if ($navstyle == "nextprev") {
			echo '<div class="left">';
			next_posts_link('&laquo; Older Entries');
			echo '</div>';
			echo '<div class="right">';
			previous_posts_link('Newer Entries &raquo;');
			echo '</div>';
		} elseif ($navstyle == "numbar") {
			sf_corenav();
		}

		echo '</div> <!-- END .' . $class . ' -->';
	}
}

// Display last x posts.  Default: 5 posts.
function sf_recent_posts($args='') {
	global $wpdb;

	parse_str($args);
	if (!isset($numposts)) $numposts = 3;

	if (isset($exclude)) {
		$catid = $wpdb->get_var("SELECT term_ID FROM $wpdb->terms WHERE name='$exclude'");
		$exc_str = "&cat=-$catid";
	}

	$qry_str = 'showposts='.$numposts.$exc_str;

	$posts = new WP_Query($qry_str);
	while ($posts->have_posts()) : $posts->the_post();
		$postdate = get_the_time('M j, Y');
		$excerpt = '('.$postdate.') ';
		$excerpt .= get_the_excerpt();
		$title = get_the_title();

		$rec_posts .= '<h4>'.$title.'</h4>';
		$rec_posts .= '<div class="news-summary">'.$excerpt.'</div>';
	endwhile;

	if (!$rec_posts) {
		echo "No news yet. Check back later.";
	} else {
		echo $rec_posts;
	}
}

// Add first and last classes to list items returned from wp_list_pages
function sf_addFirstLastClass($pageList) {
	// pattern to focus on just li's
	$allLisPattern = '/<li class="page_item(.*)<\/li>/s';
	preg_match($allLisPattern,$pageList,$allLis);
	$liClassPattern =  "/<li[^>]+class=\"([^\"]+)/i";

	// first let's break out each li
	$liArray = explode("\n",$allLis[0]);

	// count to get last li
	$liArrayCount = count($liArray);

	$lastLiPosition = $liArrayCount-1;

	// get the class name(s) of first class and last class
	preg_match($liClassPattern,$liArray[0],$firstMatch);
	preg_match($liClassPattern,$liArray[$lastLiPosition],$lastMatch);

	// add the new class names and replace the complete first and last lis
	$newFirstLi = str_replace($firstMatch[1],$firstMatch[1]. " first",$liArray[0]);
	$newLastLi = str_replace($lastMatch[1],$lastMatch[1]. " last",$liArray[$lastLiPosition]);
	// replace first and last of the li array with new lis

	// rebuild newPageList
		// set first li
		$newPageList .= $newFirstLi.'';
		$i=1;
		while($i<$lastLiPosition)	{
			$newPageList .= $liArray[$i];
			$i++;
		}
		// set last li
		$newPageList .= $newLastLi;

		// lastly, replace old list with new list
		$pageList = str_replace($allLis[0],$newPageList,$pageList);
	return $pageList;
}

add_filter('wp_list_pages', 'sf_addFirstLastClass');

// List child pages
function sf_child_pages() {
	global $post;

	if ($post->post_parent)
		$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
	else
		$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");

	if ($children) {
		$output = '<ul>';
		$output .= $children;
		$output .= '</ul>';
	}

	print $output;
}

// Generate breadcrumbs
function sf_breadcrumbs($args='') {
 	parse_str($args);

	if (!isset($between)) $between = '&raquo;';
	if (!isset($name)) $name = 'Home'; //text for the 'Home' link
	if (!isset($currentBefore)) $currentBefore = '<span class="current">';
	if (!isset($currentAfter)) $currentAfter = '</span>';

	if (!is_home() && !is_front_page() || is_paged()) {
		echo '<div id="crumbs">';

		global $post;
		$home = get_bloginfo('url');
		echo '<a href="' . $home . '">' . $name . '</a> ' . $between . ' ';

		if (is_category()) {
			global $wp_query;

			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);

			if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $between . ' '));
			echo $currentBefore . 'Archive by category &#39;';
			single_cat_title();
			echo '&#39;' . $currentAfter;
		} elseif (is_day()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $between . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $between . ' ';
			echo $currentBefore . get_the_time('d') . $currentAfter;
		} elseif (is_month()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $between . ' ';
			echo $currentBefore . get_the_time('F') . $currentAfter;
		} elseif (is_year()) {
			echo $currentBefore . get_the_time('Y') . $currentAfter;
		} elseif (is_single()) {
			$cat = get_the_category(); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . $between . ' ');
			echo $currentBefore;
			the_title();
			echo $currentAfter;
		} elseif (is_page() && !$post->post_parent) {
			echo $currentBefore;
			the_title();
			echo $currentAfter;
		} elseif (is_page() && $post->post_parent) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();

			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}

			$breadcrumbs = array_reverse($breadcrumbs);

			foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $between . ' ';
			echo $currentBefore;
			the_title();
			echo $currentAfter;
		} elseif (is_search()) {
			echo $currentBefore . 'Search results for &#39;' . get_search_query() . '&#39;' . $currentAfter;
		} elseif (is_tag()) {
			echo $currentBefore . 'Posts tagged &#39;';
			single_tag_title();
			echo '&#39;' . $currentAfter;
		} elseif (is_author()) {
			global $author;

			$userdata = get_userdata($author);
			echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
		} elseif (is_404()) {
			echo $currentBefore . 'Error 404' . $currentAfter;
		}

		if (get_query_var('paged')) {
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
		}

		echo '</div>';
	}
}

// Generate dynamic copyright string
function sf_copyright() {
	/* Get all posts */
	$all_posts = get_posts('post_status=publish&order=ASC');
	/* Get first post */
	$first_post = $all_posts[0];
	/* Get date of first post */
	$first_date = $first_post->post_date_gmt;

	/* Display common footer copyright notice */
	echo 'Copyright &copy; ';

	/* Display first post year and current year */
	if (!$first_date || (substr($first_date,0,4) == date('Y'))) {
		/* Only display current year if no posts in previous years */
		echo date('Y');
	} else {
		echo substr($first_date,0,4) . "-" . date('Y');
	}

	/* Display blog name from 'General Settings' page */
	echo ' '.get_bloginfo('name').'. ';
	echo 'Design by <a href="http://betterbug.com/">Drake Creative</a>';
}

// Get page slug
function sf_get_slug() {
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug;
}

// Post Tag support for pages
function sf_register_page_tags(){
     register_taxonomy_for_object_type('post_tag', 'page');
}

add_action('init', 'sf_register_page_tags');

// Adds an "even" or "odd" post class to each post using the post_class() function.
global $current_class;
$current_class = 'odd';

function sf_post_class($classes) {
	global $current_class;
	$classes[] = $current_class;

	$current_class = ($current_class == 'odd') ? 'even' : 'odd';

	return $classes;
}

add_filter('post_class','sf_post_class');

// Add performance metrics to page footer
function sf_performance($visible = false) {
	$stat = sprintf(
		'Page generated with %d queries in %.3f seconds, using %.2fMB memory',
		get_num_queries(),
		timer_stop(0, 3),
		memory_get_peak_usage() / 1024 / 1024
	);

    echo $visible ? $stat : "<!-- {$stat} -->" ;
}

add_action('wp_footer', 'sf_performance', 20);

// remove theme and plugin editor menu itmes
function sf_remove_editor_menu() {
	remove_action('admin_menu', '_add_themes_utility_last', 101);
}

add_action('_admin_menu', 'sf_remove_editor_menu', 1);

// Rewrite search urls to get rid of querystring
function sf_search_url_rewrite() {
	if (is_search() && !empty($_GET['s'])) {
		wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
		exit();
	}
}

add_action('template_redirect', 'sf_search_url_rewrite');

// remove localization routines
function sf_remove_l1on() {
	if (!is_admin()) {
		wp_deregister_script('l10n');
	}
}

add_action('init', 'sf_remove_l1on');

// Check referrer querystring to prevent comment floods
function sf_check_referrer() {
	if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == "") {
		wp_die(__('Please enable referrers in your browser to cooment'));
	}
}

add_action('check_comment_flood', 'sf_check_referrer');
?>
