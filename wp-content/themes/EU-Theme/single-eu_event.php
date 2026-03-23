<?php get_header(); ?>

<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>

<article <?php post_class(); ?>>
    <h1 class="post-title">
        <?php the_title(); ?>
    </h1>

    <div class="post-content">
        <?php
        the_content();

        // Your existing ACF field
        echo get_field('eu_event_name', get_the_ID());
?>

        <!-- Displaying a new ACF field directly -->
        <p><strong>Date:</strong>
            <?php the_field('eu_event_date'); ?>
        </p>
    </div>


    <div class="post-content">
        <?php the_content();
        echo get_field('eu_event_name', get_the_ID());
        the_post_thumbnail('small');

?>
    </div>
</article>

<?php
    endwhile;
endif; ?>

<?php get_footer(); ?>