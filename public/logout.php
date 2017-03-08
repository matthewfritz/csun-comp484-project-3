<?php

/*
 * logout.php
 * Handles the logout functionality
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// only perform the logout operation on a logged-in user
if(Authentication::check()) {
	Authentication::logout();
}

// go back to the home page
redirect("index.php");