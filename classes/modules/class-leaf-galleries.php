<?php

if (!class_exists('Leaf_Galleries')) {

	class Leaf_Galleries extends Sprout_Module {
		
		protected function __construct() {

		}

		public function init() {

			$this->register_hooks();

		}

		public function register_hooks() {

			add_action('init', array($this, 'add_image_sizes'));

			add_filter('post_gallery', array($this, 'gallery'), 10, 2);

			add_filter('metaslider_flex_slider_get_html', array($this, 'show_first_image'), 1);			

		}

		public function add_image_sizes() {

			add_image_size('gallery_thumbnail', 400, 400, 1);

		}

		public function show_first_image($html) {

			$html = preg_replace('/(<li [^>]*?style=("|\')[^\2]*?)display: *none;?/', '$1', $html, 1);

			return $html;

		}

		public function gallery($output, $attr) {

			global $post;

			static $instance = 0;
			$instance++;

			// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
			if ( isset( $attr['orderby'] ) ) {
				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				if ( !$attr['orderby'] )
					unset( $attr['orderby'] );
			}

			extract(shortcode_atts(array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => 'dl',
				'icontag'    => 'dt',
				'captiontag' => 'dd',
				'columns'    => 0,
				'size'       => 'gallery_thumbnail',
				'include'    => '',
				'exclude'    => ''
			), $attr));

			$id = intval($id);
			if ('RAND' == $order) {
				$orderby = 'none';
			}

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

			// No items in gallery, return empty string

			if (empty($attachments)) {
				return '';
			}

			if (is_feed()) {

				$output = "\n";
				foreach ($attachments as $att_id => $attachment) {

					$output .= wp_get_attachment_link($att_id, $size, true) . "\n";

				}

				return $output;

			}

			$itemtag = tag_escape($itemtag);
			$captiontag = tag_escape($captiontag);
			$columns = intval($columns);

			$selector = "gallery-{$instance}";

			$size_class = sanitize_html_class($size);
			$column_class = $columns > 0 ? 'one-' . str_replace(array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12), array('half', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth', 'eleventh', 'twelfth'), $columns) : 'one-half-small-tablet one-fourth-large-tablet';
			$output = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

			$output .= '<div class="row guttered">';

			$i = 0;
			foreach ($attachments as $id => $attachment) {

				$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

				$output .= "<{$itemtag} class='gallery-item" . (!empty($column_class) ? " $column_class" : "") . "'>";
				$output .= "
					<{$icontag} class='gallery-icon'>
						$link
					</{$icontag}>";

				if ($captiontag && trim($attachment->post_excerpt)) {

					$output .= "
						<{$captiontag} class='wp-caption-text gallery-caption'>
						" . wptexturize($attachment->post_excerpt) . "
						</{$captiontag}>";

				}

				$output .= "</{$itemtag}>";

			}

			$output .= "
				</div>
			</div><!-- /.gallery -->\n";

			return $output;

		}

	}

	Sprout::add_module('Leaf_Galleries');

}

?>