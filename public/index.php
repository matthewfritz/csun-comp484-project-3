<?php

/*
 * index.php
 * Handles the landing page for the application
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// page title
$pageTitle = "Home";

// include the header code
require_once("layout/header.php");

// change the text that should be displayed based on the individual
if(Authentication::check()) {
	if(Authentication::userHasRole('customer')) {
		$tagline = "<a href=\"menu.php\">Buy something</a> or <a href=\"logout.php\">get out</a>.";
	}
	if(Authentication::userHasRole('barista')) {
		$tagline = "<a href=\"pendingOrders.php\">Make something</a> or leave.</a>";
	}
}
else
{
	$tagline = "<a href=\"login.php\">Login</a> or leave.</a>";
}

// landing page code goes here
echo <<<LEADMARKUP
	<div class="row">
		<div class="col-sm-12">
			<p>
				$tagline
			</p>
		</div>
	</div>
LEADMARKUP;

// include the footer code
require_once("layout/footer.php");