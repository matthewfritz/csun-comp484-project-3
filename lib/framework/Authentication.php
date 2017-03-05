<?php

/**
 * Authentication.php
 * Handles authentication functionality
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */
class Authentication
{
	/**
	 * Returns whether a user is logged-in.
	 *
	 * @return boolean
	 */
	public static function check() : bool {
		$loggedIn = session(env("SESSION_USER_ID", "user_id"));
		return !is_null($loggedIn);
	}

	/**
	 * Returns the ID of the logged-in user. Returns null if there is no user
	 * that is currently logged-in.
	 *
	 * @return string|null
	 */
	public static function id() {
		if(self::check()) {
			return session(env("SESSION_USER_ID", "user_id"));
		}

		return null;
	}
}