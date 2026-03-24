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

<!-- Popular Programs 4x2 Grid -->
<section class="showcase-grid">

    <a href="<?php echo esc_url(site_url('/adult-nordic/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #1a5276;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Year-Round Nordic</h3>
            <p class="showcase-card-desc">Train with experienced coaches from May through winter. Beginner to advanced skiers welcome.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/adult-nordic/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #2D62A5;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Learn to Ski</h3>
            <p class="showcase-card-desc">New to cross-country skiing? Start here with beginner-friendly lessons and patient coaches.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/juniors/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #4a235a;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Junior Training</h3>
            <p class="showcase-card-desc">Competitive training for ages 14&ndash;19. State champions and national qualifiers.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/youth/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #1e8449;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">EU SkiWerx</h3>
            <p class="showcase-card-desc">Building a love for the outdoors through Nordic skiing for young developmental athletes.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/paddling/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #2c3e50;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Junior Paddling</h3>
            <p class="showcase-card-desc">Kayak, SUP and canoe throughout the summer at Long Lake. Ages 11&ndash;18.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/paddling/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #B9313A;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Adult Canoe Racing</h3>
            <p class="showcase-card-desc">Learn competitive canoe racing with pro boats on Long Lake. Adults 18+.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/adult-nordic/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #245089;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Learn to Rollerski</h3>
            <p class="showcase-card-desc">Get a head start on ski season with spring rollerski technique lessons.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/calendar/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #333;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Race Calendar</h3>
            <p class="showcase-card-desc">View upcoming races, training camps, and community events all season long.</p>
            <span class="showcase-card-btn">View Calendar</span>
        </div>
    </a>

</section>

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
