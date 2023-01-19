<?php

class Reh_Api_Products
{
    // Fields from plugin Germanized
    const GERMANIZED_FIELDS = ['unit_amount', 'unit_regular_price'];

    /**
     * Fetches products and variations.
     */
    public function fetchProducts(WP_REST_Request $request): WP_REST_Response
    {
        $parameters = $request->get_params();

        $args = [
            'limit' => -1,
            'virtual' => $parameters['virtual'] ?? false,
            'status' => $parameters['status'] ?? 'publish'
        ];

        // Limit products query to specific category
        if (isset($parameters['category'])) {
            // TODO: check array a output parameter
            $term = get_term($parameters['category'], 'product_cat', ARRAY_A);
            if ($catSlug = $term['slug'] ?? null) {
                $args['category'] = $catSlug;
            }
        }

        $fields = isset($parameters['_fields'])
            ? explode(',', $parameters['_fields'])
            : array_merge(
                ['id', 'name', 'sku', 'stock_quantity', 'regular_price', 'category_ids'],
                self::GERMANIZED_FIELDS
            );

        return new WP_REST_Response(array_merge(
            $this->getSimpleProducts($args, $fields),
            $this->getVariableProducts($args, $fields),
        ));
    }

    /**
     * Updates stock and price of products and variations.
     * @throws Exception
     */
    public function updateProducts(WP_REST_Request $request): void
    {
        foreach (json_decode($request->get_body(), true) as $productData) {
            $product = wc_get_product($productData['id']);

            if ($product) {
                if (isset($productData['regular_price']) && is_numeric($productData['regular_price'])) {
                    $product->set_regular_price($productData['regular_price']);
                }

                if (isset($productData['stock_quantity']) && is_numeric($productData['stock_quantity'])) {
                    if (!$product->get_manage_stock()) {
                        $product->set_manage_stock(true);
                    }
                    $product->set_stock_quantity($productData['stock_quantity']);
                }

                // Set values for fields from plugin Germanized
                $gzdProduct = null;
                foreach (self::GERMANIZED_FIELDS as $germanizedField) {
                    if (isset($productData[$germanizedField]) && is_numeric($productData[$germanizedField])) {
                        $gzdProduct = $this->setGermanizedFieldValue($germanizedField, $productData[$germanizedField], $product);
                    }
                }

                if ($gzdProduct) {
                    $gzdProduct->get_wc_product()->save();
                    $gzdProduct->save();
                }

                $product->save();
            }
        }
    }

    private function getSimpleProducts(array $args, array $fields): array
    {
        $args['type'] = 'simple';

        return array_map(function (WC_Product_Simple $product) use ($fields) {
            $result = [];

            $data = $product->get_data();

            foreach ($fields as $field) {
                $result[$field] = in_array($field, self::GERMANIZED_FIELDS)
                    ? $this->getGermanizedFieldValue($field, $product)
                    : $data[$field];
            }

            return $result;
        }, wc_get_products($args));
    }

    private function getVariableProducts(array $args, array $fields): array
    {
        $args['type'] = 'variable';

        $variableProducts = wc_get_products($args);
        $products = [];
        foreach ($variableProducts as $variableProduct) {
            /** @var WC_Product_Variable $variableProduct */

            // Set categories for each variation
            $categories = [];
            if (array_search('category_ids', $fields, true)) {
                $categories = $variableProduct->get_category_ids();
            }

            foreach ($variableProduct->get_children() as $variationId) {
                $variation = wc_get_product($variationId);

                if (!$variation->exists()) {
                    continue;
                }

                $data = $variation->get_data();
                $variationData = [];
                foreach ($fields as $field) {
                    if ($field === 'category_ids') continue;

                    $variationData[$field] = in_array($field, self::GERMANIZED_FIELDS)
                        ? $this->getGermanizedFieldValue($field, $variation)
                        : $data[$field];
                }
                $variationData['category_ids'] = $categories;

                $products[] = $variationData;
            }
        }

        return $products;
    }

    /**
     * @throws Exception
     * @return mixed
     */
    private function getGermanizedFieldValue(string $field, WC_Product $product)
    {
        if (!is_plugin_active('woocommerce-germanized/woocommerce-germanized.php')) {
            throw new Exception('WooCommerce Plugin Germanized is not installed');
        }

        $gzdProduct = wc_gzd_get_gzd_product($product);
        $value = null;

        if ($gzdProduct) {
            // Unit amount field
            if ($field === self::GERMANIZED_FIELDS[0]) {
                $value = $gzdProduct->get_unit_product();
            }

            // Unit regular price field
            if ($field === self::GERMANIZED_FIELDS[1]) {
                $value = $gzdProduct->get_unit_price_regular();
            }
        }

        return $value;
    }

    /**
     * @throws Exception
     */
    private function setGermanizedFieldValue(string $field, $value, WC_Product $product): ?WC_GZD_Product
    {
        if (!is_plugin_active('woocommerce-germanized/woocommerce-germanized.php')) {
            throw new Exception('WooCommerce Plugin Germanized is not installed');
        }

        if ($gzdProduct = wc_gzd_get_gzd_product($product)) {
            // Unit amount field
            if ($field === self::GERMANIZED_FIELDS[0]) {
                $gzdProduct->set_unit_product($value);
            }

            // Unit regular price field
            if ($field === self::GERMANIZED_FIELDS[1]) {
                $gzdProduct->set_unit_price_regular($value);
            }

            return $gzdProduct;
        }

         return null;
    }
}
