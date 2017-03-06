<?php

/*
 * index.php
 * Handles the landing page for the applicaiton
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// include the header code
require_once("layout/header.php");

// landing page code goes here
echo <<<LEADMARKUP
	<div class="row">
		<div class="col-sm-12">
			LANDING PAGE
		</div>
	</div>
LEADMARKUP;

// include the footer code
require_once("layout/footer.php");