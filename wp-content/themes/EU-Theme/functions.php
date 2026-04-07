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
    // UTS page slugs for detection
    private static $uts_slugs = ['urban-trail-series', 'go-spring', 'night-light', 'turkey-day-trail-trot', 'bluff-tuff'];

    // Add 'dropdown' class to <li> elements that have children
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Add 'dropdown' class if this item has children (depth 0 only)
        if ($args->walker->has_children && $depth === 0) {
            $classes[] = 'dropdown';
        }

        // Add 'uts-nav' class to Urban Trail Series menu items
        $url_path = trim(wp_parse_url($item->url, PHP_URL_PATH), '/');
        if (in_array($url_path, self::$uts_slugs, true)) {
            $classes[] = 'uts-nav';
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
    wp_enqueue_style('google-fonts-oswald', 'https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap', [], null);
    wp_enqueue_style('google-fonts-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap', [], null);
    wp_enqueue_style('mytheme-style', get_stylesheet_uri(), [], '3.4');
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');

// Add 'uts-page' body class on Urban Trail Series pages
function eu_uts_body_class($classes) {
    if (is_page()) {
        $slug = get_post_field('post_name', get_the_ID());
        $uts_slugs = ['urban-trail-series', 'go-spring', 'night-light', 'turkey-day-trail-trot', 'bluff-tuff'];
        if (in_array($slug, $uts_slugs, true)) {
            $classes[] = 'uts-page';
        }
    }
    return $classes;
}
add_filter('body_class', 'eu_uts_body_class');

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
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'programs', 'with_front' => false],
        'supports'     => ['title', 'editor', 'thumbnail'],
        'menu_icon'    => 'dashicons-clipboard',
        'show_in_rest' => false,
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

// Program meta box
function eu_program_meta_box() {
    add_meta_box('eu_program_details', 'Program Details', 'eu_program_meta_box_html', 'eu_program', 'normal', 'high');
}
add_action('add_meta_boxes', 'eu_program_meta_box');

function eu_program_meta_box_html($post) {
    wp_nonce_field('eu_program_meta_nonce_action', 'eu_program_meta_nonce');
    $status     = get_post_meta($post->ID, '_eu_program_status', true) ?: 'open';
    $link       = get_post_meta($post->ID, '_eu_program_link', true);
    $coach      = get_post_meta($post->ID, '_eu_program_coach', true);
    $cost       = get_post_meta($post->ID, '_eu_program_cost', true);
    $schedule   = get_post_meta($post->ID, '_eu_program_schedule', true);
    $featured   = get_post_meta($post->ID, '_eu_program_featured', true);
    $short_desc = get_post_meta($post->ID, '_eu_program_short_desc', true);
    $page_link  = get_post_meta($post->ID, '_eu_program_page_link', true);
    ?>
    <table class="form-table" style="margin-top:0;">
        <tr>
            <th><label for="eu_program_status">Status</label></th>
            <td>
                <select id="eu_program_status" name="eu_program_status" style="width:100%;max-width:400px;">
                    <option value="open" <?php selected($status, 'open'); ?>>Open for Registration</option>
                    <option value="closed" <?php selected($status, 'closed'); ?>>Closed for the Season</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="eu_program_coach">Coach</label></th>
            <td><input type="text" id="eu_program_coach" name="eu_program_coach" value="<?php echo esc_attr($coach); ?>" style="width:100%;max-width:400px;" placeholder="e.g. John Richter"></td>
        </tr>
        <tr>
            <th><label for="eu_program_cost">Cost</label></th>
            <td><input type="text" id="eu_program_cost" name="eu_program_cost" value="<?php echo esc_attr($cost); ?>" style="width:100%;max-width:400px;" placeholder="e.g. $175 per season"></td>
        </tr>
        <tr>
            <th><label for="eu_program_schedule">Schedule</label></th>
            <td><input type="text" id="eu_program_schedule" name="eu_program_schedule" value="<?php echo esc_attr($schedule); ?>" style="width:100%;max-width:400px;" placeholder="e.g. Wednesdays 6:00–7:30pm, May–Aug"></td>
        </tr>
        <tr>
            <th><label for="eu_program_link">Registration Link</label></th>
            <td><input type="url" id="eu_program_link" name="eu_program_link" value="<?php echo esc_attr($link); ?>" style="width:100%;max-width:400px;" placeholder="https://..."></td>
        </tr>
    </table>

    <hr>
    <h4 style="margin-bottom:8px;">Homepage Showcase</h4>
    <table class="form-table" style="margin-top:0;">
        <tr>
            <th><label>Featured</label></th>
            <td>
                <label>
                    <input type="checkbox" name="eu_program_featured" value="1" <?php checked($featured, '1'); ?>>
                    Show on homepage grid (max 8)
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="eu_program_short_desc">Short Description</label></th>
            <td><textarea id="eu_program_short_desc" name="eu_program_short_desc" style="width:100%;max-width:400px;" rows="2" maxlength="100" placeholder="Max 100 characters for homepage card"><?php echo esc_textarea($short_desc); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="eu_program_page_link">Program Page Link</label></th>
            <td><input type="url" id="eu_program_page_link" name="eu_program_page_link" value="<?php echo esc_attr($page_link); ?>" style="width:100%;max-width:400px;" placeholder="https://... (full program page)"></td>
        </tr>
    </table>
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

    // Coach / Cost / Schedule
    if (isset($_POST['eu_program_coach'])) {
        update_post_meta($post_id, '_eu_program_coach', sanitize_text_field($_POST['eu_program_coach']));
    }
    if (isset($_POST['eu_program_cost'])) {
        update_post_meta($post_id, '_eu_program_cost', sanitize_text_field($_POST['eu_program_cost']));
    }
    if (isset($_POST['eu_program_schedule'])) {
        update_post_meta($post_id, '_eu_program_schedule', sanitize_text_field($_POST['eu_program_schedule']));
    }

    // Featured / Short Desc / Page Link (homepage showcase)
    update_post_meta($post_id, '_eu_program_featured', isset($_POST['eu_program_featured']) ? '1' : '0');
    if (isset($_POST['eu_program_short_desc'])) {
        update_post_meta($post_id, '_eu_program_short_desc', sanitize_text_field(mb_substr($_POST['eu_program_short_desc'], 0, 100)));
    }
    if (isset($_POST['eu_program_page_link'])) {
        update_post_meta($post_id, '_eu_program_page_link', esc_url_raw($_POST['eu_program_page_link']));
    }
}
add_action('save_post_eu_program', 'eu_save_program_meta');

