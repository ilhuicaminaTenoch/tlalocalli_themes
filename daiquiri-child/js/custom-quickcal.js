jQuery(document).ready(function($) {
    function getBlockedDates() {
        var blockedDates = [];
        var today = new Date();
        for (var i = 0; i < 6; i++) {
            var date = new Date();
            date.setDate(today.getDate() + i);
            blockedDates.push(date.toISOString().split('T')[0]);
        }
        return blockedDates;
    }

    var blockedDates = getBlockedDates();
    console.log(blockedDates); // Esto te mostrará las fechas bloqueadas en la consola.

    // Suponiendo que el calendario se inicializa en un elemento con la clase 'quickcal-calendar'.
    $('.booked-calendar .bc-body .bc-col').each(function() {
        var $dateElement = $(this);
        var date = $dateElement.data('date');
        if (blockedDates.includes(date)) {
            $dateElement.addClass('prev-date');
            $dateElement.find('.date').removeClass('tooltipster tooltipstered');
        }
    });
});
