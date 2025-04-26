<?php
/**
 * Register a custom post type for jobs.
 *
 * @return void
 */
function jbms_register_job_post_type() {
    register_post_type('job', [
        'label' => 'Jobs',
        'public' => true,
        'show_in_rest' => true, 
        'has_archive' => true,
        'supports' => ['title', 'editor','custom-fields'],
        'rewrite' => ['slug' => 'jobs'],
        'menu_icon' => 'dashicons-portfolio',
    ]);
}
add_action('init', 'jbms_register_job_post_type');


?>
 