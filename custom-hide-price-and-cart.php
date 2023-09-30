<?php
/**
 * Plugin Name: Custom Hide Price and Cart
 * Description: Hide product prices, remove "Add to Cart," and add a gate for non-logged-in users in WooCommerce.
 * Version: 1.0
 * Author: Xplodman <a.elsayed.it@gmail.com>
 * Author URI: https://github.com/xplodman
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

// Function to hide price and remove "Add to Cart" button.
function custom_hide_price_and_cart() {
	// Check if the user is not logged in.
	if ( ! is_user_logged_in() ) {
		// Hide the price on single product pages.
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		// Remove the "Add to Cart" button on single product pages.
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

		// Hide the price on archive (product listing) pages.
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		// Remove the "Add to Cart" button on archive (product listing) pages.
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		// Add gate for non-logged-in users before adding to the cart.
		add_filter( 'woocommerce_is_purchasable', 'custom_check_cart_permission', 10, 2 );
	}
}

// Function to check cart permission.
function custom_check_cart_permission( $purchasable ): bool {
	// Check if the user is not logged in.
	if ( ! is_user_logged_in() ) {
		// Prevent adding to the cart for non-logged-in users.
		return false;
	}

	return (bool) $purchasable;
}

// Hook the functions to the appropriate actions.
add_action( 'wp', 'custom_hide_price_and_cart' );

