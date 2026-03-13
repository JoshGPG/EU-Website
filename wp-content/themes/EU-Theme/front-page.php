<?php get_header(); ?>

    </div><!-- close .container from header -->
</main><!-- close .site-content from header -->

<!-- Hero Box - Large slider -->
<section class="hero-box">
    <div class="hero-slider">
        <div class="hero-slide active" style="background-color: #2c3e50;">
            <div class="hero-slide-content">
                <h1>Welcome to EnduranceUnited</h1>
                <p>Pushing limits. Building champions. Join the movement.</p>
            </div>
        </div>
        <div class="hero-slide" style="background-color: #1a5276;">
            <div class="hero-slide-content">
                <h1>Nordic Programs</h1>
                <p>Train with the best coaches in cross-country skiing, biathlon, and more.</p>
            </div>
        </div>
        <div class="hero-slide" style="background-color: #4a235a;">
            <div class="hero-slide-content">
                <h1>Race Events 2026</h1>
                <p>Register now for the upcoming season of competitive endurance events.</p>
            </div>
        </div>
        <div class="hero-slide" style="background-color: #1e8449;">
            <div class="hero-slide-content">
                <h1>Youth Development</h1>
                <p>Building the next generation of endurance athletes from the ground up.</p>
            </div>
        </div>
    </div>
    <div class="hero-slider-dots">
        <span class="dot active" data-slide="0"></span>
        <span class="dot" data-slide="1"></span>
        <span class="dot" data-slide="2"></span>
        <span class="dot" data-slide="3"></span>
    </div>
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
