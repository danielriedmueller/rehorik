<?php

class Reh_Api_Products
{
    public function fetchProducts(WP_REST_Request $request): WP_REST_Response
    {
        $parameters = $request->get_params();

        //http://localhost/wp-json/wc/v3/products?category=735&status=publish&_fields=sku%2Cstock_quantity%2Cregular_price%2Cmanage_stock%2Cvirtual%2Cstatus%2Ctype%2Cid%2Cname%2Ccategories&per_page=100
        $args = [
            'limit' => -1,
            'virtual' => $parameters['virtual'] ?? false,
            'status' => $parameters['status'] ?? 'publish',
        ];

        if (isset($parameters['category'])) {
            $args['category'] = $parameters['category'];
        }

        $fields = $parameters['_fields']
            ? explode(',', $parameters['_fields'])
            : ['name', 'sku', 'stock_quantity', 'regular_price'];

        return new WP_REST_Response(array_merge(
            $this->getSimpleProducts($args, $fields),
            $this->getVariableProducts($args, $fields),
        ));
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
            foreach ($variableProduct->get_available_variations() as $variation) {
                if ($variation instanceof WC_Product_Variation) {
                    $variation = $variation->get_data();
                }

                $variationData = [];
                foreach ($fields as $field) {
                    $variationData[$field] = $variation[$field];
                }

                $products[] = $variationData;
            }
        }

        return $products;
    }
}
