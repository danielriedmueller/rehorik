<?php
global $product;

$event = tribe_events_get_ticket_event($product->get_id());

if (!$event) {
    return;
}

$availableTickets = null;
$tickets = Tribe__Tickets__Tickets::get_all_event_tickets($event->ID);
if (is_array($tickets) && sizeof($tickets) > 0) {
    $availableTickets = $tickets[0]->available();
}

$location = tribe_get_venue($event->ID);

$startDatetime = $product->get_meta(TICKET_EVENT_DATE_START_META);
$endDatetime = $product->get_meta(TICKET_EVENT_DATE_END_META);

if ($startDatetime && $endDatetime) {
    $startDate = date('d.m.Y', $startDatetime);
    $endDate = date('d.m.Y', $endDatetime);

    if ($startDate === $endDate) {
        $date = $startDate;
        $time = sprintf('%s - %s', date('H:i', $startDatetime), date('H:i', $endDatetime));
    } else {
        $date = sprintf('%s - %s', date(DATE_FORMAT, $startDatetime), date(DATE_FORMAT, $endDatetime));
    }
}

$price = wc_price($product->get_price());
?>
<div class="rehorik-product-attributes">
    <div class='rehorik-product-min-price'><?= ($product->is_type('variable') ? "ab " : "") . $price . " *" ?></div>
    <table>
        <tbody>
        <tr class="seperator">
            <td colspan="2">
                <hr/>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="available-tickets-attribute-cell">
                <?php if ($availableTickets) : ?>
                    Noch
                    <span><?= $availableTickets ?></span> <?php echo $availableTickets === 1 ? 'Platz' : 'Plätze' ?> verfügbar
                <?php else : ?>
                    Nicht länger verfügbar
                <?php endif; ?>
            </td>
        </tr>
        <tr class="seperator">
            <td colspan="2">
                <hr/>
            </td>
        </tr>
        <?php if ($date) : ?>
            <tr>
                <td>DATUM</td>
                <td class="rehorik-product-attribute-list"><?= $date ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($time) : ?>
            <tr>
                <td>UHRZEIT</td>
                <td class="rehorik-product-attribute-list"><?= $time ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td>ORT</td>
            <td class="rehorik-product-attribute-list"><?= $location ?></td>
        </tr>
        </tbody>
    </table>
</div>
