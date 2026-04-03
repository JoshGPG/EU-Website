<?php
/**
 * Single Staff/Board Member Detail Page
 *
 * Automatically used by WordPress for individual eu_staff posts.
 * Displays photo, role, email, bio, and photo gallery.
 */
get_header();

if (have_posts()) : while (have_posts()) : the_post();

$pid   = get_the_ID();
$role  = get_post_meta($pid, '_eu_staff_role', true);
$email = get_post_meta($pid, '_eu_staff_email', true);
$thumb = get_the_post_thumbnail_url($pid, 'large');

// Determine back link: board member → Board page, coach → Coaches page
$groups    = get_the_terms($pid, 'eu_staff_group');
$back_link  = '';
$back_label = '';
if ($groups && !is_wp_error($groups)) {
    $is_board = false;
    foreach ($groups as $g) {
        if ($g->slug === 'board-of-directors') {
            $is_board = true;
            break;
        }
    }
    if ($is_board) {
        $back_page = get_page_by_path('board-of-directors');
        if ($back_page) {
            $back_link  = get_permalink($back_page);
            $back_label = 'Board of Directors';
        }
    } else {
        $back_page = get_page_by_path('coaches');
        if ($back_page) {
            $back_link  = get_permalink($back_page);
            $back_label = 'Coaches';
        }
    }
}
?>

<?php if ($back_link) : ?>
    <a href="<?php echo esc_url($back_link); ?>" class="staff-detail-back">
        &larr; Back to <?php echo esc_html($back_label); ?>
    </a>
<?php endif; ?>

<div class="staff-detail-header">
    <?php if ($thumb) : ?>
        <div class="staff-detail-photo">
            <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
        </div>
    <?php endif; ?>

    <div class="staff-detail-info">
        <h1 class="page-title"><?php the_title(); ?></h1>

        <?php if ($role) : ?>
            <span class="staff-detail-role"><?php echo esc_html($role); ?></span>
        <?php endif; ?>

        <?php if ($email) : ?>
            <a href="mailto:<?php echo esc_attr($email); ?>" class="staff-detail-email"><?php echo esc_html($email); ?></a>
        <?php endif; ?>
    </div>
</div>

<?php if (get_the_content()) : ?>
    <div class="staff-detail-bio nordic-intro">
        <?php the_content(); ?>
    </div>
<?php endif; ?>

<?php eu_render_photo_gallery(get_the_title() . ' Photos'); ?>

<?php if ($back_link) : ?>
    <div style="margin-top: 30px;">
        <a href="<?php echo esc_url($back_link); ?>" class="staff-detail-back">
            &larr; Back to <?php echo esc_html($back_label); ?>
        </a>
    </div>
<?php endif; ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
