<?php

/**
 *
 * @package           Live_Weather_Station
 *
 * @wordpress-plugin
 * Plugin Name:       Live Weather Station
 * Plugin URI:        https://pierre.lannoy.fr/wordpress-live-weather-station-for-netatmo/
 * Description:       Display, in many different and elegant ways, the meteorological data collected by your Netatmo weather station or coming from OpenWeatherMap.
 * Version:           2.2.0
 * Author:            Pierre Lannoy
 * Author URI:        https://pierre.lannoy.fr
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       live-weather-station
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LWS_VERSION', '2.2.0' );
define( 'LWS_MINIMUM_WP_VERSION', '4.0' );
define( 'LWS_PLUGIN_ID', 'live-weather-station' );
define( 'LWS_PLUGIN_NAME', 'Live Weather Station' );

define( 'LWS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LWS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'LWS_ADMIN_DIR', plugin_dir_path( __FILE__ ).'admin/');
define( 'LWS_ADMIN_URL', plugin_dir_url( __FILE__ ).'admin/');

define( 'LWS_PUBLIC_DIR', plugin_dir_path( __FILE__ ).'public/');
define( 'LWS_PUBLIC_URL', plugin_dir_url( __FILE__ ).'public/');

define( 'LWS_INCLUDES_DIR', plugin_dir_path( __FILE__ ).'includes/');



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-live-weather-station-activator.php
 *
 * @since    1.0.0
 */
function activate_Live_Weather_Station() {
	require_once LWS_INCLUDES_DIR.'class-live-weather-station-activator.php';
	Live_Weather_Station_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-live-weather-station-deactivator.php
 *
 * @since    1.0.0
 */
function deactivate_Live_Weather_Station() {
	require_once LWS_INCLUDES_DIR.'class-live-weather-station-deactivator.php';
	Live_Weather_Station_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Live_Weather_Station' );
register_deactivation_hook( __FILE__, 'deactivate_Live_Weather_Station' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public front site hooks.
 *
 * @since    1.0.0
 */
require LWS_INCLUDES_DIR.'class-live-weather-station.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_Live_Weather_Station() {
	$plugin = new Live_Weather_Station();
	$plugin->run();
}

run_Live_Weather_Station();
