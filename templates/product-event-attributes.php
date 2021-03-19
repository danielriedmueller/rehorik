<?php
global $product;
$event = tribe_events_get_ticket_event($product->get_id());

$location = tribe_get_venue($event->ID);
$startDate = tribe_get_start_date($event->ID, false, 'd.m.Y');
$endDate = tribe_get_start_date($event->ID, false, 'd.m.Y');
$startTime = tribe_get_start_time($event->ID);
$endTime = tribe_get_end_time($event->ID);

$date = $startDate === $endDate ? $startDate : sprintf('%s - %s', $startDate, $endDate);
$time = sprintf('%s - %s', $startTime, $endTime);


$price = wc_price($product->get_price());


?>
<div class="rehorik-product-attributes">
    <div class='rehorik-product-min-price'><?= ($product->is_type('variable') ? "ab " : "") . $price . " *" ?></div>
    <table class="mt">
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