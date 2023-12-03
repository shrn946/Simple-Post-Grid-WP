<?php
// Post-Loop.php

// Add this code to your theme's functions.php file or create a custom plugin.

function custom_post_grid_shortcode($atts) {
    // Get the 'posts_per_page' value from the options
    $posts_per_page_option = get_option('custom_post_grid_posts_per_page', -1);

    // Merge the default attributes with user-specified attributes
    $atts = shortcode_atts(
        array(
            'include_category' => '', // Specify the category slug to include
            'exclude_category' => '', // Specify the category slug to exclude
            'posts_per_page'   => $posts_per_page_option, // Number of posts to display
        ),
        $atts,
        'custom_post_grid'
    );

    // Query arguments
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $atts['posts_per_page'],
    );

    // Check if either include or exclude category is specified
    if (!empty($atts['include_category'])) {
        $args['category_name'] = $atts['include_category'];
    } elseif (!empty($atts['exclude_category'])) {
        $args['category__not_in'] = array(get_cat_ID($atts['exclude_category']));
    }

    // Get posts
    $posts_query = new WP_Query($args);

    // Output HTML
    ob_start(); ?>

    <div class="grid-row">

    <?php
    // Loop through posts
    while ($posts_query->have_posts()) :
        $posts_query->the_post();

        // Get post data
      $post_date = get_the_date('M j, Y'); // Example: Nov 1, 2023
        $author_name    = get_the_author();
        $post_title     = get_the_title();
        $post_content   = wp_trim_words(get_the_content(), 15); // Limit content to 17 words
        $post_permalink = get_permalink();
        $post_bg_image  = get_the_post_thumbnail_url(get_the_ID(), 'full');

        // Use fallback image if featured image is not available
        if (empty($post_bg_image)) {
            $post_bg_image = plugin_dir_url(__FILE__) . 'fallback-img.jpg';
        }

        // Get the post categories
        $categories = get_the_category();

        // Check if there is at least one category
        if (!empty($categories)) {
            // Get the first category
            $first_category = $categories[0];

            // Get the category name and link
            $category_name = $first_category->name;
            $category_link = get_category_link($first_category->term_id);
        }

        ?>

        <div class="example-1 card on">
            <div class="wrapper" style="background: url('<?php echo esc_url($post_bg_image); ?>') 50% 50%/cover no-repeat;">
                <div class="date">
                    <?php echo $post_date; ?>
                </div>

                <div class="data">
                    <div class="content">
                        <span class="author"><?php echo $author_name; ?></span>
                        <h3 class="title"><a href="<?php echo $post_permalink; ?>"><?php echo $post_title; ?></a></h3>
                        <p class="text"><?php echo $post_content; ?></p>

                        <!-- Display the first category name and link -->
                        <?php if (!empty($categories)) : ?>
                            <div class="first-category">
                               <?php echo esc_html($category_name); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

    <?php endwhile; ?>

    </div>
    <?php
    // Reset Post Data
    wp_reset_postdata();
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('custom_post_grid', 'custom_post_grid_shortcode');
