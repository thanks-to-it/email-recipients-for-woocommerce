<?php
/**
 * Email Recipients for WooCommerce - Main Class
 *
 * @version 1.2.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Email_Recipients' ) ) :

final class Alg_WC_Email_Recipients {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public $version = ALG_WC_EMAIL_RECIPIENTS_VERSION;

	/**
	 * @var   Alg_WC_Email_Recipients The single instance of the class
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_WC_Email_Recipients Instance
	 *
	 * Ensures only one instance of Alg_WC_Email_Recipients is loaded or can be loaded.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @static
	 * @return  Alg_WC_Email_Recipients - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_WC_Email_Recipients Constructor.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 *
	 * @access  public
	 */
	function __construct() {

		// Check for active plugins
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		// Set up localisation
		add_action( 'init', array( $this, 'localize' ) );

		// Pro
		if ( 'email-recipients-for-woocommerce-pro.php' === basename( ALG_WC_EMAIL_RECIPIENTS_FILE ) ) {
			require_once( 'pro/class-alg-wc-email-recipients-pro.php' );
		}

		// Include required files
		$this->includes();

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}

	}

	/**
	 * localize.
	 *
	 * @version 1.2.0
	 * @since   1.1.1
	 */
	function localize() {
		load_plugin_textdomain( 'email-recipients-for-woocommerce', false, dirname( plugin_basename( ALG_WC_EMAIL_RECIPIENTS_FILE ) ) . '/langs/' );
	}

	/**
	 * includes.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function includes() {
		// Core
		$this->core = require_once( 'class-alg-wc-email-recipients-core.php' );
	}

	/**
	 * admin.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( ALG_WC_EMAIL_RECIPIENTS_FILE ), array( $this, 'action_links' ) );
		// Settings
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
		// Version updated
		if ( get_option( 'alg_wc_email_recipients_version', '' ) !== $this->version ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * action_links.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 *
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		$custom_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_email_recipients' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>';
		if ( 'email-recipients-for-woocommerce.php' === basename( ALG_WC_EMAIL_RECIPIENTS_FILE ) ) {
			$custom_links[] = '<a target="_blank" style="font-weight: bold; color: green;" href="https://wpfactory.com/item/email-recipients-for-woocommerce/">' .
				__( 'Go Pro', 'email-recipients-for-woocommerce' ) . '</a>';
		}
		return array_merge( $custom_links, $links );
	}

	/**
	 * add_woocommerce_settings_tab.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function add_woocommerce_settings_tab( $settings ) {
		$settings[] = require_once( 'settings/class-alg-wc-email-recipients-settings.php' );
		return $settings;
	}

	/**
	 * version_updated.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function version_updated() {
		update_option( 'alg_wc_email_recipients_version', $this->version );
	}

	/**
	 * plugin_url.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( ALG_WC_EMAIL_RECIPIENTS_FILE ) );
	}

	/**
	 * plugin_path.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( ALG_WC_EMAIL_RECIPIENTS_FILE ) );
	}

}

endif;
