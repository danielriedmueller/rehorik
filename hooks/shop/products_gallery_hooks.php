<?php

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);


add_action('woocommerce_before_shop_loop', 'product_filter_button', 20);



function product_filter_button()
{
    echo '<button id="product-filter-button">Filtern & Sortieren</button>';
}

