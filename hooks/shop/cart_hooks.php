<?php
remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
add_action( 'rehorik_cart_notices', 'woocommerce_output_all_notices', 10 );