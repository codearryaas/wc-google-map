<?php
/**
 * Plugin Name: WC Google Map
 * Plugin URI: https://racase.com.np
 * Description: A simple Google Map plugin for showcasing blocks and settings page. This plugin was created for #WCKTM2023 to teach about block and settings page development.
 * Version: 1.0.0
 * Author: Rakesh Lawaju
 *
 * @package wc-google-map
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load all translations for our plugin from the MO file.
 */
function wc_google_map_load_textdomain() {
	load_plugin_textdomain( 'wc-google-map', false, basename( __DIR__ ) . '/languages' );
}
add_action( 'init', 'wc_google_map_load_textdomain' );

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * Passes translations to JavaScript.
 */
function wc_google_map_register_block() {
	$settings = wc_google_map_get_settings();
	if( empty( $settings['enableGoogleMapBlock'] ) ) {
		return false;
	}

	// Register the block by passing the location of block.json to register_block_type.
	register_block_type( __DIR__ );

	if ( function_exists( 'wp_set_script_translations' ) ) {
		/**
		 * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
		 * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
		 * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
		 */
		wp_set_script_translations( 'wc-google-map-block-map', 'wc-google-map' );
	}
}
add_action( 'init', 'wc_google_map_register_block' );
