<?php
function sf_strip_attachments($where) {
	$where .= ' AND post_type != "attachment"';
	return $where;
}
add_filter('posts_where','sf_strip_attachments');

get_header();
?>

	<!-- content -->
	<div id="content" class="content">
		<div class="entry" id="entry-err">
			<h2 class="pagetitle">Can't find that page, sorry... <small>(Error 404)</small></h2>
			
			<p>Let me help you find what you came here for:</p>

			<?php
				$s = preg_replace("/(.*)-(html|htm|php|asp|aspx)$/","$1",$wp_query->query_vars['name']);
				$posts = query_posts('post_type=any&name='.$s);
				$s = str_replace("-"," ",$s);

				if (count($posts) == 0) {
					$posts = query_posts('post_type=any&s='.$s);
				}

				if (count($posts) > 0) {
					echo "<ol><li>";
					echo "<p>Were you looking for <strong>one of the following</strong> posts or pages?</p>";

					echo "<ul>";
						foreach ($posts as $post) {
							echo '<li><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></li>';
						}
					echo "</ul>";

					echo "<p>If not, don't worry, I've got a few more tips for you to find it:</p></li>";
				} else {
					echo "<p><strong>Don't worry though!</strong> I've got a few tips for you to find it:</p>";
					echo "<ol>";
				}
			?>
				<li>
					<label for="s"><strong>Search</strong> for it:</label>
					<form style="display:inline;" action="<?php bloginfo('siteurl');?>">
						<input type="text" value="<?php echo esc_attr($s); ?>" id="s" name="s"/> <input type="submit" value="Search"/>
					</form>
				</li>

				<li>
					<strong>If you typed in a URL...</strong> make sure the spelling, cApitALiZaTiOn, and punctuation are correct. Then try reloading the page.
				</li>

				<li>
					<strong>Look</strong> for it in the <a href="<?php bloginfo('siteurl');?>/sitemap/">sitemap</a>.
				</li>

				<li>
					<strong>Start over again</strong> at my <a href="<?php bloginfo('siteurl');?>">homepage</a> (and please contact me to say what went wrong, so I can fix it).
				</li>
			</ol>
		</div>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>