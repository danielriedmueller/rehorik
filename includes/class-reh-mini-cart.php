<?php
require_once('model/model-reh-mini-cart-item.php');

use model\Reh_Mini_Cart_Item;

class Reh_Mini_Cart
{
    protected static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @throws Exception
     */
    public function __construct() {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            throw new Exception('WooCommerce is not installed');
        }

        $this->init();
    }

    public function init() {
        $addToCartNonce = wp_create_nonce( 'rehorik-add-to-cart' );
        $updateCartNonce = wp_create_nonce( 'rehorik-update-cart' );

        add_action('wp_enqueue_scripts', function () use ($addToCartNonce, $updateCartNonce) {
            $assetsDir = get_stylesheet_directory_uri() . '/assets/';
            wp_enqueue_script('cart-ajax', $assetsDir . 'js/cart_ajax.js', ['jquery'], 1, true);
            wp_localize_script( 'cart-ajax', 'settings', [
                'ajax_url' => admin_url( 'admin-ajax.php'),
                'add_nonce' => $addToCartNonce,
                'update_nonce' => $updateCartNonce,
            ]);
        });
    }

    public function getCurrentUserId(): ?int
    {
        $currentCustomerId = get_current_user_id();

        if ($currentCustomerId === 0) {
            return null;
        }

        return $currentCustomerId;
    }

    /**
     * @return Reh_Mini_Cart_Item[]
     */
    public function getReorderItems(?int $userId): array
    {
        $limit = 3;

        $args = ['limit' => $limit];
        if ($userId) {
            $args['customer_id'] = $userId;
        }
        $customerOrders = wc_get_orders($args);

        $items = [];
        foreach ($customerOrders as $customerOrder) {
            foreach (wc_get_order($customerOrder)->get_items() as $orderItem) {
                if ($miniCartItem = Reh_Mini_Cart_Item::createFromWcOrderItem($orderItem)) {
                    foreach ($items as $item) {
                        if ($miniCartItem->isSame($item)) {
                            continue 2;
                        }
                    }

                    $items[] = $miniCartItem;
                }
            }
        }

        return $items;
    }
}
