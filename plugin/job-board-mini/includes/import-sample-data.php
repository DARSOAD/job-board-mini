<?php
// Hook for the admin menu
add_action('admin_menu', 'jbms_register_import_jobs_menu');

function jbms_register_import_jobs_menu() {
    add_menu_page(
        'Import jobs',         
        'Import jobs',           
        'manage_options',            
        'jb-import-jobs',             
        'jbms_render_import_jobs_page', 
        'dashicons-upload',           
        25                           
    );
}

// Callback function to render the import jobs page
// This function will be called when the menu item is clicked
function jbms_render_import_jobs_page() {
    ?>
    <div class="wrap">
        <h1>Import jobs</h1>
        <form method="post">
            <input type="submit" name="jbms_import_jobs" class="button button-primary" value="Import now">
        </form>
    </div>
    <?php

    
    if (isset($_POST['jbms_import_jobs'])) {
        jbms_import_jobs_from_json();
    }
}

// Function to import jobs from JSON file
// This function will be called when the form is submitted
function jbms_import_jobs_from_json() {
    $json_path = plugin_dir_path(__FILE__) . '../sample-data/sample-data.json';

    if (!file_exists($json_path)) {
        echo '<div class="notice notice-error"><p>Sample-data.json file not found.</p></div>';
        return;
    }

    $json_data = file_get_contents($json_path);
    $jobs = json_decode($json_data, true);

    if (empty($jobs)) {
        echo '<div class="notice notice-error"><p>The JSON file is empty or malformed.</p></div>';
        return;
    }

    foreach ($jobs as $job) {
        $post_id = wp_insert_post([
            'post_type'    => 'job',
            'post_title'   => sanitize_text_field($job['title']),
            'post_content' => sanitize_textarea_field($job['description']),
            'post_status'  => 'publish',
        ]);

        if (!is_wp_error($post_id)) {
            // Add custom fields for the job
            if (isset($job['location'])) {
                update_post_meta($post_id, '_jbms_location', sanitize_text_field($job['location']));
            }
            if (isset($job['salary'])) {
                update_post_meta($post_id, '_jbms_salary', intval($job['salary']));
            }
            if (isset($job['type'])) {
                update_post_meta($post_id, '_jbms_type', sanitize_text_field($job['type']));
            }
        }
    }

    echo '<div class="notice notice-success"><p>Jobs imported successfully.</p></div>';
}
?>
