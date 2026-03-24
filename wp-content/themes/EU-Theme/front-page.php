<?php get_header(); ?>

    </div><!-- close .container from header -->
</main><!-- close .site-content from header -->

<!-- Hero Box - Large slider -->
<section class="hero-box">
    <div class="hero-slider">
        <?php
        // Build slides array from individual ACF fields (slots 1-4)
        $slides = [];
        for ($i = 1; $i <= 8; $i++) {
            $title = get_field('slide_title_' . $i);
            if ($title) {
                $slides[] = [
                    'title'    => $title,
                    'subtitle' => get_field('slide_subtitle_' . $i),
                    'image'    => get_field('slide_image_' . $i),
                    'bg_color' => get_field('slide_bg_color_' . $i) ?: '#2c3e50',
                ];
            }
        }

        if (!empty($slides)) :
            foreach ($slides as $idx => $slide) :
                $active = ($idx === 0) ? ' active' : '';
                $style  = 'background-color: ' . esc_attr($slide['bg_color']) . ';';
                if (!empty($slide['image'])) {
                    $style .= ' background-image: url(' . esc_url($slide['image']) . ');';
                }
        ?>
            <div class="hero-slide<?php echo $active; ?>" style="<?php echo $style; ?>">
                <div class="hero-slide-content">
                    <h1><?php echo esc_html($slide['title']); ?></h1>
                    <p><?php echo esc_html($slide['subtitle']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else : ?>
            <div class="hero-slide active" style="background-color: #2c3e50;">
                <div class="hero-slide-content">
                    <h1>Welcome to EnduranceUnited</h1>
                    <p>Pushing limits. Building champions. Join the movement.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if (count($slides) > 1) : ?>
        <div class="hero-slider-dots">
            <?php for ($i = 0; $i < count($slides); $i++) : ?>
                <span class="dot<?php echo ($i === 0) ? ' active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Programs Showcase Grid -->
<?php
$featured_query = new WP_Query([
    'post_type'      => 'eu_program',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'meta_query'     => [['key' => '_eu_program_featured', 'value' => '1']],
]);

if ($featured_query->have_posts()) : ?>
<section class="showcase-grid" style="--card-count: <?php echo $featured_query->post_count; ?>;">
    <?php while ($featured_query->have_posts()) : $featured_query->the_post();
        $thumb     = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
        $coach     = get_post_meta(get_the_ID(), '_eu_program_coach', true);
        $short_desc = get_post_meta(get_the_ID(), '_eu_program_short_desc', true);
        $page_link = get_post_meta(get_the_ID(), '_eu_program_page_link', true) ?: '#';
    ?>
        <a href="<?php echo esc_url($page_link); ?>" class="showcase-card">
            <div class="showcase-card-img"<?php if ($thumb) : ?> style="background-image: url(<?php echo esc_url($thumb); ?>);"<?php endif; ?>></div>
            <div class="showcase-card-body">
                <h3 class="showcase-card-title"><?php the_title(); ?></h3>
                <?php if ($coach) : ?>
                    <p class="showcase-card-coach">Coach: <?php echo esc_html($coach); ?></p>
                <?php endif; ?>
                <?php if ($short_desc) : ?>
                    <p class="showcase-card-desc"><?php echo esc_html($short_desc); ?></p>
                <?php endif; ?>
                <span class="showcase-card-btn">Learn More &rarr;</span>
            </div>
        </a>
    <?php endwhile; ?>
</section>
<?php wp_reset_postdata();
endif; ?>

<!-- Two Column Boxes -->
<section class="two-col-boxes">
    <?php
    $twocol_defaults = [
        1 => ['title' => 'Latest News', 'text' => 'Stay up to date with the latest program announcements, race results, and community highlights from EnduranceUnited.', 'link_label' => 'Read More', 'link_url' => site_url('/news/'), 'color' => '#2D62A5'],
        2 => ['title' => 'Upcoming Events', 'text' => 'Check out our calendar of races, training camps, and community gatherings happening throughout the season.', 'link_label' => 'View Events', 'link_url' => site_url('/events/'), 'color' => '#245089'],
    ];
    for ($i = 1; $i <= 2; $i++) :
        $d     = $twocol_defaults[$i];
        $title = get_field('twocol_title_' . $i) ?: $d['title'];
        $text  = get_field('twocol_text_' . $i) ?: $d['text'];
        $label = get_field('twocol_link_label_' . $i) ?: $d['link_label'];
        $url   = get_field('twocol_link_url_' . $i) ?: $d['link_url'];
        $color = get_field('twocol_color_' . $i) ?: $d['color'];
    ?>
        <div class="col-box" style="background-color: <?php echo esc_attr($color); ?>;">
            <h2><?php echo esc_html($title); ?></h2>
            <p><?php echo esc_html($text); ?></p>
            <a href="<?php echo esc_url($url); ?>" class="box-link"><?php echo esc_html($label); ?> &rarr;</a>
        </div>
    <?php endfor; ?>
</section>

<!-- 2x2 Feature Grid -->
<section class="feature-grid">
    <?php
    $feat_defaults = [
        1 => ['label' => 'Upcoming Race',   'title' => 'City of Lakes Loppet',          'text' => 'Check the calendar for the next race and get registered before spots fill up.', 'cta' => 'View Calendar', 'url' => site_url('/events/'), 'color' => '#2D62A5'],
        2 => ['label' => 'Featured Program', 'title' => 'Adult Year-Round Nordic',       'text' => 'Train with experienced coaches year-round. Beginner to advanced skiers welcome.', 'cta' => 'Learn More', 'url' => site_url('/adult-nordic/'), 'color' => '#B9313A'],
        3 => ['label' => 'From the Blog',    'title' => 'Season Recap & What\'s Ahead',  'text' => 'A look back at an incredible season and a preview of what\'s coming next.', 'cta' => 'Read Post', 'url' => site_url('/news/'), 'color' => '#333333'],
        4 => ['label' => 'Support EU',       'title' => 'Make a Donation',               'text' => 'Your donations fund scholarships, equipment, trail access, and youth programs so everyone can get outside.', 'cta' => 'Donate Now', 'url' => '#', 'color' => '#245089'],
    ];
    for ($i = 1; $i <= 4; $i++) :
        $d     = $feat_defaults[$i];
        $label = get_field('feat_label_' . $i) ?: $d['label'];
        if (!$label) continue;
        $title = get_field('feat_title_' . $i) ?: $d['title'];
        $text  = get_field('feat_text_' . $i) ?: $d['text'];
        $cta   = get_field('feat_cta_' . $i) ?: $d['cta'];
        $url   = get_field('feat_url_' . $i) ?: $d['url'];
        $color = get_field('feat_color_' . $i) ?: $d['color'];
    ?>
        <a href="<?php echo esc_url($url); ?>" class="feature-box" style="background-color: <?php echo esc_attr($color); ?>;">
            <span class="feature-label"><?php echo esc_html($label); ?></span>
            <h2><?php echo esc_html($title); ?></h2>
            <p><?php echo esc_html($text); ?></p>
            <span class="feature-cta"><?php echo esc_html($cta); ?> &rarr;</span>
        </a>
    <?php endfor; ?>
</section>

<!-- Testimonials Slider -->
<?php
$test_defaults = [
    1 => ['quote' => 'EU completely changed how I approach training. The coaches are world-class and the community keeps you coming back.', 'author' => 'Sarah M., Adult Nordic Program'],
    2 => ['quote' => 'My kids have grown so much through the youth program. They\'ve learned discipline, teamwork, and a love for the outdoors.', 'author' => 'Mike T., Youth Program Parent'],
    3 => ['quote' => 'The race events are incredibly well organized. From registration to finish line, everything is top-notch.', 'author' => 'Jenna L., Race Participant'],
    4 => ['quote' => 'I joined as a complete beginner and within a season I was racing competitively. Can\'t recommend EU enough.', 'author' => 'David R., Adult Nordic Program'],
];
$testimonials = [];
for ($i = 1; $i <= 6; $i++) {
    $d     = isset($test_defaults[$i]) ? $test_defaults[$i] : ['quote' => '', 'author' => ''];
    $quote = get_field('test_quote_' . $i) ?: $d['quote'];
    if (!$quote) continue;
    $testimonials[] = [
        'quote'  => $quote,
        'author' => get_field('test_author_' . $i) ?: $d['author'],
    ];
}
if (!empty($testimonials)) : ?>
<section class="testimonials">
    <div class="testimonials-inner">
        <?php foreach ($testimonials as $idx => $t) : ?>
            <div class="testimonial-slide<?php echo ($idx === 0) ? ' active' : ''; ?>">
                <p class="testimonial-quote">&ldquo;<?php echo esc_html($t['quote']); ?>&rdquo;</p>
                <span class="testimonial-author">&mdash; <?php echo esc_html($t['author']); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($testimonials) > 1) : ?>
        <div class="testimonial-dots">
            <?php for ($i = 0; $i < count($testimonials); $i++) : ?>
                <span class="dot<?php echo ($i === 0) ? ' active' : ''; ?>" data-tslide="<?php echo $i; ?>"></span>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</section>
