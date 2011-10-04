<?php
/*
	Solo-Frame Custom comment functions
	
	This file is a part of the Solo-Frame WordPress theme framework.
*/

function sf_list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

add_filter('get_comments_number', 'sf_comment_count', 0);

function sf_comment_count($count) {
	global $id;

	$comments_by_type = &separate_comments(get_comments('post_id=' . $id));
	return count($comments_by_type['comment']);
}

?>