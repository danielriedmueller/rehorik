<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

add_action(Reh_Product_Feed::CRON_HOOK, [Reh_Product_Feed::class, 'run_event']);

class Reh_Product_Feed
{
    // Fields from plugin Germanized
    private const GERMANIZED_FIELDS = ['unit_amount', 'unit_regular_price', 'unit'];

    const CRON_HOOK = 'reh_product_feed';
    const DIR_NAME = 'reh-feed';

    const SHIPPING_COST = '5.80';

    const GOOGLE_WINE_CATEGORY = [
        'id' => 421,
        'text' => 'Nahrungsmittel, Getränke & Tabak > Getränke > Alkoholische Getränke > Wein'
    ]; // has alcohol

    const GOOGLE_COFFEE_CATEGORY = [
        'id' => 1868,
        'text' => 'Nahrungsmittel, Getränke & Tabak > Getränke > Kaffee'
    ]; // has caffeine

    protected static $_instance = null;

    public static function instance(): self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function run_event(): void
    {
        self::instance()->updateFeed();
    }

    /**
     * @throws Exception
     */
    public static function schedule_event(): void
    {
        self::checkWritable();

        if (wp_next_scheduled(self::CRON_HOOK)) {
            throw new Exception('Product feed is already active');
        }

        $error = wp_schedule_event(time(), 'daily', self::CRON_HOOK, [], true);
        if ($error instanceof WP_Error) {
            throw new Exception($error->get_error_message());
        }
    }

    /**
     * @throws Exception
     */
    public static function clear_schedule(): void
    {
        $error = wp_clear_scheduled_hook(self::CRON_HOOK, [], true);

        if ($error instanceof WP_Error) {
            throw new Exception($error->get_error_message());
        }
    }

    public static function get_feed_url(): string
    {
        $path = wp_upload_dir();
        $path = $path['baseurl'] . '/' . self::DIR_NAME . '/';

        return trailingslashit($path);
    }

    public static function get_feed_path(): string
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
        $path = self::get_feed_path();

        if (!is_dir($path)) {
            if (!wp_mkdir_p($path)) {
                throw new Exception('Cannot create directory');
            }
        }

