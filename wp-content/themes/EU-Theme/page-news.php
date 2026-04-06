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

$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$sort_order   = (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'ASC' : 'DESC';
$paged        = get_query_var('paged') ? get_query_var('paged') : 1;

$query_args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => $sort_order,
];

if ($current_category) {
    $query_args['category_name'] = $current_category;
}

if ($search_query) {
    $query_args['s'] = $search_query;
}

$news_query = new WP_Query($query_args);

$filter_tabs = [
    ''                => 'All News',
    'program-news'    => 'Program News',
    'race-event-news' => 'Race Event News',
    'other-news'      => 'Other News',
];

// Build base URL preserving current filters
$base_url = get_permalink();
?>

    </div><!-- close .container from header -->
</main><!-- close .site-content from header -->

<!-- News Grid Section -->
<section class="news-section">
    <div class="container">

        <div class="news-toolbar">
            <div class="news-filters">
                <?php foreach ($filter_tabs as $slug => $label) :
                    $is_active = ($slug === $current_category);
                    $tab_args = [];
                    if ($slug) $tab_args['category'] = $slug;
                    if ($search_query) $tab_args['s'] = $search_query;
                    if ($sort_order === 'ASC') $tab_args['sort'] = 'oldest';
                    $url = $tab_args ? esc_url(add_query_arg($tab_args, $base_url)) : esc_url($base_url);
                ?>
                    <a href="<?php echo $url; ?>" class="news-filter-tab<?php echo $is_active ? ' active' : ''; ?>">
                        <?php echo esc_html($label); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="news-controls">
                <form class="news-search" action="<?php echo esc_url($base_url); ?>" method="get">
                    <?php if ($current_category) : ?>
                        <input type="hidden" name="category" value="<?php echo esc_attr($current_category); ?>">
                    <?php endif; ?>
                    <?php if ($sort_order === 'ASC') : ?>
                        <input type="hidden" name="sort" value="oldest">
                    <?php endif; ?>
                    <input type="text" name="s" value="<?php echo esc_attr($search_query); ?>" placeholder="Search posts..." class="news-search-input">
                    <button type="submit" class="news-search-btn">Search</button>
                </form>

                <div class="news-sort">
                    <?php
                    $newest_args = [];
                    if ($current_category) $newest_args['category'] = $current_category;
                    if ($search_query) $newest_args['s'] = $search_query;
                    $newest_url = $newest_args ? esc_url(add_query_arg($newest_args, $base_url)) : esc_url($base_url);

                    $oldest_args = ['sort' => 'oldest'];
                    if ($current_category) $oldest_args['category'] = $current_category;
                    if ($search_query) $oldest_args['s'] = $search_query;
                    $oldest_url = esc_url(add_query_arg($oldest_args, $base_url));
                    ?>
                    <a href="<?php echo $newest_url; ?>" class="news-sort-btn<?php echo $sort_order === 'DESC' ? ' active' : ''; ?>">Newest</a>
                    <a href="<?php echo $oldest_url; ?>" class="news-sort-btn<?php echo $sort_order === 'ASC' ? ' active' : ''; ?>">Oldest</a>
                </div>
            </div>
        </div>

        <?php if ($search_query) : ?>
            <div class="news-search-status">
                Showing results for "<strong><?php echo esc_html($search_query); ?></strong>"
                <a href="<?php
                    $clear_args = [];
                    if ($current_category) $clear_args['category'] = $current_category;
                    if ($sort_order === 'ASC') $clear_args['sort'] = 'oldest';
                    echo $clear_args ? esc_url(add_query_arg($clear_args, $base_url)) : esc_url($base_url);
                ?>" class="news-search-clear">Clear search</a>
            </div>
        <?php endif; ?>

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
                'total'     => $news_query->max_num_pages,
                'current'   => $paged,
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
                'add_args'  => [],
            ];

            if ($current_category) {
                $pagination_args['add_args']['category'] = $current_category;
            }
            if ($search_query) {
                $pagination_args['add_args']['s'] = $search_query;
            }
            if ($sort_order === 'ASC') {
                $pagination_args['add_args']['sort'] = 'oldest';
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
                <?php if ($search_query) : ?>
                    <p>No posts found for "<?php echo esc_html($search_query); ?>". Try a different search term.</p>
                <?php else : ?>
                    <p>No news posts found<?php echo $current_category ? ' in this category' : ''; ?>. Check back soon!</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
