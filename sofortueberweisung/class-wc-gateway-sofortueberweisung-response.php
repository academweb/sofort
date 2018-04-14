<?php
//HEADER

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Class WC_Gateway_Sofortueberweisung_Responce
 */
class WC_Gateway_Sofortueberweisung_Response extends Micropayment_Response
{

    /**
     * @return bool
     */
    static function payment_complete()
    {

        $secretfield = Micropayment_WC_Settings::getInstance()->getSecretfield();

        if (isset($_GET) && !empty($_GET) && is_array($_GET)) {

            if (isset($_GET['secretfield']) && !empty($_GET['secretfield']) && $secretfield == $_GET['secretfield']) {

                $order = wc_get_order($_GET['order']);

                if (isset($order) && is_object($order)) {
                    return self::_get_function_parameter($order, 'Sofortueberweisung');
                } else {
                    return "status=error\nmessage=no_order";
                }
            } else {
                return "status=error\nmessage=security_issue";
            }
        } else {
            return "status=error\nmessage=no_parameters";
        }

    }
}