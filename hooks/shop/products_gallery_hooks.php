<?php

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action('woocommerce_before_shop_loop', 'result_count_and_ordering', 20);

function result_count_and_ordering()
{
    echo '<div class="rehorik-result-count-and-ordering">';
    woocommerce_result_count();
    woocommerce_catalog_ordering();
    echo '</div>';
}