// --- EU Testimonial Custom Post Type ---
function eu_register_testimonial_cpt() {
    register_post_type('eu_testimonial', [
        'labels' => [
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'menu_name'          => 'Testimonials',
            'add_new'            => 'Add New Testimonial',
            'add_new_item'       => 'Add New Testimonial',
            'edit_item'          => 'Edit Testimonial',
            'new_item'           => 'New Testimonial',
            'view_item'          => 'View Testimonial',
            'search_items'       => 'Search Testimonials',
            'not_found'          => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in Trash',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'supports'     => ['title', 'editor'],
        'menu_icon'    => 'dashicons-format-quote',
        'show_in_rest' => false,
    ]);
}
add_action('init', 'eu_register_testimonial_cpt');

// Testimonial meta box
function eu_testimonial_meta_box() {
    add_meta_box('eu_testimonial_details', 'Testimonial Details', 'eu_testimonial_meta_box_html', 'eu_testimonial', 'normal', 'high');
}
add_action('add_meta_boxes', 'eu_testimonial_meta_box');

function eu_testimonial_meta_box_html($post) {
    wp_nonce_field('eu_testimonial_meta_nonce_action', 'eu_testimonial_meta_nonce');
    $author_name = get_post_meta($post->ID, '_eu_testimonial_author', true);
    $program     = get_post_meta($post->ID, '_eu_testimonial_program', true);
    $featured    = get_post_meta($post->ID, '_eu_testimonial_featured', true);
    ?>
    <table class="form-table" style="margin-top:0;">
        <tr>
            <th><label for="eu_testimonial_author">Author Name</label></th>
            <td><input type="text" id="eu_testimonial_author" name="eu_testimonial_author" value="<?php echo esc_attr($author_name); ?>" style="width:100%;max-width:400px;" placeholder="e.g. Sarah M."></td>
        </tr>
        <tr>
            <th><label for="eu_testimonial_program">Program / Role</label></th>
            <td><input type="text" id="eu_testimonial_program" name="eu_testimonial_program" value="<?php echo esc_attr($program); ?>" style="width:100%;max-width:400px;" placeholder="e.g. Adult Nordic Program"></td>
        </tr>
        <tr>
            <th><label>Show on Homepage</label></th>
            <td>
                <label>
                    <input type="checkbox" name="eu_testimonial_featured" value="1" <?php checked($featured, '1'); ?>>
                    Feature in homepage slider
                </label>
            </td>
        </tr>
    </table>
    <p class="description">Use the main editor above to write the testimonial quote.</p>
    <?php
}

function eu_save_testimonial_meta($post_id) {
    if (!isset($_POST['eu_testimonial_meta_nonce'])) return;
    if (!wp_verify_nonce($_POST['eu_testimonial_meta_nonce'], 'eu_testimonial_meta_nonce_action')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['eu_testimonial_author'])) {
        update_post_meta($post_id, '_eu_testimonial_author', sanitize_text_field($_POST['eu_testimonial_author']));
    }
    if (isset($_POST['eu_testimonial_program'])) {
        update_post_meta($post_id, '_eu_testimonial_program', sanitize_text_field($_POST['eu_testimonial_program']));
    }
    update_post_meta($post_id, '_eu_testimonial_featured', isset($_POST['eu_testimonial_featured']) ? '1' : '0');
}
add_action('save_post_eu_testimonial', 'eu_save_testimonial_meta');

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

