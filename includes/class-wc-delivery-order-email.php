<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * A custom Delivery Order WooCommerce Email class
 *
 * @since 0.1
 * @extends \WC_Email
 */
class WC_Delivery_Order_Email extends WC_Email_New_Order
{
    /**
     * Set email defaults
     *
     * @since 0.1
     */
    public function __construct() {
        parent::__construct();

        // set ID, this simply needs to be a unique name
        $this->id = 'wc_delivery_order';

        // this is the title in WooCommerce Email settings
        $this->title = 'Lieferservicebestellung';

        // this is the description in WooCommerce email settings
        $this->description = 'Lieferservice Email wird gesendet, wenn ein Nutzer ein Produkt als Lieferung bestellt hat.';

        // these are the default heading and subject lines that can be overridden using the settings
        $this->heading = 'Lieferservicebestellung';
        $this->subject = 'Lieferservicebestellung';
    }

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
     * Remove non-delivery items from order
     *
     * @param WC_Order $order
     * @return WC_Order
     */
    private function filterOrderItems(WC_Order $order) {
        foreach ($order->get_items() as $item_id => $item) {
            $isDelivery = $item->get_meta(DELIVERY_ATTRIBUTE_SLUG);
            if (!$isDelivery) {
                $order->remove_item($item_id);
            }
        }

        return $order;
    }

    /**
     * Get email subject.
     *
     * @since  3.1.0
     * @return string
     */
    public function get_default_subject() {
        return __( '[{site_title}]: New order #{order_number}', 'woocommerce' );
    }

    /**
     * Get email heading.
     *
     * @since  3.1.0
     * @return string
     */
    public function get_default_heading() {
        return __( 'New Order: #{order_number}', 'woocommerce' );
    }
}