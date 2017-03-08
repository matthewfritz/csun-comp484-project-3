<?php

/*
 * submitOrder.php
 * Handles the creation of a new order
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// only allow access to the menu upon login
if(!Authentication::check()) {
	redirect('login.php');
}

// only baristas should be able to access this page
if(!Authentication::userHasRole('customer')) {
	redirect('index.php');
}

// let's figure out what's in the session
$session_cart = session("cart");

// an empty cart gets redirected to the My Cart page
if(empty($session_cart)) {
	redirect('cart.php');
}

// let's restructure the session data
$cart = [];
foreach($session_cart as $item) {
	if(!empty($cart[$item->product_id])) {
		// the item already exists in the user's cart so let's increment
		// the quantity of the item
		$cart[$item->product_id]++;
	}
	else
	{
		// the item does not yet exist so let's create it
		$cart[$item->product_id] = 1;
	}
}

// create the order in the database
$result = TsarbucksDatabase::instance()->createOrder(
	Authentication::id(),
	$cart
);

// if the order was successful, send the user to the My Orders page;
// otherwise send the user to the cart
if($result) {
	// clear out the cart session data first
	session_forget('cart');

	session(['message' => 'Your order has been placed successfully']);
	redirect('myOrders.php');
}
else
{
	redirect('cart.php');
}