// Helper: render program card grid for a given group slug and status
function eu_render_program_boxes($group_slug, $status = 'open') {
    // For 'open' status, also include programs with no status set (default = open)
    if ($status === 'open') {
        $meta_query = [
            'relation' => 'OR',
            ['key' => '_eu_program_status', 'value' => 'open'],
            ['key' => '_eu_program_status', 'compare' => 'NOT EXISTS'],
            ['key' => '_eu_program_status', 'value' => ''],
        ];
    } else {
        $meta_query = [['key' => '_eu_program_status', 'value' => $status]];
    }

    $query = new WP_Query([
        'post_type'      => 'eu_program',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'meta_query'     => $meta_query,
        'tax_query'      => [['taxonomy' => 'eu_program_group', 'field' => 'slug', 'terms' => $group_slug]],
    ]);

    if (!$query->have_posts()) {
        echo '<p class="program-box-empty">No programs listed yet.</p>';
        wp_reset_postdata();
        return;
    }

    $closed_class = ($status === 'closed') ? ' program-card-grid--closed' : '';
    echo '<div class="program-card-grid' . $closed_class . '">';
    while ($query->have_posts()) {
        $query->the_post();
        $pid      = get_the_ID();
        $link     = get_post_meta($pid, '_eu_program_link', true);
        $coach    = get_post_meta($pid, '_eu_program_coach', true);
        $cost     = get_post_meta($pid, '_eu_program_cost', true);
        $schedule = get_post_meta($pid, '_eu_program_schedule', true);
        $thumb    = get_the_post_thumbnail_url($pid, 'medium_large');
        ?>
        <div class="program-card">
            <?php if ($thumb) : ?>
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <div class="program-card-img" style="background-image: url(<?php echo esc_url($thumb); ?>)"></div>
                </a>
            <?php endif; ?>
            <div class="program-card-body">
                <h3 class="program-card-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                <div class="program-card-meta">
                    <?php if ($coach) : ?>
                        <span class="program-card-coach">Coach: <?php echo eu_coach_link($coach); ?></span>
                    <?php endif; ?>
                    <?php if ($cost) : ?>
                        <span class="program-card-cost"><?php echo esc_html($cost); ?></span>
                    <?php endif; ?>
                    <?php if ($schedule) : ?>
                        <span class="program-card-schedule"><?php echo esc_html($schedule); ?></span>
                    <?php endif; ?>
                </div>
                <div class="program-card-desc"><?php echo wp_kses_post(get_the_content()); ?></div>
                <?php if ($link && $status === 'open') : ?>
                    <a href="<?php echo esc_url($link); ?>" class="program-card-cta">Register &rarr;</a>
                <?php else : ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="program-card-cta program-card-cta--details">View Details &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    echo '</div>';
    wp_reset_postdata();
}

// --- EU Staff & Board Custom Post Type ---
function eu_register_staff_cpt() {
    register_post_type('eu_staff', [
        'labels' => [
            'name'               => 'Staff & Board',
            'singular_name'      => 'Staff Member',
            'menu_name'          => 'Staff & Board',
            'add_new'            => 'Add New Member',
            'add_new_item'       => 'Add New Staff Member',
            'edit_item'          => 'Edit Staff Member',
            'new_item'           => 'New Staff Member',
            'view_item'          => 'View Staff Member',
            'search_items'       => 'Search Staff & Board',
            'not_found'          => 'No staff members found',
            'not_found_in_trash' => 'No staff members found in Trash',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'team', 'with_front' => false],
        'supports'     => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'menu_icon'    => 'dashicons-groups',
        'show_in_rest' => false,
    ]);

    register_taxonomy('eu_staff_group', 'eu_staff', [
        'labels' => [
            'name'          => 'Staff Groups',
            'singular_name' => 'Staff Group',
            'add_new_item'  => 'Add New Group',
            'edit_item'     => 'Edit Group',
            'search_items'  => 'Search Groups',
        ],
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ]);
}
add_action('init', 'eu_register_staff_cpt');

// Staff meta box
function eu_staff_meta_box() {
    add_meta_box('eu_staff_details', 'Staff Details', 'eu_staff_meta_box_html', 'eu_staff', 'normal', 'high');
}
add_action('add_meta_boxes', 'eu_staff_meta_box');

function eu_staff_meta_box_html($post) {
    wp_nonce_field('eu_staff_meta_nonce_action', 'eu_staff_meta_nonce');
    $role  = get_post_meta($post->ID, '_eu_staff_role', true);
    $email = get_post_meta($post->ID, '_eu_staff_email', true);
    ?>
    <table class="form-table" style="margin-top:0;">
        <tr>
            <th><label for="eu_staff_role">Role / Title</label></th>
            <td><input type="text" id="eu_staff_role" name="eu_staff_role" value="<?php echo esc_attr($role); ?>" style="width:100%;max-width:400px;" placeholder="e.g. President, Youth Head Coach, Adult Team Coach: Tuesday West PM"></td>
        </tr>
        <tr>
            <th><label for="eu_staff_email">Email</label></th>
            <td><input type="email" id="eu_staff_email" name="eu_staff_email" value="<?php echo esc_attr($email); ?>" style="width:100%;max-width:400px;" placeholder="e.g. name@enduranceunited.org (optional)"></td>
        </tr>
    </table>
    <p class="description">Use the main editor above to add a bio (optional). Coaches with bios get a larger featured card. Use the Featured Image to add a photo.</p>
    <?php
}

function eu_save_staff_meta($post_id) {
    if (!isset($_POST['eu_staff_meta_nonce'])) return;
    if (!wp_verify_nonce($_POST['eu_staff_meta_nonce'], 'eu_staff_meta_nonce_action')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['eu_staff_role'])) {
        update_post_meta($post_id, '_eu_staff_role', sanitize_text_field($_POST['eu_staff_role']));
    }
    if (isset($_POST['eu_staff_email'])) {
        update_post_meta($post_id, '_eu_staff_email', sanitize_email($_POST['eu_staff_email']));
    }
}
add_action('save_post_eu_staff', 'eu_save_staff_meta');

