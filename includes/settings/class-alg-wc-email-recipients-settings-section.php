<?php
/**
 * Email Recipients for WooCommerce - Section Settings
 *
 * @version 1.3.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Email_Recipients_Settings_Section' ) ) :

class Alg_WC_Email_Recipients_Settings_Section {

	/**
	 * id.
	 *
	 * @since 1.3.0
	 */
	public $id;

	/**
	 * desc.
	 *
	 * @since 1.3.0
	 */
	public $desc;

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		add_filter( 'woocommerce_get_sections_alg_wc_email_recipients',              array( $this, 'settings_section' ) );
		add_filter( 'woocommerce_get_settings_alg_wc_email_recipients_' . $this->id, array( $this, 'get_settings' ), PHP_INT_MAX );
	}

	/**
	 * settings_section.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function settings_section( $sections ) {
		$sections[ $this->id ] = $this->desc;
		return $sections;
	}

	/**
	 * get_pro_desc.
	 *
	 * @version 1.3.0
	 * @since   1.3.0
	 */
	function get_pro_desc( $desc = false ) {
		switch ( $desc ) {

			case 'status':
				return apply_filters( 'alg_wc_email_recipients_settings',
					'<br><br>' . sprintf( __( 'Statuses: %s.', 'email-recipients-for-woocommerce' ), implode( ', ', wc_get_order_statuses() ) ) );

			case 'downloadable':
				return apply_filters( 'alg_wc_email_recipients_settings',
					'<br><br>' . sprintf( __( 'Available conditions: %s', 'email-recipients-for-woocommerce' ), '<br><br>* ' . implode( '<br><br>* ', array(
						'downloadable'         => __( 'Forward only when all order products are downloadable', 'email-recipients-for-woocommerce' ),
						'downloadable_one'     => __( 'Forward only when at least one order product is downloadable', 'email-recipients-for-woocommerce' ),
						'not_downloadable'     => __( 'Forward only when all order products are not downloadable', 'email-recipients-for-woocommerce' ),
						'not_downloadable_one' => __( 'Forward only when at least one order product is not downloadable', 'email-recipients-for-woocommerce' ),
					) ) ) );

			default:
				return apply_filters( 'alg_wc_email_recipients_settings',
					'You will need <a target="_blank" href="https://wpfactory.com/item/email-recipients-for-woocommerce/">Email Recipients for WooCommerce Pro</a> plugin version to enable this option.' );

		}
	}

}

endif;
