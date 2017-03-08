<?php

/*
 * addCartItem.php
 * Handles adding a product to the user's cart
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// only allow access to this page upon login
if(!Authentication::check()) {
	redirect('login.php');
}

// only add an item if there was an ID specified
if(!empty($_POST['item_id'])) {
	// grab the product with that item ID
	$product = Database::instance()->selectWhere('products', [['product_id', '=', $_POST['item_id']]]);

	// add the product into the session
	if(empty($_SESSION['cart'])) {
		$_SESSION['cart'] = [];
	}
	$_SESSION['cart'][] = $product[0];

	// let the user know the item has been added
	session([
		'message' => $product[0]->display_name . " has been added to your cart",
	]);
}

// redirect back to the menu
redirect("menu.php");