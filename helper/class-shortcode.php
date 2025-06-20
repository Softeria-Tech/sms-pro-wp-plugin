<?php
/**
 * Shortcode helper.
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
    
/**
 * PHP version 5
 *
 * @category Handler
 * @package  SMSPro
 * @author   SMS Pro <support@softeriatech.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://sms.softeriatech.com/
 * Shortcode class
 */
class Shortcode
{

    /**
     * Construct function.
     *
     * @return string
     */
    public function __construct()
    {
        $user_authorize = new smspro_Setting_Options();
        if ($user_authorize->is_user_authorised()) {           
            add_shortcode('sa_loginwithotp', array( $this, 'addSaLoginwithotp' ), 100);
            add_shortcode('sa_signupwithmobile', array( $this, 'addSaSignupwithmobile' ), 100);
            add_shortcode('sa_subscribe', array($this, 'addSaSubscribe'), 100);
            add_action('wp_ajax_save_subscribe', array( $this, 'saveSubscribeData' ));
            add_action('wp_ajax_nopriv_save_subscribe', array( $this, 'saveSubscribeData' ));
            add_action('sa_addTabs', array( $this, 'addTabs' ), 100);
        }
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
        $tabs['signupwithotp']['nav'] = 'Shortcodes';
        $tabs['signupwithotp']['icon'] = 'dashicons-admin-users';
        $tabs['signupwithotp']['inner_nav']['signup']['title']       = 'Shortcodes';
        $tabs['signupwithotp']['inner_nav']['signup']['tab_section'] = 'signup_with_phone';
        $tabs['signupwithotp']['inner_nav']['signup']['first_active'] = true;
        $tabs['signupwithotp']['inner_nav']['signup']['tabContent']  = array();
        $tabs['signupwithotp']['inner_nav']['signup']['filePath']    = 'views/signup-with-otp-template.php'; 
        $tabs['signupwithotp']['help_links']                        = array(
        'youtube_link' => array(
        'href'   => 'https://youtu.be/mJ6IEFmmXhI',
        'target' => '_blank',
        'alt'    => 'Watch steps on Youtube',
        'class'  => 'btn-outline',
        'label'  => 'Youtube',
        'icon'   => '<span class="dashicons dashicons-video-alt3" style="font-size: 21px;"></span> ',

        ),
        'kb_link'      => array(
        'href'   => 'https://sms.softeriatech.com/knowledgebase/sms-pro-shortcodes/',
        'target' => '_blank',
        'alt'    => 'Read how to use smspro shortcodes',
        'class'  => 'btn-outline',
        'label'  => 'Documentation',
        'icon'   => '<span class="dashicons dashicons-format-aside"></span>',
        ),
        );
        return $tabs;
    }
    
