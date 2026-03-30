<?php
/**
 * Template Name: Program Page
 *
 * A consolidated template for all program pages (Adult Nordic, Juniors, Youth,
 * Paddling, Cycling, Trail Running, etc.). Content is managed via ACF fields
 * in the page editor rather than hardcoded in PHP.
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

// Collect program sections (up to 5 slots)
$sections = [];
for ($i = 1; $i <= 5; $i++) {
    $title = get_field('section_title_' . $i);
    if ($title) {
        $sections[] = [
            'title'       => $title,
            'description' => get_field('section_description_' . $i),
            'group_slug'  => get_field('section_group_slug_' . $i),
        ];
    }
}
?>

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

<?php foreach ($sections as $section) : ?>
    <h2 class="nordic-section-title"><?php echo esc_html($section['title']); ?></h2>

    <?php if (!empty($section['description'])) : ?>
        <div class="paddle-program-detail">
            <?php echo wp_kses_post($section['description']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($section['group_slug'])) : ?>
        <?php eu_render_program_boxes($section['group_slug'], 'open'); ?>
    <?php endif; ?>
<?php endforeach; ?>

<?php if ($show_closed && !empty($sections)) : ?>
    <h2 class="nordic-section-title closed" style="margin-top: 40px;">Closed for the Season</h2>
    <?php if ($closed_message) : ?>
        <p class="nordic-closed-note"><?php echo esc_html($closed_message); ?></p>
    <?php endif; ?>

    <?php foreach ($sections as $section) : ?>
        <?php if (!empty($section['group_slug'])) : ?>
            <?php eu_render_program_boxes($section['group_slug'], 'closed'); ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php get_footer(); ?>
