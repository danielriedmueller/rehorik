<?php
if (!class_exists(Reh_Product_Feed::class)) {
    return;
}

class Reh_Product_Feed
{
    // Fields from plugin Germanized
    private const GERMANIZED_FIELDS = ['unit_amount', 'unit_regular_price', 'unit'];

    const CRON_HOOK = 'reh_product_feed';
    const DIR_NAME = 'reh-feed';

    protected static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        add_action(self::CRON_HOOK, [$this, 'updateFeed']);
    }

    /**
     * @throws Exception
     */
    public static function activate(): void
    {
        self::checkWritable();

        if (wp_next_scheduled(self::CRON_HOOK)) {
            throw new Exception('Product feed is already active');
        }

        add_action(self::CRON_HOOK, [self::class, 'updateFeed']);

        $error = wp_schedule_event(time(), 'hourly', self::CRON_HOOK, [], true);

        if ($error instanceof WP_Error) {
            throw new Exception($error->get_error_message());
        }
    }

    /**
     * @throws Exception
     */
    public static function deactivate(): void
    {
        $error = wp_clear_scheduled_hook(self::CRON_HOOK, [], true);

        if ($error instanceof WP_Error) {
            throw new Exception($error->get_error_message());
        }
    }

    public static function getFeedUrl(): string
    {
        $path = wp_upload_dir();
        $path = $path['baseurl'] . '/' . self::DIR_NAME . '/';

        return trailingslashit($path);
    }

    public static function getFeedPath(): string
    {
        $path = wp_upload_dir();
        $path = $path['basedir'] . '/' . self::DIR_NAME . '/';

        return trailingslashit($path);
    }

    /**
     * @throws Exception
     */
    private static function checkWritable(): void
    {
        $path = self::getFeedPath();

        if (!is_dir($path)) {
            if (!wp_mkdir_p($path)) {
                throw new Exception('Cannot create directory');
            }
        }

        if (!is_writable($path)) {
            throw new Exception($path . ' is not writable');
        }
    }

    public function updateFeed(): void
    {
        $args = [
            'limit' => -1,
            'virtual' => false,
            'status' => 'publish',
            'stock_status' => 'instock',
            'category' => ['kaffee', 'spirits', 'wein'],
        ];

        $this->updateFeedForAtalanda($args);
        $this->updateFeedForGoogleMerchant($args);
        $this->updateFeedForInstagram($args);
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

        $this->saveToCsv('atalanda-feed.csv', $products);
    }

    public function updateFeedForGoogleMerchant(array $args): void
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

        $this->saveToCsv('google-merchant-feed.csv', $products);
    }

    public function updateFeedForInstagram(array $args): void
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

        $this->saveToCsv('instagram-feed.csv', $products);
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
        $path = self::getFeedPath();
        self::checkWritable();

        $fp = fopen($path . $filename, 'w');

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
