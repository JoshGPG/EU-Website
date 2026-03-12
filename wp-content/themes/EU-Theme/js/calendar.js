(function () {
    'use strict';

    var events = (window.euCalendarData && window.euCalendarData.events) || [];
    var now = new Date();
    var thisMonth = now.getMonth();
    var thisYear = now.getFullYear();
    var nextMonth = thisMonth === 11 ? 0 : thisMonth + 1;
    var nextYear = thisMonth === 11 ? thisYear + 1 : thisYear;

    // Build event map keyed by "YYYY-MM-DD"
    var eventMap = {};
    events.forEach(function (ev) {
        if (!ev.date) return;
        if (!eventMap[ev.date]) {
            eventMap[ev.date] = [];
        }
        eventMap[ev.date].push(ev);
    });

    var monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var gridLeft = document.getElementById('eu-calendar-grid-left');
    var gridRight = document.getElementById('eu-calendar-grid-right');
    var labelLeft = document.getElementById('eu-calendar-month-left');
    var labelRight = document.getElementById('eu-calendar-month-right');
    var eventsPanel = document.getElementById('eu-day-events');

    if (!gridLeft || !gridRight) return;

    function pad(n) {
        return n < 10 ? '0' + n : '' + n;
    }

    function renderMonth(grid, label, year, month) {
        label.textContent = monthNames[month] + ' ' + year;
        grid.innerHTML = '';

        var firstDay = new Date(year, month, 1).getDay();
        var daysInMonth = new Date(year, month + 1, 0).getDate();

        var today = new Date();
        var todayStr = today.getFullYear() + '-' + pad(today.getMonth() + 1) + '-' + pad(today.getDate());

        for (var e = 0; e < firstDay; e++) {
            var empty = document.createElement('div');
            empty.className = 'cal-day cal-empty';
            grid.appendChild(empty);
        }

        for (var d = 1; d <= daysInMonth; d++) {
            var dateStr = year + '-' + pad(month + 1) + '-' + pad(d);
            var cell = document.createElement('div');
            cell.className = 'cal-day';
            cell.textContent = d;

            if (dateStr === todayStr) {
                cell.classList.add('is-today');
            }

            if (eventMap[dateStr]) {
                cell.classList.add('has-events');
                cell.setAttribute('data-date', dateStr);
                cell.addEventListener('click', onDayClick);
            }

            grid.appendChild(cell);
        }
    }

    function onDayClick() {
        var dateStr = this.getAttribute('data-date');
        var dayEvents = eventMap[dateStr];
        if (!dayEvents || !eventsPanel) return;

        var parts = dateStr.split('-');
        var displayDate = monthNames[parseInt(parts[1], 10) - 1] + ' ' + parseInt(parts[2], 10) + ', ' + parts[0];

        var html = '<h3 class="cal-panel-title">Events on ' + displayDate + '</h3>';

        dayEvents.forEach(function (ev) {
            html += '<div class="cal-event-card">';
            html += '<h4><a href="' + ev.url + '">' + escapeHtml(ev.title) + '</a></h4>';

            var timeParts = [];
            if (ev.startTime) timeParts.push(formatTime(ev.startTime));
            if (ev.endTime) timeParts.push(formatTime(ev.endTime));
            if (timeParts.length) {
                html += '<p class="cal-event-time">' + timeParts.join(' &ndash; ') + '</p>';
            }

            if (ev.location) {
                html += '<p class="cal-event-location">' + escapeHtml(ev.location) + '</p>';
            }

            if (ev.excerpt) {
                html += '<p class="cal-event-excerpt">' + escapeHtml(ev.excerpt) + '</p>';
            }

            html += '</div>';
        });

        eventsPanel.innerHTML = html;

        var allDays = document.querySelectorAll('.cal-day');
        for (var i = 0; i < allDays.length; i++) {
            allDays[i].classList.remove('is-selected');
        }
        this.classList.add('is-selected');
    }

    function formatTime(timeStr) {
        var parts = timeStr.split(':');
        var h = parseInt(parts[0], 10);
        var m = parts[1] || '00';
        var ampm = h >= 12 ? 'PM' : 'AM';
        if (h === 0) h = 12;
        else if (h > 12) h -= 12;
        return h + ':' + m + ' ' + ampm;
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    renderMonth(gridLeft, labelLeft, thisYear, thisMonth);
    renderMonth(gridRight, labelRight, nextYear, nextMonth);
})();
