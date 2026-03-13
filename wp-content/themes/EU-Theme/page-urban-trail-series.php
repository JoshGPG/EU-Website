<?php
/**
 * Template Name: Urban Trail Series
 */
get_header();
?>

<h1 class="page-title">Urban Trail Series</h1>
<p class="page-intro">The Urban Trail Series is presented by Endurance United, a St. Paul based non-profit dedicated to promoting an Active, Healthy, Outdoor lifestyle. Join us for the premier urban trail racing experience. The Urban Trail Series consists of courses that highlight the world class parks, dramatic views and challenging terrain of Saint Paul.</p>

<section class="showcase-grid showcase-grid--summary">

    <a href="<?php echo esc_url(site_url('/go-spring/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #1e8449;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Go Spring!</h3>
            <p class="showcase-card-desc">Kick off the racing season on Saint Paul&rsquo;s spring trails. A fun, fast course to shake off winter and welcome the outdoors.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="#" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #B9313A;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Bluff Tuff</h3>
            <p class="showcase-card-desc">Take on the dramatic bluffs and rugged terrain of Saint Paul&rsquo;s river valley in this challenging summer trail race.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/night-light/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #1a5276;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Night Light</h3>
            <p class="showcase-card-desc">Race under the lights on an autumn evening. A unique nighttime trail experience through Saint Paul&rsquo;s urban parks.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/turkey-day-trail-trot/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #b7950b;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Turkey Day Trail Trot</h3>
            <p class="showcase-card-desc">Earn your Thanksgiving feast with this beloved holiday tradition&mdash;a trail run through the heart of Saint Paul.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

</section>

<?php get_footer(); ?>
