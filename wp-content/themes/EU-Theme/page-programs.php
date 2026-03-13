<?php
/**
 * Template Name: Programs
 */
get_header();
?>

<h1 class="page-title">Programs</h1>
<p class="page-intro">Beyond Nordic skiing, Endurance United offers a variety of outdoor programs to keep you active all year long — on the water, on the trails, and on two wheels.</p>

<section class="showcase-grid showcase-grid--summary">

    <a href="<?php echo esc_url(site_url('/paddling/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #2c3e50;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Paddling</h3>
            <p class="showcase-card-desc">Kayak, SUP, and canoe throughout the summer at Long Lake. Programs for juniors and adults of all experience levels.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/cycling/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #B9313A;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Cycling</h3>
            <p class="showcase-card-desc">Women&rsquo;s mountain bike fitness rides and youth MTB through our Shifting Gears program. All skill levels welcome.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/trail-running/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #245089;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Trail Running</h3>
            <p class="showcase-card-desc">Summer trail running and hiking group for all paces. Explore local trails with a supportive community of runners.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

</section>

<?php get_footer(); ?>
