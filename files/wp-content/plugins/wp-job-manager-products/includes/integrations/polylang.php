<?php
/**
 * Polylang integration.
 *
 * @since 1.8.0
 *
 * @package Products
 * @category Integration
 * @author Astoundify
 */

// Bail if integration is not active.
if ( defined( 'POLYLANG_VERSION' ) && POLYLANG_VERSION ) {
	add_action( 'init', 'wpjmp_polylang_register_settings' );

	add_filter( 'option_wpjmp_select_products_text', 'wpjmp_polylang_pll__' );
	add_filter( 'option_wpjmp_listing_products_text', 'wpjmp_polylang_pll__' );
}

/**
 * Register settings with Polylang.
 *
 * @since 1.0.0
 */
function wpjmp_polylang_register_settings() {
	pll_register_string(
		'Select Products Text',
		'Select Your Services & Products',
		'Products for WP Job Manager',
		false
	);

	pll_register_string(
		'Listing Products Text',
		'Listing products',
		'Products for WP Job Manager',
		false
	);
}

/**
 * Translate a setting.
 *
 * @since 1.0.0
 *
 * @param mixed $value Option value.
 * @return mixed
 */
function wpjmp_polylang_pll__( $value ) {
	return pll__( $value );
}
