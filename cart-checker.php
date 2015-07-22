<?php

/*
Plugin Name: Cart Checker
Description: Checks cart for products in category and prevents them from being added.
Version: 1.0
Author: Martin Greenwood
Author URI: http://martin-greenwood.co.uk
*/

function check_product_in_cart($passed, $product_id) {

	global $woocommerce;

	// get cart contents and assign to var.
	$cart_content = $woocommerce->cart->get_cart();

	//if car has stuff in do this
	if (!empty($cart_content)) {
	
		// start of the loop that fetches the cart items
		foreach ( $cart_content as $cart_item_key => $values ) {

	    	$_product = $values['data'];

	        $terms = get_the_terms( $_product->id, 'product_cat' );        

			// second level loop search, in case some items have several categories
	        foreach ($terms as $term) {
	           $_categoryid[] = $term->term_id;
	        }

		 }
	    
	    // if the cart is 110
		 if (in_array(110, $_categoryid)) {
	        
	        //category is in cart!
	        $passed = false;
	   		wc_add_notice( 'Sorry, you can only add one membership to your basket.', 'error' );
	        
	    }
	}
	return $passed;
}
//add_action( 'woocommerce_add_to_cart', 'check_product_in_cart', 999, 2 );
add_action( 'woocommerce_add_to_cart_validation', 'check_product_in_cart', 999, 2 );
