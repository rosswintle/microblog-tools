<?php
/**
 * Plugin Name:     micro.blog Tools
 * Plugin URI:		https://oikos.digital/
 * Description:     Tools for micro.blog posting
 * Author:          Ross Wintle/Oikos Digital
 * Author URI:      https://rosswintle.uk
 * Text Domain:     microblog-tools
 * Domain Path:     /languages
 * Version:         0.1.2
 *
 * @package         Microblog_Tools
 */

/*
 *  This filter makes URL's and email addresses into proper links.
 */

function mbt_link_urls( $content ) {
	return make_clickable( $content );
}

add_filter('content_save_pre', 'mbt_link_urls', 10, 1);

/*
 *  This filter turns hashtags into links to a search for that hashtag
 */

function mbt_link_hashtags( $content ) {
	return preg_replace( '/([\s+]|^)#(\w+)/', '$1<a rel="nofollow" href="' . home_url() . '/?s=%23$2">#$2</a>$3', $content );
}

add_filter('content_save_pre', 'mbt_link_hashtags', 10, 1);


/*
 *  This filter adds the date and time as a title, if the title is empty.
 *
 *  Inspired by https://github.com/colin-walker/wordpress-blank-title/
 */

function mbt_dated_titles( $title ) {
    if ( empty( $title ) ) {
      return date( 'd/m/Y, H:i' );
    } else {
      return $title;
    }
}

add_filter( 'title_save_pre', 'mbt_dated_titles', 10, 1 );

/**
 * Adds the dashboard widget
 *
 * @since 0.1.0
 */
function mbt_init_widget() {
	wp_add_dashboard_widget( 'microblog-tools', __('Microblog Now', 'microblog-tools'), 'mbt_display_widget');
}

add_action('wp_dashboard_setup', 'mbt_init_widget');

/**
 * Register the stylesheets for the Dashboard.
 *
 * @since    0.1.0
 */
function mbt_enqueue_styles() {

	wp_enqueue_style( 'microblog-tools', plugin_dir_url( __FILE__ ) . '/microblog-tools.css', [] );

}

add_action( 'admin_enqueue_scripts', 'mbt_enqueue_styles' );

/**
 * Register the JavaScript for the dashboard.
 *
 * @since    0.1.0
 */
function mbt_enqueue_scripts() {

	wp_enqueue_script( 'microblog-tools', plugin_dir_url( __FILE__ ) . 'microblog-tools.js', [ 'jquery' ] );

}

add_action( 'admin_enqueue_scripts', 'mbt_enqueue_scripts' );

/**
 * Display the dashboard widget
 *
 * @since 0.1.0
 */
function mbt_display_widget() {
?>
	<form name="post" action="<?= rest_url('/wp/v2/posts') ?>" method="post" id="microblog-tools-widget" class="initial-form hide-if-no-js">

		<div class="textarea-wrap" id="microblog-tools-post-content-wrap">
			<label class="prompt" for="microblog-tools-post-content" id="microblog-tools-post-content-prompt-text"><?php _e('Post content', 'microblog-tools'); ?></label>
			<textarea name="microblog-tools-post-content" id="microblog-tools-post-content" class="mceEditor" rows="3" cols="15" autocomplete="off"></textarea>
		</div>

		<p class="submit">
			<input type="hidden" name="action" id="microblog-tools-post-action" value="microblog-tools-save">
			<input type="hidden" name="post_type" value="post">
			<?php wp_nonce_field('wp_rest'); ?>
			<input type="submit" name="save" id="microblog-tools-save-post" class="button button-primary microblog-tools-disable-on-submit" value="<?php _e('Publish this', 'microblog-tools'); ?>">
			<br class="clear">
			<span id="microblog-tools-char-count">0</span>
		</p>

	</form>
<?php
}

/**
 * Handle the AJAX submission.  Prints 0 for failure or a json_encoded
 * array of useful info for success. Be sure to die() in both cases
 * and when sending JSON, set the Content-Type.
 *
 * @since 0.1.0
 */
// public function handle_ajax_submit() {
// 	// Check nonce
// 	if (check_admin_referer('wp-quick-image')) {
// 		$attachment_id = $_REQUEST['wp-quick-image-id'];
// 		$post_title = $_REQUEST['wp-quick-image-title'];
// 		$post_content = $_REQUEST['wp-quick-image-content'];

// 		// Set the post details with defaults. We'll modify these as per the options if necessary.
// 		$post_details = array(
// 								'post_content' => $post_content,
// 								'post_title' => $post_title,
// 								'post_status' => 'publish',
// 								'post_type' => 'post',
// 							);

// 		// Process the options and build the post details
// 		$options = get_option( 'wpqi_settings' );

// 		// post_type is always set - 'post' is the default, set above
// 		if (isset($options['post_type'])) {
// 			$post_details['post_type'] = $options['post_type'];
// 		}

// 		// Zero if not set - only do this for posts
// 		if ('post' == $post_details['post_type'] && isset($options['category'])) {
// 			if ($options['category'] > 0) {
// 				$post_details['post_category'] = array( $options['category'] );
// 			}
// 		}

// 		// Zero if not set - only do this for posts
// 		if ('post' == $post_details['post_type'] && isset($options['tag'])) {
// 			if ($options['tag'] > 0) {
// 				// tags_input take a name, not an ID!
// 				$tag_details = get_tag($options['tag']);
// 				$post_details['tags_input'] = array( $tag_details->name );
// 			}
// 		}

// 		// This is 0 or 1
// 		if (isset($options['add_excerpt'])) {
// 			if (1 == $options['add_excerpt']) {
// 				$post_details['post_excerpt'] = $post_content;
// 			}
// 		} else {
// 			// There's no options set - default is to add the excerpt
// 			$post_details['post_excerpt'] = $post_content;
// 		}

// 		// This is a 0 or 1
// 		if (isset($options['add_content'])) {
// 			if (1 == $options['add_content']) {
// 				$post_details['post_content'] = wp_get_attachment_image( $attachment_id, 'full' ) . $post_details['post_content'];
// 			}
// 		} else {
// 			// No option set - default is to do nothing.
// 		}

// 		$post_id = wp_insert_post( $post_details );

// 		if ($post_id > 0) {

// 			// Check the featured image setting - this is a 0 or 1
// 			if (isset($options['set_featured_image'])) {
// 				if (1 == $options['set_featured_image']) {
// 					update_post_meta($post_id, '_thumbnail_id', $attachment_id);
// 				}
// 			} else {
// 				// No option is set - default is to add thumbnail
// 				update_post_meta($post_id, '_thumbnail_id', $attachment_id);
// 			}
// 			header('Content-Type: application/json');
// 			echo json_encode( array(
// 								'postId' => $post_id,
// 								'editUrl' => get_edit_post_link($post_id, 'attr'),
// 								'permalink' => get_permalink($post_id),
// 				));
// 		} else {
// 			echo '0';
// 		}

// 		die();
// 	}
// }

