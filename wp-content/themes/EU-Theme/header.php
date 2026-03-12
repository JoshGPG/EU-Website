<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
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

        <nav class="main-nav">
            <ul>
                <li class="dropdown">
                    <a href="nordic.php">NORDIC ▼</a>
                    <ul class="submenu">
                        <li><a href="adult.php">Adult</a></li>
                        <li><a href="juniors.php">Juniors</a></li>
                        <li><a href="youth.php">Youth</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="programs.php">PROGRAMS ▼</a>
                    <ul class="submenu">
                        <li><a href="paddling.php">Paddling</a></li>
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
                <li>
                    <a href="<?php echo esc_url(site_url('/events-listing/')); ?>">EVENTS</a>
                </li>
                <li class="dropdown">
                    <a href="programs.php">NEWS ▼</a>
                    <ul class="submenu">
                        <li><a href="paddling.php">PROGRAM NEWS</a></li>
                        <li><a href="cycling.php">RACE EVENT NEWS</a></li>
                        <li><a href="running.php">OTHER NEWS</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>

<div class="slogan-ribbon">ACTIVE. HEALTHY. OUTDOORS.</div>

<main class="site-content">
    <div class="container">
