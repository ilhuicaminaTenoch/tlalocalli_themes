<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('daiquiri_quickcal_get_css')) {
	add_filter('daiquiri_filter_get_css', 'daiquiri_quickcal_get_css', 10, 4);
	function daiquiri_quickcal_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-people button,
body #booked-profile-page input[type="submit"],
body #booked-profile-page button,
body .booked-list-view input[type="submit"],
body .booked-list-view button,
body table.booked-calendar input[type="submit"],
body table.booked-calendar button,
body .booked-modal input[type="submit"],
body .booked-modal button,
body #booked-profile-page .booked-profile-appt-list .appt-block .booked-cal-buttons a,
body #booked-profile-page .appt-block .booked-cal-buttons .google-cal-button,
body .booked-upload-wrap {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}

CSS;
		}
		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Calendar */
table.booked-calendar th .monthName a {
	color: {$colors['extra_link']};
}
table.booked-calendar th .monthName a:hover {
	color: {$colors['extra_hover']};
}
.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-title {
	color: {$colors['text_link']};
}
body .booked-modal .bm-window p.appointment-info i,
.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-time {
	color: {$colors['inverse_dark']};
}
.booked-calendar-wrap .booked-appt-list .timeslot .spots-available {
	color: {$colors['text']};
}

body table.booked-calendar td.today.prev-date:hover .date span,
 table.booked-calendar td.today.prev-date .date span {
 color: {$colors['text_link']} !important;
}


/* Form fields */
#booked-page-form {
	color: {$colors['text']};
	border-color: {$colors['bd_color']};
}

#booked-profile-page .booked-profile-header {
	background-color: {$colors['bg_color']} !important;
	border-color: transparent !important;
	color: {$colors['text']};
}
#booked-profile-page .booked-user h3 {
	color: {$colors['text_dark']};
}
#booked-profile-page .booked-profile-header .booked-logout-button:hover {
	color: {$colors['text_link']};
}

#booked-profile-page .booked-tabs {
	border-color: {$colors['alter_bd_color']} !important;
}

.booked-modal .bm-window p.booked-title-bar {
	background-color: {$colors['alter_dark']} !important;
}
.booked-modal .bm-window p.booked-title-bar small {
    color: {$colors['bg_color']} !important;
}
.booked-modal .bm-window .close i {
	color: {$colors['alter_bg_color']};
}
body .booked-modal .bm-window p em {
    color: {$colors['text']};
}

