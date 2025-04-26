<?php
function jbms_render_job_listings() {
    $query = new WP_Query([
        'post_type' => 'job',
        'posts_per_page' => -1, // Show all jobs, no pagination needed
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $location = get_post_meta(get_the_ID(), '_jbms_location', true);
            $salary = get_post_meta(get_the_ID(), '_jbms_salary', true);
            $type = get_post_meta(get_the_ID(), '_jbms_type', true);

            echo "<div class='p-6 bg-white rounded-lg shadow-md'>";
            echo "<h3 class='text-3xl font-bold mb-2 md:text-2xl'>" . esc_html(get_the_title()) . "</h3>";
            echo "<p class='mb-2 text-3xl md:text-xl'>" . esc_html(get_the_excerpt()) . "</p>";
            echo "<p class='text-gray-600 text-3xl md:text-xl'>" . esc_html($location) . " – $" . esc_html($salary) . "</p>";
            echo "<p class='text-gray-600 text-3xl md:text-xl'> Job type - " . esc_html($type) ."</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No jobs found.</p>";
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('job_listings', 'jbms_render_job_listings');
?>