// Auto-create staff group terms
function eu_create_staff_groups() {
    $groups = [
        'Board of Directors',
        'Youth Coaches',
        'Adult Team Coaches',
        'Adult Learn to Ski Coaches',
        'Adult Intermediate Ski Coaches',
        'Junior Coaches',
        'Mountain Bike Coaches',
        'Paddle Coaches',
        'Guest Nordic Coaches',
    ];
    foreach ($groups as $name) {
        if (!term_exists($name, 'eu_staff_group')) {
            wp_insert_term($name, 'eu_staff_group');
        }
    }
}
add_action('init', 'eu_create_staff_groups');

// Helper: find a staff member by name (for linking coach names to profiles)
function eu_find_staff_by_name($name) {
    if (!$name) return null;
    $posts = get_posts([
        'post_type'      => 'eu_staff',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'title'          => $name,
    ]);
    return !empty($posts) ? $posts[0] : null;
}

// Helper: render a coach name, linked to their profile if they have a staff record
function eu_coach_link($name) {
    if (!$name) return '';
    $staff = eu_find_staff_by_name($name);
    if ($staff) {
        return '<a href="' . esc_url(get_permalink($staff)) . '" class="coach-name-link">' . esc_html($name) . '</a>';
    }
    return esc_html($name);
}

