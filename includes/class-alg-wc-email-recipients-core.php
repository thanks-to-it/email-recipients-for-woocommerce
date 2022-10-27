<?php
/**
 * Email Recipients for WooCommerce - Core Class
 *
 * @version 1.2.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Email_Recipients_Core' ) ) :

class Alg_WC_Email_Recipients_Core {

	/**
	 * Constructor.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * init.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function init() {
		// Recipients
		if ( 'yes' === get_option( 'alg_wc_email_recipients_section_enabled', 'yes' ) ) {
			if ( class_exists( 'WC_Emails' ) ) {
				$this->options = get_option( 'alg_wc_email_recipients', array() );
				$wc_emails     = WC_Emails::instance();
				foreach ( $wc_emails->emails as $wc_email ) {
					if ( ! empty( $this->options[ $wc_email->id ] ) ) {
						add_filter( 'woocommerce_email_recipient_' . $wc_email->id, array( $this, 'custom_recipient' ), PHP_INT_MAX, 2 );
					}
				}
			}
		}
		// Action
		do_action( 'alg_wc_email_recipients_init' );
	}

	/**
	 * custom_recipient.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @todo    [maybe] (dev) `( $_object && is_object( $_object ) && is_a( $_object, 'WC_Order' ) && is_callable( array( $_object, 'get_billing_email' ) ) ? ... )`
	 * @todo    [maybe] (feature) add `low_stock`, `backorder` etc. emails here
	 */
	function custom_recipient( $recipient, $_object ) {
		$wc_email_id = current_filter();
		$prefix      = 'woocommerce_email_recipient_';
		if ( $prefix === substr( $wc_email_id, 0, strlen( $prefix ) ) ) {
			$wc_email_id  = substr( $wc_email_id, strlen( $prefix ) );
			$placeholders = array(
				'%customer%' => ( is_a( $_object, 'WC_Order' ) ? $_object->get_billing_email() : '' ),
				'%admin%'    => get_option( 'admin_email' ),
				'%default%'  => $recipient,
			);
			return str_replace( array_keys( $placeholders ), $placeholders, $this->options[ $wc_email_id ] );
		}
		return $recipient;
	}

}

endif;

return new Alg_WC_Email_Recipients_Core();
