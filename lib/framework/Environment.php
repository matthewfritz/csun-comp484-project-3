<?php

/**
 * Environment.php
 * Handles the loading of the .env.php file and its inclusion into the environment
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */
class Environment 
{
	/**
	 * Loads the environment file. Returns a boolean determining whether the
	 * file has been loaded correctly.
	 *
	 * @param string $path The path to the environment file
	 * @return boolean
	 */
	public static function loadEnvironmentFile(string $path) : bool {
		// attempt to load the file
		$return = include_once($path);
		if($return !== FALSE) {
			// file was loaded correctly so push everything into the environment
			foreach($return as $key => $value) {
				putenv("{$key}={$value}");
				$_ENV[$key] = $value;
			}
			return true;
		}

		// the file was not loaded properly
		return false;
	}
}

/**
 * Helper function to return the value of an environment variable. Returns the
 * value of the environment variable if it has been set or the default value
 * if the key could not be found; defaults to NULL but can be changed.
 *
 * @param string $key The key of the environment variable to return
 * @param mixed $default Optional default value to return if the key was not found
 *
 * @return mixed|null
 */
function env(string $key, $default=null) {
	// return the value if it exists
	if(isset($_ENV[$key])) {
		return $_ENV[$key];
	}

	// if the default has been modified, return that instead
	if(!is_null($default)) {
		return $default;
	}

	// the value does not exist and the default has not been modified
	return null;
}