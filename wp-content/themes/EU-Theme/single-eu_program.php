<?php
/**
 * Single Program Detail Page
 *
 * Automatically used by WordPress for individual eu_program posts.
 * Displays full description, photos, coach, schedule, cost, and registration.
 */
get_header();

if (have_posts()) : while (have_posts()) : the_post();

$pid      = get_the_ID();
$status   = get_post_meta($pid, '_eu_program_status', true) ?: 'open';
$link     = get_post_meta($pid, '_eu_program_link', true);
$coach    = get_post_meta($pid, '_eu_program_coach', true);
$cost     = get_post_meta($pid, '_eu_program_cost', true);
$schedule = get_post_meta($pid, '_eu_program_schedule', true);
$thumb    = get_the_post_thumbnail_url($pid, 'large');

// Determine the program group for the "back to..." link
$groups = get_the_terms($pid, 'eu_program_group');
$back_link  = '';
$back_label = '';
if ($groups && !is_wp_error($groups)) {
    $group = $groups[0];
    $page  = get_page_by_path($group->slug);
    if (!$page) {
        // Try shorter slug (e.g. "paddling" from "paddling-junior")
        $slug_parts = explode('-', $group->slug);
        while (!$page && count($slug_parts) > 1) {
            array_pop($slug_parts);
            $page = get_page_by_path(implode('-', $slug_parts));
        }
    }
    if ($page) {
        $back_link  = get_permalink($page);
        $back_label = get_the_title($page);
    }
}
?>

<?php if ($back_link) : ?>
    <a href="<?php echo esc_url($back_link); ?>" class="program-detail-back">
        &larr; Back to <?php echo esc_html($back_label); ?>
    </a>
<?php endif; ?>

<?php if ($thumb) : ?>
    <div class="program-detail-hero" style="background-image: url(<?php echo esc_url($thumb); ?>);"></div>
<?php endif; ?>

<h1 class="page-title"><?php the_title(); ?></h1>

<span class="program-detail-status program-detail-status--<?php echo esc_attr($status); ?>">
    <?php echo ($status === 'open') ? 'Open for Registration' : 'Closed for the Season'; ?>
</span>

<?php if ($coach || $cost || $schedule || $link) : ?>
<div class="program-detail-meta">
    <?php if ($coach) : ?>
        <div class="program-detail-meta-item">
            <strong>Coach:</strong> <?php echo eu_coach_link($coach); ?>
        </div>
    <?php endif; ?>
    <?php if ($cost) : ?>
        <div class="program-detail-meta-item">
            <strong>Cost:</strong> <?php echo esc_html($cost); ?>
        </div>
    <?php endif; ?>
    <?php if ($schedule) : ?>
        <div class="program-detail-meta-item">
            <strong>Schedule:</strong> <?php echo esc_html($schedule); ?>
        </div>
    <?php endif; ?>
    <?php if ($link && $status === 'open') : ?>
        <a href="<?php echo esc_url($link); ?>" class="program-detail-register" target="_blank" rel="noopener">
            Register Now &rarr;
        </a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if (get_the_content()) : ?>
    <div class="program-detail-description nordic-intro">
        <?php the_content(); ?>
    </div>
<?php endif; ?>

<?php eu_render_photo_gallery(get_the_title() . ' Photos'); ?>

<?php if ($link && $status === 'open') : ?>
<div class="program-detail-cta-section">
    <h2 class="nordic-section-title">Ready to Join?</h2>
    <p>Sign up for <?php the_title(); ?> today.</p>
    <a href="<?php echo esc_url($link); ?>" class="program-detail-register program-detail-register--lg" target="_blank" rel="noopener">
        Register Now &rarr;
    </a>
</div>
<?php elseif ($status === 'closed') : ?>
<div class="program-detail-cta-section program-detail-cta-section--closed">
    <h2 class="nordic-section-title closed">Registration Closed</h2>
    <p class="nordic-closed-note">This program is currently closed for the season. Check back later or reach out for more information.</p>
</div>
<?php endif; ?>

<?php if ($back_link) : ?>
    <div style="margin-top: 30px;">
        <a href="<?php echo esc_url($back_link); ?>" class="program-detail-back">
            &larr; Back to <?php echo esc_html($back_label); ?>
        </a>
    </div>
<?php endif; ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
