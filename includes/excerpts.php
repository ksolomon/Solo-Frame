<?php
/*
	Solo-Frame Custom excerpts functions

	This file is a part of the Solo-Frame WordPress theme framework.
*/

function sf_custom_excerpt($excerpt) {
	global $post;

	$raw_excerpt = $excerpt;

	if ('' == $excerpt) {
		$excerpt = get_the_content('');
		$excerpt = strip_shortcodes($excerpt);
		$excerpt = apply_filters('the_content', $excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);

		//Set the excerpt word count and only break after sentence is complete.
		$excerpt_word_count = 20;
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
		$tokens = array();
		$excerptOutput = '';
		$count = 0;

		// Divide the string into tokens; HTML tags, or words, followed by any whitespace
		preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $excerpt, $tokens);

		foreach ($tokens[0] as $token) {
			if ($count >= $excerpt_word_count && preg_match('/[\?\.\!]\s*$/uS', $token)) {
				// Limit reached, continue until  ? . or ! occur at the end
				$excerptOutput .= trim($token);
				break;
			}

			// Add words to complete sentence
			$count++;

			// Append what's left of the token
			$excerptOutput .= $token;
		}

		$excerpt = trim(force_balance_tags($excerptOutput));

		$excerpt_end = ' <a class="more-link" href="'. esc_url(get_permalink()) . '">Read more&raquo;</a>';
		$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

		//$pos = strrpos($excerpt, '</');
		//if ($pos !== false)
		// Inside last HTML tag
		//$excerpt = substr_replace($excerpt, $excerpt_end, $pos, 0);
		//else
		// After the content
		$excerpt .= $excerpt_end;

		return $excerpt;
	}

	return apply_filters('custom_wp_trim_excerpt', $excerpt, $raw_excerpt);
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'sf_custom_excerpt');
?>
