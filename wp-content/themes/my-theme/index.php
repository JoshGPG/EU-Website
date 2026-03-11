<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

        <article <?php post_class(); ?>>
            <h2 class="post-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>

            <div class="post-meta">
                <?php the_date(); ?> &middot; By <?php the_author(); ?>
            </div>

            <div class="post-content">
                <?php the_excerpt(); ?>
                <a href="<?php the_permalink(); ?>" class="read-more">Read More &rarr;</a>
            </div>
        </article>

    <?php endwhile; ?>
<?php else : ?>
    <p>No posts found.</p>
<?php endif; ?>

<?php get_footer(); ?>
