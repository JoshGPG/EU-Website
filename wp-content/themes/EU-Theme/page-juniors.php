<?php
/**
 * Template Name: Juniors
 */
get_header();
?>

<h1 class="page-title">Spring Junior Training</h1>

<div class="nordic-intro">
    <p>The Endurance United Junior Team has had success on both the high school level and regional/national level. EU Juniors have included MN state champions Peter Moore in 2019 and Henry Snider in 2020, Paralympian Max Nelson who competed in Beijing 2022 and Milano-Cortina 2026.</p>
    <p>EU sends five qualifiers Peter, George, Anneliese, Henry and Katie to spring championship trips (Junior Nationals, CXC U16 &amp; U18 NENSA Trips) in 2026 for the Midwest Region.</p>
    <p class="nordic-note">*The EU junior program is for ages 14&ndash;19. If an athlete is 13 years of age and interested in skiing with juniors, please contact John Richter to see if juniors or EU SkiWerx is the more appropriate program.</p>
</div>

<p class="juniors-subscribe-note">Keep informed by subscribing to EU junior emails below.</p>

<h2 class="nordic-section-title">Open for Registration</h2>
<?php eu_render_program_boxes('juniors', 'open'); ?>

<h2 class="nordic-section-title closed">Closed for the Season</h2>
<p class="nordic-closed-note">Programs listed below are closed for the season.</p>
<?php eu_render_program_boxes('juniors', 'closed'); ?>

<?php get_footer(); ?>
