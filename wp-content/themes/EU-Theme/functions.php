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

// --- Custom Nav Walker (preserves dropdown/submenu CSS classes) ---
class EU_Nav_Walker extends Walker_Nav_Menu {
    // Add 'dropdown' class to <li> elements that have children
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Add 'dropdown' class if this item has children (depth 0 only)
        if ($args->walker->has_children && $depth === 0) {
            $classes[] = 'dropdown';
        }

        // Preserve any custom CSS classes added via WP Menu admin
        $class_names = implode(' ', array_filter($classes));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = [];
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = !empty($item->url)        ? $item->url        : '';

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        // Append ▼ indicator for top-level items with children
        if ($args->walker->has_children && $depth === 0) {
            $title .= ' ▼';
        }

        $item_output = ($args->before ?? '');
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ($args->link_before ?? '') . $title . ($args->link_after ?? '');
        $item_output .= '</a>';
        $item_output .= ($args->after ?? '');

        $output .= $item_output;
    }

    // Output <ul class="submenu"> for sub-menus instead of default class
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="submenu">';
    }
}

function mytheme_enqueue_styles() {
    wp_enqueue_style('google-fonts-oswald', 'https://fonts.googleapis.com/css2?family=Oswald:wght@600;700&display=swap', [], null);
    wp_enqueue_style('mytheme-style', get_stylesheet_uri(), [], '2.3');
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

// --- EU Program Custom Post Type ---
function eu_register_program_cpt() {
    register_post_type('eu_program', [
        'labels' => [
            'name'               => 'Programs',
            'singular_name'      => 'Program',
            'menu_name'          => 'Programs',
            'add_new'            => 'Add New Program',
            'add_new_item'       => 'Add New Program',
            'edit_item'          => 'Edit Program',
            'new_item'           => 'New Program',
            'view_item'          => 'View Program',
            'search_items'       => 'Search Programs',
            'not_found'          => 'No programs found',
            'not_found_in_trash' => 'No programs found in Trash',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'supports'     => ['title', 'editor'],
        'menu_icon'    => 'dashicons-clipboard',
        'show_in_rest' => true,
    ]);

    register_taxonomy('eu_program_group', 'eu_program', [
        'labels' => [
            'name'          => 'Program Groups',
            'singular_name' => 'Program Group',
            'add_new_item'  => 'Add New Group',
            'edit_item'     => 'Edit Group',
            'search_items'  => 'Search Groups',
        ],
        'hierarchical' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'eu_register_program_cpt');

// Program meta box (Status + Registration Link)
function eu_program_meta_box() {
    add_meta_box('eu_program_details', 'Program Details', 'eu_program_meta_box_html', 'eu_program', 'side', 'high');
}
add_action('add_meta_boxes', 'eu_program_meta_box');

function eu_program_meta_box_html($post) {
    wp_nonce_field('eu_program_meta_nonce_action', 'eu_program_meta_nonce');
    $status = get_post_meta($post->ID, '_eu_program_status', true) ?: 'open';
    $link   = get_post_meta($post->ID, '_eu_program_link', true);
    ?>
    <p>
        <label for="eu_program_status"><strong>Status</strong></label><br>
        <select id="eu_program_status" name="eu_program_status" style="width:100%;">
            <option value="open" <?php selected($status, 'open'); ?>>Open for Registration</option>
            <option value="closed" <?php selected($status, 'closed'); ?>>Closed for the Season</option>
        </select>
    </p>
    <p>
        <label for="eu_program_link"><strong>Registration Link</strong></label><br>
        <input type="url" id="eu_program_link" name="eu_program_link" value="<?php echo esc_attr($link); ?>" style="width:100%;" placeholder="https://...">
    </p>
    <?php
}

function eu_save_program_meta($post_id) {
    if (!isset($_POST['eu_program_meta_nonce'])) return;
    if (!wp_verify_nonce($_POST['eu_program_meta_nonce'], 'eu_program_meta_nonce_action')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['eu_program_status'])) {
        $allowed = ['open', 'closed'];
        $val = sanitize_text_field($_POST['eu_program_status']);
        if (in_array($val, $allowed, true)) {
            update_post_meta($post_id, '_eu_program_status', $val);
        }
    }
    if (isset($_POST['eu_program_link'])) {
        update_post_meta($post_id, '_eu_program_link', esc_url_raw($_POST['eu_program_link']));
    }
}
add_action('save_post_eu_program', 'eu_save_program_meta');

// Auto-create program group terms
function eu_create_program_groups() {
    $groups = [
        'Adult Nordic', 'Juniors', 'Youth',
        'Paddling - Junior', 'Paddling - Adult Canoe', 'Paddling - Clinics',
        'Cycling - Adult', 'Cycling - Youth',
        'Trail Running',
    ];
    foreach ($groups as $name) {
        if (!term_exists($name, 'eu_program_group')) {
            wp_insert_term($name, 'eu_program_group');
        }
    }
}
add_action('init', 'eu_create_program_groups');

// Helper: render program box grid for a given group slug and status
function eu_render_program_boxes($group_slug, $status = 'open') {
    $query = new WP_Query([
        'post_type'      => 'eu_program',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'meta_query'     => [['key' => '_eu_program_status', 'value' => $status]],
        'tax_query'      => [['taxonomy' => 'eu_program_group', 'field' => 'slug', 'terms' => $group_slug]],
    ]);

    if (!$query->have_posts()) {
        echo '<p class="program-box-empty">No programs listed yet.</p>';
        wp_reset_postdata();
        return;
    }

    $closed_class = ($status === 'closed') ? ' program-box-grid--closed' : '';
    echo '<div class="program-box-grid' . $closed_class . '">';
    while ($query->have_posts()) {
        $query->the_post();
        $link = get_post_meta(get_the_ID(), '_eu_program_link', true);
        $tag = $link ? 'a' : 'div';
        $href = $link ? ' href="' . esc_url($link) . '"' : '';
        ?>
        <<?php echo $tag . $href; ?> class="program-box">
            <h3 class="program-box-title"><?php the_title(); ?></h3>
            <div class="program-box-desc"><?php echo wp_kses_post(get_the_content()); ?></div>
            <?php if ($link) : ?>
                <span class="program-box-cta"><?php echo ($status === 'open') ? 'Register &rarr;' : 'View Details &rarr;'; ?></span>
            <?php endif; ?>
        </<?php echo $tag; ?>>
        <?php
    }
    echo '</div>';
    wp_reset_postdata();
}

// Flush rewrite rules on theme activation
function eu_flush_rewrite_rules() {
    eu_register_event_cpt();
    eu_register_program_cpt();
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
    $event_type = get_post_meta($post->ID, '_eu_event_type', true);
    ?>
    <p>
        <label for="eu_event_type"><strong>Event Type</strong></label><br>
        <select id="eu_event_type" name="eu_event_type" style="width:100%;">
            <option value="other" <?php selected($event_type, 'other'); ?>>Other</option>
            <option value="race" <?php selected($event_type, 'race'); ?>>Race</option>
            <option value="practice" <?php selected($event_type, 'practice'); ?>>Practice</option>
        </select>
    </p>
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

    $fields = ['_eu_event_type', '_eu_event_date', '_eu_event_start_time', '_eu_event_end_time', '_eu_event_location'];
    $keys   = ['eu_event_type', 'eu_event_date', 'eu_event_start_time', 'eu_event_end_time', 'eu_event_location'];

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
        '2.0',
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
                'eventType' => get_post_meta($id, '_eu_event_type', true) ?: 'other',
                'excerpt'   => get_the_excerpt(),
                'url'       => get_permalink(),
            ];
        }
        wp_reset_postdata();
    }

    wp_localize_script('eu-calendar', 'euCalendarData', ['events' => $events]);
}
add_action('wp_enqueue_scripts', 'eu_enqueue_calendar_assets');

