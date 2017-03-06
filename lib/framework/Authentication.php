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

	/**
	 * Performs a login operation and returns a boolean that describes whether
	 * the authentication attempt was successful.
	 *
	 * @param string $username The username of the login attempt
	 * @param string $password The password of the login attempt
	 *
	 * @return boolean
	 */
	public static function login(string $username, string $password) : bool {
		// TODO: Implement the body of this method
		return false;
	}

	/**
	 * Performs a logout operation on the logged-in user.
	 */
	public static function logout() {
		if(self::check()) {
			session_destroy_full();
		}
	}

	/**
	 * Returns an object representing the currently logged-in user or NULL if
	 * no user is logged-in.
	 *
	 * @return User|null
	 */
	public static function user() {
		return session('logged_in_user');
	}
}