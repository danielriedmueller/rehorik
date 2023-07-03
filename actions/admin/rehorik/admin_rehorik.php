<?php
require_once('delete_past_events.php');
require_once('product_feed.php');
require_once('create_coffees.php');

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook == 'toplevel_page_rehorik-admin') {
        $assetsDir = get_stylesheet_directory_uri() . '/assets/';
        wp_enqueue_script('rehorik-admin', $assetsDir . 'js/admin.js', ['jquery'], 1, false);
    }
});

// Add admin page
add_action('admin_menu', function () {
    add_menu_page('Rehorik', 'Rehorik', 'administrator', 'rehorik-admin', function () {
        $nextFeed = wp_next_scheduled(Reh_Product_Feed::CRON_HOOK);
        $feeds = array_diff(scandir(Reh_Product_Feed::get_feed_path()), array('.', '..'));
        ?>
        <h2>Rehorik Admin</h2>
        <div style="margin-top: 20px">
            <fieldset>
                <legend>Create Coffees</legend>
                <button class="rehorik-admin-action-button" data-action="create_coffees">Do it!
                </button>
            </fieldset>
        </div>
        <div style="margin-top: 20px">
            <fieldset>
                <legend>Event Tickets</legend>
                <button class="rehorik-admin-action-button" data-action="hide_past_event_tickets">Hide Past
                </button>
            </fieldset>
        </div>
        <div style="margin-top: 20px">
            <fieldset>
                <legend>Product Feed -> <?php if ($nextFeed) {
                        echo '<span style="color: green">active (' . date('d.m.Y H:i:s', $nextFeed) . ')</span>';
                    } else {
                        echo '<span style="color: red">inactive</span>';
                    } ?>
                </legend>
                <button class="rehorik-admin-action-button" data-action="create_product_feeds">Update now</button>
                <?php if ($nextFeed): ?>
                    <button class="rehorik-admin-action-button" data-action="deactivate_product_feeds">Deactivate
                        Schedule
                    </button>
                <?php else: ?>
                    <button class="rehorik-admin-action-button" data-action="activate_product_feeds">Activate Schedule
                    </button>
                <?php endif; ?>
                <?php if (!empty($feeds)): ?>
                    <div>
                        <h3>Feeds</h3>
                        <ul>
                            <?php foreach ($feeds as $feed): ?>
                                <li>
                                    <a href="<?= Reh_Product_Feed::get_feed_url() . $feed; ?>"
                                       target="_blank"><?= $feed ?></a>
                                    <span>
                                    <?php
                                    if ($changed = filemtime(Reh_Product_Feed::get_feed_path() . $feed)) {
                                        echo date('d.m.Y H:i:s', $changed);
                                    } else {
                                        echo 'unknown';
                                    }
                                    ?>
                                </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </fieldset>
        </div>
        <div style="margin-top: 20px">
            <div id="status"></div>
        </div>
        <?php
    }, null, 3);
});
