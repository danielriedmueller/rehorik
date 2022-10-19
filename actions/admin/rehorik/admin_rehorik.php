<?php
require_once('delete_past_events.php');

// Add admin page
add_action('admin_menu', function () {
    add_menu_page('Rehorik', 'Rehorik', 'administrator', 'rehorik-admin', function () {
        ?>
        <div>
            <div id="status">OK</div>
            <button disabled class="rehorik-admin-action-button" data-action="update_coffee_price">Update Coffee Price</button>
            <button disabled class="rehorik-admin-action-button" data-action="update_sku">Update SKUs</button>
            <button class="rehorik-admin-action-button" data-action="hide_past_event_tickets">Hide Past Event Tickets</button>
            <button class="rehorik-admin-action-button" data-action="update_tickets_date">Update All Tickets</button>
            <button class="rehorik-admin-action-button" data-action="create_test_coupon">Create Test Coupon</button>
        </div>
        <?php
    }, null, 3);
});

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook == 'toplevel_page_rehorik-admin') {
        $assetsDir = get_stylesheet_directory_uri() . '/assets/';
        wp_enqueue_script('rehorik-admin', $assetsDir . 'js/admin.js', ['jquery'], 1, false);
    }
});

add_action('wp_ajax_create_test_coupon', function () {
    //$couponFactory = new Reh_Create_Coupon();
    //$couponFactory->createCoupon(12.5);
    //$couponFactory->deleteCoupon('ouqnq');

    $order_id = 30524;
    $allmails = WC()->mailer()->emails;
    $email = $allmails['WC_Email_Customer_Completed_Order'];
    $email->trigger( $order_id );
});

add_action('wp_ajax_update_sku', function () {
    $skus = [
        '08.005.018.024.0145',
        '08.006.018.034.0965',
        '08.007.018.034.0220',
        '08.007.018.034.0633',
        '1000320',
        '1000321',
        '08.011.018.032.0221',
        '08.003.018.026.9622',
        '08.002.018.027.8972',
        '08.003.018.026.9627',
        '08.003.018.026.9625',
        '08.003.018.026.9624',
        '08.003.018.026.9623',
        '08.003.018.026.9626',
        '08.016.018.027.0959',
        '1000323',
        '08.003.018.027.8990',
        '08.003.018.027.9701',
        '08.003.018.027.8991',
        '08.003.018.032.0812',
        '1000387',
        '1000388',
        '1001030',
        '1001029',
        '1001031',
        '1000390',
        '1001135',
        '1001134',
        '08.002.018.036.9592',
        '08.002.018.036.9399',
        '1001137',
        '1001136',
        '08.006.018.032.0639',
        '1000507',
        '08.008.018.034.7547',
        '1001231',
        '08.011.018.032.0223',
        '1000353',
        '1001033',
        '1000803',
        '1000505',
        '1001008',
        '1000645',
        '1001236',
        '1000641',
        '1001235',
        '1001099',
        '1000964',
        '1000241',
        '1000147',
        '1001186',
        '1000502',
        '1000996',
        '1001009',
        '1001012',
        '1001081',
        '1001083',
        '1000515',
        '1000111',
        '1000110',
        '1000785',
        '1001188',
        '1001193',
        '1001323',
        '1001322',
        '1000807',
        '1000804',
        '1000805',
        '1000758',
        '1001176',
        '1001177',
        '1000749',
        '1000747',
        '1001117',
        '1000536',
        '1000922',
        '1000925',
        '1000498',
        '1000989',
        '1001101',
        '1000242',
        '1000882',
        '1001219',
        '1000880',
        '1001103',
        '1000883',
        '1001194',
        '1000982',
        '1000333',
        '1001179',
        '1001244',
        '1001247',
        '1000201',
        '1000806',
        '1000980',
        '1001098',
        '1000884',
        '1000485',
        '1000148',
        '1001178',
        '1001248',
    ];

    try {
        $products = wc_get_products(['status' => 'publish', 'limit' => -1, 'category' => ['wein', 'spirits']]);

        foreach ($products as $product) {
            $found = null;

            if ($product->is_type('variable')) {
                echo 'is variable: ' . '<a href="' . $product->get_permalink() . '">' . $product->get_title() . '</a></br>';
                continue;
            }

            /** @var WC_Product_Simple $product */
            $sku = $product->get_sku();
            if (!empty($sku) && strlen($sku) < 5 && strlen($sku) > 2) {
                $stringLength = strlen($sku);
                $title = $product->get_title();

                foreach ($skus as $newSku) {
                    if ($sku === substr($newSku, -$stringLength)) {
                        if ($found) {
                            echo 'already found: ' . $found . ', ' . '<a href="' . $product->get_permalink() . '">' . $product->get_title() . '</a>' . '<br>';
                        }
                        $found = $newSku;
                    }
                }

                if (!$found) {
                    throw new Exception('not found: ' . $sku . ', ' . '<a href="' . $product->get_permalink() . '">' . $product->get_title() . '</a>');
                }
            }

            if ($found) {
                echo 'new sku ' . $found . ': <a href="' . $product->get_permalink() . '">' . $product->get_title() . '</a> ' . $product->get_sku() . '</br>';

                if (!wc_product_has_unique_sku($product->get_id(), $found)) {
                    $product_id_found = wc_get_product_id_by_sku($found);
                    $product_found = wc_get_product($product_id_found);
                    throw new Exception(
                        'not unique: ' . $found . ', '
                        . ' <a href="' . $product->get_permalink() . '">' . $product->get_title() . '</a>'
                        . ' <a href="' . $product_found->get_permalink() . '">' . $product_found->get_title() . '</a>'
                    );
                } else {
                    $product->set_sku($found);
                    $product->save();
                }
            }
        }

        echo "OK";
    } catch (Exception $exception) {
        echo "error: " . $exception->getMessage();
    }
});

