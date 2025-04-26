<?php

/**
 * Template Name: Front Page
 */

get_header(); ?>

<!-- Hero Section -->
<section class="bg-cover bg-top h-[60vh] flex items-center justify-center" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/hero-bg.webp');">
    <div class="text-center text-white px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Find Your Next Career Opportunity</h1>
        <p class="text-lg md:text-2xl">Explore exciting job openings tailored for you.</p>
    </div>
</section>

<!-- Filters Section -->
<section class="py-10 bg-gray-100">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col space-y-4 text-3xl">
            <div class="w-full flex space-x-4">
                <select id="filter-location" class="w-full p-3 border rounded-md">
                    <option value="">All Locations</option>
                </select>
                <input type="number" id="filter-salary" placeholder="Minimum Salary" class="w-full p-3 border rounded-md" />
            </div>
            <button id="filter-button" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">Apply Filters</button>
        </div>
    </div>
</section>

<!-- Job Listings Section -->
<section class="py-16 bg-gray-100">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-10">Available Jobs</h2>
        <div class="grid grid-cols-1 space-y-8 gap-8 lg:grid-cols-2 job-listings md:space-y-0">
            <?php echo do_shortcode('[job_listings ]'); ?>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-16 bg-white">
    <div class="max-w-3xl lg:max-w-2xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-10">Contact Us</h2>
        <form action="#" method="post" class="space-y-6 text-2xl md:text-xl">
            <div>
                <label for="name" class="block mb-2 font-semibold ">Name</label>
                <input type="text" id="name" name="name" required class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="email" class="block mb-2 font-semibold">Email</label>
                <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="message" class="block mb-2 font-semibold">Message</label>
                <textarea id="message" name="message" rows="5" required class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-md hover:bg-blue-700 transition w-full text-3xl">Send Message</button>
            </div>
        </form>
    </div>
</section>

<?php get_footer(); ?>