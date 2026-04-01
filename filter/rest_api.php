<?php
/**
 * Restricts access to the WordPress REST API users endpoint.
 *
 * The default /wp-json/wp/v2/users endpoint exposes usernames and other
 * user data publicly, which can be used for brute-force attacks.
 * This filter requires authentication for any users endpoint request.
 */
add_filter('rest_pre_dispatch', function ($result, WP_REST_Server $server, WP_REST_Request $request) {
    $route = $request->get_route();

    if (preg_match('/^\/wp\/v2\/users/', $route) && !current_user_can('manage_options')) {
        return new WP_Error(
            'rest_forbidden',
            'You are not allowed to access user data.',
            ['status' => 401]
        );
    }

    return $result;
}, 10, 3);
