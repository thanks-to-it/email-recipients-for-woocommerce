<?php
/**
 * Email Recipients for WooCommerce - Forwarding Section Settings
 *
 * @version 1.2.0
 * @since   1.2.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Email_Recipients_Settings_Forwarding' ) ) :

class Alg_WC_Email_Recipients_Settings_Forwarding extends Alg_WC_Email_Recipients_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.2.0
	 * @since   1.2.0
	 */
	function __construct() {
		$this->id   = 'forwarding';
		$this->desc = __( 'Forwarding', 'email-recipients-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.2.0
	 * @since   1.2.0
	 *
	 * @todo    [next] (desc) section desc?
	 */
	function get_settings() {
		return array(
			array(
				'title'    => __( 'Email Forwarding Options', 'email-recipients-for-woocommerce' ),
				'desc'     => __( 'Forward all WooCommerce emails.', 'email-recipients-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_email_recipients_forwarding_options',
			),
			array(
				'title'    => __( 'Email forwarding', 'email-recipients-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'email-recipients-for-woocommerce' ) . '</strong>',
				'desc_tip' => apply_filters( 'alg_wc_email_recipients_settings',
					'You will need <a target="_blank" href="https://wpfactory.com/item/email-recipients-for-woocommerce/">Email Recipients for WooCommerce Pro</a> plugin version to enable this section.' ),
				'id'       => 'alg_wc_email_recipients_forwarding_section_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
				'custom_attributes' => apply_filters( 'alg_wc_email_recipients_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_email_recipients_forwarding_options',
			),
			array(
				'title'    => __( 'Cc', 'email-recipients-for-woocommerce' ),
				'desc'     => __( 'Cc (carbon copy) field indicates secondary recipients whose names are visible to one another and to the principal.', 'email-recipients-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_email_recipients_cc_forwarding_options',
			),
			array(
				'title'    => __( 'Email(s)', 'email-recipients-for-woocommerce' ),
				'desc_tip' => __( 'Comma separated list of emails.', 'email-recipients-for-woocommerce' ) . ' ' . __( 'Ignored if empty.', 'email-recipients-for-woocommerce' ),
				'id'       => 'alg_wc_email_recipients_cc_email',
				'default'  => '',
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'title'    => __( 'Order status', 'email-recipients-for-woocommerce' ),
				'desc_tip' => __( 'If you want to forward only order emails and only with selected statuses, set them here.', 'email-recipients-for-woocommerce' ) . ' ' .
					__( 'Leave empty to forward for all emails and order statuses.', 'email-recipients-for-woocommerce' ),
				'id'       => 'alg_wc_email_recipients_cc_order_status',
				'default'  => array(),
				'type'     => 'multiselect',
				'class'    => 'chosen_select',
				'options'  => wc_get_order_statuses(),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_email_recipients_cc_forwarding_options',
			),
			array(
				'title'    => __( 'Bcc', 'email-recipients-for-woocommerce' ),
				'desc'     => __( 'Bcc (blind carbon copy) field indicates tertiary recipients whose names are invisible to each other and to the primary and secondary recipients.', 'email-recipients-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_email_recipients_bcc_forwarding_options',
			),
			array(
				'title'    => __( 'Email(s)', 'email-recipients-for-woocommerce' ),
				'desc_tip' => __( 'Comma separated list of emails.', 'email-recipients-for-woocommerce' ) . ' ' . __( 'Ignored if empty.', 'email-recipients-for-woocommerce' ),
				'id'       => 'alg_wc_email_recipients_bcc_email',
				'default'  => '',
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'title'    => __( 'Order status', 'email-recipients-for-woocommerce' ),
				'desc_tip' => __( 'If you want to forward only order emails and only with selected statuses, set them here.', 'email-recipients-for-woocommerce' ) . ' ' .
					__( 'Leave empty to forward for all emails and order statuses.', 'email-recipients-for-woocommerce' ),
				'id'       => 'alg_wc_email_recipients_bcc_order_status',
				'default'  => array(),
				'type'     => 'multiselect',
				'class'    => 'chosen_select',
				'options'  => wc_get_order_statuses(),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_email_recipients_bcc_forwarding_options',
			),
		);
	}

}

endif;

return new Alg_WC_Email_Recipients_Settings_Forwarding();
