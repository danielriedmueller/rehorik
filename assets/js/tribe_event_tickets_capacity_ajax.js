(function ($) {
    if (typeof settings === 'undefined') {
        return false;
    }

    const ticketCapacityElements = $('td.available-tickets-attribute-cell[data-ticket-id]');
    const ticketIds = ticketCapacityElements.map((index, element) => element.getAttribute('data-ticket-id')).get();

    const applyCapacityTexts = function (ticketId, capacity) {
        const ticketCapacityElement = $('td.available-tickets-attribute-cell[data-ticket-id="' + ticketId + '"]');
        if (ticketCapacityElement.length > 0) {
            ticketCapacityElement.html(capacity);
        }
    }

    if (ticketCapacityElements.length > 0 && ticketIds.length > 0) {
        $.ajax({
            type: 'post',
            url: settings.ajax_url,
            data: {
                action: 'rehorik_ajax_tribe_events_get_ticket_capacity',
                nonce: settings.nonce,
                ticket_ids: ticketIds,
            },
            complete: function (response) {
                ticketCapacityElements.removeClass('loading');
            },
            success: function (response) {
                for (let ticketId in response.data) {
                    applyCapacityTexts(ticketId, response.data[ticketId]);
                }
            },
            error: function (req, status, err) {
                ticketCapacityElements.html('Kapazität konnte nicht geladen werden');
            }
        });
    }
})(jQuery);
