<?php
/**
 * Template Name: Cycling
 */
get_header();
?>

<h1 class="page-title">2026 Cycling</h1>

<h2 class="nordic-section-title">Adults</h2>

<h3 class="cycling-program-name">Women&rsquo;s Mountain Bike Fitness Rides</h3>
<div class="nordic-intro">
    <p>Join fun women to get those legs cranking and heart pumping on your mountain bikes. Sessions will have a planned workout, with options for intervals or over distance riding. These sessions are ideal for beginner to intermediate women interested in improving their fitness or working towards an early summer race. Mountain bike skills are discussed briefly but the main focus of these rides is fitness.</p>
</div>

<?php eu_render_program_boxes('cycling-adult', 'open'); ?>

<h2 class="nordic-section-title" style="margin-top: 40px;">Youth</h2>

<h3 class="cycling-program-name">Youth Mountain Bike</h3>
<div class="nordic-intro">
    <p><strong>Shifting Gears in Partnership with Endurance United &mdash; Youth MTB</strong></p>
    <p>Introducing youth ages pre K to 12th grade to the fun of the outdoors and trails for a lifetime! Shifting Gears and Endurance United share a common vision in promoting outdoor fun and enjoyment for all riders by building confidence, resilience, and character who are connected to an outdoor community.</p>
</div>

<?php eu_render_program_boxes('cycling-youth', 'open'); ?>

<h2 class="nordic-section-title closed" style="margin-top: 40px;">Closed for the Season</h2>
<p class="nordic-closed-note">Programs listed below are closed for the season.</p>
<?php eu_render_program_boxes('cycling-adult', 'closed'); ?>
<?php eu_render_program_boxes('cycling-youth', 'closed'); ?>

<?php get_footer(); ?>
