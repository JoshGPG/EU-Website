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
        <a href="#" class="box-link">Read More &rarr;</a>
    </div>
    <div class="col-box col-box-right">
        <h2>Upcoming Events</h2>
        <p>Check out our calendar of races, training camps, and community gatherings happening throughout the season.</p>
        <a href="<?php echo esc_url(site_url('/calendar/')); ?>" class="box-link">View Events &rarr;</a>
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
</script>

<?php get_footer(); ?>
