<?php
/**
 * Plugin Name: WC Google Map
 * Description: A simple Google Map plugin for showcasing blocks and settings page. This plugin was created for #WCKTM2023 to teach about block and settings page development.
 * Author: Rakesh Lawaju
 * Author URI: https://www.racase.com.np
 * Plugin URI: https://www.racase.com.np
 * Version: 1.3.8
 * Text Domain: wc-google-map
 * Domain Path: /languages
 * Tested up to: 6.3
 * Requires at least: 6.1
 * Requires PHP: 5.5
 *
 * WC Google Map is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with WC Google Map. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package WC Google Map
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function wc_google_map_submenu_page_callback() {
        wp_enqueue_style( 'wc-google-map-admin-settings' );
        wp_enqueue_script( 'wc-google-map-admin-settings' );
	echo '<div class="wrap">
                <div id="google-map-settings-app">Loading...</div>';
	echo '</div>';
}

function wc_google_map_register_custom_submenu_page() {
	add_submenu_page(
		'tools.php',
		'Google Map',
		'Google Map',
		'manage_options',
		'wc-google-map',
		'wc_google_map_submenu_page_callback' );
}

add_action('admin_menu', 'wc_google_map_register_custom_submenu_page');


function wc_google_map_register_assets() {
        $assets = include plugin_dir_path( __FILE__ ) .  '/dist/admin/settings/index.asset.php';
        wp_register_script( 'wc-google-map-admin-settings', plugin_dir_url( __FILE__ ) .  '/dist/admin/settings/index.js', $assets['dependencies'], $assets['version'], true );
        wp_register_style( 'wc-google-map-admin-settings', plugin_dir_url( __FILE__ ) .  '/dist/admin/settings/index.css', array( 'wp-components' ), $assets['version'] );
}
add_action('init', 'wc_google_map_register_assets');

function wc_google_map_add_settings_api(){
    register_rest_route( 'wc-google-map/v1', '/settings/', array(
        'methods' => 'GET',
        'callback' => 'wc_google_map_api_get_settings',
	'permission_callback' => function() {
		return current_user_can( 'manage_options' );
	}
    ) );

    register_rest_route( 'wc-google-map/v1', '/settings/', array(
        'methods' => 'POST',
        'callback' => 'wc_google_map_api_update_settings',
	'permission_callback' => function() {
		return current_user_can( 'manage_options' );
	}
    ) );
}
add_action( 'rest_api_init', 'wc_google_map_add_settings_api');

function wc_google_map_get_settings() {
	$default_values = array(
		'enableGoogleMapBlock' => true
	);

	$settings = get_option( 'ws_google_map_settings', $default );

	return wp_parse_args( $settings, $default_values );
} 

function wc_google_map_api_get_settings() {
	$settings = wc_google_map_get_settings();
	wp_send_json( $settings );
}

function wc_google_map_api_update_settings() {
	$data = json_decode(file_get_contents('php://input'), true);
	$settings = array();

	$settings['enableGoogleMapBlock'] = isset( $data['enableGoogleMapBlock'] ) && true === $data['enableGoogleMapBlock'];

	if ( ! empty( $settings ) ) {
		update_option( 'ws_google_map_settings', $settings );
	}

	wp_send_json( $settings );
}

include_once 'dist/blocks/google-map/index.php';