<?php

function mytheme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => 'Primary Menu',
    ]);
}
add_action('after_setup_theme', 'mytheme_setup');

function mytheme_enqueue_styles() {
    wp_enqueue_style('mytheme-style', get_stylesheet_uri(), [], '1.1');
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');

function mytheme_widgets_init() {
    register_sidebar([
        'name'          => 'Sidebar',
        'id'            => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'mytheme_widgets_init');

// --- EU Event Custom Post Type ---
function eu_register_event_cpt() {
    $labels = [
        'name'               => 'Events',
        'singular_name'      => 'Event',
        'menu_name'          => 'Events',
        'add_new'            => 'Add New Event',
        'add_new_item'       => 'Add New Event',
        'edit_item'          => 'Edit Event',
        'new_item'           => 'New Event',
        'view_item'          => 'View Event',
        'search_items'       => 'Search Events',
        'not_found'          => 'No events found',
        'not_found_in_trash' => 'No events found in Trash',
    ];

    register_post_type('eu_event', [
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'events'],
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'menu_icon'     => 'dashicons-calendar-alt',
        'show_in_rest'  => true,
    ]);
}
add_action('init', 'eu_register_event_cpt');

// Flush rewrite rules on theme activation
function eu_flush_rewrite_rules() {
    eu_register_event_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'eu_flush_rewrite_rules');

// Auto-create Calendar and Events pages if they don't exist
function eu_create_pages() {
    if (get_option('eu_pages_created')) return;

    $pages = [
        ['title' => 'Calendar',       'slug' => 'calendar',       'template' => 'page-calendar.php'],
        ['title' => 'Events Listing', 'slug' => 'events-listing', 'template' => 'page-events.php'],
    ];

    foreach ($pages as $page) {
        $exists = get_page_by_path($page['slug']);
        if (!$exists) {
            $id = wp_insert_post([
                'post_title'  => $page['title'],
                'post_name'   => $page['slug'],
                'post_status' => 'publish',
                'post_type'   => 'page',
            ]);
            if ($id && !is_wp_error($id)) {
                update_post_meta($id, '_wp_page_template', $page['template']);
            }
        }
    }

    update_option('eu_pages_created', true);
    flush_rewrite_rules();
}
add_action('init', 'eu_create_pages');

// --- Event Details Meta Box ---
function eu_event_meta_box() {
    add_meta_box(
        'eu_event_details',
        'Event Details',
        'eu_event_meta_box_html',
        'eu_event',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'eu_event_meta_box');

function eu_event_meta_box_html($post) {
    wp_nonce_field('eu_event_meta_nonce_action', 'eu_event_meta_nonce');

    $date       = get_post_meta($post->ID, '_eu_event_date', true);
    $start_time = get_post_meta($post->ID, '_eu_event_start_time', true);
    $end_time   = get_post_meta($post->ID, '_eu_event_end_time', true);
    $location   = get_post_meta($post->ID, '_eu_event_location', true);
    ?>
    <p>
        <label for="eu_event_date"><strong>Event Date</strong></label><br>
        <input type="date" id="eu_event_date" name="eu_event_date" value="<?php echo esc_attr($date); ?>" style="width:100%;">
    </p>
    <p>
        <label for="eu_event_start_time"><strong>Start Time</strong></label><br>
        <input type="time" id="eu_event_start_time" name="eu_event_start_time" value="<?php echo esc_attr($start_time); ?>" style="width:100%;">
    </p>
    <p>
        <label for="eu_event_end_time"><strong>End Time</strong></label><br>
        <input type="time" id="eu_event_end_time" name="eu_event_end_time" value="<?php echo esc_attr($end_time); ?>" style="width:100%;">
    </p>
    <p>
        <label for="eu_event_location"><strong>Location</strong></label><br>
        <input type="text" id="eu_event_location" name="eu_event_location" value="<?php echo esc_attr($location); ?>" style="width:100%;">
    </p>
    <?php
}

function eu_save_event_meta($post_id) {
    if (!isset($_POST['eu_event_meta_nonce'])) return;
    if (!wp_verify_nonce($_POST['eu_event_meta_nonce'], 'eu_event_meta_nonce_action')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['_eu_event_date', '_eu_event_start_time', '_eu_event_end_time', '_eu_event_location'];
    $keys   = ['eu_event_date', 'eu_event_start_time', 'eu_event_end_time', 'eu_event_location'];

    foreach ($fields as $i => $meta_key) {
        if (isset($_POST[$keys[$i]])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$keys[$i]]));
        }
    }
}
add_action('save_post_eu_event', 'eu_save_event_meta');

// --- Enqueue Calendar Script (only on Calendar page template) ---
function eu_enqueue_calendar_assets() {
    if (!is_page_template('page-calendar.php')) return;

    wp_enqueue_script(
        'eu-calendar',
        get_template_directory_uri() . '/js/calendar.js',
        [],
        '1.0',
        true
    );

    $events_query = new WP_Query([
        'post_type'      => 'eu_event',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);

    $events = [];
    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $id = get_the_ID();
            $events[] = [
                'title'     => get_the_title(),
                'date'      => get_post_meta($id, '_eu_event_date', true),
                'startTime' => get_post_meta($id, '_eu_event_start_time', true),
                'endTime'   => get_post_meta($id, '_eu_event_end_time', true),
                'location'  => get_post_meta($id, '_eu_event_location', true),
                'excerpt'   => get_the_excerpt(),
                'url'       => get_permalink(),
            ];
        }
        wp_reset_postdata();
    }

    wp_localize_script('eu-calendar', 'euCalendarData', ['events' => $events]);
}
add_action('wp_enqueue_scripts', 'eu_enqueue_calendar_assets');
