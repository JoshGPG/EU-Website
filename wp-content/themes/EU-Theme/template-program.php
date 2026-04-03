<?php
/**
 * Template Name: Program Page
 *
 * A consolidated template for all program pages (Adult Nordic, Juniors, Youth,
 * Paddling, Cycling, Trail Running, etc.). Content is managed via ACF fields
 * in the page editor rather than hardcoded in PHP.
 *
 * Auto-detects the program group from the page slug so programs show up
 * automatically when assigned to the matching group. Manual sections still
 * work for multi-group pages (Paddling, Cycling).
 *
 * Uses individual numbered fields (ACF free compatible, no repeaters).
 */
get_header();

$subtitle       = get_field('program_subtitle');
$intro          = get_field('program_intro');
$show_closed    = get_field('show_closed_section');
$closed_message = get_field('closed_section_message');
$coaches        = get_field('coaches_info');
$equipment      = get_field('equipment_needs');
$additional     = get_field('additional_info');

// Auto-detect group slug from the page slug (e.g. "adult-nordic" page → "adult-nordic" group)
$auto_slug = $post->post_name;

// Season-aware description
$season_start = (int) get_field('season_start_month');
$season_end   = (int) get_field('season_end_month');
$current_month = (int) date('n');
$season_desc   = '';

if ($season_start && $season_end) {
    // Handle seasons that wrap around the year (e.g. May–April)
    if ($season_start <= $season_end) {
        $in_season = ($current_month >= $season_start && $current_month <= $season_end);
    } else {
        $in_season = ($current_month >= $season_start || $current_month <= $season_end);
    }

    $season_desc = $in_season
        ? get_field('in_season_description')
        : get_field('off_season_description');
}

// Collect special notes (up to 3 slots)
$special_notes = [];
for ($i = 1; $i <= 3; $i++) {
    $note = get_field('special_note_' . $i);
    if ($note) $special_notes[] = $note;
}

// Collect program sections (up to 5 slots) — for multi-group pages like Paddling/Cycling
// Only count a section as "configured" if it has BOTH a title AND a group slug
$sections = [];
for ($i = 1; $i <= 5; $i++) {
    $title      = get_field('section_title_' . $i);
    $group_slug = get_field('section_group_slug_' . $i);
    if ($title && $group_slug) {
        $sections[] = [
            'title'       => $title,
            'description' => get_field('section_description_' . $i),
            'group_slug'  => $group_slug,
        ];
    }
}

// Use manual section slugs if configured, otherwise auto-detect from page slug
$has_manual_sections = !empty($sections);
$group_slugs = [];
if ($has_manual_sections) {
    foreach ($sections as $section) {
        $group_slugs[] = $section['group_slug'];
    }
} else {
    $group_slugs[] = $auto_slug;
}
?>

<?php // --- TEMPORARY DEBUG — remove after testing --- ?>
<?php if (current_user_can('manage_options')) : ?>
<div style="background:#fff3cd;border:2px solid #ffc107;padding:15px;margin-bottom:20px;border-radius:6px;font-size:0.85rem;">
    <strong>DEBUG (admin-only):</strong><br>
    Page slug: <code><?php echo esc_html($auto_slug); ?></code><br>
    Manual sections found: <code><?php echo $has_manual_sections ? 'YES (' . count($sections) . ')' : 'NO'; ?></code><br>
    Group slugs being queried: <code><?php echo esc_html(implode(', ', $group_slugs)); ?></code><br>
    <?php
    // Check what the taxonomy term looks like
    $term = get_term_by('slug', $group_slugs[0], 'eu_program_group');
    if ($term) {
        echo 'Taxonomy term found: <code>' . esc_html($term->name) . '</code> (slug: <code>' . esc_html($term->slug) . '</code>, ' . $term->count . ' programs assigned)<br>';
    } else {
        echo '<span style="color:red;">Taxonomy term "<code>' . esc_html($group_slugs[0]) . '</code>" NOT FOUND in eu_program_group!</span><br>';
        // List all available terms
        $all_terms = get_terms(['taxonomy' => 'eu_program_group', 'hide_empty' => false]);
        if (!is_wp_error($all_terms) && !empty($all_terms)) {
            echo 'Available group slugs: ';
            $slugs = [];
            foreach ($all_terms as $t) {
                $slugs[] = '<code>' . esc_html($t->slug) . '</code> (' . $t->count . ')';
            }
            echo implode(', ', $slugs) . '<br>';
        }
    }
    // Try the actual query
    $debug_query = new WP_Query([
        'post_type' => 'eu_program',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'tax_query' => [['taxonomy' => 'eu_program_group', 'field' => 'slug', 'terms' => $group_slugs[0]]],
    ]);
    echo 'Programs in this group (any status): <code>' . $debug_query->found_posts . '</code><br>';
    if ($debug_query->have_posts()) {
        while ($debug_query->have_posts()) {
            $debug_query->the_post();
            $s = get_post_meta(get_the_ID(), '_eu_program_status', true);
            echo '&nbsp;&nbsp;- ' . esc_html(get_the_title()) . ' (status: <code>' . esc_html($s ?: '[not set]') . '</code>)<br>';
        }
        wp_reset_postdata();
    }
    ?>
