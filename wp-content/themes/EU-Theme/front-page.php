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
    <div class="col-box col-box-left">
        <h2>Latest News</h2>
        <p>Stay up to date with the latest program announcements, race results, and community highlights from EnduranceUnited.</p>
        <a href="<?php echo esc_url(site_url('/news/')); ?>" class="box-link">Read More &rarr;</a>
    </div>
    <div class="col-box col-box-right">
        <h2>Upcoming Events</h2>
        <p>Check out our calendar of races, training camps, and community gatherings happening throughout the season.</p>
        <a href="<?php echo esc_url(site_url('/calendar/')); ?>" class="box-link">View Events &rarr;</a>
    </div>
</section>

<!-- 2x2 Feature Grid -->
<section class="feature-grid">
    <a href="<?php echo esc_url(site_url('/calendar/')); ?>" class="feature-box feature-race" style="background-color: #2D62A5;">
        <span class="feature-label">Upcoming Race</span>
        <h2>City of Lakes Loppet</h2>
        <p>Check the calendar for the next race and get registered before spots fill up.</p>
        <span class="feature-cta">View Calendar &rarr;</span>
    </a>
    <a href="<?php echo esc_url(site_url('/adult-nordic/')); ?>" class="feature-box feature-program" style="background-color: #B9313A;">
        <span class="feature-label">Featured Program</span>
        <h2>Adult Year-Round Nordic</h2>
        <p>Train with experienced coaches year-round. Beginner to advanced skiers welcome.</p>
        <span class="feature-cta">Learn More &rarr;</span>
    </a>
    <a href="<?php echo esc_url(site_url('/news/')); ?>" class="feature-box feature-blog" style="background-color: #333;">
        <span class="feature-label">From the Blog</span>
        <h2>Season Recap &amp; What&rsquo;s Ahead</h2>
        <p>A look back at an incredible season and a preview of what&rsquo;s coming next.</p>
        <span class="feature-cta">Read Post &rarr;</span>
    </a>
    <a href="#" class="feature-box feature-donate" style="background-color: #245089;">
        <span class="feature-label">Support EU</span>
        <h2>Make a Donation</h2>
        <p>Your donations fund scholarships, equipment, trail access, and youth programs so everyone can get outside.</p>
        <span class="feature-cta">Donate Now &rarr;</span>
    </a>
</section>

<!-- Testimonials Slider -->
<section class="testimonials">
    <div class="testimonials-inner">
        <div class="testimonial-slide active">
            <p class="testimonial-quote">&ldquo;EU completely changed how I approach training. The coaches are world-class and the community keeps you coming back.&rdquo;</p>
            <span class="testimonial-author">&mdash; Sarah M., Adult Nordic Program</span>
        </div>
        <div class="testimonial-slide">
            <p class="testimonial-quote">&ldquo;My kids have grown so much through the youth program. They&rsquo;ve learned discipline, teamwork, and a love for the outdoors.&rdquo;</p>
            <span class="testimonial-author">&mdash; Mike T., Youth Program Parent</span>
        </div>
        <div class="testimonial-slide">
            <p class="testimonial-quote">&ldquo;The race events are incredibly well organized. From registration to finish line, everything is top-notch.&rdquo;</p>
            <span class="testimonial-author">&mdash; Jenna L., Race Participant</span>
        </div>
        <div class="testimonial-slide">
            <p class="testimonial-quote">&ldquo;I joined as a complete beginner and within a season I was racing competitively. Can&rsquo;t recommend EU enough.&rdquo;</p>
            <span class="testimonial-author">&mdash; David R., Adult Nordic Program</span>
        </div>
    </div>
    <div class="testimonial-dots">
        <span class="dot active" data-tslide="0"></span>
        <span class="dot" data-tslide="1"></span>
        <span class="dot" data-tslide="2"></span>
        <span class="dot" data-tslide="3"></span>
    </div>
</section>

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
