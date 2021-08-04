<?php
/**
 * Plugin Name: (BETA) WSUWP News
 * Plugin URI: https://github.com/wsuwebteam/wsuwp-plugin-news
 * Description: Post Types for the WSU Insider
 * Version: 0.0.1
 * Requires PHP: 7.0
 * Author: Washington State University, Dan White
 * Author URI: https://web.wsu.edu/
 * Text Domain: wsuwp-plugin-news
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Initiate plugin
require_once __DIR__ . '/includes/plugin.php';
