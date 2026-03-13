<?php
/**
 * Template Name: Calendar
 */
get_header();
?>

<h1 class="page-title">Calendar</h1>

<div class="cal-filters">
    <button class="cal-filter-btn active" data-filter="all">All Events</button>
    <button class="cal-filter-btn" data-filter="race">Races</button>
    <button class="cal-filter-btn" data-filter="practice">Practices</button>
</div>

<div class="eu-calendar-wrap">
    <div class="cal-two-months">
        <div class="eu-calendar" id="eu-calendar-left">
            <h2 class="cal-month-label" id="eu-calendar-month-left"></h2>
            <div class="cal-weekdays">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>
            <div class="cal-grid" id="eu-calendar-grid-left"></div>
        </div>

        <div class="eu-calendar" id="eu-calendar-right">
            <h2 class="cal-month-label" id="eu-calendar-month-right"></h2>
            <div class="cal-weekdays">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>
            <div class="cal-grid" id="eu-calendar-grid-right"></div>
        </div>
    </div>
</div>

<div id="eu-day-events" class="cal-day-events">
    <p class="cal-panel-hint">Click or hover over a highlighted day to see events.</p>
</div>

<?php get_footer(); ?>
