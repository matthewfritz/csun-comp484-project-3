<?php

/*
 * completeOrderItem.php
 * Handles the API for marking order items as complete
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../../lib/Initialize.php");

// only allow access to the API upon login
if(!Authentication::check()) {
	die(json_encode(["success" => "false", "error" => "Unauthorized"]));
}

// only baristas should be able to access this API
if(!Authentication::userHasRole('barista')) {
	die(json_encode(["success" => "false", "error" => "Unauthorized"]));
}

// we need an order ID and a product ID
if(empty($_POST['order-id']) || empty($_POST['product-id'])) {
	die(json_encode(["success" => "false", "error" => "Both an order ID and a product ID must be specified"]));
}

// update the database by marking the order item as complete
$result = TsarbucksDatabase::instance()->updateOrderItemCompletion(
	$_POST['order-id'],
	$_POST['product-id'],
	true
);

// print out the result based on the output
$success = (!empty($result) ? "true" : "false");
die(json_encode(["success" => $success]));