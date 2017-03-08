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

// landing page code goes here
echo <<<LEADMARKUP
	<div class="row">
		<div class="col-sm-12">
			<p>
				<a href="menu.php">Buy something</a> or leave.
			</p>
		</div>
	</div>
LEADMARKUP;

// include the footer code
require_once("layout/footer.php");