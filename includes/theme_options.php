<?php
// Default options values
$sf_options = array(
	'sf_blog_desc' => '',
	'sf_blog_kw' => '',
	'sf_blog_desc_exc' => false,
	'sf_blog_desc_len' => 20,
	'sf_analytics' => ''
);

if (is_admin()) : // Load only if we are viewing an admin page

function sf_register_settings() {
	// Register settings and call sanitation functions
	register_setting('sf_theme_options', 'sf_options', 'sf_validate_options');
}

add_action('admin_init', 'sf_register_settings');

function sf_theme_options() {
	// Add theme options page to the addmin menu
	add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'sf_theme_options_page');
}

add_action('admin_menu', 'sf_theme_options');

// Function to generate options page
function sf_theme_options_page() {
	global $sf_options;

	if (!isset($_REQUEST['saved']))
		$_REQUEST['saved'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __(' Theme Options') . "</h2>";
		// This shows the page's name and an icon if one has been provided ?>

		<?php if (false !== $_REQUEST['saved']) : ?>
			<div class="updated fade"><p><strong><?php _e('Options saved'); ?></strong></p></div>
		<?php endif; // If the form has just been submitted, this shows the notification ?>

		<form method="post" action="options.php">
			<?php $settings = get_option('sf_options', $sf_options); ?>
			<?php settings_fields('sf_theme_options');
			/* This function outputs some hidden fields required by the form,
			including a nonce, a unique number used to ensure the form has been submitted from the admin page
			and not somewhere else, very important for security */ ?>

			<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
				<tr valign="top">
					<td><h3>Meta Description/Keywords</h3></td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="sf_blog_desc">Default Meta Description</label></th>
					<td>
						<input id="sf_blog_desc" name="sf_options[sf_blog_desc]" type="text" value="<?php esc_attr_e($settings['sf_blog_desc']); ?>" />
						If used, will override blog description (from Settings page) for meta description.
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="sf_blog_kw">Default Meta Keywords</label></th>
					<td>
						<input id="sf_blog_kw" name="sf_options[sf_blog_kw]" type="text" value="<?php esc_attr_e($settings['sf_blog_kw']); ?>" />
						Default keywords for meta tag (must be comma separated).
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">Use Excerpt as Description</th>
					<td>
						<input type="checkbox" id="sf_blog_desc_exc" name="sf_options[sf_blog_desc_exc]" value="1" <?php checked(true, $settings['sf_blog_desc_exc']); ?> />
						<label for="sf_blog_desc_exc">If selected, use post/page excerpt for meta description.</label>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="sf_blog_desc_len">Post/Page Meta Description Length</label></th>
					<td>
						<input id="sf_blog_desc_len" name="sf_options[sf_blog_desc_len]" type="text" value="<?php esc_attr_e($settings['sf_blog_desc_len']); ?>" />
						Number of words from post content to use as meta description (Default: 20).
					</td>
				</tr>

				<tr valign="top">
					<td><h3>Analytics/Footer Code</h3></td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="sf_analytics">Analytics Code</label></th>
					<td>
						<textarea id="sf_analytics" name="sf_options[sf_analytics]" rows="5" cols="94"><?php echo stripslashes($settings['sf_analytics']); ?></textarea>
						<br />Paste your Google Analytics code (or other javascript to add) in the box above.
					</td>
				</tr>
			</table>

			<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
		</form>
	</div>

	<?php
}

function sf_validate_options($input) {
	global $sf_options;

	$settings = get_option('sf_options', $sf_options);
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['sf_blog_desc'] = wp_filter_nohtml_kses($input['sf_blog_desc']);
	$input['sf_blog_kw'] = wp_filter_nohtml_kses($input['sf_blog_kw']);
	$input['sf_blog_desc_len'] = wp_filter_nohtml_kses($input['sf_blog_desc_len']);

	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['sf_analytics'] = htmlentities(stripslashes($input['sf_analytics']));

	// If the checkbox has not been checked, we void it
	if (! isset($input['sf_blog_desc_exc']))
		$input['sf_blog_desc_exc'] = null;
	// We verify if the input is a boolean value
	$input['sf_blog_desc_exc'] = ($input['sf_blog_desc_exc'] == 1 ? 1 : 0);

	return $input;
}

endif;  // EndIf is_admin()
