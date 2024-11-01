<?php
/**
 * Plugin Name: WooCommerce - Re-Create WooCommerce pages
 * Plugin URI: http://www.remicorson.com/woocommerce-re-create-pages/
 * Description: Adds a "re-create pages" button to WooCommerce tools to re-generate WooCommerce default pages.
 * Version: 1.0
 * Author: Remi Corson
 * Author URI: http://remicorson.com
 * Requires at least: 3.5
 * Tested up to: 3.6.1
 *
 * Text Domain: -
 * Domain Path: -
 *
 */

/*
|--------------------------------------------------------------------------
| APPLY ACTIONS & FILTERS IS WOOCOMMERCE IS ACTIVE
|--------------------------------------------------------------------------
*/

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
	/*
	|--------------------------------------------------------------------------
	| ACTIONS
	|--------------------------------------------------------------------------
	*/
	
	add_action( 'admin_init', 'woo_create_pages_init' ); 
	
	/*
	|--------------------------------------------------------------------------
	| FILTERS
	|--------------------------------------------------------------------------
	*/
	
	add_filter('woocommerce_debug_tools', 'woo_create_pages_tool');

} // endif WooCommerce active


/*
|--------------------------------------------------------------------------
| START PLUGIN FUNCTIONS
|--------------------------------------------------------------------------
*/

/**
 * Add re-create pages line to WooCommerce tools
 *
 * @since       1.0 
 * @return      array $tools
*/
function woo_create_pages_tool( $tools ) {

	$tools['create_pages'] = array(
			'name'		=> __( 'WC Pages','woocommerce'),
			'button'	=> __('Re-create Pages','woocommerce'),
			'desc'		=> __( 'This tool will re-create WooCommerce pages.', 'woocommerce' ),
	);
	
	return $tools;
}



/**
 * Init re-create WooCommerce pages
 *
 * @since       1.0 
 * @return      -
*/
function woo_create_pages_init() {
	
	global $woocommerce;

	require_once( $woocommerce->plugin_path . '/admin/woocommerce-admin-install.php' );
	
	if( ! empty( $_GET['action'] ) && 'create_pages' == $_GET['action'] )
		woo_create_pages();
}

/**
 * Process re-create WooCommerce pages
 *
 * @since       1.0 
 * @return      -
*/
function woo_create_pages() {
	if ( ! empty( $_GET['action'] ) && ! empty( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'debug_action' ) ) {
	
		switch ( $_GET['action'] ) {
			case "create_pages" :
				woocommerce_create_pages();
				echo '<div class="updated"><p>' . __( 'WooCommerce Pages re-created.', 'woocommerce' ) . '</p></div>';
			break;
		}
	
	}
}
