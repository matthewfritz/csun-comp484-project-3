<?php

/*
 * Menu.php
 * Handles the display of the application menu bar
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

/**
 * Returns the set of menu items as a multidimensional array.
 *
 * @return array
 */
function menuitems() : array {
	$left =  [
		"home" => ["url" => "index.php", "text" => "Home", "icon" => "fa fa-home"],
	];
	$right = [];

	// add the relevant items on the left portion for an authenticated user
	if(Authentication::check()) {
		if(Authentication::userHasRole('customer')) {
			$left["menu"] = ["url" => "menu.php", "text" => "Menu", "icon" => "fa fa-book"];
			$left["orders"] = ["url" => "myOrders.php", "text" => "My Orders", "icon" => "fa fa-archive"];
		}
		else if(Authentication::userHasRole('barista')) {
			$left["orders"] = ["url" => "pendingOrders.php", "text" => "Pending Orders", "icon" => "fa fa-book"];
		}
	}

	// display a different menu item based on whether the user has authenticated
	// successfully
	if(Authentication::check()) {
		// everybody gets the welcome text
		$right['account'] = [
			"url" => "account.php", "text" => "Welcome, " . Authentication::user()->display_name . "!", "static" => "static",
		];

		//  only customers should get a cart item
		if(Authentication::userHasRole('customer')) {
			$cartCount = (!empty($_SESSION['cart']) ? count($_SESSION['cart']) : 0);

			$countMarkup = ($cartCount > 0 ? "<span class=\"badge badge-pill badge-primary\">{$cartCount}</span>" : "");

			$right['cart'] = [
				"url" => "cart.php", "text" => "My Cart $countMarkup", "icon" => "fa fa-shopping-cart",
			];
		}

		// everybody gets a logout link
		$right['auth'] = [
			"url" => "logout.php", "text" => "Logout", "icon" => "fa fa-sign-out",
		];
	}
	else
	{
		$right['auth'] = [
			"url" => "login.php", "text" => "Login", "icon" => "fa fa-sign-in",
		];
	}

	// return the set of items
	return [
		'left' => $left,
		'right' => $right
	];
}

/**
 * Builds and returns the markup to create the menubar for the application. Takes
 * an optional parameter that will make the specified menu active.
 *
 * @param string $activeItem Optional key of the item to make active
 * @return string
 */
function menubar($activeItem="home") : string {
	// build the menu elements and figure out which one should be active
	$items = menuitems();

	// create the menu output for the active element and the left/right sides
	// of the menu bar
	$output = generateMenuOutput($items['left'], $activeItem, "navbar-nav mr-auto");
	$output .= generateMenuOutput($items['right'], $activeItem, "navbar-nav my-2 my-lg-0");

	// grab the application title
	$appTitle = env("APP_TITLE", "My Application");

	// build and return the markup for the menu bar
	return <<<MENUBAR
	<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
	  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <a class="navbar-brand" href="#">{$appTitle}</a>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    {$output}
	  </div>
	</nav>
MENUBAR;
}

/**
 * Generates and returns the menu elements based on the items, the active item,
 * and the CSS classes to apply to the menu.
 *
 * @param array $items The array of items to build in the menu portion
 * @param string $activeItem The key of the item to make active
 * @param string $menuClasses The CSS classes to apply to the menu element
 *
 * @return string
 */
function generateMenuOutput(
	array $items, string $activeItem, $menuClasses="navbar-nav") : string {
	$output = "";

	// generate the output based on the menu items if there are menu items
	// to add to the navigation
	if(!empty($items)) {
		$output .= "<ul class=\"{$menuClasses}\">";
		foreach($items as $key => $item) {
			$class = "nav-item";

			// if the passed item should be active, apply the class
			if($key == $activeItem) {
				$class .= " active";
			}

			// if there are additional classes to add, apply them
			if(!empty($item['class'])) {
				$class .= " {$item['class']}";
			}

			// should this list item be a menu link or static text?
			$itemMarkup = "";
			if(!empty($item['static'])) {
				// static text
				$itemMarkup = <<<STATICTEXT
				<span class="navbar-text" style="margin-top:1px">
					{$item['text']}
				</span>
STATICTEXT;
			}
			else
			{
				$icon = (!empty($item['icon']) ? "<i class=\"{$item['icon']}\"></i>" : "");

				// menu item
				$itemMarkup = <<<MENUITEM
				<li class="{$class}">
					<a class="nav-link" href="{$item['url']}">$icon {$item['text']}</a>
				</li>
MENUITEM;
			}

			// create the markup for the menu item and add it to the output
			$output .= $itemMarkup;
		}
		$output .= "</ul>";
	}

	return $output;
}