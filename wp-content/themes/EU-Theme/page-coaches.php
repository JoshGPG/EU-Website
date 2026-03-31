<?php
/**
 * Template Name: Coaches
 *
 * Displays coaches dynamically from the eu_staff CPT, grouped by eu_staff_group taxonomy.
 * Add coaches under Staff & Board > Add New, assign to the appropriate group.
 * Coaches with bios (editor content) get a larger featured card layout.
 * Coaches without bios get a compact grid card.
 */
get_header();
?>

<h1 class="page-title">Our Coaches</h1>

<h2 class="coaches-section-title">Youth Coaches</h2>
<?php eu_render_staff_section('youth-coaches'); ?>

<h2 class="coaches-section-title">Adult Team Coaches</h2>
<?php eu_render_staff_section('adult-team-coaches'); ?>

<h2 class="coaches-section-title">Adult Learn to Ski Coaches</h2>
<?php eu_render_staff_section('adult-learn-to-ski-coaches'); ?>

<h2 class="coaches-section-title">Adult Intermediate Ski Coaches</h2>
<?php eu_render_staff_section('adult-intermediate-ski-coaches'); ?>

<h2 class="coaches-section-title">Junior Coaches</h2>
<?php eu_render_staff_section('junior-coaches'); ?>

<h2 class="coaches-section-title">Mountain Bike Coaches</h2>
<?php eu_render_staff_section('mountain-bike-coaches'); ?>

<h2 class="coaches-section-title">Paddle Coaches</h2>
<?php eu_render_staff_section('paddle-coaches'); ?>

<h2 class="coaches-section-title">Guest Nordic Coaches</h2>
<?php eu_render_staff_section('guest-nordic-coaches'); ?>

<?php get_footer(); ?>
