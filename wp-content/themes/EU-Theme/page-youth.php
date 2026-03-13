<?php
/**
 * Template Name: Youth
 */
get_header();
?>

<h1 class="page-title">EU SkiWerx</h1>
<p class="nordic-closed-note">MyXC affiliated program</p>

<div class="nordic-intro">
    <p>We have certified and experienced coaches who are dedicated to encouraging and supporting our young athletes. Driven by Endurance United&rsquo;s mission, we encourage our athletes to live a sustainable, active, healthy and outdoor lifestyle and there&rsquo;s no better time to introduce this lifestyle than in the athlete&rsquo;s young developmental years.</p>
    <p>EU SkiWerx coaches will help athletes navigate the many athletic opportunities available to them. We hope they find a love in the outdoors through Nordic Skiing and continue on in our Endurance United ski programming.</p>
    <p>Your EU SkiWerx athlete will belong to a team and community who supports and encourages the goals and aspirations of all members. Join to become part of this amazing opportunity and supportive community!</p>
</div>

<h2 class="nordic-section-title">Open for Registration</h2>
<?php eu_render_program_boxes('youth', 'open'); ?>

<h2 class="nordic-section-title closed">Closed for the Season</h2>
<p class="nordic-closed-note">Sessions below are closed for the 2025 season.</p>
<?php eu_render_program_boxes('youth', 'closed'); ?>

<?php get_footer(); ?>
