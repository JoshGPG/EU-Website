<?php get_header(); ?>

<article class="post">
    <h1 class="post-title">Welcome to <?php bloginfo('name'); ?></h1>

    <div class="post-content">
        <p>This is your home page. Edit <code>front-page.php</code> to change what appears here.</p>

        <h2>Latest Posts</h2>

        <?php
        $recent_posts = new WP_Query([
            'posts_per_page' => 5,
        ]);

        if ($recent_posts->have_posts()) : ?>
            <ul>
                <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <span class="post-meta">&mdash; <?php the_date(); ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p>No posts yet.</p>
        <?php endif; ?>
    </div>
</article>

<?php get_footer(); ?>
