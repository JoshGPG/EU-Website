<?php
/**
 * Template Name: Hub Page
 *
 * A consolidated template for hub/summary pages (Nordic, Programs, Urban Trail
 * Series, etc.). Shows a page title, intro paragraph, and a grid of showcase
 * cards that link to sub-pages. Content managed via ACF fields.
 *
 * Uses individual numbered fields (ACF free compatible, no repeaters).
 */
get_header();

$intro = get_field('hub_intro');
?>

<h1 class="page-title"><?php the_title(); ?></h1>

<?php if ($intro) : ?>
    <p class="page-intro"><?php echo esc_html($intro); ?></p>
<?php endif; ?>

<section class="showcase-grid showcase-grid--summary">
    <?php
    // Up to 6 card slots
    for ($i = 1; $i <= 6; $i++) :
        $title = get_field('hub_card_title_' . $i);
        if (!$title) continue;

        $desc    = get_field('hub_card_desc_' . $i);
        $link    = get_field('hub_card_link_' . $i) ?: '#';
        $image   = get_field('hub_card_image_' . $i);
        $bg_color = get_field('hub_card_color_' . $i) ?: '#2c3e50';

        $img_style = '';
        if (!empty($image)) {
            $img_style = 'background-image: url(' . esc_url($image) . '); background-size: cover; background-position: center;';
        } else {
            $img_style = 'background-color: ' . esc_attr($bg_color) . ';';
        }
    ?>
        <a href="<?php echo esc_url($link); ?>" class="showcase-card">
            <span class="showcase-bracket showcase-bracket--tl"></span>
            <span class="showcase-bracket showcase-bracket--br"></span>
            <div class="showcase-card-img" style="<?php echo $img_style; ?>"></div>
            <div class="showcase-card-body">
                <h3 class="showcase-card-title"><?php echo esc_html($title); ?></h3>
                <?php if ($desc) : ?>
                    <p class="showcase-card-desc"><?php echo esc_html($desc); ?></p>
                <?php endif; ?>
                <span class="showcase-card-btn">Learn More</span>
            </div>
        </a>
    <?php endfor; ?>
</section>

<?php get_footer(); ?>
