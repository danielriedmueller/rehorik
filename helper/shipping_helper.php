<?php

function getFreeShippingAmount(): float
{
    //TODO get free shipping amount programmatically
    return FREE_SHIPPING_AMOUNT;
}

function getAmountTillFreeShipping(): float
{
    $cart = WC()->cart;
    $totalPrice = $cart->get_total('edit');
    $totalTax = $cart->get_total_tax();

    return getFreeShippingAmount() - $totalPrice - $totalTax;
}
