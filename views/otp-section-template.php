<?php 
/**
 * Template.
 * PHP version 5
 *
 * @category View
 * @package  SMSPro
 * @author   SMS Pro <support@softeriatech.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://sms.softeriatech.com/
 */
    //if ( $has_woocommerce || $has_w_p_members || $has_ultimate || $has_w_p_a_m || $has_learn_press ) 
    { ?>
<div class="cvt-accordion">
    <div class="accordion-section">
        <?php if ($has_woocommerce ) { ?>
        <div class="cvt-accordion-body-title" data-href="#accordion_6"> <input type="checkbox" name="smspro_general[buyer_checkout_otp]" id="smspro_general[buyer_checkout_otp]" class="notify_box" <?php echo ( ( 'on' === $smspro_notification_checkout_otp ) ? "checked='checked'" : '' ); ?>/><label for="smspro_general[buyer_checkout_otp]"><?php esc_html_e('OTP for Checkout', 'sms-pro'); ?></label>
		<span class="expand_btn"></span>
        </div>
        <div id="accordion_6" class="cvt-accordion-body-content">
            <table class="form-table">
            <?php
            if ($has_woocommerce || $has_ultimate || $has_w_p_a_m ) {
                $post_order_verification = smspro_get_option('post_order_verification', 'smspro_general', 'off');
                $pre_order_verification  = smspro_get_option('pre_order_verification', 'smspro_general', 'on');
                ?>
            <tr valign="top">
                <td scope="row" class="td-heading" colspan="2">
                    <!--Post Order Verification-->
                    <input type="checkbox" name="smspro_general[post_order_verification]" data-parent_id="smspro_general[buyer_checkout_otp]" id="smspro_general[post_order_verification]" class="notify_box" <?php echo ( ( 'on' === $post_order_verification ) ? "checked='checked'" : '' ); ?> data-name="checkout_otp"/><label for="smspro_general[post_order_verification]"><?php esc_html_e('Post Order Verification ', 'sms-pro'); ?></label> <small>(<?php esc_html_e('disable pre-order verification', 'sms-pro'); ?>)</small>
                    <!--/-Post Order Verification-->
                </td>
            </tr>
						<?php  } ?>
            <?php
            if ($has_woocommerce ) {
                ?>
                    <tr valign="top">
                    <td scope="row" class="td-heading" style="width:40%">
                        <input type="checkbox" name="smspro_general[otp_for_selected_gateways]" id="smspro_general[otp_for_selected_gateways]" class=" notify_box" data-parent_id="smspro_general[buyer_checkout_otp]"  <?php echo ( ( 'on' === $otp_for_selected_gateways ) ? "checked='checked'" : '' ); ?> parent_accordian="otpsection"/><label for="smspro_general[otp_for_selected_gateways]"><?php esc_html_e('Enable OTP only for Selected Payment Options', 'sms-pro'); ?></label>
                        <span class="tooltip" data-title="Please select payment gateway for which you wish to enable OTP Verification"><span class="dashicons dashicons-info"></span></span><br /><br />
                    </td>
                    <td>
                <?php
                if ($has_woocommerce ) {
                    ?>
                    <select multiple size="5" name="smspro_general[checkout_payment_plans][]" id="checkout_payment_plans" class="multiselect chosen-select" data-parent_id="smspro_general[otp_for_selected_gateways]" data-placeholder="Select Payment Gateways">
                    <?php
                    $payment_plans = WC()->payment_gateways->payment_gateways();
                    foreach ( $payment_plans as $payment_plan ) {
                         echo '<option ';
                        if (in_array($payment_plan->id, $checkout_payment_plans, true) ) {
                            echo( 'selected' );
                        }
                         echo( ' value="' . esc_attr($payment_plan->id) . '">' . esc_attr($payment_plan->title) . '</option>' );
                    }
                    ?>
                    </select>
                    <script>jQuery(function() {jQuery(".chosen-select").chosen({width: "100%"});});</script>
                <?php } ?>
                    </td>
                </tr>
            <?php } ?>
                <tr valign="top" class="top-border">
            <?php
            if ($has_woocommerce ) {
                ?>
                    <td scope="row" class="td-heading">
                        <input type="checkbox" name="smspro_general[checkout_show_otp_button]" id="smspro_general[checkout_show_otp_button]" class="notify_box" data-parent_id="smspro_general[buyer_checkout_otp]" <?php echo ( ( 'on' === $checkout_show_otp_button ) ? "checked='checked'" : '' ); ?>/>
                        <label for="smspro_general[checkout_show_otp_button]"><?php esc_html_e('Show Verify Button next to phone field', 'sms-pro'); ?></label>
                        <span class="tooltip" data-title="Show verify button in-place of link at checkout"><span class="dashicons dashicons-info"></span></span>
                    </td>
            <?php } ?>
                </tr>
                <tr valign="top">
                    <td scope="row" class="td-heading">
            <?php
            if ($has_woocommerce ) {
                ?>
                        <input type="checkbox" name="smspro_general[checkout_show_otp_guest_only]" id="smspro_general[checkout_show_otp_guest_only]" class="notify_box" data-parent_id="smspro_general[buyer_checkout_otp]" <?php echo ( ( 'on' === $checkout_show_otp_guest_only ) ? "checked='checked'" : '' ); ?>/><label for="smspro_general[checkout_show_otp_guest_only]"><?php esc_html_e('Verify only Guest Checkout', 'sms-pro'); ?></label>
                        <span class="tooltip" data-title="OTP verification only for guest checkout"><span class="dashicons dashicons-info"></span></span>
            <?php } ?>
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row" class="td-heading"><?php esc_html_e('OTP Verify Button Text', 'sms-pro'); ?> </td>
                    <td>
                        <input type="text" name="smspro_general[otp_verify_btn_text]" id="smspro_general[otp_verify_btn_text]" class="notify_box" value="<?php echo esc_html($otp_verify_btn_text); ?>" style="width:90%" required/>
                        <span class="tooltip" data-title="Set OTP Verify Button Text"><span class="dashicons dashicons-info"></span></span>
                    </td>
                </tr>
            </table>
        </div>
        <?php } ?>
        
        <div class="cvt-accordion-body-title" data-href="#accordion_7"> <input type="checkbox" name="smspro_general[buyer_signup_otp]" id="smspro_general[buyer_signup_otp]" class="notify_box" <?php echo ( ( 'on' === $smspro_notification_signup_otp ) ? "checked='checked'" : '' ); ?> > <label for="smspro_general[buyer_signup_otp]"><?php esc_html_e('OTP for Registration', 'sms-pro'); ?></label>
        <span class="expand_btn"></span>
        </div>
        <div id="accordion_7" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr valign="top">
                    <?php
                    //if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) 
                    {
                    ?>
                    <td scope="row" class="td-heading">
                        <input type="checkbox" name="smspro_general[allow_multiple_user]" id="smspro_general[allow_multiple_user]" class="notify_box" data-parent_id="smspro_general[buyer_signup_otp]" <?php echo ( ( 'on' === $smspro_allow_multiple_user ) ? "checked='checked'" : '' ); ?>/><label for="smspro_general[allow_multiple_user]"><?php esc_html_e('Allow multiple accounts with same mobile number', 'sms-pro'); ?></label>
                        <span class="tooltip" data-title="OTP at registration should be active"><span class="dashicons dashicons-info"></span></span>
                    </td>
                    <?php } ?>
                </tr>
            </table>
        </div>

        <?php if ($has_woocommerce || $has_w_p_a_m ) { ?>
        <div class="cvt-accordion-body-title " data-href="#accordion_8"> <input type="checkbox" name="smspro_general[buyer_login_otp]" id="smspro_general[buyer_login_otp]" class="notify_box" <?php echo ( ( 'on' === $smspro_notification_login_otp ) ? "checked='checked'" : '' ); ?>> <label for="smspro_general[buyer_login_otp]"><?php esc_html_e('2 Factor Authentication', 'sms-pro'); ?></label>
        <span class="expand_btn"></span>
        </div>
        <div id="accordion_8" class="cvt-accordion-body-content">
            <table class="form-table">
            <?php
            if ($has_woocommerce ) {
                ?>
                <tr valign="top">
                    <td scope="row" class="login-width td-heading">
                <?php $class = ( $off_excl_role ) ? 'notify_box nopointer disabled' : 'notify_box'; ?>
                        <input type="checkbox" name="smspro_general[otp_for_roles]" id="smspro_general[otp_for_roles]" class="<?php echo esc_attr($class); ?>" data-parent_id="smspro_general[buyer_login_otp]"  <?php echo ( ( 'on' === $otp_for_roles ) ? "checked='checked'" : '' ); ?>/>

                        <label for="smspro_general[otp_for_roles]"><?php esc_html_e('Exclude Role from LOGIN OTP', 'sms-pro'); ?></label>
                        <span class="tooltip" data-title="Exclude Role from LOGIN OTP"><span class="dashicons dashicons-info"></span></span><br /><br />
                    </td>
                    <td>
                <?php

                global $wp_roles;
                $roles = $wp_roles->roles;

                if (! is_array($admin_bypass_otp_login) && 'on' === $admin_bypass_otp_login ) {
                    $admin_bypass_otp_login = array( 'administrator' );
                }
                ?>
                        <select multiple size="5" name="smspro_general[admin_bypass_otp_login][]" id="admin_bypass_otp_login" <?php echo ( ( $off_excl_role ) ? 'disabled' : 'data-parent_id="smspro_general[otp_for_roles]"' ); ?> class="multiselect chosen-select" data-placeholder="Select Roles OTP For login">
                <?php
                foreach ( $roles as $role_key => $role ) {
                    ?>
                        <option
                    <?php
                    if (in_array($role_key, $admin_bypass_otp_login, true) ) {
                        ?>
                            selected
                        <?php
                    }
                    ?>
                        value="<?php echo esc_attr($role_key); ?>"><?php echo esc_attr($role['name']); ?></option>
                    <?php
                }
                ?>
                    </select>
                <?php
                if ($off_excl_role ) {
                    ?>
                            <span style='color:#45108a;padding: 6px;border: 1px solid #45108a;display: block;margin-top: 15px;'><span class='dashicons dashicons-info' style='font-size: 17px;'></span>
                    <?php
                    /* translators: %s: Admin URL */
                    echo wp_kses_post(sprintf(__("Admin phone number is missing, <a href='%s'>click here</a> to add it to your profile", 'sms-pro'), admin_url('profile.php')));
                    ?>
                            </span>
                    <?php
                }
                ?>
                    </td>
                </tr>
            <?php } ?>
            </table>
        </div>
            <?php
        }
        ?>
        <!--customer login with otp-->
        <div class="cvt-accordion-body-title" data-href="#accordion_9"> <input type="checkbox" name="smspro_general[login_with_otp]" id="smspro_general[login_with_otp]" class="notify_box" <?php echo ( ( 'on' === $login_with_otp ) ? "checked='checked'" : '' ); ?>> <label for="smspro_general[login_with_otp]"><?php esc_html_e('Login With OTP (Customer)', 'sms-pro'); ?></label>
		 <?php
                        if ($has_woocommerce ) {
                            ?>
        <span class="expand_btn"></span>
		
        </div>
        <div id="accordion_9" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr valign="top">
                    <td scope="row" class="td-heading">
                        <!--Hide default Login form-->
                       
                            <input type="checkbox" name="smspro_general[hide_default_login_form]" id="smspro_general[hide_default_login_form]" class="notify_box" data-parent_id="smspro_general[login_with_otp]" <?php echo ( ( 'on' === $hide_default_login_form ) ? "checked='checked'" : '' ); ?>/><label for="smspro_general[hide_default_login_form]"><?php esc_html_e('Hide default Login form', 'sms-pro'); ?></label>
                            <span class="tooltip" data-title="Hide default login form on my account"><span class="dashicons dashicons-info"></span></span>
                        <?php } ?>
                        <!--/-Hide default Login form-->
                    </td>
                </tr>
            </table>
        </div>
        <!--customer login with otp-->
        <!--login with Admin otp-->
        <div class="cvt-accordion-body-title" data-href="#accordion_11"> <input type="checkbox" name="smspro_general[login_with_admin_otp]" id="smspro_general[login_with_admin_otp]" class="notify_box" <?php echo ( ( 'on' === $login_with_admin_otp ) ? "checked='checked'" : '' ); ?>> <label for="smspro_general[login_with_admin_otp]"><?php esc_html_e('Login With OTP (Admin)', 'sms-pro'); ?></label>
        <span class="expand_btn"></span>
        </div>
        <div id="accordion_11" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr valign="top">
                    <td scope="row" class="td-heading">
                        <!--Hide default Login form-->
                        
                            <input type="checkbox" name="smspro_general[hide_default_admin_login_form]" id="smspro_general[hide_default_admin_login_form]" class="notify_box" data-parent_id="smspro_general[login_with_admin_otp]" <?php echo ( ( 'on' === $hide_default_admin_login_form ) ? "checked='checked'" : '' ); ?>/><label for="smspro_general[hide_default_admin_login_form]"><?php esc_html_e('Hide default Admin Login form', 'sms-pro'); ?></label>
                            <span class="tooltip" data-title="Hide default login form on my account"><span class="dashicons dashicons-info"></span></span>
     
                        <!--/-Hide default Login form-->
                    </td>
                </tr>
            </table>
        </div>
        <!--login with Admin otp-->
        
        <!--signup with mobile-->
        <div class="cvt-accordion-body-title" data-href="#accordion_12"> 
        
        <?php $signup_with_mobile = smspro_get_option('signup_with_mobile', 'smspro_general', 'off'); ?>
        
        <input type="checkbox" name="smspro_general[signup_with_mobile]" id="smspro_general[signup_with_mobile]" class="notify_box" <?php echo ( ( 'on' === $signup_with_mobile ) ? "checked='checked'" : '' ); ?>> <label for="smspro_general[signup_with_mobile]"><?php esc_html_e('Signup With Mobile', 'sms-pro'); ?></label>
        
        
        <span class="expand_btn"></span>
        </div>
        <div id="accordion_12" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr valign="top">
                    <td scope="row" class="td-heading">
                        <!--Signup with Mob - Default Role-->
                        <?php
                        $smspro_defaultuserrole = get_option('smspro_defaultuserrole', 'customer');
                        if (! get_role($smspro_defaultuserrole) ) {
                            $smspro_defaultuserrole = 'subscriber';
                        }
                        ?>
                        <table class="form-table">
                        <tr class="top-border">
                            <th scope="row" style="vertical-align:top;">
                                <label for="smspro_defaultuserrole"><?php esc_html_e('Default User Role', 'sms-pro'); ?></label>
                            </th>
                            <td>
                                <select name="smspro_defaultuserrole" id="smspro_defaultuserrole" data-parent_id="smspro_general[signup_with_mobile]">
                                    <?php
                                    foreach ( wp_roles()->roles as $rkey => $rvalue ) {

                                        if ($rkey === $smspro_defaultuserrole ) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . esc_attr($rkey) . '" ' . esc_attr($sel) . '>' . esc_attr($rvalue['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        </table>
                        <!--Signup with Mob - Default Role-->
                    </td>
                </tr>
            </table>
        </div>
        <!--signup with mobile-->
    </div>
</div>
<br>
<?php } ?>
<!--end accordion-->

<div class="cvt-accordion" style="padding: 0px 10px 10px 10px;">
    <table class="form-table">
        <tr valign="top">
        <?php
        if ($has_woocommerce || $has_w_p_a_m ) {
            ?>
            <td scope="row"  class="td-heading">
            <!--OTP FOR Reset Password-->
                <input type="checkbox" name="smspro_general[reset_password]" id="smspro_general[reset_password]" class="notify_box" <?php echo ( ( 'on' === $enable_reset_password ) ? "checked='checked'" : '' ); ?>/><label for="smspro_general[reset_password]"><?php esc_html_e('OTP For Reset Password', 'sms-pro'); ?></label>
            <!--/-OTP FOR Reset Password-->
            </td>
            <td scope="row"  class="td-heading">
                <!--OTP FOR User Profile Update-->
            <?php  $enable_otp_user_update = get_option('smspro_otp_user_update', 'on');?>
                <input type="checkbox" name="smspro_otp_user_update" id="smspro_otp_user_update" class="notify_box" <?php echo (($enable_otp_user_update=='on')?"checked='checked'":'')?>/><label for="smspro_otp_user_update"><?php _e('OTP For User Update', 'sms-pro') ?></label>
                <!--/-OTP FOR User Profile Update-->
            </td>
        <?php } ?>
        </tr>
        <tr valign="top" class="top-border">
        <td scope="row"  class="td-heading">
            <!--OTP FOR Reset Password-->
                <input type="checkbox" name="smspro_general[otp_in_popup]" id="smspro_general[otp_in_popup]" class="notify_box" <?php echo ( ( 'on' === $otp_in_popup ) ? "checked='checked'" : '' ); ?>/><label for="smspro_general[otp_in_popup]"><?php esc_html_e('Show OTP in Popup', 'sms-pro'); ?></label>
            <!--/-OTP FOR Reset Password-->
            </td>
        </tr>    
         <tr valign="top">
             <td scope="row" class="td-heading"><?php esc_attr_e('Modal Style', 'sms-pro'); ?></td>
             <td class="td-heading">
            <?php
             $styles = array(
              'modal-slideIn' => 'Slide',
              'modal-fadeIn' => 'FadeIn',
              'modal-flipIn' => 'Flip',
              'modal-signIn' => 'Sign',
             )
                ?>
            <select name="smspro_general[modal_style]" id="modal_style">
                <option value="">Default</option>
             <?php
                foreach ( $styles as $k => $v ) {
                    ?>
                 <option value="<?php echo esc_attr($k); ?>" <?php echo ( $modal_style === $k ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr($v); ?></option>
                <?php } ?>
                    </select>
                    <span class="tooltip" data-title="Select Modal Style Effect"><span class="dashicons dashicons-info"></span></span>
                    <span class="dashicons dashicons-search" onclick="previewtemplate();" style="margin-left: 25px; cursor:pointer"></span>
                </td>
            </tr>
                            <!--/-Modal style-->
         <tr valign="top" class="<?php echo $disablePlayground; ?>">
            <td scope="row" class="td-heading"><?php esc_html_e('OTP Template Style', 'sms-pro'); ?> <span class="tooltip" data-title="Edit OTP Template Style"><span class="dashicons dashicons-info"></span></span>
            </td>
            <td colspan="3">
                <?php
                $disabled = (! is_plugin_active('elementor/elementor.php')) ? "anchordisabled" : "";
                $post = get_page_by_path('modal_style', OBJECT, 'sms-pro'); 
                ?>              
                <a href= <?php get_admin_url() ?>"edit.php?post_name=modal_style" class="button <?php echo $disabled; ?> otpeditmodel action" target="_blank" style="float:left;"><?php esc_html_e('Edit With Elementor', 'sms-pro'); ?></a>
                <?php if (!empty($post->post_type)) {?>
                <a href="#" onclick="return false;" temp-style="modal_style" class="btn-outline btn_reset_style" style="float:left;"><?php esc_html_e('Reset', 'sms-pro'); ?></a>
                <?php }?>
                <span class="reset_style"></span>    
           <?php
            if ($disabled!='') {
                ?>        
            <span><?php esc_html_e('To edit, please install elementor plugin', 'sms-pro'); ?>    </span>
                <?php
            }
            ?>
            </td>
        </tr>
	
        <tr valign="top" otp-section-token" class="<?php echo $disablePlayground; ?>">
			
            <td scope="row" class="td-heading" style="vertical-align: top;"><?php esc_html_e('OTP Template', 'sms-pro'); ?></td>
			
            <td colspan="3" style="margin-top:20px;position:relative" >
			
			
            <div class="smspro_tokens"><a href="#" data-val="[otp]" style="margin-top:20px">OTP</a> | <a href="#" data-val="[shop_url]" style="margin-top:20px">Shop Url</a> | <a href="#" data-val="[store_name]" style="margin-top:20px">Shop Name</a> </div>
			
            <textarea parent_accordian="otpsection" name="smspro_message[sms_otp_send]" id="smspro_message[sms_otp_send]" class="token-area"><?php echo esc_textarea($sms_otp_send); ?></textarea>
			
            <div id="menu_otp_section" class="sa-menu-token" role="listbox"></div>
            <span><?php esc_html_e('Template to be used for sending OTP', 'sms-pro'); ?><hr />
                <?php
                /* translators: %s: OTP tag */
                echo wp_kses_post(sprintf(__('It is mandatory to include %s tag in template content.', 'sms-pro'), '[otp]')); ?>
                <br /><br /><b><?php esc_html_e('Optional Attributes', 'sms-pro'); ?></b><br />
            <ul>
                <li><b>length</b> &nbsp; - <?php esc_html_e('length of OTP, default is 4, accepted values between 3 and 8,', 'sms-pro'); ?></li>
                <li><b>retry</b> &nbsp;&nbsp;&nbsp;&nbsp; - <?php esc_html_e('set how many times otp message can be sent in specific time default is 5,', 'sms-pro'); ?></li>
                <li><b>validity</b> &nbsp;- <?php esc_html_e('set validity of the OTP default is 15 minutes', 'sms-pro'); ?></li>
            </ul>
                <b>eg</b> : <code>[otp length="6" retry="2" validity="10"]</code></span>
           </td>
        </tr>
		
    </table>
</div>
<a href="https://youtu.be/bvmfEk_h9h0" target="_blank" class="btn-outline"><span class="dashicons dashicons-video-alt3" style="font-size: 21px"></span>  Youtube</a>
<script>
jQuery(document).ready(function(){        
jQuery("#btn_popup").click(function(){
    jQuery("#btn_popup" ).addClass("anchordisabled" );                        
    jQuery.ajax({
            type: "POST",
            url: '<?php get_admin_url()?>?postname=modal_style&action=reset_style',                                
            success: function (data) {
                    var response = JSON.parse(data);
                    if (response.status == "success") {
                   jQuery("#reset_status").html("<strong>Reset Successfully.</strong>").fadeOut(3e3,function(){jQuery("#reset_status").html("")})
                    jQuery("#btn_popup" ).hide();        
                    }
                    else{
                        jQuery("#btn_popup" ).removeClass("anchordisabled" );
                        jQuery("#btn_popup" ).css("pointer-events", "cursor" );
                    }
                 },                        
                });
                return false;
            });
    });
    //modal preview
        function previewtemplate() {
             var selected_modal =  '<?php echo !empty(SmsAlertUtility::get_elementor_data("form_list"))?SmsAlertUtility::get_elementor_data("form_list"):'popup-1';?>';
            jQuery('.sa-edit-phone').hide(); 
            jQuery('.otp-number').removeClass('hide');
            if (selected_modal=='popup-1' || selected_modal=='popup-4')
            {
                jQuery('.smspro_validate_field').removeClass('digit-group');
                jQuery('.smspro_validate_field').removeClass('popup-3');
                jQuery('.otp-number').addClass('hide');
            } else if (selected_modal=='popup-2')
            {
                jQuery('.smspro_validate_field').addClass('digit-group');
                jQuery('.smspro_validate_field').removeClass('popup-3');
            } else if (selected_modal=='popup-3')
            {
                jQuery('.smspro_validate_field').addClass('digit-group popup-3');
            }
            var selectedValue = document.getElementById("modal_style").value;
                selectedValue = (selectedValue != '')? selectedValue : 'center';
            var modal_c = jQuery(".modal.smsproModal").attr('class');
            var modal_style = selectedValue.slice(0, -2);
            jQuery(".modal.smsproModal").removeClass(modal_c).addClass('modal popup smsproModal preview '+selectedValue);
            jQuery(".modal.smsproModal").find('.back').addClass('close').removeClass('back');;
            if ( selectedValue != 'center' ){
                jQuery(".modal.smsproModal").attr("data-modal-close", modal_style);
            }
            jQuery('.modal.smsproModal .sa-message').addClass('preview-message');
            jQuery(".modal.smsproModal").show();
        }
        jQuery(document).on("click", ".close",function(){
            jQuery(".blockUI").hide();
            var modal_style = jQuery(this).parents().find('.modal.smsproModal').attr('data-modal-close');
            jQuery(this).parents().find('.modal.smsproModal').addClass(modal_style+'Out');
            jQuery(this).parents(".modal.smsproModal").not('.smspro-modal').hide('slow');
            setTimeout(function() {
                jQuery('.modal.smsproModal').removeClass(modal_style+'Out');
            }, 500);
        });
</script>