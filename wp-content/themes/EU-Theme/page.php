<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article <?php post_class(); ?>>
        <h1 class="post-title"><?php the_title(); ?></h1>

        <div class="post-content">
            <?php the_content(); ?>
        </div>
    </article>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
