<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();
    $date       = get_post_meta(get_the_ID(), '_eu_event_date', true);
    $start_time = get_post_meta(get_the_ID(), '_eu_event_start_time', true);
    $end_time   = get_post_meta(get_the_ID(), '_eu_event_end_time', true);
    $location   = get_post_meta(get_the_ID(), '_eu_event_location', true);
?>

    <article class="single-event">
        <h1 class="post-title"><?php the_title(); ?></h1>

        <div class="event-meta-box">
            <?php if ($date) : ?>
                <div class="event-meta-item">
                    <strong>Date:</strong>
                    <?php echo esc_html(date_i18n('F j, Y', strtotime($date))); ?>
                </div>
            <?php endif; ?>

            <?php if ($start_time || $end_time) : ?>
                <div class="event-meta-item">
                    <strong>Time:</strong>
                    <?php
                    if ($start_time) echo esc_html(date_i18n('g:i A', strtotime($start_time)));
                    if ($start_time && $end_time) echo ' &ndash; ';
                    if ($end_time) echo esc_html(date_i18n('g:i A', strtotime($end_time)));
                    ?>
                </div>
            <?php endif; ?>

            <?php if ($location) : ?>
                <div class="event-meta-item">
                    <strong>Location:</strong>
                    <?php echo esc_html($location); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (has_post_thumbnail()) : ?>
            <div class="event-thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <div class="post-content">
            <?php the_content(); ?>
        </div>
    </article>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
