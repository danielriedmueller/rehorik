<?php
add_action('rest_api_init', function () {
    $ns = 'reh/v1';

    register_rest_route($ns, '/products', [
        'methods' => 'GET',
        'callback' => [new Reh_Api_Products, 'fetchProducts']
    ]);

    register_rest_route($ns, '/products/update', [
        'methods' => 'POST',
        'callback' => [new Reh_Api_Products, 'updateProducts']
    ]);
});
