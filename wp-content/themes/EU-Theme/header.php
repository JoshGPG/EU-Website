<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="slogan-ribbon"><?php
        $slogan = function_exists('get_field') ? get_field('site_slogan', 'option') : '';
        echo esc_html($slogan ?: 'ACTIVE. HEALTHY. OUTDOORS.');
    ?></div>
    <header class="site-header">
        <div class="header-bar">
            <div class="header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <div class="logo-placeholder">EU</div>
                </a>
            </div>
            <nav class="main-nav">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '<ul>%3$s</ul>',
                    'walker'         => new EU_Nav_Walker(),
                ]);
            } else {
                // Fallback: hardcoded nav for when no menu is assigned
                ?>
                <ul>
                    <li class="dropdown">
                        <a href="<?php echo esc_url(site_url('/nordic/')); ?>">NORDIC ▼</a>
                        <ul class="submenu">
                            <li><a href="<?php echo esc_url(site_url('/adult-nordic/')); ?>">Adult</a></li>
                            <li><a href="<?php echo esc_url(site_url('/juniors/')); ?>">Juniors</a></li>
                            <li><a href="<?php echo esc_url(site_url('/youth/')); ?>">Youth</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo esc_url(site_url('/programs/')); ?>">PROGRAMS ▼</a>
                        <ul class="submenu">
                            <li><a href="<?php echo esc_url(site_url('/paddling/')); ?>">Paddling</a></li>
                            <li><a href="<?php echo esc_url(site_url('/cycling/')); ?>">Cycling</a></li>
                            <li><a href="<?php echo esc_url(site_url('/trail-running/')); ?>">Trail Running</a></li>
                        </ul>
                    </li>
                    <li class="dropdown uts-nav">
                        <a href="<?php echo esc_url(site_url('/urban-trail-series/')); ?>">URBAN TRAIL SERIES ▼</a>
                        <ul class="submenu">
                            <li><a href="<?php echo esc_url(site_url('/go-spring/')); ?>">Go Spring!</a></li>
                            <li><a href="#">Bluff Tuff</a></li>
                            <li><a href="<?php echo esc_url(site_url('/night-light/')); ?>">Night Light</a></li>
                            <li><a href="<?php echo esc_url(site_url('/turkey-day-trail-trot/')); ?>">Turkey Day Trail Trot</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo esc_url(site_url('/news/')); ?>">NEWS ▼</a>
                        <ul class="submenu">
                            <li><a href="<?php echo esc_url(site_url('/news/?category=program-news')); ?>">PROGRAM NEWS</a></li>
                            <li><a href="<?php echo esc_url(site_url('/news/?category=race-event-news')); ?>">RACE EVENT NEWS</a></li>
                            <li><a href="<?php echo esc_url(site_url('/news/?category=other-news')); ?>">OTHER NEWS</a></li>
                        </ul>
                    </li>
                </ul>
                <?php
            }
            ?>
            </nav>
        </div>
    </header>

    <main class="site-content">
        <div class="container">
