<?php
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die('Please do not load this page directly. Thanks!');

if (post_password_required()) { ?>
	<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php
	return;
}
?>

<a id="comments"></a>
<h3>Comments</h3>
<?php if ($comments) : ?>
	<ul class="commentlist">
		<?php foreach ($comments as $comment) : ?>
			<li id="comment-<?php comment_ID(); ?>" class="<?php if ($comment->user_id == 1) echo "authcomment"; ?>">
				<?php if ($comment->comment_approved == '0') : ?>
					<p>Your comment is awaiting approval</p>
				<?php endif; ?>
				<?php echo get_avatar(get_comment_author_email(), 48, $default_avatar); ?>
				<cite class="commentmetadata">
					<h4><?php comment_author_link(); ?></h4> on <small><?php comment_date(); ?></small>
				</cite>
				<br />
				<?php comment_text(); ?>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php if (comments_open()) : ?>
	<hr />
	<h3>Add Your Comment</h3>
	<?php if (get_option('comment_registration') && !$user_ID) : ?>
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p><?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if ($user_ID) : ?>
				<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>
			<?php else : ?>
				<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
					<label for="author">Name <?php if ($req) echo "(required)"; ?></label></p>
				<p><input required="required" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
					<label for="email">Email (will not be published<?php if ($req) echo ", required"; ?>)</label></p>
				<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
					<label for="url">Website</label></p>
			<?php endif; ?>
			<p><label for="comment">Comment</label><br /><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>
			<?php //show_subscription_checkbox();
			?>
			<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; ?>
<?php else : ?>
	<p>The comments are closed.</p>
<?php endif; ?>