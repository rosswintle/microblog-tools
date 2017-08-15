<?php
/**
 * Plugin Name:     micro.blog Tools
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Tools for micro.blog posting
 * Author:          Ross Wintle/Oikos Digital
 * Author URI:      https://rosswintle.uk
 * Text Domain:     microblog-tools
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Microblog_Tools
 */

add_filter('content_save_pre', 'mbt_link_urls', 10, 1);

function mbt_link_urls( $content ) {
	return make_clickable( $content );
}

add_filter('content_save_pre', 'mbt_link_hashtags', 10, 1);

function mbt_link_hashtags( $content ) {
	return preg_replace( '/(\s+)#(\w+)(\s+)/', '$1<a rel="nofollow" href="' . home_url() . '/?s=%23$2">#$2</a>$3', $content );
}
