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
		$users = Database::instance()->selectWhere('users', [
			['username', '=', $username],
			['password', '=', sha1($password)],
		]);
		if(!empty($users)) {
			$user = $users[0];

			// place the appropriate values into the session
			$uid = env("SESSION_USER_ID", "user_id");
			$u = env("SESSION_USER_OBJ", "user");
			session([
				$uid => $user->user_id,
				$u => $user,
			]);

			// load the user roles into the session
			$roles = Database::instance()->selectWhere('user_roles', [
				['user_id', '=', $user->user_id]
			]);
			$rid = env("SESSION_USER_ROLES", "user_roles");
			session([
				$rid => array_column($roles, "role"),
			]);

			// login was successful
			return true;
		}

		// login failed
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
		return session(env("SESSION_USER_OBJ", "user"));
	}

	/**
	 * Returns whether the currently logged-in user has a specific role.
	 *
	 * @param string $role The name of the role to check
	 * @return boolean
	 */
	public static function userHasRole(string $role) : bool {
		$roles = session(env("SESSION_USER_ROLES", "user_roles"));
		return in_array($role, $roles);
	}
}