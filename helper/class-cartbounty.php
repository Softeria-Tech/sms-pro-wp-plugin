<?php
/**
 * Cartbounty helper.
 *
 * PHP version 5
 *
 * @category Handler
 * @package  SMSPro
 * @author   SMS Pro <support@softeriatech.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://sms.softeriatech.com/
 */
if (! defined('ABSPATH') ) {
    exit;
}
if (! is_plugin_active('woo-save-abandoned-carts/cartbounty-abandoned-carts.php') && ! is_plugin_active('woo-save-abandoned-carts-pro/cartbounty-pro-abandoned-carts.php') ) {
    return;
}
/**
 * PHP version 5
 *
 * @category Handler
 * @package  SMSPro
 * @author   SMS Pro <support@softeriatech.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://sms.softeriatech.com/
 * WCAbandonedCart class
 */
class WCAbandonedCart
{
    /**
     * Construct function.
     */
    public function __construct()
    {
        add_filter('sAlertDefaultSettings', __CLASS__ . '::add_default_setting', 1);
        add_action('cartbounty_notification_sendout_hook', array( $this, 'smsproSendSms' ), 1);
        add_action('cartbounty_pro_notification_sendout_hook', array( $this, 'smsproSendSms' ), 1);
        add_action('sa_addTabs', array( $this, 'addTabs' ), 100);
    }

    /**
     * Add tabs to smspro settings at backend.
     *
     * @param array $tabs tabs.
     *
     * @return array
     */
    public static function addTabs( $tabs = array() )
    {
        $cartbounty_param = array(
        'checkTemplateFor' => 'cartbounty',
        'templates'        => self::getCartbountyTemplates(),
        );

        $tabs['woocommerce']['inner_nav']['cartbounty']['title']       = 'CartBounty';
        $tabs['woocommerce']['inner_nav']['cartbounty']['tab_section'] = 'cartbountytemplates';
        $tabs['woocommerce']['inner_nav']['cartbounty']['tabContent']  = $cartbounty_param;
        $tabs['woocommerce']['inner_nav']['cartbounty']['filePath']    = 'views/message-template.php';
        return $tabs;
    }


    /**
     * Add default settings to savesetting in setting-options.
     *
     * @param array $defaults defaults.
     *
     * @return array
     */
    public static function add_default_setting( $defaults = array() )
    {
        $defaults['smspro_ac_general']['customer_notify'] = 'off';
        $defaults['smspro_ac_message']['customer_notify'] = '';
        $defaults['smspro_ac_general']['admin_notify']    = 'off';
        $defaults['smspro_ac_message']['admin_notify']    = '';
        return $defaults;
    }

    /**
     * Get cartbounty templates.
     *
     * @return array
     */
    public static function getCartbountyTemplates()
    {
        // customer template.
        $current_val      = smspro_get_option('customer_notify', 'smspro_ac_general', 'on');
        $checkbox_name_id = 'smspro_ac_general[customer_notify]';
        $textarea_name_id = 'smspro_ac_message[customer_notify]';
        $text_body        = smspro_get_option('customer_notify', 'smspro_ac_message', SmsAlertMessages::showMessage('DEFAULT_AC_CUSTOMER_MESSAGE'));

        $templates = array();

        $templates['cartbounty-cust']['title']          = 'Send message to customer when product is left in cart';
        $templates['cartbounty-cust']['enabled']        = $current_val;
        $templates['cartbounty-cust']['status']         = 'cartbounty-cust';
        $templates['cartbounty-cust']['text-body']      = $text_body;
        $templates['cartbounty-cust']['checkboxNameId'] = $checkbox_name_id;
        $templates['cartbounty-cust']['textareaNameId'] = $textarea_name_id;
        $templates['cartbounty-cust']['token']          = self::getAbandonCartvariables();

        // admin template.
        $current_val      = smspro_get_option('admin_notify', 'smspro_ac_general', 'on');
        $checkbox_name_id = 'smspro_ac_general[admin_notify]';
        $textarea_name_id = 'smspro_ac_message[admin_notify]';
        $text_body        = smspro_get_option('admin_notify', 'smspro_ac_message', SmsAlertMessages::showMessage('DEFAULT_AC_ADMIN_MESSAGE'));

        $templates['cartbounty-admin']['title']          = 'Send message to admin when product is left in cart';
        $templates['cartbounty-admin']['enabled']        = $current_val;
        $templates['cartbounty-admin']['status']         = 'cartbounty-admin';
        $templates['cartbounty-admin']['text-body']      = $text_body;
        $templates['cartbounty-admin']['checkboxNameId'] = $checkbox_name_id;
        $templates['cartbounty-admin']['textareaNameId'] = $textarea_name_id;
        $templates['cartbounty-admin']['token']          = self::getAbandonCartvariables();

        return $templates;
    }