    /**
     * Add subscription form function.
     *
     * @param $callback callback
     *
     * @return string
     */
    public static function addSaSubscribe($callback)
    {                        
        $grp_name = ( ! empty($callback['group_name']) ) ? $callback['group_name'] : '';
        $sa_name = ( ! empty($callback['sa_name']) ) ? $callback['sa_name'] : esc_html__('Name', 'sms-pro');        
        $sa_placeholder = ( ! empty($callback['sa_placeholder']) ) ? $callback['sa_placeholder'] : esc_html__('Enter Name', 'sms-pro');    
        $sa_mobile = ( ! empty($callback['sa_mobile']) ) ? $callback['sa_mobile'] : esc_html__('Mobile', 'sms-pro');
        $sa_mobile_placeholder = ( ! empty($callback['sa_mobile_placeholder']) ) ? $callback['sa_mobile_placeholder'] : esc_html__('Enter Mobile Number', 'sms-pro');
        $sa_button = ( ! empty($callback['sa_button']) ) ? $callback['sa_button'] : esc_html__('Subscribe', 'sms-pro');
        $form_html = "<form id='sa-subscribe-form'>
			   <input type='hidden' name='grp_name' id='sa_grp_name' value='".esc_attr($grp_name)."'>
			   <p>
			   <label for='name' class ='sa_subscriber'>" .esc_html($sa_name). ":</label>
		       <input type='text' name='sa_name' id='sa_name' class ='sa_input' placeholder='" .esc_attr($sa_placeholder). "'></br>
			   <p/><p> <label for='mobile' class ='sa_subscriber'>" .esc_html($sa_mobile). ":</label>
			    <input type='text' name='sa_mobile' class='phone-valid sa_input' id='sa_mobile' placeholder='" .esc_attr($sa_mobile_placeholder). "'></br>
			   <p/><p>
			   <input type='button' class='button' name='subscribe' id='sa_subscribe' value='".esc_attr($sa_button)."'>
               </p>
                <div class='sasub_output'></div>			   
		</form>";
        
        $inline_script = "document.addEventListener('DOMContentLoaded', function() {jQuery('#sa_subscribe').click(function(){
		var name=jQuery('#sa_name').val();
		var mobile = jQuery('[name=sa_mobile]:hidden').val()?jQuery('[name=sa_mobile]:hidden').val():jQuery('[name=sa_mobile]').val();
		var grp_name=jQuery('#sa_grp_name').val();
		jQuery(this).val('Please Wait...').attr('disabled',true);
		jQuery.ajax({
			url: '".esc_url(admin_url('admin-ajax.php'))."',
			type: 'POST',
			data:'action=save_subscribe&name='+name+'&mobile='+mobile+'&grp_name='+grp_name,
			success: function(data){			
					jQuery('.sasub_output').html(data);
					jQuery('#sa_subscribe').val('Subscribe').attr('disabled',false);
					jQuery('#sa-subscribe-form').trigger('reset');
			}
		})	
        });
        });
		";
        if (! wp_script_is('sainlinescript-handle-footer', 'enqueued') ) {
               wp_register_script('sainlinescript-handle-footer', '', [], '', true);
               wp_enqueue_script('sainlinescript-handle-footer');
        }        
        wp_add_inline_script("sainlinescript-handle-footer", $inline_script);
        return $form_html;        
    }
    
    /**
     * Save subscribe function.
     *
     * @return string
     */
    function saveSubscribeData()
    {
        $grp_name = sanitize_text_field($_POST['grp_name']);
        $datas[] = array('person_name'=>sanitize_text_field($_POST['name']),'number'=>sanitize_text_field($_POST['mobile']));
        $response = SmsAlertcURLOTP::createContact($datas, $grp_name);
        $response = json_decode($response, true);
        if ($response['status']=='success') {
            echo "<div class='sastock_output' style='color: rgb(255, 255, 255); background-color: green; padding: 10px; border-radius: 4px; margin-bottom: 10px;'>You have subscribed successfully.</div>";
        } else {
            $error = !is_array($response['description'])?$response['description']:$response['description']['desc'];
            echo '<div class="sastock_output" style="color: rgb(255, 255, 255); background-color: red; padding: 10px; border-radius: 4px; margin-bottom: 10px;">'.$error.'</div>';
        }
        die();
    }

    /**
     * Loginwithotp function.     
     *
     * @param $callback callback
     *
     * @return string
     */
    public function addSaLoginwithotp($callback=null)
    { 
        $redirect_url    = ( ! empty($callback['redirect_url']) ) ? $callback['redirect_url'] : '';
        $label_field    = ( ! empty($callback['sa_label']) ) ? $callback['sa_label'] : 'Mobile Number';
        $placeholder_field    = ( ! empty($callback['sa_placeholder']) ) ? $callback['sa_placeholder'] : 'Enter Number';
        $button_field    = ( ! empty($callback['sa_button']) ) ? $callback['sa_button'] : 'Login with OTP';
        $enabled_login_with_otp = smspro_get_option('login_with_otp', 'smspro_general');
        if ('on' !== $enabled_login_with_otp && current_user_can('administrator')) {
            return(esc_html__('Please Enable Login With OTP.', 'sms-pro'));
        }
        $unique_class    = 'sa-lwo-'.mt_rand(1, 100);
        if (is_user_logged_in() && !current_user_can('administrator')) {
            return;
        }    
        ob_start();
        global $wp;
        echo '<form class="sa-lwo-form sa_loginwithotp-form '.$unique_class.'" method="post" action="' . home_url($wp->request) . '/?option=smspro_verify_login_with_otp">';
        get_smspro_template('template/login-with-otp-form.php', array('label_field'=>$label_field, 'placeholder_field'=>$placeholder_field, 'button_field'=>$button_field, 'redirect_url'=>$redirect_url));
        echo wp_nonce_field('smspro_wp_loginwithotp_nonce', 'smspro_loginwithotp_nonce', true, false);
        echo '</form><style>.sa_default_login_form{display:none;}</style>';
        echo do_shortcode('[sa_verify phone_selector=".sa_mobileno" submit_selector= ".'.$unique_class.' .smspro_login_with_otp_btn"]');
        $otp_modal = 'document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            if (jQuery(".modal.smsproModal").length==0)    
            {            
            var popup = \''.str_replace(array("\n","\r","\r\n"), "", (get_smspro_template("template/otp-popup.php", array(), true))).'\';
            jQuery("body").append(popup);
            }
        }, 200);
		});
        ';        
        if (! wp_script_is('sainlinescript-handle-footer', 'enqueued') ) {
               wp_register_script('sainlinescript-handle-footer', '', [], '', true);
               wp_enqueue_script('sainlinescript-handle-footer');
        }        
        wp_add_inline_script("sainlinescript-handle-footer", $otp_modal);    
        $content = ob_get_clean();
        return $content;
    }
    
    /**
     * Signupwithmobile function.
     *
     * @param $callback callback
     *
     * @return string
     */
    public function addSaSignupwithmobile($callback=null)
    {        
        $redirect_url    = ( ! empty($callback['redirect_url']) ) ? $callback['redirect_url'] : '';
        $label_field    = ( ! empty($callback['sa_label']) ) ? $callback['sa_label'] : 'Mobile Number';
        $placeholder_field    = ( ! empty($callback['sa_placeholder']) ) ? $callback['sa_placeholder'] : 'Enter Number';
        $button_field    = ( ! empty($callback['sa_button']) ) ? $callback['sa_button'] : 'Signup with Mobile';
        $enabled_signup_with_mobile = smspro_get_option('signup_with_mobile', 'smspro_general');
        $unique_class    = 'sa-swm-'.mt_rand(1, 100);
        if ('on' !== $enabled_signup_with_mobile && current_user_can('administrator')) {
            return(esc_html__('Please Enable Signup With Mobile.', 'sms-pro'));
        }
        if (is_user_logged_in() && !current_user_can('administrator')) {
            return;
        }    
        ob_start();
        global $wp;
        echo '<form class="sa-lwo-form sa-signupwithotp-form '.$unique_class.'" method="post" action="' . home_url($wp->request) . '/?option=signwthmob">';
        get_smspro_template('template/sign-with-mobile-form.php', array('label_field'=>$label_field, 'placeholder_field'=>$placeholder_field, 'button_field'=>$button_field, 'redirect_url'=>$redirect_url));
        echo wp_nonce_field('smspro_wp_signupwithmobile_nonce', 'smspro_signupwithmobile_nonce', true, false);
        echo '</form><style>.sa_default_signup_form{display:none;}</style>';
        echo do_shortcode('[sa_verify phone_selector="#reg_with_mob" submit_selector= ".'.$unique_class.' .smspro_reg_with_otp_btn"]');        
        $otp_modal = 'document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            if (jQuery(".modal.smsproModal").length==0)    
            {            
            var popup = \''.str_replace(array("\n","\r","\r\n"), "", (get_smspro_template("template/otp-popup.php", array(), true))).'\';
            jQuery("body").append(popup);
            }
        }, 200);
	   });
        ';        
        if (! wp_script_is('sainlinescript-handle-footer', 'enqueued') ) {
               wp_register_script('sainlinescript-handle-footer', '', [], '', true);
               wp_enqueue_script('sainlinescript-handle-footer');
        }        
        wp_add_inline_script("sainlinescript-handle-footer", $otp_modal);  
        $content = ob_get_clean();
        return $content;
    }

}
new Shortcode();
?>