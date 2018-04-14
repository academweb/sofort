<?php
//HEADER

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Generates requests to send to Sofortueberweisung
 */
class WC_Gateway_Micropayment_Sofortueberweisung_Request extends Micropayment_Request
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->notify_url = WC()->api_request_url('WC_Gateway_Sofortueberweisung');
    }

    /**
     * Get the Sofortueberweisung request URL for an order
     *
     * @param  WC_Order $order
     *
     * @return string
     */
    public function get_request_url($order)
    {

        $sett = get_option('woocommerce_micropayment-sofortueberweisung_settings');
       
   
        // $sofortueberweisung_args = http_build_query($this->get_args($order), '', '&');
        $sofortueberweisung_args = http_build_query($sett, '', '&');
   
        $seal  = md5($sofortueberweisung_args . Micropayment_WC_Settings::getInstance()->getAccesskey());
            
          
         
            $link = 'https://directbanking.micropayment.' . Micropayment_WC_Settings::getInstance()->getUrlSuffix() .'/sofort/event/?' . $sofortueberweisung_args . '&seal=' . $seal . '&order=' . $order->id;

        return    $link;

    }
}