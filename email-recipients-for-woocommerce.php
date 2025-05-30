<?php
/*
Plugin Name: Multiple Email Recipients for WooCommerce
Plugin URI: https://wordpress.org/plugins/email-recipients-for-woocommerce/
Description: Set custom recipients for WooCommerce emails.
Version: 2.0.0
Author: Algoritmika Ltd
Author URI: https://profiles.wordpress.org/algoritmika/
Text Domain: email-recipients-for-woocommerce
Domain Path: /langs
WC tested up to: 9.8
Requires Plugins: woocommerce
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

defined( 'ABSPATH' ) || exit;

if ( 'email-recipients-for-woocommerce.php' === basename( __FILE__ ) ) {
	/**
	 * Check if Pro plugin version is activated.
	 *
	 * @version 1.3.0
	 * @since   1.2.0
	 */
	$plugin = 'email-recipients-for-woocommerce-pro/email-recipients-for-woocommerce-pro.php';
	if (
		in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) ||
		( is_multisite() && array_key_exists( $plugin, (array) get_site_option( 'active_sitewide_plugins', array() ) ) )
	) {
		defined( 'ALG_WC_EMAIL_RECIPIENTS_FILE_FREE' ) || define( 'ALG_WC_EMAIL_RECIPIENTS_FILE_FREE', __FILE__ );
		return;
	}
}

defined( 'ALG_WC_EMAIL_RECIPIENTS_VERSION' ) || define( 'ALG_WC_EMAIL_RECIPIENTS_VERSION', '2.0.0' );

defined( 'ALG_WC_EMAIL_RECIPIENTS_FILE' ) || define( 'ALG_WC_EMAIL_RECIPIENTS_FILE', __FILE__ );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-alg-wc-email-recipients.php';

if ( ! function_exists( 'alg_wc_email_recipients' ) ) {
	/**
	 * Returns the main instance of Alg_WC_Email_Recipients to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function alg_wc_email_recipients() {
		return Alg_WC_Email_Recipients::instance();
	}
}

add_action( 'plugins_loaded', 'alg_wc_email_recipients' );
