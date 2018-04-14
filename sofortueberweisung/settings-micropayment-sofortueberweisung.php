<?php
//HEADER

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Settings for Sofortueberweisung Gateway
 */
return apply_filters(
    'wc_micropayment_settings_sofort',
    array(
        'enabled'      => array(
            'title'   => __('SOFORT aktivieren', WC_Micropayment::$transcription_domain),
            'label'   => __('&nbsp;', WC_Micropayment::$transcription_domain),
            'type'    => 'checkbox',
            'default' => 'no',
        ),
        'testmode'      => array(
            'title'   => __('Test mode', WC_Micropayment::$transcription_domain),
            'label'   => __('&nbsp;', WC_Micropayment::$transcription_domain),
            'type'    => 'checkbox',
            'default' => 'no',
        ),
        'title'        => array(
            'title'    => __('Titel', WC_Micropayment::$transcription_domain),
            'type'     => 'text',
            'default'  => __('SOFORT-Überweisung', WC_Micropayment::$transcription_domain),
        ),
        'description'  => array(
            'title'    => __('Description', WC_Micropayment::$transcription_domain),
            'type'     => 'textarea',
            'default'  => __(
                'Bitte halten Sie im nächsten Schritt Ihre Onlinebanking Daten bereit.',
                WC_Micropayment::$transcription_domain
            ),
            'css'      => 'max-width:350px;'
        ),
         'account'  => array(
            'title'    => __('Account', WC_Micropayment::$transcription_domain),
            'type'     => 'text',
            'default'  => __(
                '',
                WC_Micropayment::$transcription_domain
            ),
            
        ),
        'project'  => array(
            'title'    => __('Project', WC_Micropayment::$transcription_domain),
            'type'     => 'text',
            'default'  => __(
                '',
                WC_Micropayment::$transcription_domain
            ),
            
        ),
        'accesskey'  => array(
            'title'    => __('AccessKey', WC_Micropayment::$transcription_domain),
            'type'     => 'text',
            'default'  => __(
                '',
                WC_Micropayment::$transcription_domain
            ),
            
        )
    )
);
