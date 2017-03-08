<?php

/**
 * TsarbucksDatabase.php
 * Handles the database connectivity specific to the application.
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

class TsarbucksDatabase extends Database
{
	private static $instance;

	/**
	 * Returns the single instance of this class.
	 *
	 * @return TsarbucksDatabase
	 */
	public static function instance() {
		if(empty(self::$instance)) {
			// construct a new instance of this object from the environment variables
			self::$instance = new self(
				env("DATABASE_HOST"),
				env("DATABASE_PORT"),
				env("DATABASE_USER"),
				env("DATABASE_PASS"),
				env("DATABASE_NAME")
			);
		}

		return self::$instance;
	}

	public function retrieveAllOrders($user_id, $ordering="DESC") {
		$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_id $ordering";

		// prepare the statement
		$stmt = $this->prepareStatement($sql);

		return $this->retrieveAll($stmt, [$user_id]);
	}
}