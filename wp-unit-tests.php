<?php
/**
 * Plugin Name: WP Unit Tests
 * Description: Sample code for the Austin Advanced WordPress Meetup
 * Author: Pete Nelson
 * Version: 1.0.0
 * Plugin URI: https://github.com/petenelson/wp-unit-tests
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load the plugin.
require_once trailingslashit( dirname( __FILE__ ) ) . 'includes/plugin.php';

// Register the plugin.
\WPAustin\WPUnitTests\register();
