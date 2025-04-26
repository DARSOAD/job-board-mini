<?php
/**
 * Functions for Job Board Mini Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

function jbmt_enqueue_assets() {
    // Enqueue styles for the frontend
    wp_enqueue_script(
        'tailwindcss-cdn',
        'https://cdn.tailwindcss.com',
        array(),
        null,
        false 
    );

}
add_action('wp_enqueue_scripts', 'jbmt_enqueue_assets');