.booked-calendarSwitcher.calendar,
.booked-calendarSwitcher.calendar select,
#booked-profile-page .booked-tabs {
	background-color: {$colors['alter_bg_color']} !important;
}
#booked-profile-page .booked-tabs li a {
	background-color: {$colors['extra_bg_hover']};
	color: {$colors['extra_dark']};
}
#booked-profile-page .booked-tabs li a i {
	color: {$colors['extra_dark']};
}
table.booked-calendar thead,
table.booked-calendar thead th,
table.booked-calendar tr.days,
table.booked-calendar tr.days th,
#booked-profile-page .booked-tabs li.active a,
#booked-profile-page .booked-tabs li.active a:hover,
#booked-profile-page .booked-tabs li a:hover {
	color: {$colors['extra_dark']} !important;
	background-color: {$colors['extra_bg_color']} !important;
}
table.booked-calendar tr.days,
table.booked-calendar tr.days th {
	border-color: {$colors['extra_bd_color']} !important;
}
table.booked-calendar thead th i,
body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row .bc-col .page-right i, 
body div.booked-calendar-wrap div.booked-calendar .bc-head .bc-row .bc-col .page-left i {
	color: {$colors['extra_dark']} !important;
}
table.booked-calendar td.today .date span {
	border-color: {$colors['text_link']};
}
table.booked-calendar td:hover .date span {
	color: {$colors['alter_bg_color']} !important;
}
table.booked-calendar td.today:hover .date span {
	background-color: {$colors['text_link']} !important;
	color: {$colors['inverse_link']} !important;
}
#booked-profile-page .booked-tab-content {
	background-color: {$colors['bg_color']};
	border-color: {$colors['alter_bd_color']};
}
table.booked-calendar td,
table.booked-calendar td+td {
	border-color: {$colors['alter_bd_color']};
}
body table.booked-calendar td:hover .date {
	background-color: {$colors['extra_bd_color']};
}
body div.booked-calendar .bc-head .bc-col {
	background-color: {$colors['inverse_dark']}!important;
	border-color: {$colors['inverse_dark']}!important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.active:hover .date span,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.active .date .number {
	background-color: {$colors['extra_hover']};
	color: {$colors['extra_dark']};
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.next-month:hover .date span, 
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.prev-month:hover .date span {
	background-color: {$colors['extra_link']};
	color: {$colors['extra_dark']};
}

/* New */
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col {
	color: {$colors['text_dark']};
	border-color: {$colors['bd_color']};
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.next-month .date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.prev-month .date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.prev-date:hover .date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.prev-date .date {
	color: {$colors['alter_light']}!important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.today.active span.date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.active span.date {
	background-color: {$colors['alter_bg_hover']}!important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col:not(.prev-date):hover span.date {
	background-color: {$colors['alter_bg_hover']}!important;
    color: {$colors['text_dark']}!important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.today.prev-date .date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.today .date {
	background-color: {$colors['extra_bg_color']}!important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.today.prev-date .date span {
    color: {$colors['extra_dark']}!important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week div.bc-col.today:not(.active):not(:hover):not(.prev-date) .date span {
    color: {$colors['extra_dark']}!important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.entryBlock .bc-col {
	border: 20px solid {$colors['alter_bg_hover']};
}
body div.booked-calendar-wrap .booked-appt-list h2 {
	color: {$colors['text_dark']}!important;
}
body div.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-time, body div.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-people {
	color: {$colors['text_dark']};
}
body div.booked-calendar-wrap .booked-appt-list .timeslot .spots-available {
	color: {$colors['text_dark']};
}
body .booked-modal .bm-window p.booked-title-bar {
	background-color: {$colors['text_link']}!important;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body {
	border: 1px solid {$colors['bd_color']}!important;
    margin-top: -1px;
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week + .bc-row.week .bc-col {
	border-top: 1px solid {$colors['bd_color']};
}
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.active .date,
body div.booked-calendar-wrap div.booked-calendar .bc-body .bc-row.week .bc-col.today:hover .date span {
	color: {$colors['text_dark']}!important;
}

body div.booked-calendar-wrap div.booked-calendar .booked-appt-list .timeslot+.timeslot {
    border-top: 1px solid {$colors['bd_color']};
}

/* Shortcodes */

body #booked-profile-page .booked-profile-appt-list .appt-block,
body #booked-profile-page .booked-profile-appt-list .appt-block > i.fa-solid,
body #booked-profile-page .booked-profile-appt-list .appt-block > strong {
	color: {$colors['text_light']}!important;
}
body #booked-profile-page .booked-profile-appt-list .appt-block.approved,
body #booked-profile-page .booked-profile-appt-list .appt-block.approved > i.fa-solid {
	color: {$colors['text_dark']};
}
body #booked-profile-page .appt-block .booked-cal-buttons .google-cal-button {
	color: {$colors['inverse_text']}!important;
	background-color: {$colors['text_link']};
}
body #booked-profile-page .appt-block .booked-cal-buttons .google-cal-button:hover {
	color: {$colors['inverse_text']}!important;
	background-color: {$colors['text_hover']};
}
body #booked-profile-page .booked-profile-appt-list button.button-primary,
body .booked-upload-wrap,
body #booked-profile-page .booked-profile-appt-list .appt-block .booked-cal-buttons a {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_hover']};
}
body .booked-upload-wrap span {
	color: {$colors['inverse_link']};
}
body #booked-profile-page .booked-profile-appt-list button.button-primary:hover,
body .booked-upload-wrap:hover,
body #booked-profile-page .booked-profile-appt-list .appt-block .booked-cal-buttons a:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['alter_bd_hover']};
}
body .booked-upload-wrap:hover span {
	color: {$colors['inverse_link']};
}
body #booked-profile-page .booked-profile-appt-list .appt-block .status-block {
	color: {$colors['alter_light']};
	background-color: {$colors['alter_bg_hover']};
}
body #booked-profile-page .booked-profile-appt-list .appt-block.approved .status-block {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
body #booked-profile-page .booked-profile-appt-list .appt-block {
	border-color: {$colors['bd_color']};
}
body #booked-profile-page .booked-profile-appt-list .appt-block .booked-fea-buttons > a.delete, 
body #booked-profile-page .booked-profile-appt-list .appt-block .booked-fea-buttons > button.delete {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
body #booked-profile-page .booked-profile-appt-list .appt-block .booked-fea-buttons > a.delete:hover, 
body #booked-profile-page .booked-profile-appt-list .appt-block .booked-fea-buttons > button.delete:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_hover']};
}

body #booked-profile-page .booked-profile-header .booked-logout-button {
	color: {$colors['text_link']};
}

body #booked-profile-page .booked-profile-header .booked-logout-button:hover {
	color: {$colors['text_hover']};
}

CSS;
		}

		return $css;
	}
}
?>