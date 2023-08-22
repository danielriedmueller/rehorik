<?php
add_filter('woocommerce_valid_webhook_events', function ($events) {
    $events[] = 'completed';
    return $events;
});

add_filter('woocommerce_webhook_topics', function ($topics) {
    $topics['order.completed'] = 'Bestellung abgeschlossen';

    return $topics;
});

add_filter('woocommerce_webhook_topic_hooks', function ($topic_hooks) {
    $hooks = array('woocommerce_order_status_completed');
    $statuses = array_filter(
        array_keys(wc_get_order_statuses()),
        function ($status) {
            return 'wc-completed' !== $status;
        }
    );

    foreach ($statuses as $status)
        $hooks[] = 'woocommerce_order_status_completed_to_' . substr($status, 3);

    $topic_hooks['order.completed'] = $hooks;

    return $topic_hooks;
});

apply_filters( 'woocommerce_webhook_deliver_async', '__return_false' );