// Helper: render a staff/board section for a given group slug
function eu_render_staff_section($group_slug, $layout = 'auto') {
    $query = new WP_Query([
        'post_type'      => 'eu_staff',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'tax_query'      => [['taxonomy' => 'eu_staff_group', 'field' => 'slug', 'terms' => $group_slug]],
    ]);

    if (!$query->have_posts()) {
        echo '<p class="program-box-empty">No members listed yet.</p>';
        wp_reset_postdata();
        return;
    }

    // Determine layout: check if any member has a bio (editor content)
    if ($layout === 'auto') {
        $has_bio = false;
        while ($query->have_posts()) {
            $query->the_post();
            if (trim(get_the_content())) {
                $has_bio = true;
                break;
            }
        }
        $query->rewind_posts();
        $layout = $has_bio ? 'list' : 'grid';
    }

    if ($layout === 'grid') {
        // Compact card grid (board members, coaches without bios)
        echo '<div class="' . ($group_slug === 'board-of-directors' ? 'board-grid' : 'coaches-grid') . '">';
        while ($query->have_posts()) {
            $query->the_post();
            $pid   = get_the_ID();
            $role  = get_post_meta($pid, '_eu_staff_role', true);
            $email = get_post_meta($pid, '_eu_staff_email', true);
            $thumb = get_the_post_thumbnail_url($pid, 'medium');
            $is_board = ($group_slug === 'board-of-directors');
            ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="<?php echo $is_board ? 'board-card' : 'coach-card'; ?> staff-card-link">
                <?php if ($thumb) : ?>
                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                <?php else : ?>
                    <div class="<?php echo $is_board ? 'board-photo-placeholder' : 'coach-photo-placeholder'; ?>"></div>
                <?php endif; ?>
                <?php if ($is_board) : ?>
                    <h3><?php the_title(); ?></h3>
                    <?php if ($role) : ?>
                        <span class="board-role"><?php echo esc_html($role); ?></span>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="coach-info">
                        <h3><?php the_title(); ?></h3>
                        <?php if ($role) : ?>
                            <span class="coach-role"><?php echo esc_html($role); ?></span>
                        <?php endif; ?>
                        <?php if ($email) : ?>
                            <span class="coach-email"><?php echo esc_html($email); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </a>
            <?php
        }
        echo '</div>';
    } else {
        // Feature list layout (coaches with bios)
        echo '<div class="coaches-list">';
        while ($query->have_posts()) {
            $query->the_post();
            $pid     = get_the_ID();
            $role    = get_post_meta($pid, '_eu_staff_role', true);
            $email   = get_post_meta($pid, '_eu_staff_email', true);
            $thumb   = get_the_post_thumbnail_url($pid, 'medium');
            $content = trim(get_the_content());
            ?>
            <div class="coach-feature">
                <a href="<?php echo esc_url(get_permalink()); ?>" class="coach-feature-photo">
                    <?php if ($thumb) : ?>
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php else : ?>
                        <div class="coach-photo-placeholder"></div>
                    <?php endif; ?>
                </a>
                <div class="coach-feature-info">
                    <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                    <?php if ($role) : ?>
                        <span class="coach-role"><?php echo esc_html($role); ?></span>
                    <?php endif; ?>
                    <?php if ($email) : ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="coach-email" style="display:block;margin-bottom:10px;"><?php echo esc_html($email); ?></a>
                    <?php endif; ?>
                    <?php if ($content) : ?>
                        <p><?php echo wp_kses_post($content); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="staff-view-profile">View Profile &rarr;</a>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    }

    wp_reset_postdata();
}

// Flush rewrite rules on theme activation
function eu_flush_rewrite_rules() {
    eu_register_program_cpt();
    eu_register_testimonial_cpt();
    eu_register_staff_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'eu_flush_rewrite_rules');

// One-time flush when CPT rewrite rules change
function eu_maybe_flush_program_rewrite() {
    if ((int) get_option('eu_program_rewrite_version') < 2) {
        flush_rewrite_rules();
        update_option('eu_program_rewrite_version', 2);
    }
}
add_action('init', 'eu_maybe_flush_program_rewrite', 99);


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
// Program pages use template-program.php; hub pages use template-hub.php.
// Each page has its own option flag so it only gets created once.
// Bump this version to force re-check of page templates on existing pages.
function eu_create_site_pages() {
    $version = 2;
    if ((int) get_option('eu_pages_version') < $version) {
        // Clear all flags so templates get re-assigned on existing pages
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'eu_%_page_created'");
        update_option('eu_pages_version', $version);
    }

    $pages = [
        // Unique pages
        ['title' => 'News',                'slug' => 'news',                'template' => 'page-news.php',              'option' => 'eu_news_page_created'],
        ['title' => 'Testimonials',        'slug' => 'testimonials',        'template' => 'template-testimonials.php',  'option' => 'eu_testimonials_page_created'],

        // Hub pages (use consolidated hub template)
        ['title' => 'Nordic',              'slug' => 'nordic',              'template' => 'template-hub.php',           'option' => 'eu_nordic_page_created'],
        ['title' => 'Programs',            'slug' => 'programs',            'template' => 'template-hub.php',           'option' => 'eu_programs_page_created'],
        ['title' => 'Urban Trail Series',  'slug' => 'urban-trail-series',  'template' => 'template-hub.php',           'option' => 'eu_urban_trail_series_page_created'],

        // Race event pages (keep their specific templates for now — rich content)
        ['title' => 'Go Spring!',          'slug' => 'go-spring',           'template' => 'page-go-spring.php',         'option' => 'eu_go_spring_page_created'],
        ['title' => 'Night Light',         'slug' => 'night-light',         'template' => 'page-night-light.php',       'option' => 'eu_night_light_page_created'],
        ['title' => 'Turkey Day Trail Trot','slug' => 'turkey-day-trail-trot','template' => 'page-turkey-day.php',      'option' => 'eu_turkey_day_page_created'],

        // Program pages (use consolidated program template)
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
        if ($exists) {
            // Page already exists — ensure the template is assigned
            update_post_meta($exists->ID, '_wp_page_template', $page['template']);
        } else {
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
    // Note: ACF free doesn't support repeaters. Footer links use fixed slots instead.
    $site_settings_fields = [
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
    ];

    // Footer Get Involved Links — 4 fixed slots (label + url each)
    for ($i = 1; $i <= 4; $i++) {
        $site_settings_fields[] = [
            'key'   => 'field_get_involved_' . $i . '_tab',
            'label' => 'Get Involved Link ' . $i,
            'type'  => 'tab',
        ];
        $site_settings_fields[] = [
            'key'   => 'field_get_involved_label_' . $i,
            'label' => 'Get Involved Link ' . $i . ' Label',
            'name'  => 'get_involved_label_' . $i,
            'type'  => 'text',
            'instructions' => 'Leave blank to hide this link.',
        ];
        $site_settings_fields[] = [
            'key'   => 'field_get_involved_url_' . $i,
            'label' => 'Get Involved Link ' . $i . ' URL',
            'name'  => 'get_involved_url_' . $i,
            'type'  => 'url',
        ];
    }

    // Footer Our Team Links — 4 fixed slots
    for ($i = 1; $i <= 4; $i++) {
        $site_settings_fields[] = [
            'key'   => 'field_our_team_' . $i . '_tab',
            'label' => 'Our Team Link ' . $i,
            'type'  => 'tab',
        ];
        $site_settings_fields[] = [
            'key'   => 'field_our_team_label_' . $i,
            'label' => 'Our Team Link ' . $i . ' Label',
            'name'  => 'our_team_label_' . $i,
            'type'  => 'text',
            'instructions' => 'Leave blank to hide this link.',
        ];
        $site_settings_fields[] = [
            'key'   => 'field_our_team_url_' . $i,
            'label' => 'Our Team Link ' . $i . ' URL',
            'name'  => 'our_team_url_' . $i,
            'type'  => 'url',
        ];
    }

    acf_add_local_field_group([
        'key'      => 'group_site_settings',
        'title'    => 'Site Settings',
        'fields'   => $site_settings_fields,
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
    // Uses groups instead of repeaters (ACF free compatible).
    // Up to 5 program sections and 3 special notes.
    $program_fields = [
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
    ];

    // Season-aware description fields
    $month_choices = [
        '' => '— Not Set —',
        '1' => 'January', '2' => 'February', '3' => 'March',
        '4' => 'April', '5' => 'May', '6' => 'June',
        '7' => 'July', '8' => 'August', '9' => 'September',
        '10' => 'October', '11' => 'November', '12' => 'December',
    ];
    $program_fields[] = [
        'key'   => 'field_season_tab',
        'label' => 'Season',
        'type'  => 'tab',
    ];
    $program_fields[] = [
        'key'           => 'field_season_start_month',
        'label'         => 'Season Start Month',
        'name'          => 'season_start_month',
        'type'          => 'select',
        'choices'       => $month_choices,
        'default_value' => '5',
        'instructions'  => 'The month the new season begins. Leave blank to skip season descriptions.',
    ];
    $program_fields[] = [
        'key'           => 'field_season_end_month',
        'label'         => 'Season End Month',
        'name'          => 'season_end_month',
        'type'          => 'select',
        'choices'       => $month_choices,
        'default_value' => '4',
        'instructions'  => 'The month the season ends.',
    ];
    $program_fields[] = [
        'key'   => 'field_in_season_description',
        'label' => 'In-Season Description',
        'name'  => 'in_season_description',
        'type'  => 'wysiwyg',
        'tabs'  => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'instructions' => 'Shown during the active season (between start and end months).',
    ];
    $program_fields[] = [
        'key'   => 'field_off_season_description',
        'label' => 'Off-Season Description',
        'name'  => 'off_season_description',
        'type'  => 'wysiwyg',
        'tabs'  => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'instructions' => 'Shown outside the active season.',
    ];

    // Coaches section
    $program_fields[] = [
        'key'   => 'field_coaches_tab',
        'label' => 'Coaches',
        'type'  => 'tab',
    ];
    $program_fields[] = [
        'key'   => 'field_coaches_info',
        'label' => 'Coaches',
        'name'  => 'coaches_info',
        'type'  => 'wysiwyg',
        'tabs'  => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'instructions' => 'List coaches, their bios, and photos. Leave blank to hide this section.',
    ];

    // Equipment needs section
    $program_fields[] = [
        'key'   => 'field_equipment_tab',
        'label' => 'Equipment',
        'type'  => 'tab',
    ];
    $program_fields[] = [
        'key'   => 'field_equipment_needs',
        'label' => 'Equipment Needs',
        'name'  => 'equipment_needs',
        'type'  => 'wysiwyg',
        'tabs'  => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'instructions' => 'Equipment requirements and recommendations. Leave blank to hide this section.',
    ];

    // Special Notes — 3 fixed slots
    for ($i = 1; $i <= 3; $i++) {
        $program_fields[] = [
            'key'   => 'field_special_note_' . $i,
            'label' => 'Special Note ' . $i,
            'name'  => 'special_note_' . $i,
            'type'  => 'wysiwyg',
            'tabs'  => 'all',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'instructions' => 'Optional note (e.g. "ski pass required"). Leave blank to skip.',
        ];
    }

    // Program Sections — 5 fixed slots (covers paddling's 3, cycling's 2, etc.)
    for ($i = 1; $i <= 5; $i++) {
        $program_fields[] = [
            'key'   => 'field_section_' . $i . '_tab',
            'label' => 'Section ' . $i,
            'type'  => 'tab',
        ];
        $program_fields[] = [
            'key'   => 'field_section_title_' . $i,
            'label' => 'Section ' . $i . ' Title',
            'name'  => 'section_title_' . $i,
            'type'  => 'text',
            'instructions' => 'Leave blank to skip this section.',
        ];
        $program_fields[] = [
            'key'   => 'field_section_description_' . $i,
            'label' => 'Section ' . $i . ' Description',
            'name'  => 'section_description_' . $i,
            'type'  => 'wysiwyg',
            'tabs'  => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
            'instructions' => 'Detailed content for this section. Leave blank to show only program boxes.',
        ];
        $program_fields[] = [
            'key'   => 'field_section_group_slug_' . $i,
            'label' => 'Section ' . $i . ' Program Group Slug',
            'name'  => 'section_group_slug_' . $i,
            'type'  => 'text',
            'instructions' => 'The slug of the Program Group to pull boxes from (e.g. "adult-nordic", "paddling-junior").',
        ];
    }

    // Closed section settings (on a separate tab)
    $program_fields[] = [
        'key'   => 'field_closed_tab',
        'label' => 'Closed Section',
        'type'  => 'tab',
    ];
    $program_fields[] = [
        'key'           => 'field_show_closed_section',
        'label'         => 'Show Closed Section',
        'name'          => 'show_closed_section',
        'type'          => 'true_false',
        'default_value' => 1,
        'ui'            => 1,
        'instructions'  => 'Show the "Closed for the Season" section at the bottom.',
    ];
    $program_fields[] = [
        'key'           => 'field_closed_section_message',
        'label'         => 'Closed Section Message',
        'name'          => 'closed_section_message',
        'type'          => 'text',
        'default_value' => 'Programs listed below are closed for the season. For late sign-ups please reach out.',
    ];

    // Additional Information (bottom of page, after gallery)
    $program_fields[] = [
        'key'   => 'field_additional_tab',
        'label' => 'Additional Info',
        'type'  => 'tab',
    ];
    $program_fields[] = [
        'key'   => 'field_additional_info',
        'label' => 'Additional Information (Bottom of Page)',
        'name'  => 'additional_info',
        'type'  => 'wysiwyg',
        'tabs'  => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'instructions' => 'Optional content displayed below the photo gallery at the bottom of the page.',
    ];

    acf_add_local_field_group([
        'key'      => 'group_program_page_fields',
        'title'    => 'Program Page Fields',
        'fields'   => $program_fields,
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

    // --- Hero Slides Field Group (Front Page) ---
    // 8 fixed slide slots using individual fields (ACF free compatible)
    $hero_fields = [];
    $slide_defaults = [
        1 => ['title' => 'Welcome to EnduranceUnited', 'subtitle' => 'Pushing limits. Building champions. Join the movement.', 'color' => '#2c3e50'],
        2 => ['title' => 'Nordic Programs',            'subtitle' => 'Train with the best coaches in cross-country skiing, biathlon, and more.', 'color' => '#1a5276'],
        3 => ['title' => 'Race Events 2026',           'subtitle' => 'Register now for the upcoming season of competitive endurance events.', 'color' => '#4a235a'],
        4 => ['title' => 'Youth Development',          'subtitle' => 'Building the next generation of endurance athletes from the ground up.', 'color' => '#1e8449'],
    ];

    for ($i = 1; $i <= 8; $i++) {
        $d = isset($slide_defaults[$i]) ? $slide_defaults[$i] : ['title' => '', 'subtitle' => '', 'color' => '#2c3e50'];
        $hero_fields[] = [
            'key'   => 'field_slide_' . $i . '_tab',
            'label' => 'Slide ' . $i,
            'type'  => 'tab',
        ];
        $hero_fields[] = [
            'key'           => 'field_slide_title_' . $i,
            'label'         => 'Slide ' . $i . ' Title',
            'name'          => 'slide_title_' . $i,
            'type'          => 'text',
            'default_value' => $d['title'],
            'instructions'  => 'Leave blank to hide this slide.',
        ];
        $hero_fields[] = [
            'key'           => 'field_slide_subtitle_' . $i,
            'label'         => 'Slide ' . $i . ' Subtitle',
            'name'          => 'slide_subtitle_' . $i,
            'type'          => 'text',
            'default_value' => $d['subtitle'],
        ];
        $hero_fields[] = [
            'key'           => 'field_slide_image_' . $i,
            'label'         => 'Slide ' . $i . ' Background Image',
            'name'          => 'slide_image_' . $i,
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => 'Upload a background image for this slide. The color below is used as a fallback.',
        ];
        $hero_fields[] = [
            'key'           => 'field_slide_bg_color_' . $i,
            'label'         => 'Slide ' . $i . ' Background Color',
            'name'          => 'slide_bg_color_' . $i,
            'type'          => 'color_picker',
            'default_value' => $d['color'],
            'instructions'  => 'Shown while image loads or if no image is set.',
        ];
        $hero_fields[] = [
            'key'           => 'field_slide_btn_text_' . $i,
            'label'         => 'Slide ' . $i . ' Button Text',
            'name'          => 'slide_btn_text_' . $i,
            'type'          => 'text',
            'instructions'  => 'e.g. "Learn More", "Register Now". Leave blank for no button.',
        ];
        $hero_fields[] = [
            'key'           => 'field_slide_btn_url_' . $i,
            'label'         => 'Slide ' . $i . ' Button Link',
            'name'          => 'slide_btn_url_' . $i,
            'type'          => 'url',
            'instructions'  => 'URL the button links to.',
        ];
    }

    acf_add_local_field_group([
        'key'      => 'group_hero_slides',
        'title'    => 'Hero Slider',
        'fields'   => $hero_fields,
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'menu_order' => 0,
    ]);

    // --- Two Column Boxes Field Group (Front Page) ---
    // 2 boxes: each has title, text, link label, link URL, bg color
    $twocol_fields = [];
    $twocol_defaults = [
        1 => ['title' => 'Latest News', 'text' => 'Stay up to date with the latest program announcements, race results, and community highlights from EnduranceUnited.', 'link_label' => 'Read More', 'link_url' => '/news/', 'color' => '#2D62A5'],
        2 => ['title' => 'Upcoming Events', 'text' => 'Check out our calendar of races, training camps, and community gatherings happening throughout the season.', 'link_label' => 'View Events', 'link_url' => '/events/', 'color' => '#245089'],
    ];

    for ($i = 1; $i <= 2; $i++) {
        $d = $twocol_defaults[$i];
        $twocol_fields[] = [
            'key'   => 'field_twocol_' . $i . '_tab',
            'label' => 'Box ' . $i,
            'type'  => 'tab',
        ];
        $twocol_fields[] = [
            'key'           => 'field_twocol_title_' . $i,
            'label'         => 'Box ' . $i . ' Title',
            'name'          => 'twocol_title_' . $i,
            'type'          => 'text',
            'default_value' => $d['title'],
        ];
        $twocol_fields[] = [
            'key'           => 'field_twocol_text_' . $i,
            'label'         => 'Box ' . $i . ' Text',
            'name'          => 'twocol_text_' . $i,
            'type'          => 'textarea',
            'rows'          => 3,
            'default_value' => $d['text'],
        ];
        $twocol_fields[] = [
            'key'           => 'field_twocol_link_label_' . $i,
            'label'         => 'Box ' . $i . ' Link Label',
            'name'          => 'twocol_link_label_' . $i,
            'type'          => 'text',
            'default_value' => $d['link_label'],
        ];
        $twocol_fields[] = [
            'key'           => 'field_twocol_link_url_' . $i,
            'label'         => 'Box ' . $i . ' Link URL',
            'name'          => 'twocol_link_url_' . $i,
            'type'          => 'url',
            'instructions'  => 'Full URL (e.g. https://yoursite.com/news/).',
        ];
        $twocol_fields[] = [
            'key'           => 'field_twocol_color_' . $i,
            'label'         => 'Box ' . $i . ' Background Color',
            'name'          => 'twocol_color_' . $i,
            'type'          => 'color_picker',
            'default_value' => $d['color'],
        ];
    }

    acf_add_local_field_group([
        'key'      => 'group_twocol_boxes',
        'title'    => 'Two Column Boxes',
        'fields'   => $twocol_fields,
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'menu_order' => 10,
    ]);

    // --- Feature Grid Field Group (Front Page) ---
    // 4 boxes: each has label, title, text, CTA text, link URL, bg color
    $feat_fields = [];
    $feat_defaults = [
        1 => ['label' => 'Upcoming Race',     'title' => 'City of Lakes Loppet',              'text' => 'Check the calendar for the next race and get registered before spots fill up.', 'cta' => 'View Calendar', 'color' => '#2D62A5'],
        2 => ['label' => 'Featured Program',   'title' => 'Adult Year-Round Nordic',           'text' => 'Train with experienced coaches year-round. Beginner to advanced skiers welcome.', 'cta' => 'Learn More', 'color' => '#B9313A'],
        3 => ['label' => 'From the Blog',      'title' => 'Season Recap & What\'s Ahead',      'text' => 'A look back at an incredible season and a preview of what\'s coming next.', 'cta' => 'Read Post', 'color' => '#333333'],
        4 => ['label' => 'Support EU',         'title' => 'Make a Donation',                   'text' => 'Your donations fund scholarships, equipment, trail access, and youth programs so everyone can get outside.', 'cta' => 'Donate Now', 'url' => 'https://checkout.square.site/merchant/CR5SR1AYB52YS/checkout/JIDMUSWX6MU3NZEM2LJQ6APV', 'color' => '#2D62A5'],
    ];

    for ($i = 1; $i <= 4; $i++) {
        $d = $feat_defaults[$i];
        $feat_fields[] = [
            'key'   => 'field_feat_' . $i . '_tab',
            'label' => 'Feature ' . $i,
            'type'  => 'tab',
        ];
        $feat_fields[] = [
            'key'           => 'field_feat_label_' . $i,
            'label'         => 'Feature ' . $i . ' Label',
            'name'          => 'feat_label_' . $i,
            'type'          => 'text',
            'default_value' => $d['label'],
            'instructions'  => 'Small uppercase label above the title (e.g. "Upcoming Race"). Leave blank to hide this box.',
        ];
        $feat_fields[] = [
            'key'           => 'field_feat_title_' . $i,
            'label'         => 'Feature ' . $i . ' Title',
            'name'          => 'feat_title_' . $i,
            'type'          => 'text',
            'default_value' => $d['title'],
        ];
        $feat_fields[] = [
            'key'           => 'field_feat_text_' . $i,
            'label'         => 'Feature ' . $i . ' Description',
            'name'          => 'feat_text_' . $i,
            'type'          => 'textarea',
            'rows'          => 2,
            'default_value' => $d['text'],
        ];
        $feat_fields[] = [
            'key'           => 'field_feat_cta_' . $i,
            'label'         => 'Feature ' . $i . ' Button Text',
            'name'          => 'feat_cta_' . $i,
            'type'          => 'text',
            'default_value' => $d['cta'],
        ];
        $feat_fields[] = [
            'key'           => 'field_feat_url_' . $i,
            'label'         => 'Feature ' . $i . ' Link URL',
            'name'          => 'feat_url_' . $i,
            'type'          => 'url',
            'instructions'  => 'Where this box links to.',
        ];
        $feat_fields[] = [
            'key'           => 'field_feat_color_' . $i,
            'label'         => 'Feature ' . $i . ' Background Color',
            'name'          => 'feat_color_' . $i,
            'type'          => 'color_picker',
            'default_value' => $d['color'],
        ];
    }

    acf_add_local_field_group([
        'key'      => 'group_feature_grid',
        'title'    => 'Feature Grid (2x2)',
        'fields'   => $feat_fields,
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'menu_order' => 20,
    ]);

    // --- Hub Page Fields Field Group ---
    // For summary/hub pages (Nordic, Programs, Urban Trail Series, etc.)
    // Up to 6 showcase cards with title, description, link, image, and color.
    $hub_fields = [
        [
            'key'   => 'field_hub_intro',
            'label' => 'Page Introduction',
            'name'  => 'hub_intro',
            'type'  => 'textarea',
            'rows'  => 3,
            'instructions' => 'A short intro paragraph displayed below the page title.',
        ],
    ];

    for ($i = 1; $i <= 6; $i++) {
        $hub_fields[] = [
            'key'   => 'field_hub_card_' . $i . '_tab',
            'label' => 'Card ' . $i,
            'type'  => 'tab',
        ];
        $hub_fields[] = [
            'key'   => 'field_hub_card_title_' . $i,
            'label' => 'Card ' . $i . ' Title',
            'name'  => 'hub_card_title_' . $i,
            'type'  => 'text',
            'instructions' => 'Leave blank to hide this card.',
        ];
        $hub_fields[] = [
            'key'   => 'field_hub_card_desc_' . $i,
            'label' => 'Card ' . $i . ' Description',
            'name'  => 'hub_card_desc_' . $i,
            'type'  => 'textarea',
            'rows'  => 2,
        ];
        $hub_fields[] = [
            'key'   => 'field_hub_card_link_' . $i,
            'label' => 'Card ' . $i . ' Link',
            'name'  => 'hub_card_link_' . $i,
            'type'  => 'url',
            'instructions' => 'URL this card links to (e.g. the sub-page).',
        ];
        $hub_fields[] = [
            'key'           => 'field_hub_card_image_' . $i,
            'label'         => 'Card ' . $i . ' Image',
            'name'          => 'hub_card_image_' . $i,
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => 'Optional card image. If empty, the background color below is used.',
        ];
        $hub_fields[] = [
            'key'           => 'field_hub_card_color_' . $i,
            'label'         => 'Card ' . $i . ' Background Color',
            'name'          => 'hub_card_color_' . $i,
            'type'          => 'color_picker',
            'default_value' => '#2c3e50',
            'instructions'  => 'Fallback color when no image is set.',
        ];
    }

    acf_add_local_field_group([
        'key'      => 'group_hub_page_fields',
        'title'    => 'Hub Page Cards',
        'fields'   => $hub_fields,
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'template-hub.php',
                ],
            ],
        ],
        'menu_order' => 0,
    ]);

}
add_action('acf/init', 'eu_register_acf_field_groups');
