<?php
/**
 * Template Name: Events Listing
 */
get_header();

$today = date('Y-m-d');

$events_query = new WP_Query([
    'post_type' => 'eu_event',
    'posts_per_page' => 20,
    'post_status' => 'publish',
    'meta_key' => '_eu_event_date',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => [
        [
            'key' => '_eu_event_date',
            'value' => $today,
            'compare' => '>=',
            'type' => 'DATE',
        ],
    ],
]);
?>

<h1 class="page-title">Upcoming Events</h1>

<?php if ($events_query->have_posts()): ?>
<div class="events-listing">
    <?php while ($events_query->have_posts()):
        $events_query->the_post();
        //$date       = get_post_meta(get_the_ID(), '_eu_event_date', true);
        $date = get_field('eu_event_date');
        $start_time = get_post_meta(get_the_ID(), '_eu_event_start_time', true);
        $end_time = get_post_meta(get_the_ID(), '_eu_event_end_time', true);
        $location = get_post_meta(get_the_ID(), '_eu_event_location', true);
?>
    <div class="event-card">
        <?php if ($date): ?>
        <div class="event-date-badge">
            <span class="event-month">
                <?php echo esc_html(date_i18n('M', strtotime($date))); ?>
            </span>
            <span class="event-day">
                <?php echo esc_html(date_i18n('j', strtotime($date))); ?>
            </span>
        </div>
        <?php
        endif; ?>

        <div class="event-card-content">
            <h2 class="event-card-title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>

            <div class="event-card-meta">
                <?php if ($start_time || $end_time): ?>
                <span class="event-card-time">
                    <?php
            if ($start_time)
                echo esc_html(date_i18n('g:i A', strtotime($start_time)));
            if ($start_time && $end_time)
                echo ' &ndash; ';
            if ($end_time)
                echo esc_html(date_i18n('g:i A', strtotime($end_time)));
?>
                </span>
                <?php
        endif; ?>

                <?php if ($location): ?>
                <span class="event-card-location">
                    <?php echo esc_html($location); ?>
                </span>
                <?php
        endif; ?>
            </div>

            <?php if (has_excerpt()): ?>
            <p class="event-card-excerpt">
                <?php echo esc_html(get_the_excerpt()); ?>
            </p>
            <?php
        endif; ?>
        </div>
    </div>
    <?php
    endwhile;
    wp_reset_postdata(); ?>
</div>
<?php
else: ?>
<p>No upcoming events at this time. Check back soon!</p>
<?php
endif; ?>

<?php get_footer(); ?>