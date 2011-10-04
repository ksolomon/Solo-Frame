<?php
$options = array(
	array(
		"desc" => __("<h3>Meta Description/Keywords</h3>"),
		"type" => "nothing"
	),

	array(
		"name" => __('Default Meta Description'),
		"desc" => __('If used, will override blog description (from Settings page) for meta description'),
		"id" => $shortname."_blog_desc",
		"std" => "",
		"type" => "text"
	),

	array(
		"name" => __('Default Meta Keywords'),
		"desc" => __('Default keywords for meta tag'),
		"id" => $shortname."_blog_kw",
		"std" => "",
		"type" => "text"
	),

	array(
		"name" => __('Use Excerpt for Meta Description?'),
		"desc" => __('If selected, use post/page excerpt for meta description'),
		"id" => $shortname."_blog_desc_exc",
		"std" => "false",
		"type" => "checkbox"
	),

	array(
		"name" => __('Post/Page Meta Description Length'),
		"desc" => __('Number of words from post content to use as meta description (Default: 20)'),
		"id" => $shortname."_blog_desc_len",
		"std" => "",
		"type" => "text"
	),

	array(
		"desc" => __("<h3>Analytics/Footer Code</h3>"),
		"type" => "nothing"
	),

	array(
		"name" => __('Analytics code'),
		"desc" => __("Paste your Google Analytics code (or other javascript to add) in the box above"),
		"id" => $shortname."_analytics",
		"std" => __(""),
		"type" => "textarea",
		"options" => array("rows" => "5","cols" => "94")
	)
);

function sf_add_admin() {
    global $themename, $shortname, $options;

	if ($_GET['page'] == basename(__FILE__)) {
		if ('save' == $_REQUEST['action']) {
			foreach ($options as $value) {
				update_option($value['id'], $_REQUEST[ $value['id'] ]);
			}

			foreach ($options as $value) {
				if(isset($_REQUEST[ $value['id'] ])) { update_option($value['id'], $_REQUEST[ $value['id'] ] ); } else { delete_option($value['id']); }
			}

			header("Location: themes.php?page=theme_options.php&saved=true");
			die;
		} elseif('reset' == $_REQUEST['action']) {
			foreach ($options as $value) {
				delete_option($value['id']);
			}

			header("Location: themes.php?page=theme_options.php&reset=true");
			die;
		}
	}

    add_theme_page("Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'sf_admin');
}

function sf_admin() {
    global $themename, $shortname, $options;

    if ($_REQUEST['saved']) echo '<div id="message" class="updated fade"><p><strong>'.__('Theme settings saved.').'</strong></p></div>';
    if ($_REQUEST['reset']) echo '<div id="message" class="updated fade"><p><strong>'.__('Theme settings reset.').'</strong></p></div>';

	$nonce = wp_create_nonce('sf_admin'); // create nonce token for security
?>
	<div="wrap">
		<?php if (function_exists('screen_icon')) screen_icon(); ?>

		<h2>Theme Options</h2>

		<form method="post" action="themes.php?page=theme_options.php&_wpnonce=<?php echo $nonce ?>">
			<table class="form-table">
				<?php foreach ($options as $value) {
					switch ($value['type']) {
						case 'text':
						?>
						<tr valign="top">
							<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name']); ?></label></th>
							<td>
								<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
								<?php echo __($value['desc']); ?>
							</td>
						</tr>
						<?php
						break;

						case 'select':
						?>
						<tr valign="top">
							<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name']); ?></label></th>
							<td>
								<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
									<?php foreach ($value['options'] as $option) { ?>
										<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<?php
						break;

						case 'textarea':
						$ta_options = $value['options'];
						?>
						<tr valign="top">
							<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name']); ?></label></th>
							<td><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php
							if (get_option($value['id']) != "") {
								echo __(stripslashes(get_option($value['id'])));
							} else {
								echo __($value['std']);
							}?></textarea><br /><?php echo __($value['desc']); ?></td>
						</tr>
						<?php
						break;

						case 'radio':
						?>
						<tr valign="top">
							<th scope="row"><?php echo __($value['name']); ?></th>
							<td>
							<?php foreach ($value['options'] as $key=>$option) {
								$radio_setting = get_option($value['id']);
								if ($radio_setting != '') {
									if ($key == get_option($value['id'])) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = "";
									}
								} else {
									if ($key == $value['std']) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = "";
									}
								} ?>
								<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label><br />
							<?php } ?>
							</td>
						</tr>
						<?php
						break;

						case 'checkbox':
						?>
						<tr valign="top">
							<th scope="row"><?php echo __($value['name']); ?></th>
							<td>
								<?php
								if (get_option($value['id'])) {
									$checked = "checked=\"checked\"";
								} else {
									$checked = "";
								}
								?>
								<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
								<label for="<?php echo $value['id']; ?>"><?php echo __($value['desc']); ?></label>
							</td>
						</tr>
						<?php
						break;
						
						case 'nothing':
						?>
						<tr valign="top">
							<th scope="row"><?php echo __($value['desc']); ?></th>
							<td>&nbsp;</td>
						</tr>
						<?php
						break;

						default:
						break;
					}
				}
?>
			</table>

			<p class="submit">
				<input name="save" type="submit" value="<?php _e('Save changes'); ?>" />
				<input type="hidden" name="action" value="save" />
			</p>
		</form>

		<form method="post" action="themes.php?page=theme_options.php&_wpnonce=<?php echo $nonce ?>">
			<p class="submit">
				<input name="reset" type="submit" value="<?php _e('Reset'); ?>" />
				<input type="hidden" name="action" value="reset" />
			</p>
		</form>
	</div>
	<?php
}

add_action('admin_menu', 'sf_add_admin'); 
?>