// --- News Categories ---
function eu_create_news_categories() {
    $categories = [
        ['name' => 'Program News',    'slug' => 'program-news'],
        ['name' => 'Race Event News', 'slug' => 'race-event-news'],
        ['name' => 'Other News',      'slug' => 'other-news'],
    ];

    foreach ($categories as $cat) {
        if (!term_exists($cat['slug'], 'category')) {
            wp_insert_term($cat['name'], 'category', ['slug' => $cat['slug']]);
        }
    }
}
add_action('init', 'eu_create_news_categories');

// Auto-create all site pages (consolidated)
// Program pages use template-program.php; other pages keep their specific templates.
// Each page has its own option flag so it only gets created once.
function eu_create_site_pages() {
    $pages = [
        // Non-program pages (keep their specific templates)
        ['title' => 'News',                'slug' => 'news',                'template' => 'page-news.php',              'option' => 'eu_news_page_created'],
        ['title' => 'Nordic',              'slug' => 'nordic',              'template' => 'page-nordic.php',            'option' => 'eu_nordic_page_created'],
        ['title' => 'Programs',            'slug' => 'programs',            'template' => 'page-programs.php',          'option' => 'eu_programs_page_created'],
        ['title' => 'Urban Trail Series',  'slug' => 'urban-trail-series',  'template' => 'page-urban-trail-series.php','option' => 'eu_urban_trail_series_page_created'],
        ['title' => 'Go Spring!',          'slug' => 'go-spring',           'template' => 'page-go-spring.php',         'option' => 'eu_go_spring_page_created'],
        ['title' => 'Night Light',         'slug' => 'night-light',         'template' => 'page-night-light.php',       'option' => 'eu_night_light_page_created'],
        ['title' => 'Turkey Day Trail Trot','slug' => 'turkey-day-trail-trot','template' => 'page-turkey-day.php',      'option' => 'eu_turkey_day_page_created'],

        // Program pages (use consolidated template)
        ['title' => 'Adult Nordic',  'slug' => 'adult-nordic',  'template' => 'template-program.php', 'option' => 'eu_adult_nordic_page_created'],
        ['title' => 'Juniors',       'slug' => 'juniors',       'template' => 'template-program.php', 'option' => 'eu_juniors_page_created'],
        ['title' => 'Youth',         'slug' => 'youth',         'template' => 'template-program.php', 'option' => 'eu_youth_page_created'],
        ['title' => 'Paddling',      'slug' => 'paddling',      'template' => 'template-program.php', 'option' => 'eu_paddling_page_created'],
        ['title' => 'Cycling',       'slug' => 'cycling',       'template' => 'template-program.php', 'option' => 'eu_cycling_page_created'],
        ['title' => 'Trail Running', 'slug' => 'trail-running', 'template' => 'template-program.php', 'option' => 'eu_trail_running_page_created'],
    ];

    foreach ($pages as $page) {
        if (get_option($page['option'])) continue;

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

        update_option($page['option'], true);
    }
}
add_action('init', 'eu_create_site_pages');