<?php endif; ?>

<script>
(function() {
    var slides = document.querySelectorAll('.hero-slide');
    var dots = document.querySelectorAll('.hero-slider-dots .dot');
    if (slides.length < 2) return;
    var current = 0;
    var total = slides.length;

    function goToSlide(index) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = index;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    var timer = setInterval(function() {
        goToSlide((current + 1) % total);
    }, 15000);

    dots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            goToSlide(parseInt(this.getAttribute('data-slide')));
            clearInterval(timer);
            timer = setInterval(function() {
                goToSlide((current + 1) % total);
            }, 15000);
        });
    });
})();

// Testimonial slider
(function() {
    var tSlides = document.querySelectorAll('.testimonial-slide');
    var tDots = document.querySelectorAll('.testimonial-dots .dot');
    if (!tSlides.length) return;
    var tCurrent = 0;
    var tTotal = tSlides.length;

    function goToTestimonial(index) {
        tSlides[tCurrent].classList.remove('active');
        tDots[tCurrent].classList.remove('active');
        tCurrent = index;
        tSlides[tCurrent].classList.add('active');
        tDots[tCurrent].classList.add('active');
    }

    var tTimer = setInterval(function() {
        goToTestimonial((tCurrent + 1) % tTotal);
    }, 6000);

    tDots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            goToTestimonial(parseInt(this.getAttribute('data-tslide')));
            clearInterval(tTimer);
            tTimer = setInterval(function() {
                goToTestimonial((tCurrent + 1) % tTotal);
            }, 6000);
        });
    });
})();
</script>

<?php get_footer(); ?>
