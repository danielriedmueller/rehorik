<?php
add_action('wp_ajax_create_coffees', function () {
    try {
        $skuParts = [
            'EDIA' => ['250', '500', '1000'],
            'EKEN' => ['250', '500', '1000'],
            'ESPA' => ['250', '500', '1000'],
            'ENUO' => ['250', '500', '1000'],
            'EPRS' => ['250', '500', '1000'],
            'E190' => ['250', '500', '1000'],
            'EROS' => ['250', '500', '1000'],
            'EARD' => ['250', '500', '1000'],
            'EPRI' => ['250', '500', '1000'],
            'ECAF' => ['250', '500', '1000'],
            'EVIC' => ['250', '500', '1000'],
            'EENT' => ['250', '500', '1000'],
            'EBER' => ['250', '500', '1000'],
            'EAMA' => ['250', '500', '1000'],
            'EWHA' => ['250', '500', '1000'],
            'FFES' => ['250', '500', '1000'],
            'CSCH' => ['250', '500', '1000'],
            'FREG' => ['250', '500', '1000'],
            'FSPE' => ['250', '500', '1000'],
            'FWEI' => ['250', '500', '1000'],
            'FPRE' => ['250', '500', '1000'],
            'FKAR' => ['250', '500', '1000'],
            'FWHA' => ['250', '500', '1000'],
            'FOST' => ['250', '500', '1000'],
            'FMOK' => ['250', '500', '1000'],
            'FPAS' => ['250', '500', '1000'],
            'FMON' => ['250', '500', '1000'],
            'FMAL' => ['250', '500', '1000'],
            'FHOR' => ['250', '500', '1000'],
            'FENT' => ['250', '500', '1000'],
            'FCAS' => ['250', '500', '1000'],
            'FVIC' => ['250', '500', '1000'],
            'FSUM' => ['250', '500', '1000'],
            'FSPA' => ['250', '500', '1000'],
            'FAMA' => ['250', '500', '1000'],
            'FRUB' => ['250'],
            'FJAV' => ['250'],
            'CAMA' => ['250', '500', '1000'],
        ];

        $skuPartsGrind = [
            '0' => 'ganze-bohne',
            '1' => 'ibric',
            '2' => 'siebtraeger-herdkaennchen',
            '4' => 'aeropress',
            '5' => 'filtermaschine-handfilter',
            '8' => 'stempelkanne',
            '13' => 'karlsbader-coldbrew',
        ];

        $message = '';

        foreach ($skuParts as $skuPart => $weights) {
            $products = wc_get_products(['sku' => $skuPart]);
            if (count($products) !== 1) {
                $message .= 'Product with SKU ' . $skuPart . ' not found. <br>';
                continue;
            }

            /** @var WC_Product_Variable $product */
            $product = $products[0];

            if (!$product->is_type('variable')) {
                $message .= 'Product with SKU ' . $skuPart . ' is not variable. <br>';
                continue;
            }

            $variationIds = $product->get_children();

            // First delete all variations
            foreach ($variationIds as $variationId) {
                $variation = wc_get_product($variationId);
                $variation->delete(true);
            }

            // Then create new variations
            $newVariations = [];

            foreach ($weights as $weight) {
                foreach ($skuPartsGrind as $skuPartGrind => $slug) {
                    $sku = $skuPartGrind . $skuPart . $weight;
                    $message .= $sku . ' created <br>';

                    $variation = new WC_Product_Variation();
                    $variation->set_parent_id($product->get_id());
                    $variation->set_sku($sku);
                    $variation->set_attributes([
                        'pa_mahlgrad' => $slug,
                        'pa_gewicht' => $weight . 'g',
                    ]);
                    $unit = $weight / 1000;
                    $variation->set_weight($unit);
                    $gzd_product = wc_gzd_get_gzd_product($variation);
                    $gzd_product->set_unit_product($unit);

                    $gzd_product->save();
                    $variation->save();
                    $newVariations[] = $variation;
                }
            }

            $product->set_children($newVariations);
        }

        wp_send_json_success(['message' => $message]);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
});
