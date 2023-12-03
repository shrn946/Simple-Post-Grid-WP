<?php
/*
Plugin Name: Simple Post Grid | Card Style 
Description: Simple Post Grid | Card Style is a versatile WordPress plugin that empowers you to effortlessly showcase your posts in a visually appealing card-style grid. 
Version: 1.0
Author: Hassan Naqvi
WP Design Lab
*/

// Include the file
include(plugin_dir_path(__FILE__) . 'includes/card-posts.php');

// Enqueue scripts and styles
function latest_posts_with_filter_scripts() {
    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue styles
    wp_enqueue_style('latest-posts-with-filter-styles', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'latest_posts_with_filter_scripts');



// Add a settings link on the Plugins page
function card_post_grid_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=card-post-grid-settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'card_post_grid_settings_link');

// Add settings page under the "Settings" tab
function card_post_grid_settings_page() {
    ?>
    <div class="wrap" style="font-size: 20px;">
        <h1>Card Post Grid Settings</h1>
        <p>Welcome to the settings page for the Card Post Grid plugin.</p>
        <h2>How to Use Shortcode</h2>
        <p style="font-size: 20px; font-weight: bold;">To showcase the Card-style Post Grid on your site, utilize the following shortcode:</p>
        <pre>Use this shortcode to display all posts: [custom_post_grid]</pre>
       Customize the shortcode with the 'exclude_category' attribute: 
         <pre>[custom_post_grid include_category="category1" exclude_category="category2" posts_per_page="5"]</pre>


        <div class="video-link">
            <h3>Video Tutorial</h3>
            
            <iframe width="560" height="315" src="https://www.youtube.com/embed/0YNg_P1gfnY?si=7VmbwbWjW9fXMG0j&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            
        </div>
    </div>
    <?php
}

function card_post_grid_menu() {
    add_options_page(
        'Card Post Grid Settings',
        'Card Post Grid',
        'manage_options',
        'card-post-grid-settings',
        'card_post_grid_settings_page'
    );
}

add_action('admin_menu', 'card_post_grid_menu');


















