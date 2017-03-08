<?php

/*
 * menu.php
 * Handles the menu page for the application
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
$pageTitle = "Menu";
$activeMenuItem = "menu";

// include the header code
require_once("layout/header.php");

// create the table based on the data
$data = Database::instance()->selectWhere('products');
$table = "<table class=\"table table-hover\">";
$table .= <<<TABLEHEAD
    <tr>
		<th>Product Name</th>
		<th>Price</th>
		<th>Size (oz)</th>
		<th><span class="sr-only">Action</span></th>
    </tr>
TABLEHEAD;
foreach($data as $item) {
	$table .= <<<TABLEITEM
	<tr>
		<td>{$item->display_name}</td>
		<td>\${$item->price}</td>
		<td>{$item->size}</td>
		<td>
			<form method="POST" action="addCartItem.php">
				<input type="hidden" name="item_id" value="{$item->product_id}" />
				<button class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to Cart</i></button>
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
LEADMARKUP;

// include the footer code
require_once("layout/footer.php");