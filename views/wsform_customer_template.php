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
$wsform_forms = SA_Wsform::getWsForms();
if (! empty($wsform_forms) ) {
	$disablePlayground     = SmsAlertUtility::isPlayground()?"disablePlayground":"";
    ?>
<!-- accordion -->
<div class="cvt-accordion">
    <div class="accordion-section">
    <?php foreach ( $wsform_forms as $ks => $vs ) { ?>
        <div class="cvt-accordion-body-title" data-href="#accordion_cust_<?php echo esc_attr($ks); ?>">
            <input type="checkbox" name="smspro_wsform_general[wsform_form_status_<?php echo esc_attr($ks); ?>]" id="smspro_wsform_general[wsform_form_status_<?php echo esc_attr($ks); ?>]" class="notify_box" <?php echo ( ( smspro_get_option('wsform_form_status_' . esc_attr($ks), 'smspro_wsform_general', 'on') === 'on' ) ? "checked='checked'" : '' ); ?>/><label><?php echo esc_attr(ucwords(str_replace('-', ' ', $vs))); ?></label>
            <span class="expand_btn"></span>
        </div>
        <div id="accordion_cust_<?php echo esc_attr($ks); ?>" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr>
                    <td><input data-parent_id="smspro_wsform_general[wsform_form_status_<?php echo esc_attr($ks); ?>]" type="checkbox" name="smspro_wsform_general[wsform_message_<?php echo esc_attr($ks); ?>]" id="smspro_wsform_general[wsform_message_<?php echo esc_attr($ks); ?>]" class="notify_box" <?php echo ( ( smspro_get_option('wsform_message_' . esc_attr($ks), 'smspro_wsform_general', 'on') === 'on' ) ? "checked='checked'" : '' ); ?>/><label for="smspro_wsform_general[wsform_message_<?php echo esc_attr($ks); ?>]">Enable Message</label>
                    <a href="admin.php?page=ws-form-edit&id=<?php echo $ks;?>" title="Edit Form" target="_blank" class="alignright"><small><?php esc_html_e('Edit Form', 'sms-pro')?></small></a>
                    </td>
                    </tr>
                <tr valign="top"  style="position:relative">
                    <td class="<?php echo $disablePlayground; ?>">
                        <div class="smspro_tokens">
        <?php
        $fields = SA_Wsform::getWsFormVariables($ks);
        foreach ( $fields as $key=>$value ) {
            echo  "<a href='#' data-val='[" . esc_attr($key) . "]'>".esc_attr($value)."</a> | ";
        }
        ?>
                        </div>
                        <textarea data-parent_id="smspro_wsform_general[wsform_message_<?php echo esc_attr($ks); ?>]" name="smspro_wsform_message[wsform_sms_body_<?php echo esc_attr($ks); ?>]" id="smspro_wsform_message[wsform_sms_body_<?php echo esc_attr($ks); ?>]" <?php echo( ( smspro_get_option('wsform_form_status_' . esc_attr($ks), 'smspro_wsform_general', 'on') === 'on' ) ? '' : "readonly='readonly'" ); ?> class="token-area"><?php echo esc_textarea(smspro_get_option('wsform_sms_body_' . esc_attr($ks), 'smspro_wsform_message', SmsAlertMessages::showMessage('DEFAULT_CONTACT_FORM_CUSTOMER_MESSAGE'))); ?></textarea>
                        <div id="menu_wsform_cust_<?php echo esc_attr($ks); ?>" class="sa-menu-token" role="listbox"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Select Phone Field : <select name="smspro_wsform_general[wsform_sms_phone_<?php echo esc_attr($ks); ?>]">
        <?php
        foreach ( $fields as $key=>$value ) {
            ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php echo ( trim(smspro_get_option('wsform_sms_phone_' . $ks, 'smspro_wsform_general', '')) === $key ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr($value); ?></option>
            <?php
        }
        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input data-parent_id="smspro_wsform_general[wsform_form_status_<?php echo esc_attr($ks); ?>]" type="checkbox" name="smspro_wsform_general[wsform_otp_<?php echo esc_attr($ks); ?>]" id="smspro_wsform_general[wsform_otp_<?php echo esc_attr($ks); ?>]" class="notify_box" <?php echo ( ( smspro_get_option('wsform_otp_' . esc_attr($ks), 'smspro_wsform_general', 'off') === 'on' ) ? "checked='checked'" : '' ); ?>/><label for="smspro_wsform_general[wsform_otp_<?php echo esc_attr($ks); ?>]">Enable Mobile Verification</label>
                    </td>
                </tr>
            </table>
        </div>
    <?php } ?>
    </div>
</div>
<!--end accordion-->
    <?php
} else {
    echo '<h3>No Form(s) published</h3>';
}
?>