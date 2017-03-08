<?php

/*
 * login.php
 * Handles the login page for the application
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the library code
require_once("../lib/Initialize.php");

// is the user already logged-in?
if(Authentication::check()) {
	// just redirect back to the home page since the user is already
	// logged-in
	redirect('index.php');
}
else
{
	// check to see whether there was an authentication attempt
	if(!empty($_POST)) {
		if(Authentication::login(
			$_POST['username'],
			$_POST['password']
		)) {
			// successful authentication, so redirect to the home page
			redirect('index.php');
		}
		else
		{
			// prepare the set of errors
			$errors = [
				'Incorrect username / password combination'
			];
		}
	}
}

// page title
$pageTitle = "Login";

// include the header code
require_once("layout/header.php");

// landing page code goes here
echo <<<LEADMARKUP
	<div class="row">
		<div class="col-sm-8 col-md-6 offset-sm-2 offset-md-3">
			<form method="POST" action="{$_SERVER['SCRIPT_NAME']}">
				<div class="form-group">
					<label for="username"><strong>Username</strong></label>
					<input type="text" class="form-control" name="username" id="username" placeholder="Username" />
				</div>
				<div class="form-group">
					<label for="password"><strong>Password</strong></label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" />
				</div>
				<input type="submit" class="btn btn-primary" value="Login" />
			</form>
		</div>
	</div>
LEADMARKUP;

// include the footer code
require_once("layout/footer.php");