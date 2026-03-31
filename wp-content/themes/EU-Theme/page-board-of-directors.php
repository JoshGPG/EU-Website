<?php
/**
 * Template Name: Board of Directors
 *
 * Displays board members dynamically from the eu_staff CPT.
 * Add board members under Staff & Board > Add New, assign to "Board of Directors" group.
 */
get_header();
?>

<h1 class="page-title">Board of Directors</h1>

<?php eu_render_staff_section('board-of-directors', 'grid'); ?>

<?php get_footer(); ?>
