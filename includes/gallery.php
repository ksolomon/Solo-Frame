<?php
add_filter('post_gallery', 'sf_gallery', 10, 2);

function sf_gallery($output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'div',
        'icontag'    => 'div',
        'captiontag' => 'div',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
   ), $attr));

    $id = intval($id);
    if ('RAND' == $order)
        $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif (!empty($exclude)) {
        $exclude = preg_replace('/[^0-9,]+/', '', $exclude);
        $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    } else {
        $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    }

    if (empty($attachments))
        return '';

    if (is_feed()) {
        $output = "\n";
        foreach ($attachments as $att_id => $attachment)
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';

	if (apply_filters('use_default_gallery_style', true))
		$gallery_style = "";

	$size_class = sanitize_html_class($size);
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

    $output = apply_filters('gallery_style', "<div id='$selector' class='gallery galleryid-{$id}'>");
    $i = 0;

    foreach ($attachments as $id => $attachment) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

		$output .= "<{$itemtag} id='item-{$id}' class='gallery-item col-{$columns}'>";
		$output .= "<{$icontag} class='gallery-icon'>$link</{$icontag}>";

		if ($captiontag && trim($attachment->post_excerpt)) {
			$output .= "<{$captiontag} class='gallery-caption'>" . wptexturize($attachment->post_excerpt) . "</{$captiontag}>";
		}

		$output .= "</{$itemtag}>";

		if ($columns > 0 && ++$i % $columns == 0)
			$output .= '<br />';
	}

	$output .= "</div>\n";

    return $output;
}
?>
