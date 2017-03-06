<?php

/*
 * Developer.php
 * Contains functionality specific to the development of applications.
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

/**
 * Prints out debugging information about the specified variable to the screen.
 *
 * @param mixed $var The variable for which to display information
 */
function debug($var) {
	$output = "";
	if(is_callable($var)) {
		$output = "The variable is a function";
	}
	elseif(is_bool($var)) {
		// represent the boolean as a string so we can display a false value
		// to the screen
		$output = ($var ? "true" : "false");
	}
	else
	{
		// grab the information about the variable as a string
		$output = print_r($var, true);
	}

	// spit out debugging output that uses Bootstrap
	echo <<<OUTPUT
	<div class="col-sm-12">
		<div class="card">
			<h6 class="card-header">DEBUG OUTPUT</h6>
			<div class="card-block">
				<small>
				<pre>{$output}</pre>
				</small>
			</div>
		</div>
	</div>
OUTPUT;
}

/**
 * Prints out debugging information about the specified variable to the screen
 * and halts script execution.
 *
 * @param mixed $var The variable for which to display information.
 */
function debug_stop($var) {
	debug($var);
	exit();
}