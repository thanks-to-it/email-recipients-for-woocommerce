<?php
/**
 * Email Recipients for WooCommerce - General Section Settings
 *
 * @version 1.2.1
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Email_Recipients_Settings_General' ) ) :

class Alg_WC_Email_Recipients_Settings_General extends Alg_WC_Email_Recipients_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'Recipients', 'email-recipients-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.2.1
	 * @since   1.0.0
	 *
	 * @todo    [next] (desc) section desc?
	 */
	function get_settings() {
		$settings = array(
			array(
				'title'    => __( 'Email Recipients Options', 'email-recipients-for-woocommerce' ),
				'desc'     => __( 'Comma separated list of emails.', 'email-recipients-for-woocommerce' ) . ' ' .
					sprintf( __( 'Available placeholders: %s.', 'email-recipients-for-woocommerce' ),
						'<code>' . implode( '</code>, <code>', array( '%customer%', '%admin%', '%default%' ) ) . '</code>' ) . ' ' .
					__( 'Leave empty for the default WooCommerce value.', 'email-recipients-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_email_recipients_options',
			),
			array(
				'title'    => __( 'Email recipients', 'email-recipients-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'email-recipients-for-woocommerce' ) . '</strong>',
				'id'       => 'alg_wc_email_recipients_section_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
		);
		if ( class_exists( 'WC_Emails' ) ) {
			$wc_emails = WC_Emails::instance();
			foreach ( $wc_emails->emails as $wc_email ) {
				$settings = array_merge( $settings, array(
					array(
						'title'    => $wc_email->title,
						'id'       => "alg_wc_email_recipients[{$wc_email->id}]",
						'default'  => '',
						'type'     => 'text',
						'css'      => 'width:100%;',
						'alg_wc_er_sanitize' => 'textarea',
					),
				) );
			}
		}
		$settings = array_merge( $settings, array(
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_email_recipients_options',
			)
		) );
		return $settings;
	}

}

endif;

return new Alg_WC_Email_Recipients_Settings_General();
