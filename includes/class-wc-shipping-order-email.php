<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * A custom Shipping Order WooCommerce Email class,
 * filters delivery order items
 *
 * @since 0.1
 * @extends \WC_Email
 */
class WC_Shipping_Order_Email extends WC_Email_New_Order
{
    /**
     * Trigger the sending of this email.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function trigger( $order_id, $order = false ) {
        $this->setup_locale();

        if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
            $order = wc_get_order( $order_id );
        }

        if ( is_a( $order, 'WC_Order' ) ) {
            $this->object                         = $this->filterOrderItems($order);
            $this->placeholders['{order_date}']   = wc_format_datetime( $this->object->get_date_created() );
            $this->placeholders['{order_number}'] = $this->object->get_order_number();
        }

        if (sizeof($this->object->get_items()) > 0 && $this->is_enabled() && $this->get_recipient() ) {
            $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
        }

        $this->restore_locale();
    }

    /**
     * Remove delivery items from order
     *
     * @param WC_Order $order
     * @return WC_Order
     */
    private function filterOrderItems(WC_Order $order) {
        foreach ($order->get_items() as $item_id => $item) {
            if ($item->get_product()->get_shipping_class() === DELIVERY_SHIPPING_CLASS_SLUG) {
                $order->remove_item($item_id);
            }
        }

        return $order;
    }

}