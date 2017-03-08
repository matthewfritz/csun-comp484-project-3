<?php

/*
 * removeCartItem.php
 * Handles removing a product from the user's cart
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// only allow access to this page upon login
if(!Authentication::check()) {
	redirect('login.php');
}

// only remove an item if there was a cart ID specified
if(isset($_POST['cart_item_id'])) {
	// remove the product from the session
	if(!empty($_SESSION['cart'])) {
		$item = $_SESSION['cart'][$_POST['cart_item_id']];

		// let the user know the item has been removed
		session([
			'message' => $item->display_name . " has been removed from your cart",
		]);

		// remove the product
		unset($_SESSION['cart'][$_POST['cart_item_id']]);
	}
}

// redirect back to the cart
redirect("cart.php");