        if (!is_writable($path)) {
            throw new Exception($path . ' is not writable');
        }
    }

    /**
     * @throws Exception
     */
    public function updateFeed(): void
    {
        $args = [
            'limit' => -1,
            'virtual' => false,
            'status' => 'publish',
            'stock_status' => 'instock',
            'category' => [COFFEE_CATEGORY_SLUG, WINE_CATEGORY_SLUG],
        ];

        $fields = array_merge(
            [
                'id',
                'image',
                'description',
                'short_description',
                'name',
                'sku',
                'stock_quantity',
                'stock_status',
                'date_modified',
                'manage_stock',
                'regular_price',
                'category_ids',
                'parent_id'
            ],
            self::GERMANIZED_FIELDS
        );

        $products = $this->refineProducts($this->queryProducts($args, $fields));
        $products = $this->mapGoogleCategories($products);
        $products = $this->markAlcoholicProducts($products);

        $this->updateFeedForAtalanda($products);
        $this->updateFeedForGoogleMerchant($products);
        $this->updateFeedForInstagram($products);
    }

    private function refineProducts(array $products): array
    {
        foreach ($products as &$product) {
            if ($product['manage_stock'] === false && $product['stock_status'] === 'instock') {
                $product['stock_quantity'] = 1;
            }

            if (!empty($product['short_description'])) {
                $product['description'] = ucfirst($product['short_description']) . " " . $product['description'];
            }

            $product['description'] = htmlspecialchars(strip_tags($product['description']));
            $product['name'] = htmlspecialchars(strip_tags($product['name']));

            // Fix categories and add names
            if (!empty($product['category_ids'])) {
                $categoryIds = is_array($product['category_ids']) ? $product['category_ids'] : [$product['category_ids']];
                $product['category_names'] = $this->getCategoryNames($categoryIds);
            }
        }

        return $products;
    }

    private function mapGoogleCategories(array $products): array
    {
        foreach ($products as &$product) {
            if (!empty($product['category_ids']) && is_array($product['category_ids'])) {
                if ($googleCategory = $this->getGoogleCategory($product['category_ids'])) {
                    $product['google_category_id'] = $googleCategory['id'];
                    $product['google_category_name'] = htmlspecialchars(strip_tags($googleCategory['text']));
                }
            }
        }

        return $products;
    }

    private function markAlcoholicProducts(array $products): array
    {
        foreach ($products as &$product) {
            if (!empty($product['google_category_id'])) {
                if (self::GOOGLE_WINE_CATEGORY['id'] === $product['google_category_id']) {
                    $product['alcoholic'] = true;
                }
            }
        }

        return $products;
    }

    /**
     * @throws Exception
     */
    public function updateFeedForAtalanda(array $products): void
    {
        if (empty($products)) {
            return;
        }

        $path = self::get_feed_path();
        self::checkWritable();

        $googleNS = 'http://base.google.com/ns/1.0';
        $atalandaNS = 'http://api.atalanda.com/ns/gfeed';
        $xml = new SimpleXMLElement('<rss version="2.0" xmlns:atalanda="' . $atalandaNS . '" xmlns:g="' . $googleNS . '" />');
        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'Rehorik Onlineshop');
        $channel->addChild('link', 'https://rehorik.de');
        $channel->addChild('description', 'This is a product feed for Google Merchant from rehorik.de');

        foreach ($products as $product) {
            $child = $channel->addChild('item');
            $child->addChild('id', $product['id'], $googleNS);
            $child->addChild('title', $product['name']);
            $child->addChild('description', $this->wrapValueInCdata($product['description']));
            $child->addChild('link', get_permalink($product['id']));
            $child->addChild('image_link', $product['image'], $googleNS);
            $child->addChild('availability', $product['stock_quantity'] > 0 ? 'in stock' : 'out of stock', $googleNS);
            $child->addChild('price', $product['regular_price'] . ' EUR', $googleNS);
            $child->addChild('mpn', $product['sku']);
            $child->addChild('brand', 'Rehorik', $googleNS);
            $child->addChild('google_product_category', $this->wrapValueInCdata($product['google_category_name']), $googleNS);
            $child->addChild('product_type', $this->wrapValueInCdata($product['google_category_name']), $googleNS);
            $child->addChild('identifier_exists', 'FALSE', $googleNS);
            $child->addChild('tax_rate', '19', $atalandaNS);

            if (!empty($product['parent_id'])) {
                $child->addChild('item_group_id', $product['parent_id'], $googleNS);
                $child->addChild('size', $product['unit_amount'] . ' ' . $product['unit'], $googleNS);
            }

            if (!empty($product['unit_amount'] && !empty($product['unit']))) {
                $child->addChild('unit_pricing_measure', $product['unit_amount'] . ' ' . $product['unit'], $googleNS);
                $child->addChild('unit_pricing_base_measure', '1 ' . $product['unit'], $googleNS);
            }
        }

        file_put_contents($path . 'atalanda-feed.xml', $xml->asXML());
    }

    /**
     * @throws Exception
     */
    public function updateFeedForGoogleMerchant(array $products): void
    {
        if (empty($products)) {
            return;
        }

        $path = self::get_feed_path();
        self::checkWritable();

        $ns = 'http://base.google.com/ns/1.0';
        $xml = new SimpleXMLElement('<rss version="2.0" xmlns:g="' . $ns . '" />');
        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'Rehorik Onlineshop');
        $channel->addChild('link', 'https://rehorik.de');
        $channel->addChild('description', 'This is a product feed for Google Merchant from rehorik.de');

        foreach ($products as $product) {
            $child = $channel->addChild('item');
            $child->addChild('id', $product['id'], $ns);
            $child->addChild('title', $product['name'], $ns);
            $child->addChild('description', $this->wrapValueInCdata($product['description']), $ns);
            $child->addChild('link', get_permalink($product['id']), $ns);
            $child->addChild('image_link', $product['image'], $ns);
            $child->addChild('condition', 'new', $ns);
            $child->addChild('availability', $product['stock_quantity'] > 0 ? 'in stock' : 'out of stock', $ns);
            $child->addChild('price', $product['regular_price'] . ' EUR', $ns);
            $shipping = $child->addChild('shipping', null, $ns);
            $shipping->addChild('country', 'DE', $ns);
            $shipping->addChild('service', 'Standardversand', $ns);
            $shipping->addChild('price', self::SHIPPING_COST . ' EUR', $ns);
            $child->addChild('mpn', $product['sku'], $ns);
            $child->addChild('brand', 'Rehorik', $ns);
            $child->addChild('google_product_category', $product['google_category_id'], $ns);
            $child->addChild('product_type', $product['category_names'], $ns);
            $child->addChild('identifier_exists', 'ja', $ns);
            $tax = $child->addChild('tax', null, $ns);
            $tax->addChild('rate', 19, $ns);

            if (!empty($product['parent_id'])) {
                $child->addChild('item_group_id', $product['parent_id'], $ns);
                $child->addChild('size', $product['unit_amount'] . ' ' . $product['unit'], $ns);
            }

            if (!empty($product['unit_amount'] && !empty($product['unit']))) {
                $child->addChild('unit_pricing_measure', $product['unit_amount'] . ' ' . $product['unit'], $ns);
                $child->addChild('unit_pricing_base_measure', '1 ' . $product['unit'], $ns);
            }
        }

        file_put_contents($path . 'google-merchant-feed.xml', $xml->asXML());
    }

    /**
     * Only non alcoholic products are allowed
     *
     * @throws Exception
     */
    public function updateFeedForInstagram(array $products): void
    {
        $onlyNonAlcoholicProducts = array_filter($products, function ($product) {
            return !$product['alcoholic'];
        });

        $productsWithVariants = array_filter($onlyNonAlcoholicProducts, function ($product) {
            return !empty($product['parent_id']);
        });

        $productsWithoutVariants = array_filter($onlyNonAlcoholicProducts, function ($product) {
            return empty($product['parent_id']);
        });

        $this->createInstagramFeedWithVariants($productsWithVariants);
        $this->createInstagramFeedWithoutVariants($productsWithoutVariants);
    }

    /**
     * @throws Exception
     */
    private function createInstagramFeedWithVariants(array $products): void
    {
        if (empty($products)) {
            return;
        }

        $path = self::get_feed_path();
        self::checkWritable();
        $path .= 'facebook-shopping-variants-feed.csv';

        $fp = fopen($path, 'w');

        $header = [
            'id',
            'title',
            'availability',
            'condition',
            'description',
            'image_link',
            'link',
            'price',
            'brand',
            'google_product_category',
            'size',
            'shipping',
            'item_group_id',
        ];

        fputcsv($fp, $header);

        $csvProducts = [];
        foreach ($products as $product) {
            $csvProduct = [];
            $csvProduct['id'] = $product['id'];
            $csvProduct['title'] = $product['name'];
            $csvProduct['availability'] = $product['stock_quantity'] > 0 ? 'in stock' : 'out of stock';
            $csvProduct['condition'] = 'new';
            $csvProduct['description'] = $product['description'];
            $csvProduct['image_link'] = $product['image'];
            $csvProduct['link'] = get_permalink($product['id']);
            $csvProduct['price'] = $product['regular_price'] . ' EUR';
            $csvProduct['brand'] = $product['sku'];
            $csvProduct['google_product_category'] = $product['google_category_id'];
            $csvProduct['size'] = $product['unit_amount'] . ' ' . $product['unit'];
            $csvProduct['shipping'] = 'DE::Ground:' . self::SHIPPING_COST . ' EUR';

            if (empty($product['parent_id'])) {
                throw new Exception('Product without variants should not be in this feed');
            }
            $csvProduct['item_group_id'] = $product['parent_id'];

            $csvProducts[] = $csvProduct;
        }

        foreach ($csvProducts as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    private function createInstagramFeedWithoutVariants(array $products): void
    {
        if (empty($products)) {
            return;
        }

        $path = self::get_feed_path();
        self::checkWritable();
        $path .= 'facebook-shopping-feed.csv';

        $fp = fopen($path, 'w');

        $header = [
            'id',
            'title',
            'availability',
            'condition',
            'description',
            'image_link',
            'link',
            'price',
            'brand',
            'google_product_category',
            'size',
            'shipping'
        ];

        fputcsv($fp, $header);

        $csvProducts = [];
        foreach ($products as $product) {
            $csvProduct = [];
            $csvProduct['id'] = $product['id'];
            $csvProduct['title'] = $product['name'];
            $csvProduct['availability'] = $product['stock_quantity'] > 0 ? 'in stock' : 'out of stock';
            $csvProduct['condition'] = 'new';
            $csvProduct['description'] = $product['description'];
            $csvProduct['image_link'] = $product['image'];
            $csvProduct['link'] = get_permalink($product['id']);
            $csvProduct['price'] = $product['regular_price'] . ' EUR';
            $csvProduct['brand'] = $product['sku'];
            $csvProduct['google_product_category'] = $product['google_category_id'];
            $csvProduct['size'] = $product['unit_amount'] . ' ' . $product['unit'];
            $csvProduct['shipping'] = 'DE::Ground:' . self::SHIPPING_COST . ' EUR';
            $csvProducts[] = $csvProduct;
        }

        foreach ($csvProducts as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    private function queryProducts($args, $fields): array
    {
        return array_merge(
            $this->getSimpleProducts($args, $fields),
            $this->getVariableProducts($args, $fields)
        );
    }

    private function getSimpleProducts(array $args, array $fields): array
    {
        $args['type'] = 'simple';

        return array_map(function (WC_Product_Simple $product) use ($fields) {
            $result = [];
            $data = $product->get_data();

            foreach ($fields as $field) {
                if (in_array($field, self::GERMANIZED_FIELDS)) {
                    $result[$field] = $this->getGermanizedFieldValue($field, $product);
                } elseif ($field === 'image') {
                    $image = wp_get_attachment_image_src($product->get_image_id(), 'full');
                    $result['image'] = $image[0] ?? null;
                } else {
                    $result[$field] = $data[$field];
                }
            }

            return $result;
        }, wc_get_products($args));
    }

    private function getVariableProducts(array $args, array $fields): array
    {
        $products = [];

        $args['type'] = 'variable';
        $variableProducts = wc_get_products($args);

        foreach ($variableProducts as $variableProduct) {
            if (isItCategory($variableProduct, COFFEE_CATEGORY_SLUG)) {
                $data = $this->getCoffeeProductData($variableProduct, $fields);
            } else {
                $data = $this->getVariableProductData($variableProduct, $fields);
            }

            $products = array_merge($products, $data);
        }

        return $products;
    }

    private function getVariableProductData(WC_Product_Variable $variableProduct, array $fields): array
    {
        $parentId = $variableProduct->get_id();
        $parentDescription = $variableProduct->get_description();
        $parentShortDescription = $variableProduct->get_short_description();
        $parentCategories = $variableProduct->get_category_ids();

        $products = [];

        foreach ($variableProduct->get_children() as $variationId) {
            $variation = wc_get_product($variationId);

            if (!$variation->exists()) {
                continue;
            }

            $data = $variation->get_data();
            $variationData = [];

            foreach ($fields as $field) {
                if (in_array($field, self::GERMANIZED_FIELDS)) {
                    $variationData[$field] = $this->getGermanizedFieldValue($field, $variation);
                } elseif ($field === 'image') {
                    $image = wp_get_attachment_image_src($variation->get_image_id(), 'full');
                    $variationData[$field] = $image[0] ?? null;
                } elseif ($field === 'description') {
                    $variationData[$field] = $parentDescription;
                } elseif ($field === 'short_description') {
                    $variationData[$field] = $parentShortDescription;
                } elseif ($field === 'category_ids') {
                    $variationData[$field] = $parentCategories;
                } elseif ($field === 'parent_id') {
                    $variationData[$field] = $parentId;
                } else {
                    $variationData[$field] = $data[$field];
                }
            }

            $products[] = $variationData;
        }

        return $products;
    }

    private function getCoffeeProductData(WC_Product_Variable $variableProduct, array $fields): array
    {
        $parentId = $variableProduct->get_id();
        $parentDescription = $variableProduct->get_description();
        $parentShortDescription = $variableProduct->get_short_description();
        $parentCategories = $variableProduct->get_category_ids();
        $parentName = $variableProduct->get_name();

        $products = [];

        foreach ($variableProduct->get_children() as $variationId) {
            $variation = wc_get_product($variationId);

            if (!$variation->exists()) {
                continue;
            }

            $data = $variation->get_data();
            $variationData = [];

            foreach ($fields as $field) {
                if (in_array($field, self::GERMANIZED_FIELDS)) {
                    $variationData[$field] = $this->getGermanizedFieldValue($field, $variation);
                } elseif ($field === 'image') {
                    $image = wp_get_attachment_image_src($variation->get_image_id(), 'full');
                    $variationData[$field] = $image[0] ?? null;
                } elseif ($field === 'description') {
                    $variationData[$field] = $parentDescription;
                } elseif ($field === 'short_description') {
                    $variationData[$field] = $parentShortDescription;
                } elseif ($field === 'parent_id') {
                    $variationData[$field] = $parentId;
                } elseif ($field === 'category_ids') {
                    $variationData[$field] = $parentCategories;
                } elseif ($field === 'name') {
                    // Use parent title
                    $variationData[$field] = $parentName;
                } else {
                    $variationData[$field] = $data[$field];
                }
            }

            $products[] = $variationData;
        }

        // Create two versions of one product with different Mahlgraden
        $ganzeBohnen = [];
        $gemahlen = [];
        foreach ($products as $product) {
            $ganzeBohne = $product;

            $product['name'] .= ' - gemahlen';
            $product['id'] .= 'gemahlen';
            $product['parent_id'] .= 'gemahlen';

            $ganzeBohne['name'] .= ' - ganze Bohne';
            $ganzeBohne['id'] .= 'ganzebohne';
            $ganzeBohne['parent_id'] .= 'ganzebohne';

            $ganzeBohnen[] = $ganzeBohne;
            $gemahlen[] = $product;
        }

        return array_merge($ganzeBohnen, $gemahlen);
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

    /**
     * Maps the WooCommerce product category to the Google product category.
     * https://www.google.com/basepages/producttype/taxonomy-with-ids.de-DE.txt
     */
    private function getGoogleCategory(array $categoryIds): ?array
    {
        if (empty($categoryIds)) {
            return null;
        }

        $googleProductCategoriesMapping = [
            WINE_CATEGORY_SLUG => self::GOOGLE_WINE_CATEGORY,
            COFFEE_CATEGORY_SLUG => self::GOOGLE_COFFEE_CATEGORY
        ];

        if ($this->isCategory($categoryIds, WINE_CATEGORY_SLUG)) {
            return $googleProductCategoriesMapping[WINE_CATEGORY_SLUG];
        }

        if ($this->isCategory($categoryIds, COFFEE_CATEGORY_SLUG)) {
            return $googleProductCategoriesMapping[COFFEE_CATEGORY_SLUG];
        }

        return null;
    }

    private function getCategoryNames(array $categoryIds): string
    {
        $categoryNames = [];

        foreach ($categoryIds as $categoryId) {
            $category = get_term_by('id', $categoryId, 'product_cat');

            if ($category) {
                $categoryNames[] = $category->name;
            }
        }

        return implode(' > ', $categoryNames);
    }

    /**
     * Checks if product belongs to category
     *
     * @param int[] $categoryIds
     * @param string $category // category slug
     */
    private function isCategory(array $categoryIds, string $category): bool
    {
        $taxonomy = 'product_cat';
        $seperator = ";";
        $allCategories = [];

        foreach ($categoryIds as $category_id) {
            $term = get_term($category_id, $taxonomy);
            $allCategories[] = $term->slug;
            $parents = get_term_parents_list($category_id, $taxonomy, [
                'format' => 'slug',
                'separator' => $seperator,
                'link' => false,
                'inclusive' => false
            ]);
            $allCategories = array_merge($allCategories, explode($seperator, $parents));
        }

        return in_array($category, $allCategories);
    }

    // TODO: Try without CDATA
    private function wrapValueInCdata(string $value): string
    {
        //return sprintf('<![CDATA[%s]]>', $value);

        return $value;
    }
}
