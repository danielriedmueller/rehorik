<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * A custom Delivery Order WooCommerce Email class
 *
 * @since 0.1
 * @extends \WC_Email
 */
class WC_Delivery_Order_Email extends WC_Email
{
    /**
     * Set email defaults
     *
     * @since 0.1
     */
    public function __construct() {

        // set ID, this simply needs to be a unique name
        $this->id = 'wc_delivery_order';

        // this is the title in WooCommerce Email settings
        $this->title = 'Lieferservicebestellung';

        // this is the description in WooCommerce email settings
        $this->description = 'Lieferservice Email wird gesendet, wenn ein Nutzer ein Produkt geliefert bekommen möchte.';

        // these are the default heading and subject lines that can be overridden using the settings
        $this->heading = 'Lieferservicebestellung';
        $this->subject = 'Lieferservicebestellung';

        // these define the locations of the templates that this email should use, we'll just use the new order template since this email is similar
        $this->template_html  = 'emails/admin-new-order.php';
        $this->template_plain = 'emails/plain/admin-new-order.php';

        // Trigger on new paid orders
        add_action( 'woocommerce_order_status_pending_to_processing_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_pending_to_completed_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_failed_to_processing_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_failed_to_completed_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_failed_to_on-hold_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_cancelled_to_processing_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_cancelled_to_completed_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_cancelled_to_on-hold_notification', array( $this, 'trigger' ), 10, 2 );
        // Call parent constructor to load any other defaults not explicity defined here
        parent::__construct();

        $this->recipient = DELIVERY_ORDER_EMAIL;
    }

    /**
     * Determine if the email should actually be sent and setup email merge variables
     *
     * @since 0.1
     * @param int $order_id
     */
    public function trigger( $order_id ) {
        if (!$order_id) {
            return;
        }

        $this->object = new WC_Order( $order_id );
        $items = $this->object->get_items();


        // bail if shipping method is not expedited
        if ( ! in_array( $this->object->get_shipping_method(), array( 'Three Day Shipping', 'Next Day Shipping' ) ) )
            return;

        // replace variables in the subject/headings
        $this->find[] = '{order_date}';
        $this->replace[] = date_i18n( woocommerce_date_format(), strtotime( $this->object->order_date ) );

        $this->find[] = '{order_number}';
        $this->replace[] = $this->object->get_order_number();

        if ( ! $this->is_enabled() || ! $this->get_recipient() )
            return;

        // woohoo, send the email!
        $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
    }
}