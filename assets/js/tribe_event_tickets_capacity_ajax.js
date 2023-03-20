(function ($) {
    if (typeof settings === 'undefined') {
        return false;
    }

    const ticketCapacityElements = document.querySelectorAll('td.available-tickets-attribute-cell[data-ticket-id]');

    if (ticketCapacityElements.length) {
        ticketCapacityElements.forEach((element) => {
            const ticketId = element.getAttribute('data-ticket-id');
            if (ticketId) {
                const me = $(element);
                $.ajax({
                    type: 'post',
                    url: settings.ajax_url,
                    data: {
                        action: 'rehorik_ajax_tribe_events_get_ticket_capacity',
                        nonce: settings.nonce,
                        ticket_id: ticketId,
                    },
                    complete: function (response) {
                        me.removeClass('loading');
                    },
                    success: function (response) {
                        me.html(response.text);
                    },
                    error: function (req, status, err) {
                        console.log('Something went wrong', status, err);
                        me.html('Kapazität konnte nicht geladen werden');
                    }
                });
            }
        });
    }
})(jQuery);
