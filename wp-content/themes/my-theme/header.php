<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="container">
        <div>
            <h1 class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
            <p class="site-description"><?php bloginfo('description'); ?></p>
        </div>

        <nav class="main-navigation">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'fallback_cb'    => false,
            ]);
            ?>
        </nav>
    </div>
</header>

<main class="site-content">
    <div class="container">
