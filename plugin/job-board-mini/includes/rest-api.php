<?php
/**
 * REST API endpoints for Job Board Mini plugin
 */

// Prevent direct access to the file
// This is a security measure to ensure that the file is not accessed directly via URL
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Endpoint: /wp-json/job-board-mini/v1/jobs
 * 
 */
add_action('rest_api_init', function () {
    register_rest_route('job-board-mini/v1', '/jobs/', [
        'methods' => 'GET',
        'callback' => 'jbmt_get_jobs',
        'permission_callback' => '__return_true',
    ]);
});

function jbmt_get_jobs($request) {
    $location = sanitize_text_field($request->get_param('location'));
    $salary = intval($request->get_param('salary'));

    $meta_query = [];

    if (!empty($location)) {
        $meta_query[] = [
            'key' => '_jbms_location',
            'value' => $location,
            'compare' => 'LIKE',
        ];
    }

    if (!empty($salary)) {
        $meta_query[] = [
            'key' => '_jbms_salary',
            'value' => $salary,
            'compare' => '>=',
            'type' => 'NUMERIC',
        ];
    }

    $query_args = [
        'post_type' => 'job',
        'posts_per_page' => -1,
        'meta_query' => $meta_query,
    ];

    $query = new WP_Query($query_args);
    $jobs = [];

    while ($query->have_posts()) {
        $query->the_post();

        $jobs[] = [
            'title' => get_the_title(),
            'description' => get_the_content(),
            'location' => get_post_meta(get_the_ID(), '_jbms_location', true),
            'salary' => get_post_meta(get_the_ID(), '_jbms_salary', true),
            'type' => get_post_meta(get_the_ID(), '_jbms_type', true),
        ];
    }

    wp_reset_postdata();

    return rest_ensure_response($jobs);
}

/**
 * Endpoint: /wp-json/job-board-mini/v1/locations
 * Returns a list of unique job locations
 */
add_action('rest_api_init', function () {
    register_rest_route('job-board-mini/v1', '/locations/', [
        'methods' => 'GET',
        'callback' => 'jbmt_get_unique_locations',
        'permission_callback' => '__return_true',
    ]);
});

function jbmt_get_unique_locations() {
    global $wpdb;

    $results = $wpdb->get_col("
        SELECT DISTINCT meta_value
        FROM $wpdb->postmeta
        WHERE meta_key = '_jb_location'
        ORDER BY meta_value ASC
    ");

    return rest_ensure_response($results);
}
