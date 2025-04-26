<?php
/*
Plugin Name: Job Board Mini
Plugin URI: https://archiebolden.com/job-board-mini
Description: A simple job board plugin for WordPress.
Version: 1.0
Author: Diego Rodriguez
Author URI: https://archiebolden.com/job-board-mini
Text Domain: job-board-mini
License: GPLv2 or later
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/post-types.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-fields.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/import-sample-data.php';

// Enqueue styles and scripts
wp_enqueue_script(
    'jbmt-filter-js',
    plugin_dir_url(__FILE__) . 'assets/js/filter.js',
    array(),
    filemtime(plugin_dir_path(__FILE__) . 'assets/js/filter.js'),
    true
);

// Enqueue styles for the frontend
require_once plugin_dir_path(__FILE__) . 'includes/rest-api.php';

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style(
        'jb-admin-style',
        plugin_dir_url(__FILE__) . 'assets/css/admin-style.css',
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'assets/css/admin-style.css')
    );
});