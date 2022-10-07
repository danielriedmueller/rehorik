<?php

class Reh_Api_Products
{
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
            $term = get_term($parameters['category'], 'product_cat', ARRAY_A);
            if ($catSlug = $term['slug'] ?? null) {
                $args['category'] = $catSlug;
            }
        }

        $fields = isset($parameters['_fields'])
            ? explode(',', $parameters['_fields'])
            : ['id', 'name', 'sku', 'stock_quantity', 'regular_price', 'category_ids'];

        return new WP_REST_Response(array_merge(
            $this->getSimpleProducts($args, $fields),
            $this->getVariableProducts($args, $fields),
        ));
    }

    /**
     * Updates stock and price of products and variations.
     */
    public function updateProducts(WP_REST_Request $request): void
    {
        foreach (json_decode($request->get_body(), true) as $productData) {
            $product = wc_get_product($productData['id']);
            $product->set_manage_stock(true);
            $product->set_regular_price($productData['regular_price']);
            $product->set_stock_quantity($productData['stock_quantity']);
            $product->save();
        }
    }

    private function getSimpleProducts(array $args, array $fields): array
    {
        $args['type'] = 'simple';

        return array_map(function (WC_Product_Simple $product) use ($fields) {
            $result = [];
            foreach ($fields as $field) {
                $result[$field] = $product->get_data()[$field];
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

                $variationData = [];
                foreach ($fields as $field) {
                    if ($field === 'category_ids') continue;

                    $variationData[$field] = $variation->get_data()[$field];
                }
                $variationData['category_ids'] = $categories;

                $products[] = $variationData;
            }
        }

        return $products;
    }
}
