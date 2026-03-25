<?php
/**
 * Template Name: Testimonials
 *
 * Displays all published testimonials in a card grid.
 */
get_header();
?>

<h1 class="page-title">Testimonials &amp; Reviews</h1>

<?php
$testimonial_query = new WP_Query([
    'post_type'      => 'eu_testimonial',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

if ($testimonial_query->have_posts()) : ?>
<div class="testimonials-grid">
    <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
        $author  = get_post_meta(get_the_ID(), '_eu_testimonial_author', true);
        $program = get_post_meta(get_the_ID(), '_eu_testimonial_program', true);
    ?>
        <div class="testimonial-card">
            <div class="testimonial-card-quote">
                &ldquo;<?php echo esc_html(wp_strip_all_tags(get_the_content())); ?>&rdquo;
            </div>
            <?php if ($author) : ?>
                <div class="testimonial-card-author">
                    <span class="testimonial-card-name"><?php echo esc_html($author); ?></span>
                    <?php if ($program) : ?>
                        <span class="testimonial-card-program"><?php echo esc_html($program); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>
<?php wp_reset_postdata();
else : ?>
    <p class="page-intro">No testimonials yet. Check back soon!</p>
<?php endif; ?>

<?php get_footer(); ?>
