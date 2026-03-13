<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="slogan-ribbon">ACTIVE. HEALTHY. OUTDOORS.</div>
    <header class="site-header">
        <div class="header-bar">
            <div class="header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <div class="logo-placeholder">EU</div>
                </a>
            </div>
            <nav class="main-nav">
            <ul>
                <li class="dropdown">
                    <a href="nordic.php">NORDIC ▼</a>
                    <ul class="submenu">
                        <li><a href="<?php echo esc_url(site_url('/adult-nordic/')); ?>">Adult</a></li>
                        <li><a href="<?php echo esc_url(site_url('/juniors/')); ?>">Juniors</a></li>
                        <li><a href="<?php echo esc_url(site_url('/youth/')); ?>">Youth</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="programs.php">PROGRAMS ▼</a>
                    <ul class="submenu">
                        <li><a href="<?php echo esc_url(site_url('/paddling/')); ?>">Paddling</a></li>
                        <li><a href="cycling.php">Cycling</a></li>
                        <li><a href="running.php">Trail Running</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="programs.php">RACE EVENTS ▼</a>
                    <ul class="submenu">
                        <li><a href="paddling.php">Urban Trail Series</a></li>
                        <li><a href="cycling.php">Nordic Racing</a></li>
                        <li><a href="running.php">Bike Racing</a></li>
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
            </nav>
        </div>
    </header>

    <main class="site-content">
        <div class="container">