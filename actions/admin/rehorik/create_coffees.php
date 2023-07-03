<?php
add_action('wp_ajax_create_coffees', function () {
    try {
        //$skuParts = ['FSUM', 'EROS', 'E190'];
        $skuParts = ['EROS'];
        $skuPartsWeight = ['250', '500', '1000'];
        $skuPartsGrind = [
            '0' => 'ganze-bohne',
            '1' => 'aeropress',
            '2' => 'stempelkanne',
            '3' => 'karlsbader',
            '4' => 'ibric',
            '5' => 'siebtraeger',
            '6' => 'herdkaennchen',
            '7' => 'handfilter',
            '8' => 'filtermaschine'
        ];

        foreach ($skuParts as $skuPart) {
            $products = wc_get_products(['sku' => $skuPart]);
            if (count($products) !== 1) {
                throw new Exception('Product with SKU ' . $skuPart . ' not found.');
            }

            /** @var WC_Product_Variable $product */
            $product = $products[0];

            if (!$product->is_type('variable')) {
                throw new Exception('Product with SKU ' . $skuPart . ' is not variable.');
            }

            $variationIds = $product->get_children();

            // First delete all variations
            foreach ($variationIds as $variationId) {
                $variation = wc_get_product($variationId);
                $variation->delete(true);
            }

            // Then create new variations
            $newVariations = [];

            foreach ($skuPartsWeight as $skuPartWeight) {
                foreach ($skuPartsGrind as $skuPartGrind => $slug) {
                    $sku = $skuPartGrind.$skuPart.$skuPartWeight;
                    $newPrice = 6.50;

                    $variation = new WC_Product_Variation();
                    $variation->set_parent_id($product->get_id());
                    $variation->set_sku($sku);
                    $variation->set_attributes([
                        'pa_mahlgrad' => $slug,
                        'pa_gewicht' => $skuPartWeight . 'g',
                    ]);
                    $unit = $skuPartWeight / 1000;
                    $variation->set_weight($unit);

                    $gzd_product = wc_gzd_get_gzd_product($variation);
                    $gzd_product->get_wc_product()->set_regular_price($newPrice);
                    $gzd_product->set_unit_price_regular($newPrice);
                    $gzd_product->set_unit_price($newPrice);

                    $gzd_product->get_wc_product()->save();
                    $gzd_product->save();
                    $newVariations[] = $variation;
                }
            }

            $product->set_children($newVariations);
        }

        wp_send_json_success();
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
});
