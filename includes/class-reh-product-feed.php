<?php

class Reh_Product_Feed
{
    // Fields from plugin Germanized
    const GERMANIZED_FIELDS = ['unit_amount', 'unit_regular_price', 'unit'];

    const CRON_HOOK = 'reh_product_feed';

    protected static $_instance = null;

    public function __construct()
    {
        /**
         * $this->loader->add_action( 'admin_init', $plugin_admin, 'register_weekly_cron');
         * $this->loader->add_action('rex_feed_weekly_update', $plugin_admin, 'activate_weekly_update');

        $this->define_admin_hooks();
         if( ! wp_next_scheduled( 'rex_feed_weekly_update' ) ) {
        wp_schedule_event( time(), 'weekly', 'rex_feed_weekly_update' );
         $error = wp_schedule_event(time(), 'daily', 'reh_feed_daily', true);
        }
         **/
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function reh_feed()
    {
        $productIds = [14018, 1313, 28571, 29236, 18738];

        $args = [
            'limit' => -1,
            'virtual' => false,
            'status' => 'publish',
            'include' => $productIds
        ];

        $this->updateFeedForAtalanda($args);
    }

    public function deactivate_feed(): void
    {
        wp_clear_scheduled_hook(self::CRON_HOOK);
    }

    public function updateFeedForAtalanda(array $args): void
    {
        $fields = array_merge(
            [
                'id',
                'image',
                'description',
                'short_description',
                'name',
                'sku',
                'stock_quantity',
                'regular_price'
            ],
            self::GERMANIZED_FIELDS
        );

        $products = $this->queryProducts($args, $fields);

        $this->saveToCsv('reh-atalanda-feed.csv', $products);
    }

    private function queryProducts($args, $fields): array
    {
        return array_merge(
            $this->getSimpleProducts($args, $fields),
            $this->getVariableProducts($args, $fields)
        );
    }

    /**
     * @throws Exception
     */
    private function saveToCsv(string $filename, array $products): void
    {
        $path = wp_upload_dir();
        $path = $path['basedir'] . '/reh-feed/';

        if (!is_dir($path)) {
            if (!wp_mkdir_p($path)) {
                throw new Exception('Cannot create directory');
            }
        }

        $path = trailingslashit($path) . $filename;

        if (!is_writable($path)) {
            throw new Exception($path . ' is not writable');
        }

        $fp = fopen($path, 'w');

        foreach ($products as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    private function getSimpleProducts(array $args, array $fields): array
    {
        $args['type'] = 'simple';

        return array_map(function (WC_Product_Simple $product) use ($fields) {
            $result = [];

            foreach ($fields as $field) {
                if (in_array($field, self::GERMANIZED_FIELDS)) {
                    $result[$field] = $this->getGermanizedFieldValue($field, $product);
                } elseif ($field === 'image') {
                    $image = wp_get_attachment_image_src($product->get_image_id(), 'full');
                    $result['image'] = $image[0] ?? null;
                } else {
                    $result[$field] = $product->get_data()[$field];
                }
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
            foreach ($variableProduct->get_children() as $variationId) {
                $variation = wc_get_product($variationId);

                if (!$variation->exists()) {
                    continue;
                }

                $variationData = [];
                foreach ($fields as $field) {
                    if (in_array($field, self::GERMANIZED_FIELDS)) {
                        $variationData[$field] = $this->getGermanizedFieldValue($field, $variation);
                    } elseif ($field === 'image') {
                        $image = wp_get_attachment_image_src($variation->get_image_id(), 'full');
                        $variationData[$field] = $image[0] ?? null;
                    } elseif ($field === 'description') {
                        $variationData[$field] = $variableProduct->get_description();
                    } elseif ($field === 'short_description') {
                        $variationData[$field] = $variableProduct->get_short_description();
                    } else {
                        $variationData[$field] = $variation->get_data()[$field];
                    }
                }

                $products[] = $variationData;
            }
        }

        return $products;
    }

    /**
     * @return mixed
     * @throws Exception
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

            // Unit
            if ($field === self::GERMANIZED_FIELDS[2]) {
                $value = $gzdProduct->get_unit();
            }
        }

        return $value;
    }
}
