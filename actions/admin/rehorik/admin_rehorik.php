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
        $nextFeed = wp_next_scheduled(Reh_Product_Feed::CRON_HOOK);
        $feeds = array_diff(scandir(Reh_Product_Feed::get_feed_path()), array('.', '..'));
        ?>
        <h2>Rehorik Admin</h2>
        <button class="rehorik-admin-action-button" data-action="update_coffee_price">Update Coffee Price</button>
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

add_action('wp_ajax_update_coffee_price', function () {
    $newPrices = [
        'CAMA' => [9.75, 18.5, 36.5],
        'CSCH' => [8.5, 16, 31.5],
        'E190' => [9.75, 18.5, 36.5],
        'EAMA' => [9.25, 17.5, 34.5],
        'EARA' => [12.5, null, null],
        'EARD' => [8.75, 16.5, 32.5],
        'EBER' => [9.25, 17.5, 34.5],
        'ECAF' => [8.5, 16, 31.5],
        'ECOF' => [null, 16, 31.5],
        'EDIA' => [8.5, 16.5, 32.5],
        'EENT' => [9.5, 18, 35.5],
        'EHER' => [9, 17, 33.5],
        'EKEN' => [9.5, 18, 35.5],
        'EMER' => [9, 17, 33.5],
        'EMIR' => [11.95, null, null],
        'ENUO' => [8.5, 16, 31.5],
        'EPRI' => [8.5, 16, 31.5],
        'EPRS' => [8.5, 16, 31.5],
        'EROS' => [8.75, 16.5, 32.5],
        'ESPA' => [8.5, 16, 31.5],
        'EVIC' => [9.25, 17.5, 34.5],
        'FAMA' => [9.25, 17.5, 34.5],
        'FCAS' => [9, 17, 33.5],
        'FENT' => [9.5, 18, 35.5],
        'FFES' => [8.5, 16, 31.5],
        'FGAK' => [12, 23, 45.5],
        'FHOR' => [9, 17, 33.5],
        'FJAV' => [11.9, null, null],
        'FKAR' => [9, 17, 33.5],
        'FMAL' => [9, 17, 33.5],
        'FMIR' => [11.95, null, null],
        'FMOK' => [9.5, 18, 35.5],
        'FMON' => [9, 17, 33.5],
        'FOST' => [9, 17, 33.5],
        'FPAS' => [9, 17, 33.5],
        'FPRE' => [9.25, 17.5, 34.5],
        'FREG' => [8.75, 16.5, 32.5],
        'FROC' => [9, 17, 33.5],
        'FRUB' => [11.9, null, null],
        'FRUG' => [12.5, null, null],
        'FSPA' => [8.5, 16, 31.5],
        'FSPE' => [8.25, 15.5, 30.5],
        'FSUM' => [9.5, 18, 35.5],
        'FVIC' => [8.5, 16, 31.5],
        'FWEI' => [9, 17, 33.5],
        'EDOM' => [null, 18, null],
        'EJAH' => [null, 16, null],
        'FJAH' => [null, 16, null],
        'EPOM' => [null, 16, null],
    ];

    foreach ($newPrices as $coffee => $newPrice) {
        $product_id = wc_get_product_id_by_sku($coffee);
        /** @var WC_Product $product */
        $product = wc_get_product($product_id);

        if (!$product) {
            continue;
        }

        if (!$product->is_type('variable')) {
            continue;
        }

        foreach ($product->get_children() as $childId) {
            $child = wc_get_product($childId);

            $gzd_product = wc_gzd_get_gzd_product($child);
            //$gzd_product->set_default_delivery_time_slug('');

            $unit = $gzd_product->get_unit_product();
            if ($unit !== '0.25' && $unit !== '0.5' && $unit !== '1') {
                continue;
            }

            if ($unit === '0.25' && $newPrice[0]) {
                $gzd_product->get_wc_product()->set_regular_price($newPrice[0]);
                $unitPrice = $newPrice[0] / (float)$unit;
                $gzd_product->set_unit_price_regular($unitPrice);
                $gzd_product->set_unit_price($unitPrice);
            }

            if ($unit === '0.5' && $newPrice[1]) {
                $gzd_product->get_wc_product()->set_regular_price($newPrice[1]);
                $unitPrice = $newPrice[1] / (float)$unit;
                $gzd_product->set_unit_price_regular($unitPrice);
                $gzd_product->set_unit_price($unitPrice);

            }

            if ($unit === '1' && $newPrice[2]) {
                $gzd_product->get_wc_product()->set_regular_price($newPrice[2]);
                $gzd_product->set_unit_price_regular($newPrice[2]);
                $gzd_product->set_unit_price($newPrice[2]);
            }

            $gzd_product->get_wc_product()->save();
            $gzd_product->save();
        }
    }
});