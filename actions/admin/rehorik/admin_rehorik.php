<?php
require_once('delete_past_events.php');
require_once('product_feed.php');

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook == 'toplevel_page_rehorik-admin') {
        $assetsDir = get_stylesheet_directory_uri() . '/assets/';
        wp_enqueue_script('rehorik-admin', $assetsDir . 'js/admin.js', ['jquery'], 1, false);
    }
});

// Add admin page
add_action('admin_menu', function () {
    add_menu_page('Rehorik', 'Rehorik', 'administrator', 'rehorik-admin', function () {
        ?>
        <h2>Rehorik Admin</h2>
        <div style="margin-top: 20px">
            <fieldset>
                <legend>Event Tickets</legend>
                <button class="rehorik-admin-action-button" data-action="hide_past_event_tickets">Hide Past
                </button>
            </fieldset>
        </div>
        <div style="margin-top: 20px">
            <fieldset>
                <legend>Product Feed -> <?php if ($nextEvent = wp_next_scheduled(Reh_Product_Feed::CRON_HOOK)) {
                        echo '<span style="color: green">active (' . date('d.m.Y H:i:s', $nextEvent) . ')</span>';
                    } else {
                        echo '<span style="color: red">inactive</span>';
                    } ?>
                </legend>
                <button class="rehorik-admin-action-button" data-action="activate_product_feeds">Activate</button>
                <button class="rehorik-admin-action-button" data-action="deactivate_product_feeds">Deactivate</button>
            </fieldset>
        </div>
        <div style="margin-top: 20px">
            <div id="status"></div>
        </div>
        <?php
    }, null, 3);
});
