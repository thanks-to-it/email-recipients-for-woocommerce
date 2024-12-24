<?php
/**
 * Email Recipients for WooCommerce - Core Class
 *
 * @version 1.3.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Email_Recipients_Core' ) ) :

class Alg_WC_Email_Recipients_Core {

	/**
	 * recipient_options.
	 *
	 * @since 1.3.0
	 */
	public $recipient_options;

	/**
	 * cc_email.
	 *
	 * @since 1.3.0
	 */
	public $cc_email;

	/**
	 * bcc_email.
	 *
	 * @since 1.3.0
	 */
	public $bcc_email;

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
	 * @version 1.3.0
	 * @since   1.0.0
	 */
	function init() {

		// Recipients
		if ( 'yes' === get_option( 'alg_wc_email_recipients_section_enabled', 'yes' ) ) {
			if ( class_exists( 'WC_Emails' ) ) {
				$this->recipient_options = get_option( 'alg_wc_email_recipients', array() );
				$wc_emails               = WC_Emails::instance();
				foreach ( $wc_emails->emails as $wc_email ) {
					if ( ! empty( $this->recipient_options[ $wc_email->id ] ) ) {
						add_filter( 'woocommerce_email_recipient_' . $wc_email->id, array( $this, 'custom_recipient' ), PHP_INT_MAX, 2 );
					}
				}
			}
		}

		// Email forwarding
		if ( 'yes' === get_option( 'alg_wc_email_recipients_forwarding_section_enabled', 'no' ) ) {
			if ( '' != ( $this->cc_email = get_option( 'alg_wc_email_recipients_cc_email', '' ) ) ) {
				add_filter( 'woocommerce_email_headers', array( $this, 'add_cc_email' ), PHP_INT_MAX, 3 );
			}
			if ( '' != ( $this->bcc_email = get_option( 'alg_wc_email_recipients_bcc_email', '' ) ) ) {
				add_filter( 'woocommerce_email_headers', array( $this, 'add_bcc_email' ), PHP_INT_MAX, 3 );
			}
		}

		// Action
		do_action( 'alg_wc_email_recipients_init' );

	}

	/**
	 * add_bcc_email.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 *
	 * @todo    (feature) per email (i.e., per `$id`) (same in `add_cc_email()`)
	 */
	function add_bcc_email( $email_headers, $id, $_object ) {
		return (
			apply_filters( 'alg_wc_email_recipients_do_forward', true, $_object, 'bcc' ) ?
			$email_headers . "Bcc: " . $this->bcc_email . "\r\n" :
			$email_headers
		);
	}

	/**
	 * add_cc_email.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 */
	function add_cc_email( $email_headers, $id, $_object ) {
		return (
			apply_filters( 'alg_wc_email_recipients_do_forward', true, $_object, 'cc' ) ?
			$email_headers . "Cc: " . $this->cc_email . "\r\n" :
			$email_headers
		);
	}

	/**
	 * custom_recipient.
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 *
	 * @todo    (dev) `( $_object && is_object( $_object ) && is_a( $_object, 'WC_Order' ) && is_callable( array( $_object, 'get_billing_email' ) ) ? ... )`?
	 * @todo    (feature) add `low_stock`, `backorder` etc. emails here?
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
			return str_replace( array_keys( $placeholders ), $placeholders, $this->recipient_options[ $wc_email_id ] );
		}
		return $recipient;
	}

}

endif;

return new Alg_WC_Email_Recipients_Core();
