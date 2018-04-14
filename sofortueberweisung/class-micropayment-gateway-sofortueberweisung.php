<?php
//HEADER

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Class WC_Gateway_Sofortueberweisung
 *
 * @extends WC_Payment_Gateway
 */
class WC_Gateway_Micropayment_Sofortueberweisung extends WC_Payment_Gateway
{

    /**
     * Constructor
     */
    function __construct()
    {

        // The global ID for this Payment method
        $this->id = "micropayment-sofortueberweisung";

        // The Title shown on the top of the Payment Gateways Page next to all the other Payment Gateways
        $this->method_title = __("Micropayment SOFORT-Überweisung", 'woocommerce-micropayment');

        // The description for this Payment Gateway, shown on the actual Payment options page on the backend
        $this->method_description =
            __(
                "Direkte Onlinebezahlung durch PIN / TAN Eingabe.",
                'woocommerce-micropayment'
            );

        // The title to be used for the vertical tabs that can be ordered top to bottom
        $this->title = __("Micropayment SOFORT-Überweisung", 'woocommerce-micropayment');

        // If you want to show an image next to the gateway's name on the frontend, enter a URL to an image.
        $this->icon =
            (WC_Admin_Settings::get_option(
                    'wc_settings_tab_micropayment_deactivate_logos'
                ) === WC_MICRO_PAYMENT_CHECKBOX_NO) ? false
                : WC_MP_PLUGIN_URL . '/assets/images/sofortueberweisung.png';

        // Bool. Can be set to true if you want payment fields to show on the checkout
        // if doing a direct integration, which we are doing in this case
        $this->has_fields = false;

        // Supports the default credit card form
        //$this->supports = array( 'default_credit_card_form' );

        // This basically defines your settings which are then loaded with init_settings()
        $this->init_form_fields();

        // After init_settings() is called, you can get the settings and load them into variables, e.g:
        // $this->title = $this->get_option( 'title' );
        $this->init_settings();

        // Turn these settings into variables we can use
        foreach ($this->settings as $setting_key => $value) {
            $this->$setting_key = $value;
        }

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
    }

    /**
     * Initialise Gateway Settings Form Fields
     */
    public function init_form_fields()
    {
        $this->form_fields =
            include(WC_MP_PLUGIN_PATH . '/includes/gateways/sofortueberweisung/settings-micropayment-sofortueberweisung.php');
    }

    /**
     * Process the payment and return the result
     *
     * @param int $order_id
     *
     * @return array
     */
    public function process_payment($order_id)
    {

        include_once(WC_MP_PLUGIN_PATH . '/includes/gateways/sofortueberweisung/class-micropayment-gateway-sofortueberweisung-request.php');

        $order = wc_get_order($order_id);

        // Mark as on-hold (we're awaiting the payment)
        $order->update_status('pending', __('Micropayment Sofortueberweisung', 'woocommerce-micropayment'));

        $sofortueberweisung_request = new WC_Gateway_Micropayment_Sofortueberweisung_Request();

        // Reduce stock levels
        $order->reduce_order_stock();
        
        //echo '<pre>'; print_r($order); echo '</pre>';
        //wp_die();
        $order->update_status('pending');
        // Remove cart

        WC()->cart->empty_cart();

        return array(
            'result'   => 'success',
            'redirect' => $sofortueberweisung_request->get_request_url($order)
        );
    }

    /**
     * @return string
     */
    public function get_icon()
    {
        if (!$this->icon) {
            return apply_filters('woocommerce_gateway_icon', '', $this->id);
        }
        $icons = sprintf(
            '<img class="micropayment__icon" src="%s" alt="%s" title="%s"/>',
            $this->icon,
            $this->title,
            $this->title
        );

        return apply_filters('woocommerce_gateway_icon', $icons, $this->id);
    }
}