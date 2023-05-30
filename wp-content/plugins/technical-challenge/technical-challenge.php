<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.endpointprotector.com
 * @since             1.0.0
 * @package           Technical_Challenge
 *
 * @wordpress-plugin
 * Plugin Name:       Technical Challenge
 * Plugin URI:        https://www.endpointprotector.com
 * Description:       Just a Technical Challenge Plugin (TCP)
 * Version:           1.0.0
 * Author:            Oleksandr Popov
 * Author URI:        https://www.endpointprotector.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       technical-challenge
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TECHNICAL_CHALLENGE_VERSION', '1.0.0' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-technical-challenge.php';


/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
define( 'TECH_CHALLENGE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once TECH_CHALLENGE_PLUGIN_PATH . 'includes/class-technical-challenge.php';

if ( class_exists( 'Technical_Challenge' ) ) {
	$technicalChallenge = new Technical_Challenge();
}

  register_activation_hook( __FILE__, array( $technicalChallenge, 'activate' ) );
  register_deactivation_hook( __FILE__, array( $technicalChallenge, 'deactivate' ) );
  register_uninstall_hook( __FILE__, array( 'Technical_Challenge', 'uninstall' ) );
