<?php
//Remove product tabs
add_filter( 'woocommerce_product_tabs', '__return_empty_array', 98 );