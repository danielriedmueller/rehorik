<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (!is_plugin_active('woocommerce/woocommerce.php')) {
    throw new Exception('WooCommerce is not installed');
}

require_once('model/model-reh-mini-cart-item.php');

use model\Reh_Mini_Cart_Item;

class Reh_Mini_Cart
{
    public static function getCurrentUserId(): ?int
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
    public static function getReorderItems(?int $userId): array
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
