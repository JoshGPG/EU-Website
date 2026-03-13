<?php
/**
 * Template Name: News
 */
get_header();

$allowed_categories = ['program-news', 'race-event-news', 'other-news'];
$current_category = '';

if (isset($_GET['category']) && in_array($_GET['category'], $allowed_categories, true)) {
    $current_category = $_GET['category'];
}

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$query_args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'paged'          => $paged,
];

if ($current_category) {
    $query_args['category_name'] = $current_category;
}

$news_query = new WP_Query($query_args);

$filter_tabs = [
    ''                => 'All News',
    'program-news'    => 'Program News',
    'race-event-news' => 'Race Event News',
    'other-news'      => 'Other News',
];
?>

    </div><!-- close .container from header -->
</main><!-- close .site-content from header -->

<!-- News Grid Section -->
<section class="news-section">
    <div class="container">

        <div class="news-filters">
            <?php foreach ($filter_tabs as $slug => $label) :
                $is_active = ($slug === $current_category);
                $url = $slug ? esc_url(add_query_arg('category', $slug, get_permalink())) : esc_url(get_permalink());
            ?>
                <a href="<?php echo $url; ?>" class="news-filter-tab<?php echo $is_active ? ' active' : ''; ?>">
                    <?php echo esc_html($label); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($news_query->have_posts()) : ?>
            <div class="news-grid">
                <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                    <article class="news-card">
                        <div class="news-card-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <div class="news-card-img-placeholder"></div>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="news-card-body">
                            <?php
                            $categories = get_the_category();
                            if ($categories) :
                                $cat = $categories[0];
                            ?>
                                <span class="news-card-category"><?php echo esc_html($cat->name); ?></span>
                            <?php endif; ?>

                            <h2 class="news-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <div class="news-card-meta">
                                <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                <span class="news-card-author">by <?php the_author(); ?></span>
                            </div>

                            <div class="news-card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="news-card-readmore">Read More &rarr;</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            $pagination_args = [
                'total'   => $news_query->max_num_pages,
                'current' => $paged,
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
            ];

            if ($current_category) {
                $pagination_args['add_args'] = ['category' => $current_category];
            }

            $pagination = paginate_links($pagination_args);
            if ($pagination) :
            ?>
                <div class="news-pagination">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="news-empty">
                <p>No news posts found<?php echo $current_category ? ' in this category' : ''; ?>. Check back soon!</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