add_action('wp_ajax_update_coffee_price', function () {
    $newPrices = [
        'Schümli' => [6.50, 12.50, 25.00],
        '190°' => [8.25, 16.00, 32.00],
        'Kenya Gourmet' => [8.25, 16.00, 32.00],
        'Arabica Due' => [6.75, 13.00, 26.00],
        'Bergsport' => [7.75, 15.00, 30.00],
        'Amazonas' => [7.25, 14.00, 28.00],
        'Spätlese' => [6.75, 13.00, 26.00],
        'Café Felix' => [6.50, 12.50, 25.00],
        'La Victoria' => [7.25, 14.00, 28.00],
        'Primissimo' => [6.50, 12.50, 25.00],
        'Röstmeister' => [6.75, 13.00, 26.00],
        'Nuovo' => [6.75, 13.00, 26.00],
        'Primo' => [6.25, 12.00, 24.00],
        'Diavolo' => [6.75, 13.00, 26.00],
        'Espresso Entkoffeiniert' => [6.75, 13.00, 26.00],
        'Mokka' => [7.25, 14.00, 28.00],
        'Gakundu' => [8.25, 16.00, 32.00],
        'La Passeio' => [7.00, 13.50, 27.00],
        'Filterkaffee Spätlese' => [6.75, 13.00, 26.00],
        'Horizontes' => [6.75, 13.00, 26.00],
        'La Cascada' => [6.75, 13.00, 26.00],
        'Filterkaffee La Victoria' => [6.75, 13.00, 26.00],
        'Filterkaffee Amazonas' => [7.25, 14.00, 28.00],
        'Sumatra' => [7.25, 14.00, 28.00],
        'Monsooned Malabar' => [6.75, 13.00, 26.00],
        'Karlsbader Mischung' => [7.00, 13.50, 27.00],
        'Festmischung' => [6.25, 12.00, 24.00],
        'Regensburger Mischung' => [6.75, 13.00, 26.00],
        'Premium Blend' => [7.00, 13.50, 27.00],
        'Spezial Mischung' => [5.75, 11.00, 22.00],
        'Malega' => [6.75, 13.00, 26.00],
        'Filterkaffee Entkoffeiniert' => [6.50, 12.50, 25.00],
        'Weihnachtsmischung' => [7.25, 14.00, 28.00],
        'Ostermischung' => [7.25, 14.00, 28.00],
    ];

    try {
        $products = wc_get_products(['status' => 'publish', 'limit' => -1, 'category' => ['kaffee']]);

        foreach ($newPrices as $coffee => $newPrice) {
            $similiarity = null;
            $found = [];

            foreach ($products as $product) {
                /** @var WC_Product_Simple $product */
                similar_text($coffee, $product->get_title(), $similiarity);
                $found[$similiarity] = $product;
            }

            krsort($found);
            /** @var WC_Product_Simple $foundProduct */
            $foundProduct = current($found);

            if (!$foundProduct) {
                throw new Exception('no product found');
            }

            if ($foundProduct->is_type('variable')) {
                foreach ($foundProduct->get_children() as $childId) {
                    $child = wc_get_product($childId);

                    $gzd_product = wc_gzd_get_gzd_product($child);
                    $gzd_product->set_default_delivery_time_slug('');

                    $unit = $gzd_product->get_unit_product();
                    if ($unit !== '0.25' && $unit !== '0.5' && $unit !== '1') {
                        throw new Exception('wrong unit');
                    }

                    if ($unit === '0.25') {
                        $gzd_product->get_wc_product()->set_regular_price($newPrice[0]);
                        $gzd_product->set_unit_price_regular($newPrice[2] + 1);
                        $gzd_product->set_unit_price($newPrice[2] + 1);
                    }

                    if ($unit === '0.5') {
                        $gzd_product->get_wc_product()->set_regular_price($newPrice[1]);
                        $gzd_product->set_unit_price_regular($newPrice[2]);
                        $gzd_product->set_unit_price($newPrice[2]);

                    }

                    if ($unit === '1') {
                        $gzd_product->get_wc_product()->set_regular_price($newPrice[2]);
                        $gzd_product->set_unit_price_regular($newPrice[2]);
                        $gzd_product->set_unit_price($newPrice[2]);
                    }

                    $gzd_product->get_wc_product()->save();
                    $gzd_product->save();
                }

            } else {
                throw new Exception('not variable');
            }
        }

        echo "OK";
    } catch (Exception $exception) {
        echo "error: " . $exception->getMessage();
    }
});

