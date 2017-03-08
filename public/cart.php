<?php

/*
 * car.php
 * Handles the shopping cart for the application
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// only allow access to the cart upon login
if(!Authentication::check()) {
	redirect('login.php');
}

// only customers should be able to access this page
if(!Authentication::userHasRole('customer')) {
	redirect('index.php');
}

// page title and active menu item
$pageTitle = "My Cart";
$activeMenuItem = "cart";

// include the header code
require_once("layout/header.php");

$totalCost = 0.0;
$totalSize = 0;

// create the table based on the session cart data
if(!empty($_SESSION['cart'])) {
	$table = "<table class=\"table table-hover\">";
	$table .= <<<TABLEHEAD
    <tr>
		<th>Product Name</th>
		<th>Price</th>
		<th>Size (oz)</th>
		<th><span class="sr-only">Action</span></th>
    </tr>
TABLEHEAD;
	foreach($_SESSION['cart'] as $key => $item) {
		$totalCost += $item->price;
		$totalSize += $item->size;

		$table .= <<<TABLEITEM
	<tr>
		<td>{$item->display_name}</td>
		<td>\${$item->price}</td>
		<td>{$item->size}</td>
		<td>
			<form method="POST" action="removeCartItem.php">
				<input type="hidden" name="cart_item_id" value="{$key}" />
				<button class="btn btn-danger"><i class="fa fa-times"></i> Remove from Cart</i></button>
			</form>
		</td>
	</tr>
TABLEITEM;
	}
	$table .= "</table>";

	// landing page code goes here
	echo <<<LEADMARKUP
	<div class="row">
		<div class="col-sm-12">
			${table}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p><strong>Total Cost: \${$totalCost}</strong></p>
			<p><strong>Total Size: {$totalSize} ounces</strong></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form method="POST" action="submitOrder.php">
				<button class="btn btn-primary"><i class="fa fa-thumbs-up"></i> Submit Order</button>
			</form>
		</div>
	</div>
LEADMARKUP;
}
else
{
	echo <<<NOITEMS
		<p>You have nothing in your cart. <a href="menu.php">Buy something</a> or <a href="logout.php">get out</a>.</p>
NOITEMS;
}

// include the footer code
require_once("layout/footer.php");