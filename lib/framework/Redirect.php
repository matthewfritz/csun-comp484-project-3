<?php

/*
 * Redirect.php
 * Handles redirection operations
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

/**
 * Performs a redirect to the location specified by the path parameter.
 *
 * @param string $path The path that should be used for the redirect
 */
function redirect(string $path) {
	header("Location: $path", true);
	exit();
}