/*
add_action('wp_ajax_create_sigil_attributes', function() {
    try {
        $guetesiegel = 'pa_guetesiegel';
        $products = wc_get_products(array( 'status' => 'publish', 'limit' => -1 ));

        $updateAttribute = function($attribute, $product) use ($guetesiegel) {
            wp_set_object_terms($product->get_id(), $attribute, $guetesiegel, true);
            $product_attributes = get_post_meta( $product->get_id() ,'_product_attributes', true);
            $product_attributes[$guetesiegel] = [
                'name' => $guetesiegel,
                'value' => $attribute,
                'is_visible' => '1',
                'is_taxonomy' => '1'
            ];
            update_post_meta($product->get_id(), '_product_attributes', $product_attributes);
        };

        foreach ($products as $product) {
            if (!empty($product->get_attribute('biodynamisch'))) {
                $updateAttribute('biodynamisch', $product);
            }

            if (!empty($product->get_attribute('biosiegel'))) {
                $updateAttribute('biosiegel', $product);
            }

            if (!empty($product->get_attribute('product-of-month'))) {
                $updateAttribute('produkt-des-monats', $product);
            }
            if (!empty($product->get_attribute('regional'))) {
                $updateAttribute('regional', $product);
            }
        }

        echo "OK";
    } catch (Exception $exception) {
        echo "error: " . $exception->getMessage();
    }
});
*/
/*
function syncEventCategoriesToProductCategories() {
    //Map event catgegories with woocommerce categories
    $eventCats = get_terms(TribeEvents::TAXONOMY, array('hide_empty' => 0));
    $eventParentProductCat = get_term_by('slug', TICKET_CATEGORY_SLUG, 'product_cat');

    foreach ($eventCats as $eventCat) {
        $existingCat = get_term_by('slug', $eventCat->slug, 'product_cat');

        if ($eventCat->parent === 0) {
            $productParentCat = $eventParentProductCat;
        } else {
            $eventParentCat = get_term($eventCat->parent, TribeEvents::TAXONOMY);
            $productParentCat = get_term_by('slug', $eventParentCat->slug, 'product_cat');
        }

        if ($productParentCat) {
            if (!$existingCat) {
                wp_insert_term( $eventCat->name, 'product_cat', array(
                    'parent' => $productParentCat->term_id, // optional
                    'slug' => $eventCat->slug // optional
                ));
            } else {
                wp_update_term($existingCat->term_id, 'product_cat', array(
                    'name' => $eventCat->name,
                    'parent' => $productParentCat->term_id, // optional
                    'slug' => $eventCat->slug // optional
                ));
            }
        }
    }
}
*/
