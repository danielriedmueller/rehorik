<?php
global $product;
$event = tribe_events_get_ticket_event($product->get_id());

if (!$event) {
    return;
}

$location = tribe_get_venue($event->ID);

$startDate = $product->get_meta(TICKET_EVENT_DATE_START_META);
$endDate = $product->get_meta(TICKET_EVENT_DATE_END_META);
$startTime = $product->get_meta(TICKET_EVENT_TIME_START_META);
$endTime = $product->get_meta(TICKET_EVENT_TIME_END_META);

$date = $startDate === $endDate
    ? date('d.m.Y', strtotime($startDate))
    : sprintf('%s - %s', date('d.m.Y', strtotime($startDate)), date('d.m.Y', strtotime($endDate)));
$time = sprintf('%s - %s', $startTime, $endTime);

$price = wc_price($product->get_price());
?>
<div class="rehorik-product-attributes">
    <div class='rehorik-product-min-price'><?= ($product->is_type('variable') ? "ab " : "") . $price . " *" ?></div>
    <table>
        <tbody>
            <tr class="seperator">
                <td colspan="2"><hr /></td>
            </tr>
            <tr>
                <td>DATUM</td>
                <td class="rehorik-product-attribute-list"><?= $date ?></td>
            </tr>
            <tr>
                <td>UHRZEIT</td>
                <td class="rehorik-product-attribute-list"><?= $time ?></td>
            </tr>
            <tr>
                <td>ORT</td>
                <td class="rehorik-product-attribute-list"><?= $location ?></td>
            </tr>
        </tbody>
    </table>
</div>