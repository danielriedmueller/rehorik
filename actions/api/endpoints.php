<?php
add_action('rest_api_init', function () {
    register_rest_route('reh/v1', '/sync', array(
        'methods' => 'GET',
        'callback' => [new Reh_Api_Products, 'fetchProducts']
    ));
});
