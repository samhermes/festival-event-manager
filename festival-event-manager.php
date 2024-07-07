<?php
/**
 * Plugin Name: Festival Event Manager
 * Plugin URI: https://samhermes.com
 * Description: Create and manage events.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Sam Hermes
 * Author URI: https://samhermes.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: festival
 * Domain Path: /languages
 *
 * @package festival
 */

define( 'FESTIVAL_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Include template loader.
 */
if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
	require FESTIVAL_PATH . '/inc/templates/class-gamajo-template-loader.php';
}

/**
 * Set up template loader.
 */
require_once FESTIVAL_PATH . 'inc/templates/class-festival-template-loader.php';

/**
 * Register custom post type.
 */
require_once FESTIVAL_PATH . 'inc/post-type.php';

/**
 * Register custom post meta.
 */
require_once FESTIVAL_PATH . 'inc/post-meta.php';

/**
 * Register custom taxonomy.
 */
require_once FESTIVAL_PATH . 'inc/taxonomy.php';

/**
 * Modifications to REST API.
 */
require_once FESTIVAL_PATH . 'inc/rest-api.php';

/**
 * Set up custom template tags.
 */
require_once FESTIVAL_PATH . 'inc/template-tags.php';

/**
 * Set up custom posts list column.
 */
require_once FESTIVAL_PATH . 'inc/posts-column.php';

/**
 * Set up custom block category.
 */
require_once FESTIVAL_PATH . 'inc/block-category.php';

/**
 * Set up a custom single template.
 */
require_once FESTIVAL_PATH . 'inc/templates/index.php';

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function festival_blocks_init() {
	register_block_type( __DIR__ . '/build/blocks/events' );
}
add_action( 'init', 'festival_blocks_init' );

/**
 * Enqueue assets for the plugin.
 */
function festival_enqueue_admin_assets() {
	global $post;
	$slotfills_asset = include( plugin_dir_path( __FILE__ ) . 'build/slotfills.asset.php' );

	if ( 'festival_events' === $post->post_type ) {
		wp_enqueue_script( 'festival-slotfills', plugins_url( '/build/slotfills.js', __FILE__ ), $slotfills_asset['dependencies'], $slotfills_asset['version'], true );
		wp_enqueue_style( 'festival-slotfills', plugins_url( '/build/slotfills.css', __FILE__ ), '', '0.0.2' );
	}
}
add_action( 'admin_enqueue_scripts', 'festival_enqueue_admin_assets' );
