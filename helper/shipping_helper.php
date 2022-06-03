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
    foreach ($cart->get_cart() as $product) {
        /** @var WC_Product_Variation $variation */
        $variation = $product['data'];
        $totalPrice += ($variation->get_price('edit') * $product['quantity']);
    }

    return getFreeShippingAmount() - $totalPrice;
}
