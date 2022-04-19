<?php

class WC_Shipping_Bike extends WC_Shipping_Method
{
    /**
     * Constructor. The instance ID is passed to this.
     */
    public function __construct($instance_id = 0)
    {
        $this->id = 'bike';
        $this->instance_id = absint($instance_id);
        $this->method_title = 'Bikekurier';
        $this->method_description = 'Versand als Lieferservice mit dem Fahrrad';
        $this->supports = array(
            'shipping-zones',
            'instance-settings',
            'instance-settings-modal',
        );
        $this->instance_form_fields = array(
            'title' => array(
                'title' => 'Bikekurier',
                'type' => 'text',
                'description' => 'Bikekurier',
                'default' => 'Bikekurier',
                'desc_tip' => true
            ),
            'tax_status' => array(
                'title' => __('Tax status', 'woocommerce'),
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'default' => 'taxable',
                'options' => array(
                    'taxable' => __('Taxable', 'woocommerce'),
                    'none' => _x('None', 'Tax status', 'woocommerce'),
                ),
            ),
            'cost' => array(
                'title' => 'Kosten',
                'type' => 'text',
                'placeholder' => '',
                'description' => '',
                'default' => '5.8',
                'desc_tip' => false
            )
        );
        $this->enabled = $this->get_option('enabled');
        $this->tax_status = $this->get_option('tax_status');
        $this->title = $this->get_option('title');

        add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
    }

    /**
     * calculate_shipping function.
     * @param array $package (default: array())
     */
    public function calculate_shipping($package = array())
    {
        $this->add_rate(array(
            'id' => $this->id . $this->instance_id,
            'label' => $this->title,
            'cost' => $this->get_option('cost'),
        ));
    }
}