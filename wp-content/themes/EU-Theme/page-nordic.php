<?php
/**
 * Template Name: Nordic
 */
get_header();
?>

<h1 class="page-title">Nordic Ski Programs</h1>
<p class="page-intro">Endurance United offers year-round Nordic ski training for all ages and skill levels. Whether you're picking up skis for the first time or chasing a spot on the national team, there's a program for you.</p>

<section class="showcase-grid showcase-grid--summary">

    <a href="<?php echo esc_url(site_url('/adult-nordic/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #1a5276;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Adult Nordic</h3>
            <p class="showcase-card-desc">Year-round training for adults of every ability — from first-time skiers to elite racers. On-snow, rollerski, and dryland sessions led by experienced coaches.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/juniors/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #4a235a;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">Junior Training</h3>
            <p class="showcase-card-desc">Competitive training for ages 14&ndash;19. Develop race technique, build endurance, and qualify for state and national competitions.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

    <a href="<?php echo esc_url(site_url('/youth/')); ?>" class="showcase-card">
        <span class="showcase-bracket showcase-bracket--tl"></span>
        <span class="showcase-bracket showcase-bracket--br"></span>
        <div class="showcase-card-img" style="background-color: #1e8449;"></div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">EU SkiWerx</h3>
            <p class="showcase-card-desc">Developmental youth programming that builds a love for the outdoors through Nordic skiing, games, and adventure.</p>
            <span class="showcase-card-btn">Learn More</span>
        </div>
    </a>

</section>

<?php get_footer(); ?>
