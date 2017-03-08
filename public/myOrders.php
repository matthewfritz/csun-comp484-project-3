<?php

/*
 * myOrders.php
 * Handles the My Orders page for the application
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// only allow access to the menu upon login
if(!Authentication::check()) {
	redirect('login.php');
}

// page title and active menu item
$pageTitle = "My Orders";
$activeMenuItem = "orders";

// include the header code
require_once("layout/header.php");

// create the table based on the data
$data = TsarbucksDatabase::instance()->retrieveAllOrders(Authentication::id());
$currentOrderId = -1;
$table = "";

$orderTotal = 0;
$orderSize = 0;

// iterate over the items that have been returned in the table
foreach($data as $item) {
	if($item->order_id != $currentOrderId) {
		// terminate the previous table if it was a real order ID
		if($currentOrderId != -1) {
			// add the summation information to the table
			$table .= <<<TOTALS
				<td colspan="5">
					<div class="pull-right">
					<strong>Total Price:</strong> \$$orderTotal<br />
					<strong>Total Size:</strong> $orderSize oz
					</div>
				</td>
				</table>
			</div>
		</div>
TOTALS;

			// reset the totals
			$orderTotal = 0;
			$orderSize = 0;
		}

		$currentOrderId = $item->order_id;

		// the order has changed, so add the new header and table markup
		$table .= "<div class=\"row\"><div class=\"col-sm-12\">";
		$table .= "<h3>Order {$currentOrderId}</h3>";
		$table .= <<<TABLEMARKUP
			<table class="table table-hover table-bordered">
			<tr>
				<th>Product Name</th>
				<th>Size (oz)</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Status</th>
			</tr>
TABLEMARKUP;
	}

	// add to the running total of the order and size
	$itemPrice = $item->price * $item->quantity;
	$orderTotal += $itemPrice;
	$orderSize += $item->size * $item->quantity;

	// was the order fulfilled?
	if($item->completed) {
		$fulfilled = "<span class=\"badge badge-success\">Complete</span>";
	}
	else
	{
		$fulfilled = "<span class=\"badge badge-default\">Pending</span>";
	}

	// display the information to the table row
	$table .= <<<ROWMARKUP
		<tr>
			<td>{$item->display_name}</td>
			<td>{$item->size}</td>
			<td>{$item->quantity}</td>
			<td>\${$itemPrice}</td>
			<td>{$fulfilled}</td>
		</tr>
ROWMARKUP;
}
if($currentOrderId != -1) {
	// terminate the final table if there were results
	$table .= "</table>";
}

// landing page code goes here
echo $table;

// include the footer code
require_once("layout/footer.php");