    /**
     * Smsalert send sms.
     *
     * @return void
     */
    public function smsproSendSms()
    {
        global $wpdb;
        $set_checkout_url = false;
        if (is_plugin_active('woo-save-abandoned-carts-pro/cartbounty-pro-abandoned-carts.php') ) {
            $table_name       = $wpdb->prefix . CARTBOUNTY_PRO_TABLE_NAME;
            $time             = smspro_get_option('hours', 'cartbounty_pro_notification_frequency', '60');
            $plugin_admin     = new CartBounty_Pro_Admin(CARTBOUNTY_PRO_PLUGIN_NAME_SLUG, CARTBOUNTY_PRO_VERSION_NUMBER);
            $set_checkout_url = true;

        } else {
            $table_name = $wpdb->prefix . CARTBOUNTY_TABLE_NAME;
            $time       = smspro_get_option('hours', 'cartbounty_notification_frequency', '60');
        }

        $timezone      = wp_timezone_string();
        $datetime      = get_gmt_from_date('UTC' . $timezone);
        $time_interval = date('Y-m-d H:i:s', strtotime('-' . $time . ' Minutes', strtotime($datetime)));

        // send msg to user.
        $rows_to_phone = $wpdb->get_results(
            'SELECT * FROM ' . $table_name . " WHERE mail_sent = 0 AND cart_contents != '' AND time < '" . $time_interval . "'",
            ARRAY_A
        );

        if ($rows_to_phone ) {
            $smspro_ac_customer_notify  = smspro_get_option('customer_notify', 'smspro_ac_general', 'on');
            $smspro_ac_customer_message = smspro_get_option('customer_notify', 'smspro_ac_message', '');

            if ('on' === $smspro_ac_customer_notify && '' !== $smspro_ac_customer_message ) {
                foreach ( $rows_to_phone as $data ) {
                    if ($set_checkout_url ) {
                        $data['checkout_url'] = $plugin_admin->create_cart_url($data['email'], $data['session_id'], $data['id']);
                    }
                    do_action('sa_send_sms', $data['phone'], $this->parseSmsBody($data, $smspro_ac_customer_message));
                }
            }

            // send msg to admin.
            $sms_admin_phone = smspro_get_option('sms_admin_phone', 'smspro_message', '');
            if (! empty($sms_admin_phone) ) {
                $smspro_ac_admin_notify  = smspro_get_option('admin_notify', 'smspro_ac_general', 'on');
                $smspro_ac_admin_message = smspro_get_option('admin_notify', 'smspro_ac_message', '');

                if ('on' === $smspro_ac_admin_notify && '' !== $smspro_ac_admin_message ) {
                    $sms_admin_phone = explode(',', $sms_admin_phone);
                    foreach ( $sms_admin_phone as $phone ) {
                        do_action('sa_send_sms', $phone, $this->parseSmsBody($data, $smspro_ac_admin_message));
                    }
                }
            }
        }
    }

    /**
     * Get abandon cartvariables.
     *
     * @return array
     */
    public static function getAbandonCartvariables()
    {
        $variables = array(
        '[name]'          => 'Name',
        '[surname]'       => 'Surname',
        '[email]'         => 'Email',
        '[phone]'         => 'Phone',
        '[location]'      => 'Location',
        '[cart_total]'    => 'Cart Total',
        '[currency]'      => 'Currency',
        '[time]'          => 'Time',
        '[item_name]'     => 'Item name',
        '[item_name_qty]' => 'Item with Qty',
        '[store_name]'    => 'Store Name',
        '[shop_url]'      => 'Shop Url',
        );

        if (is_plugin_active('woo-save-abandoned-carts-pro/cartbounty-pro-abandoned-carts.php') ) {
            $variables['[checkout_url]'] = 'Checkout Url';
        }

        return $variables;
    }

    /**
     * Parse sms body.
     *
     * @param array  $data    data.
     * @param string $content content.
     *
     * @return string
     */
    public function parseSmsBody( $data = array(), $content = null )
    {
        $cart_items         = (array) unserialize($data['cart_contents']);
        $item_name          = implode(
            ', ',
            array_map(
                function ( $o ) {
                        return $o['product_title'];
                },
                $cart_items
            )
        );
        $item_name_with_qty = implode(
            ', ',
            array_map(
                function ( $o ) {
                        return sprintf('%s [%u]', $o['product_title'], $o['quantity']);
                },
                $cart_items
            )
        );

        $find = array(
        '[item_name]',
        '[item_name_qty]',
        '[checkout_url]',
        );

        $replace = array(
        wp_specialchars_decode($item_name),
        $item_name_with_qty,
        ( array_key_exists('checkout_url', $data) ? $data['checkout_url'] : '' ),
        );

        $content = str_replace($find, $replace, $content);

        $order_variables = self::getAbandonCartvariables();
        foreach ( $order_variables as $key => $value ) {
            foreach ( $data as $dkey => $dvalue ) {
                if (trim($key, '[]') === $dkey ) {
                    $array_trim_keys[ $key ] = $dvalue;
                }
            }
        }
        $content = str_replace(array_keys($order_variables), array_values($array_trim_keys), $content);

        return $content;
    }
}
new WCAbandonedCart();
