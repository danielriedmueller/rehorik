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
        'CAMA' => [
            10.5,
            20,
            39.5
        ],
        'CSCH' => [
            9,
            17,
            33.5
        ],
        'E190' => [
            10.5,
            20,
            39.5
        ],
        'EARD' => [
            9.25,
            17.5,
            34.5
        ],
        'EBER' => [
            9.75,
            18.5,
            36.5
        ],
        'EAMA' => [
            9.75,
            18.5,
            36.5
        ],
        'EHER' => [
            9.5,
            18,
            35.5
        ],
        'EVIC' => [
            9.75,
            18.5,
            36.5
        ],
        'ECAF' => [
            9,
            17,
            33.5
        ],
        'ECOF' => [
            9,
            17,
            33.5
        ],
        'EDIA' => [
            9.25,
            17.5,
            34.5
        ],
        'EENT' => [
            10,
            19,
            37.5
        ],
        'EHEA' => [
            10.5,
            20,
            39.5
        ],
        'EKEN' => [
            10,
            19,
            37.5
        ],
        'EMER' => [
            9.5,
            18,
            35.5
        ],
        'ENUO' => [
            9,
            17,
            33.5
        ],
        'EPRS' => [
            9,
            17,
            33.5
        ],
        'EPRI' => [
            9,
            17,
            33.5
        ],
        'EROS' => [
            9.25,
            17.5,
            34.5
        ],
        'ESPA' => [
            9,
            17,
            33.5
        ],
        'FAMA' => [
            9.75,
            18.5,
            36.5
        ],
        'FVIC' => [
            9,
            17,
            33.5
        ],
        'FMOK' => [
            10,
            19,
            37.5
        ],
        'FMON' => [
            9.5,
            18,
            35.5
        ],
        'FSUM' => [
            10,
            19,
            37.5
        ],
        'FENT' => [
            10,
            19,
            37.5
        ],
        'FFES' => [
            9,
            17,
            33.5
        ],
        'FGAK' => [
            12,
            23,
            45.5
        ],
        'FKAR' => [
            9.5,
            18,
            35.5
        ],
        'FCAS' => [
            9.5,
            18,
            35.5
        ],
        'FPAS' => [
            9.5,
            18,
            35.5
        ],
        'FROC' => [
            9.5,
            18,
            35.5
        ],
        'FMAL' => [
            9.5,
            18,
            35.5
        ],
        'FPRE' => [
            9.75,
            18.5,
            36.5
        ],
        'FREG' => [
            9.25,
            17.5,
            34.5
        ],
        'FSPA' => [
            9,
            17,
            33.5
        ],
        'FSPE' => [
            8.75,
            16.5,
            32.5
        ],
        'FWEI' => [
            9.5,
            18,
            35.5
        ],
        'FOST' => [
            9.5,
            18,
            35.5
        ],
        'EDOM' => [
            9.75,
            18.5,
            36.5
        ],
        'EPOM' => [
            9,
            17,
            33.5
        ],
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