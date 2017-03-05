<?php

/*
 * Session.php
 * Performs various session-handling capabilities for the application
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// initialize the session
session_start();

/**
 * Retrieves or sets data in the session.
 *
 * If the key is an array it will be used to set data into the session as
 * key/value pairs. The function will then return true.
 *
 * If the key is a single value it will be used to retrieve data from the
 * session. If the default parameter has been specified then that will be the
 * value returned if the key cannot be found in the session. If neither case
 * is satisfied then the function will return null.
 *
 * @param array|string $key The key or array to apply for the session operation
 * @param mixed $default Optional default value if the key cannot be found
 *
 * @return mixed|null
 */
function session($key, $default=null) {
	// are we only retrieving a value?
	if(!is_array($key)) {
		// if the key exists in the session return its matching value
		if(isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}

		// if the default value has been modified return that value
		if(!is_null($default)) {
			return $default;
		}

		// key does not exist and default has not been modified so return null
		return null;
	}

	// we are setting a value or values instead
	foreach($key as $k => $v) {
		$_SESSION[$k] = $v;
	}
	return true;
}

/**
 * Removes the value of a session element matching the given key. Returns true
 * if the removal was successful and false otherwise.
 *
 * @return boolean
 */
function session_forget($key) : bool {
	if(isset($_SESSION[$key])) {
		unset($_SESSION[$key]);
		return true;
	}

	return false;
}

/**
 * Performs a full session destruction and purge. This method removes all data
 * in the session, removes the session cookie, and then destroys the session.
 */
function session_destroy_full() {
	// Unset all of the session variables.
	$_SESSION = array();
	// Kill the session by destroying the session
	// cookie
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}
	// Finally, destroy the session itself.
	session_destroy();
}