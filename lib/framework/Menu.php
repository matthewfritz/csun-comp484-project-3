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
	return [
		"home" => ["url" => "#", "text" => "Home"],
		"menu" => ["url" => "#", "text" => "Menu"],
		"orders" => ["url" => "#", "text" => "My Orders"],
	];
}

/**
 * Builds and returns the markup to create the menubar for the application. Takes
 * an optional parameter that will make the specified menu active.
 *
 * @param string $activeItem Optional key of the item to make active
 * @return string
 */
function menubar($activeItem="") : string {
	// build the menu elements and figure out which one should be active
	$items = menuitems();

	// generate the output based on the menu items
	$output = "<ul class=\"navbar-nav\">";
	foreach($items as $key => $item) {
		$class = "nav-item";

		// if the passed item should be active, apply the class
		if($key == $activeItem) {
			$class .= " active";
		}

		// create the markup for the menu item and add it to the output
		$output .= <<<MENUITEM
			<li class="{$class}">
				<a class="nav-link" href="{$item['url']}">{$item['text']}</a>
			</li>
MENUITEM;
	}
	$output .= "</ul>";

	// build and return the markup for the menu bar
	return <<<MENUBAR
	<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
	  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <a class="navbar-brand" href="#">Tsarbucks</a>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    {$output}
	  </div>
	</nav>
MENUBAR;
}