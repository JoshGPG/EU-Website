<?php
/**
 * Template Name: Program Page
 *
 * A consolidated template for all program pages (Adult Nordic, Juniors, Youth,
 * Paddling, Cycling, Trail Running, etc.). Content is managed via ACF fields
 * in the page editor rather than hardcoded in PHP.
 */
get_header();

$subtitle       = get_field('program_subtitle');
$intro           = get_field('program_intro');
$special_notes   = get_field('special_notes');
$sections        = get_field('program_sections');
$show_closed     = get_field('show_closed_section');
$closed_message  = get_field('closed_section_message');
?>

<h1 class="page-title"><?php the_title(); ?></h1>

<?php if ($subtitle) : ?>
    <p class="nordic-closed-note"><?php echo esc_html($subtitle); ?></p>
<?php endif; ?>

<?php if ($intro) : ?>
    <div class="nordic-intro">
        <?php echo wp_kses_post($intro); ?>
    </div>
<?php endif; ?>

<?php if (!empty($special_notes)) : ?>
    <?php foreach ($special_notes as $note) : ?>
        <div class="nordic-intro">
            <?php echo wp_kses_post($note['note_text']); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($sections)) : ?>
    <?php foreach ($sections as $section) : ?>
        <h2 class="nordic-section-title"><?php echo esc_html($section['section_title']); ?></h2>

        <?php if (!empty($section['section_description'])) : ?>
            <div class="paddle-program-detail">
                <?php echo wp_kses_post($section['section_description']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($section['program_group_slug'])) : ?>
            <?php eu_render_program_boxes($section['program_group_slug'], 'open'); ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($show_closed && !empty($sections)) : ?>
    <h2 class="nordic-section-title closed" style="margin-top: 40px;">Closed for the Season</h2>
    <?php if ($closed_message) : ?>
        <p class="nordic-closed-note"><?php echo esc_html($closed_message); ?></p>
    <?php endif; ?>

    <?php foreach ($sections as $section) : ?>
        <?php if (!empty($section['program_group_slug'])) : ?>
            <?php eu_render_program_boxes($section['program_group_slug'], 'closed'); ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php get_footer(); ?>
