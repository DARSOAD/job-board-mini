<?php

add_action('add_meta_boxes', 'jbms_add_job_meta_boxes');

function jbms_add_job_meta_boxes() {
    add_meta_box(
        'jbms_job_details',          
        'Job details',        
        'jbms_render_job_meta_box',      
        'job',                         
        'normal',                     
        'default'                    
    );
}


function jbms_render_job_meta_box($post) {
    wp_nonce_field('jbms_save_job_meta', 'jbms_job_meta_nonce');

    $location = get_post_meta($post->ID, '_jbms_location', true);
    $salary = get_post_meta($post->ID, '_jbms_salary', true);
    $type = get_post_meta($post->ID, '_jbms_type', true);

    // Job types array
    $types = [
        'Full-Time',
        'Part-Time',
        'Remote',
        'Contract',
        'Freelance',
        'Internship',
        'Temporary',
    ];
    ?>
    <div class="jb-admin-fields">
        <p>
            <label for="jbms_location"><strong>Location:</strong></label><br>
            <input type="text" id="jbms_location" name="jbms_location" value="<?php echo esc_attr($location); ?>" class="jb-input-field">
        </p>
        <p>
            <label for="jbms_salary"><strong>Salary:</strong></label><br>
            <input type="number" id="jbms_salary" name="jbms_salary" value="<?php echo esc_attr($salary); ?>" class="jb-input-field">
        </p>
        <p>
            <label for="jbms_type"><strong>Job Type:</strong></label><br>
            <select id="jbms_type" name="jbms_type" class="jbms-input-field">
                <option value=""> Select </option>
                <?php foreach ($types as $option) : ?>
                    <option value="<?php echo esc_attr($option); ?>" <?php selected($type, $option); ?>>
                        <?php echo esc_html($option); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
    </div>
    <?php
}

// Hook for saving the meta box data
// This function will be called when the post is saved
add_action('save_post_job', 'jbms_save_job_meta');

function jbms_save_job_meta($post_id) {
    // Check if our nonce is set and valid
    // This is a security check to ensure that the request is coming from the correct source
    if (!isset($_POST['jbms_job_meta_nonce']) || !wp_verify_nonce($_POST['jbms_job_meta_nonce'], 'jbms_save_job_meta')) {
        return;
    }


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }


    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

   
    if (isset($_POST['jbms_location'])) {
        update_post_meta($post_id, '_jbms_location', sanitize_text_field($_POST['jbms_location']));
    }

    if (isset($_POST['jbms_salary'])) {
        update_post_meta($post_id, '_jbms_salary', intval($_POST['jbms_salary']));
        error_log('SALARIO GUARDADO: ' . $_POST['jbms_salary']);
    }

    if (isset($_POST['jbms_type'])) {
        update_post_meta($post_id, '_jbms_type', sanitize_text_field($_POST['jbms_type']));
    }
}
?>
