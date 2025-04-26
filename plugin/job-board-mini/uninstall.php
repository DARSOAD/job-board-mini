<?php
/**
 * Uninstall script for the Job Board Mini plugin.
 *
 * This script will run automatically when the plugin is deleted from the WordPress admin.
 * It ensures all data created by the plugin (like custom post types and meta fields) is properly removed.
 *
 * IMPORTANT: This action is irreversible. Only include code here if you want to delete plugin data permanently.
 */

// Exit if accessed directly.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}


// Delete all 'job' custom post types
$jobs = get_posts([
    'post_type' => 'job',
    'post_status' => 'any',
    'numberposts' => -1,
]);

foreach ($jobs as $job) {
    wp_delete_post($job->ID, true); // true = force delete, bypass trash
}