// --- Photo Gallery Helper ---
function eu_render_photo_gallery($title = 'Photo Gallery') {
    $images = get_posts([
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_parent'    => get_the_ID(),
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    if (empty($images)) return;

    echo '<section class="eu-gallery-section">';
    echo '<h2 class="nordic-section-title">' . esc_html($title) . '</h2>';
    echo '<div class="eu-gallery-grid">';

    foreach ($images as $index => $image) {
        $thumb = wp_get_attachment_image_url($image->ID, 'medium_large');
        $full  = wp_get_attachment_image_url($image->ID, 'full');
        $alt   = get_post_meta($image->ID, '_wp_attachment_image_alt', true);
        ?>
        <a href="<?php echo esc_url($full); ?>"
           class="eu-gallery-item"
           data-gallery-index="<?php echo (int) $index; ?>"
           onclick="euGalleryOpen(event, <?php echo (int) $index; ?>)">
            <img src="<?php echo esc_url($thumb); ?>"
                 alt="<?php echo esc_attr($alt ?: $title); ?>"
                 loading="lazy">
        </a>
        <?php
    }

    echo '</div>';

    // Lightbox overlay
    ?>
    <div class="eu-lightbox" id="eu-lightbox" onclick="euGalleryClose(event)">
        <button class="eu-lightbox-close" onclick="euGalleryClose(event)" aria-label="Close">&times;</button>
        <button class="eu-lightbox-prev" onclick="euGalleryNav(event, -1)" aria-label="Previous">&#8249;</button>
        <img class="eu-lightbox-img" id="eu-lightbox-img" src="" alt="">
        <button class="eu-lightbox-next" onclick="euGalleryNav(event, 1)" aria-label="Next">&#8250;</button>
    </div>

    <script>
    (function() {
        var images = <?php
            $gallery_data = [];
            foreach ($images as $img) {
                $gallery_data[] = wp_get_attachment_image_url($img->ID, 'full');
            }
            echo wp_json_encode($gallery_data);
        ?>;
        var current = 0;
        var lightbox = document.getElementById('eu-lightbox');
        var lbImg = document.getElementById('eu-lightbox-img');

        window.euGalleryOpen = function(e, idx) {
            e.preventDefault();
            current = idx;
            lbImg.src = images[current];
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        window.euGalleryClose = function(e) {
            if (e.target === lightbox || e.target.classList.contains('eu-lightbox-close')) {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }
        };

        window.euGalleryNav = function(e, dir) {
            e.stopPropagation();
            current = (current + dir + images.length) % images.length;
            lbImg.src = images[current];
        };

        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') { lightbox.classList.remove('active'); document.body.style.overflow = ''; }
            if (e.key === 'ArrowLeft') { current = (current - 1 + images.length) % images.length; lbImg.src = images[current]; }
            if (e.key === 'ArrowRight') { current = (current + 1) % images.length; lbImg.src = images[current]; }
        });
    })();
    </script>
    <?php
    echo '</section>';
}

// =============================================================================
// ACF Options Page + Field Group Registrations
// =============================================================================

// Register ACF Options Page: "Site Settings"
function eu_register_acf_options_page() {
    if (!function_exists('acf_add_options_page')) return;

    acf_add_options_page([
        'page_title' => 'Site Settings',
        'menu_title' => 'Site Settings',
        'menu_slug'  => 'site-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-settings',
        'position'   => 2,
    ]);
}
add_action('acf/init', 'eu_register_acf_options_page');

// Register ACF Field Groups via PHP
function eu_register_acf_field_groups() {
    if (!function_exists('acf_add_local_field_group')) return;

    // --- Site Settings Field Group ---
    acf_add_local_field_group([
        'key'      => 'group_site_settings',
        'title'    => 'Site Settings',
        'fields'   => [
            // Branding
            [
                'key'   => 'field_site_slogan',
                'label' => 'Site Slogan',
                'name'  => 'site_slogan',
                'type'  => 'text',
                'default_value' => 'ACTIVE. HEALTHY. OUTDOORS.',
                'instructions'  => 'Displayed in the ribbon above the header.',
            ],
            // Contact Info
            [
                'key'   => 'field_office_email',
                'label' => 'Office Email',
                'name'  => 'office_email',
                'type'  => 'email',
                'default_value' => 'info@enduranceunited.org',
            ],
            [
                'key'   => 'field_office_phone',
                'label' => 'Office Phone',
                'name'  => 'office_phone',
                'type'  => 'text',
                'default_value' => '(612) 850-3937',
            ],
            [
                'key'   => 'field_office_address',
                'label' => 'Office Address',
                'name'  => 'office_address',
                'type'  => 'textarea',
                'rows'  => 3,
                'default_value' => "713 Minnehaha Ave. East, Suite 216\nSaint Paul, MN 55106, USA",
            ],
            // Social URLs
            [
                'key'   => 'field_facebook_url',
                'label' => 'Facebook URL',
                'name'  => 'facebook_url',
                'type'  => 'url',
                'default_value' => 'https://www.facebook.com/EnduranceUntd/',
            ],
            [
                'key'   => 'field_instagram_url',
                'label' => 'Instagram URL',
                'name'  => 'instagram_url',
                'type'  => 'url',
                'default_value' => 'https://www.instagram.com/enduranceunited/',
            ],
            [
                'key'   => 'field_youtube_url',
                'label' => 'YouTube URL',
                'name'  => 'youtube_url',
                'type'  => 'url',
                'default_value' => 'https://www.youtube.com/channel/UCsrv65x0Vzscsh3vRJk_PUA',
            ],
            // Footer Content
            [
                'key'   => 'field_footer_about_text',
                'label' => 'Footer About Text',
                'name'  => 'footer_about_text',
                'type'  => 'textarea',
                'rows'  => 4,
                'default_value' => 'Empowering communities through education, athletics, and mentorship. We are committed to developing young leaders on and off the field.',
                'instructions'  => 'The "About Us" paragraph in the footer.',
            ],
            // Footer - Get Involved Links (Repeater)
            [
                'key'          => 'field_footer_get_involved_links',
                'label'        => 'Footer Get Involved Links',
                'name'         => 'footer_get_involved_links',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Link',
                'sub_fields'   => [
                    [
                        'key'   => 'field_get_involved_label',
                        'label' => 'Label',
                        'name'  => 'label',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_get_involved_url',
                        'label' => 'URL',
                        'name'  => 'url',
                        'type'  => 'url',
                    ],
                ],
            ],
            // Footer - Our Team Links (Repeater)
            [
                'key'          => 'field_footer_our_team_links',
                'label'        => 'Footer Our Team Links',
                'name'         => 'footer_our_team_links',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Link',
                'sub_fields'   => [
                    [
                        'key'   => 'field_our_team_label',
                        'label' => 'Label',
                        'name'  => 'label',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_our_team_url',
                        'label' => 'URL',
                        'name'  => 'url',
                        'type'  => 'url',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'site-settings',
                ],
            ],
        ],
        'menu_order' => 0,
    ]);

    // --- Program Page Fields Field Group ---
    acf_add_local_field_group([
        'key'      => 'group_program_page_fields',
        'title'    => 'Program Page Fields',
        'fields'   => [
            [
                'key'   => 'field_program_subtitle',
                'label' => 'Subtitle',
                'name'  => 'program_subtitle',
                'type'  => 'text',
                'instructions' => 'Optional subtitle displayed below the page title (e.g. "MyXC affiliated program").',
            ],
            [
                'key'   => 'field_program_intro',
                'label' => 'Introduction',
                'name'  => 'program_intro',
                'type'  => 'wysiwyg',
                'tabs'  => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'instructions' => 'The introductory description paragraphs for this program.',
            ],
            [
                'key'          => 'field_special_notes',
                'label'        => 'Special Notes',
                'name'         => 'special_notes',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add Note',
                'instructions' => 'Optional notes like "ski pass required" or age restrictions.',
                'sub_fields'   => [
                    [
                        'key'   => 'field_note_text',
                        'label' => 'Note',
                        'name'  => 'note_text',
                        'type'  => 'wysiwyg',
                        'tabs'  => 'all',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                    ],
                ],
            ],
            [
                'key'          => 'field_program_sections',
                'label'        => 'Program Sections',
                'name'         => 'program_sections',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add Section',
                'instructions' => 'Each section represents a program group (e.g. "Junior Paddling", "Adult Canoe Racing").',
                'sub_fields'   => [
                    [
                        'key'   => 'field_section_title',
                        'label' => 'Section Title',
                        'name'  => 'section_title',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_section_description',
                        'label' => 'Section Description',
                        'name'  => 'section_description',
                        'type'  => 'wysiwyg',
                        'tabs'  => 'all',
                        'toolbar' => 'full',
                        'media_upload' => 1,
                        'instructions' => 'Detailed content for this section. Leave blank to show only program boxes.',
                    ],
                    [
                        'key'   => 'field_program_group_slug',
                        'label' => 'Program Group Slug',
                        'name'  => 'program_group_slug',
                        'type'  => 'text',
                        'instructions' => 'The slug of the Program Group taxonomy term to pull program boxes from (e.g. "adult-nordic", "paddling-junior").',
                    ],
                ],
            ],
            [
                'key'           => 'field_show_closed_section',
                'label'         => 'Show Closed Section',
                'name'          => 'show_closed_section',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
                'instructions'  => 'Show the "Closed for the Season" section at the bottom.',
            ],
            [
                'key'           => 'field_closed_section_message',
                'label'         => 'Closed Section Message',
                'name'          => 'closed_section_message',
                'type'          => 'text',
                'default_value' => 'Programs listed below are closed for the season. For late sign-ups please reach out.',
                'conditional_logic' => [
                    [
                        [
                            'field'    => 'field_show_closed_section',
                            'operator' => '==',
                            'value'    => '1',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'template-program.php',
                ],
            ],
        ],
        'menu_order' => 0,
    ]);
}
add_action('acf/init', 'eu_register_acf_field_groups');