</div>
<?php endif; ?>

<h1 class="page-title"><?php the_title(); ?></h1>

<?php if ($subtitle) : ?>
    <p class="nordic-closed-note"><?php echo esc_html($subtitle); ?></p>
<?php endif; ?>

<?php if ($season_desc) : ?>
    <div class="nordic-intro">
        <?php echo wp_kses_post($season_desc); ?>
    </div>
<?php endif; ?>

<?php if ($intro) : ?>
    <div class="nordic-intro">
        <?php echo wp_kses_post($intro); ?>
    </div>
<?php endif; ?>

<?php foreach ($special_notes as $note) : ?>
    <div class="nordic-intro">
        <?php echo wp_kses_post($note); ?>
    </div>
<?php endforeach; ?>

<?php if ($coaches) : ?>
    <h2 class="nordic-section-title">Coaches</h2>
    <div class="paddle-program-detail">
        <?php echo wp_kses_post($coaches); ?>
    </div>
<?php endif; ?>

<?php if ($equipment) : ?>
    <h2 class="nordic-section-title">Equipment Needs</h2>
    <div class="paddle-program-detail">
        <?php echo wp_kses_post($equipment); ?>
    </div>
<?php endif; ?>

<?php if ($has_manual_sections) : ?>
    <?php // --- Manual sections (for multi-group pages like Paddling/Cycling) --- ?>
    <?php foreach ($sections as $section) : ?>
        <h2 class="nordic-section-title"><?php echo esc_html($section['title']); ?></h2>

        <?php if (!empty($section['description'])) : ?>
            <div class="paddle-program-detail">
                <?php echo wp_kses_post($section['description']); ?>
            </div>
        <?php endif; ?>

        <?php eu_render_program_boxes($section['group_slug'], 'open'); ?>
    <?php endforeach; ?>
<?php else : ?>
    <?php // --- Auto-detected open programs from page slug --- ?>
    <h2 class="nordic-section-title">Open for Registration</h2>
    <?php eu_render_program_boxes($auto_slug, 'open'); ?>
<?php endif; ?>

<?php // --- Closed for the Season --- ?>
<?php if ($show_closed !== false) : ?>
    <?php
    // Check if there are any closed programs before showing the heading
    $has_closed = false;
    foreach ($group_slugs as $slug) {
        $check = new WP_Query([
            'post_type'      => 'eu_program',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'meta_query'     => [['key' => '_eu_program_status', 'value' => 'closed']],
            'tax_query'      => [['taxonomy' => 'eu_program_group', 'field' => 'slug', 'terms' => $slug]],
        ]);
        if ($check->have_posts()) {
            $has_closed = true;
        }
        wp_reset_postdata();
    }
    ?>

    <?php if ($has_closed) : ?>
        <h2 class="nordic-section-title closed" style="margin-top: 40px;">Closed for the Season</h2>
        <?php if ($closed_message) : ?>
            <p class="nordic-closed-note"><?php echo esc_html($closed_message); ?></p>
        <?php endif; ?>

        <?php foreach ($group_slugs as $slug) : ?>
            <?php eu_render_program_boxes($slug, 'closed'); ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<?php // --- Photo Gallery (from page attachments) --- ?>
<?php eu_render_photo_gallery(); ?>

<?php // --- Additional Information (bottom of page) --- ?>
<?php if ($additional) : ?>
    <div class="nordic-intro" style="margin-top: 30px;">
        <?php echo wp_kses_post($additional); ?>
    </div>
<?php endif; ?>

<?php get_footer(); ?>
