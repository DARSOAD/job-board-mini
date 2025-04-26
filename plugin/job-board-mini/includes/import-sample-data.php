<?php

// Hook into the admin menu
add_action('admin_menu', function () {
    add_menu_page(
        'Import Jobs',                  
        'Import Jobs',                  
        'manage_options',               
        'jb-import-jobs',               
        'jbms_import_jobs_page',        
        'dashicons-upload',             
        25                               
    );
});

// Function to display the import jobs page
function jbms_import_jobs_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['jbms_import_default'])) {
        jbms_import_default_sample_jobs();
        echo '<div class="updated"><p>Default sample jobs imported successfully.</p></div>';
    }

    if (isset($_POST['jbms_import_custom']) && !empty($_FILES['jbms_custom_file']['tmp_name'])) {
        jbms_import_custom_sample_jobs($_FILES['jbms_custom_file']['tmp_name']);
        echo '<div class="updated"><p>Custom jobs imported successfully.</p></div>';
    }

?>
    <div class="wrap">
        <h1>Import Jobs</h1>

        <h2>Import Default Sample Jobs</h2>
        <form method="post">
            <input type="submit" name="jbms_import_default" class="button button-primary" value="Import Default Jobs">
        </form>

        <hr>

        <h2>Upload Custom JSON File</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="jbms_custom_file" accept="application/json" required>
            <br><br>
            <input type="submit" name="jbms_import_custom" class="button button-primary" value="Upload and Import Jobs">
        </form>

        <hr>

        <h2>Need help formatting your JSON?</h2>
        <p>You can download a sample file that shows the correct structure for job imports.
            Make sure your JSON follows this format to avoid errors during the upload process.</p>
        <br>
        <a class="button button-secondary" href="<?php echo esc_url(plugin_dir_url(__FILE__) . '../sample-data/sample-data.json'); ?>" download>Download Sample JSON Format</a>

    </div>
<?php
}

// Function to import default jobs from bundled JSON file
function jbms_import_default_sample_jobs()
{
    $json_path = plugin_dir_path(__FILE__) . '../sample-data/sample-data.json';
    jbms_import_jobs_from_file($json_path);
}

// Function to import custom uploaded JSON file
function jbms_import_custom_sample_jobs($uploaded_file_path)
{
    jbms_import_jobs_from_file($uploaded_file_path);
}

// Helper function to process a JSON file and insert jobs
function jbms_import_jobs_from_file($file_path) {
    // Check if the file exists
    if (!file_exists($file_path)) {
        echo '<div class="notice notice-error"><p>The file does not exist.</p></div>';
        return;
    }

    // Get the JSON content
    $json = file_get_contents($file_path);
    if ($json === false) {
        echo '<div class="notice notice-error"><p>Error reading the file.</p></div>';
        return;
    }

    // Decode the JSON content into an array
    $jobs = json_decode($json, true);
    if (empty($jobs)) {
        echo '<div class="notice notice-error"><p>The JSON file is empty or malformed.</p></div>';
        return;
    }

    // Initialize counters and arrays
    $invalid_jobs = [];
    $imported_count = 0;
    $error_file_url = '';

    // Iterate through each job entry
    foreach ($jobs as $index => $job) {
        $missing_fields = get_missing_fields($job);

        if (!empty($missing_fields)) {
            // Add job to invalid jobs array
            $invalid_jobs[] = [
                'index' => $index,
                'job' => $job,
                'reason' => 'Missing fields: ' . implode(', ', $missing_fields),
                'timestamp' => current_time('mysql'),
            ];
            continue; // Skip this job if missing required fields
        }

        // Insert job as a WordPress post
        $post_id = wp_insert_post([
            'post_type' => 'job',
            'post_title' => sanitize_text_field($job['title']),
            'post_content' => sanitize_textarea_field($job['description']),
            'post_status' => 'publish',
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Update custom fields
            update_post_meta($post_id, '_jbms_location', sanitize_text_field($job['location']));
            update_post_meta($post_id, '_jbms_salary', intval($job['salary']));
            update_post_meta($post_id, '_jbms_type', sanitize_text_field($job['type']));
            $imported_count++;
        } else {
            // Log error if post insertion fails
            $invalid_jobs[] = [
                'index' => $index,
                'job' => $job,
                'reason' => 'Failed to insert post.',
                'timestamp' => current_time('mysql'),
            ];
        }
    }

    // Display errors if any invalid jobs exist
    if (!empty($invalid_jobs)) {
        echo '<div class="notice notice-warning">';
        echo '<p>' . esc_html(count($invalid_jobs)) . ' jobs failed to import. Please review the errors below.</p>';

        // Display the invalid jobs directly
        echo '<ul>';
        foreach ($invalid_jobs as $invalid_job) {
            echo '<li>';
            echo 'Job at index ' . esc_html($invalid_job['index']) . ' failed: ';
            echo esc_html($invalid_job['reason']) . ' (Timestamp: ' . esc_html($invalid_job['timestamp']) . ')';
            echo '</li>';
        }
        echo '</ul>';

        // Provide the download link for the error report
        $error_file_name = 'invalid-jobs.json';
        $error_file_path = plugin_dir_path(__FILE__) . '../sample-data/' . $error_file_name;
        $error_file_url = plugin_dir_url(__FILE__) . '../sample-data/' . $error_file_name;

        // Save the invalid jobs to a file
        if (file_put_contents($error_file_path, json_encode($invalid_jobs, JSON_PRETTY_PRINT)) !== false) {
            echo '<p><a class="button button-secondary" href="' . esc_url($error_file_url) . '" download>Download Error Report</a></p>';
        } else {
            echo '<p>Error saving the invalid jobs report.</p>';
        }

        echo '</div>';
    }

    // Display success message if jobs are imported
    if ($imported_count > 0) {
        echo '<div class="notice notice-success"><p>' . esc_html($imported_count) . ' jobs imported successfully.</p></div>';
    }
}

// Helper function to check missing fields
function get_missing_fields($job) {
    $missing_fields = [];

    // Check for missing required fields
    if (empty($job['title'])) {
        $missing_fields[] = 'title';
    }
    if (empty($job['description'])) {
        $missing_fields[] = 'description';
    }
    if (empty($job['location'])) {
        $missing_fields[] = 'location';
    }
    if (empty($job['salary'])) {
        $missing_fields[] = 'salary';
    }
    if (empty($job['type'])) {
        $missing_fields[] = 'type';
    }

    return $missing_fields;
}

