<?php
/**
 * Email Recipients for WooCommerce - Settings
 *
 * @version 1.2.1
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Email_Recipients_Settings' ) ) :

class Alg_WC_Email_Recipients_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 *
	 * @version 1.2.1
	 * @since   1.0.0
	 */
	function __construct() {

		$this->id    = 'alg_wc_email_recipients';
		$this->label = __( 'Email Recipients', 'email-recipients-for-woocommerce' );
		parent::__construct();

		add_filter( 'woocommerce_admin_settings_sanitize_option', array( $this, 'alg_wc_er_sanitize' ), PHP_INT_MAX, 3 );

		// Sections
		require_once( 'class-alg-wc-email-recipients-settings-section.php' );
		require_once( 'class-alg-wc-email-recipients-settings-general.php' );
		require_once( 'class-alg-wc-email-recipients-settings-forwarding.php' );

	}

	/**
	 * alg_wc_er_sanitize.
	 *
	 * @version 1.2.1
	 * @since   1.2.1
	 */
	function alg_wc_er_sanitize( $value, $option, $raw_value ) {
		if ( ! empty( $option['alg_wc_er_sanitize'] ) ) {
			switch ( $option['alg_wc_er_sanitize'] ) {
				case 'textarea':
					return wp_kses_post( trim( $raw_value ) );
				default:
					$func = $option['alg_wc_er_sanitize'];
					return ( function_exists( $func ) ? $func( $raw_value ) : $value );
			}
		}
		return $value;
	}

	/**
	 * get_settings.
	 *
	 * @version 1.1.1
	 * @since   1.0.0
	 */
	function get_settings() {
		global $current_section;
		return array_merge( apply_filters( 'woocommerce_get_settings_' . $this->id . '_' . $current_section, array() ), array(
			array(
				'title'     => __( 'Reset Settings', 'email-recipients-for-woocommerce' ),
				'type'      => 'title',
				'id'        => $this->id . '_' . $current_section . '_reset_options',
			),
			array(
				'title'     => __( 'Reset section settings', 'email-recipients-for-woocommerce' ),
				'desc'      => '<strong>' . __( 'Reset', 'email-recipients-for-woocommerce' ) . '</strong>',
				'desc_tip'  => __( 'Check the box and save changes to reset.', 'email-recipients-for-woocommerce' ),
				'id'        => $this->id . '_' . $current_section . '_reset',
				'default'   => 'no',
				'type'      => 'checkbox',
			),
			array(
				'type'      => 'sectionend',
				'id'        => $this->id . '_' . $current_section . '_reset_options',
			),
		) );
	}

	/**
	 * maybe_reset_settings.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function maybe_reset_settings() {
		global $current_section;
		if ( 'yes' === get_option( $this->id . '_' . $current_section . '_reset', 'no' ) ) {
			foreach ( $this->get_settings() as $value ) {
				if ( isset( $value['id'] ) ) {
					$id = explode( '[', $value['id'] );
					delete_option( $id[0] );
				}
			}
			add_action( 'admin_notices', array( $this, 'admin_notices_settings_reset_success' ), PHP_INT_MAX );
		}
	}

	/**
	 * admin_notices_settings_reset_success.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function admin_notices_settings_reset_success() {
		echo '<div class="notice notice-success is-dismissible"><p><strong>' .
			__( 'Your settings have been reset.', 'email-recipients-for-woocommerce' ) . '</strong></p></div>';
	}

	/**
	 * save.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function save() {
		parent::save();
		$this->maybe_reset_settings();
	}

}

endif;

return new Alg_WC_Email_Recipients_Settings();
