<?php
add_action('rest_api_init', function () {
    $ns = 'reh/v1';

    register_rest_route($ns, '/products', [
        'methods' => 'GET',
        'callback' => [new Reh_Api_Products, 'fetchProducts'],
        'permission_callback' => '__return_true'
    ]);

    register_rest_route($ns, '/products/update', [
        'methods' => 'POST',
        'callback' => [new Reh_Api_Products, 'updateProducts'],
        'permission_callback' => function (WP_REST_Request $request) {
            $secret = defined('REH_API_SECRET') ? REH_API_SECRET : '';
            if (empty($secret)) {
                return new WP_Error('misconfigured', 'API secret is not configured.', ['status' => 500]);
            }
            return hash_equals($secret, $request->get_header('X-Reh-Secret') ?? '');
        }
    ]);
});
