<?php

function getFreeShippingAmount(): float
{
    //TODO get free shipping amount programmatically
    return FREE_SHIPPING_AMOUNT;
}

function getAmountTillFreeShipping(): float
{
    $cart = WC()->cart;
    $totalPrice = 0;
    $needsShipping = false;
    foreach ($cart->get_cart() as $product) {
        /** @var WC_Product_Simple $data */
        $data = $product['data'];
        $totalPrice += ($data->get_price('edit') * $product['quantity']);

        if ($data->needs_shipping()) {
            $needsShipping = true;
        }
    }

    if (!$needsShipping) {
        return 0;
    }

    return round(getFreeShippingAmount() - $totalPrice, 2);
}

function getShippingDurationMessage(): string
{
    return sprintf('<br /><small>Lieferzeit: %s</small>', SHIPPING_DURATION_MESSAGE);
}
