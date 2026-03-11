<?php get_header(); ?>

<article class="post">
    <h1 class="post-title">Page Not Found</h1>
    <div class="post-content">
        <p>Sorry, the page you're looking for doesn't exist.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>">&larr; Back to Home</a>
    </div>
</article>

<?php get_footer(); ?>
