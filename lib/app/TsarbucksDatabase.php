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

	/**
	 * Retrieves all orders from the provided user ID. An optional parameter can
	 * be specified to change the ordering direction.
	 *
	 * @param string $user_id The user ID of the individual for which to retrieve orders
	 * @param string $ordering Optional parameter to change ordering direction
	 *
	 * @return array|boolean
	 */
	public function retrieveAllOrders(string $user_id, $ordering="DESC") {
		$sql = <<<RETRIEVESQL
			SELECT
				orders.order_id,
				orders.product_id,
				orders.quantity,
				orders.completed,
				products.display_name,
				products.price,
				products.size
			FROM orders
				JOIN products USING (product_id) 
			WHERE orders.user_id = ?
			ORDER BY orders.order_id $ordering
RETRIEVESQL;

		// prepare the statement
		$stmt = $this->prepareStatement($sql);

		return $this->retrieveAll($stmt, [$user_id]);
	}

	/**
	 * Retrieves all pending orders from the database. An optional parameter can
	 * be specified to change the ordering direction.
	 *
	 * @param string $ordering Optional parameter to change ordering direction
	 *
	 * @return array|boolean
	 */
	public function retrievePendingOrders($ordering="DESC") {
		$sql = <<<RETRIEVESQL
			SELECT
				orders.order_id,
				orders.product_id,
				orders.quantity,
				orders.completed,
				products.display_name,
				products.price,
				products.size,
				users.display_name AS user_display_name
			FROM orders
				JOIN products USING (product_id)
				JOIN users USING (user_id)
			WHERE orders.completed = 0
			ORDER BY orders.order_id $ordering
RETRIEVESQL;

		// prepare the statement
		$stmt = $this->prepareStatement($sql);

		return $this->retrieveAll($stmt);
	}

	/**
	 * Updates whether an item in an order has been completed. Returns whether
	 * the update was successful.
	 *
	 * @param int $orderId The ID of the order
	 * @param int $productId The ID of the item
	 * @param boolean $completed True if the item was completed, false otherwise
	 *
	 * @return boolean
	 */
	public function updateOrderItemCompletion($orderId, $productId, $completed) {
		$sql = <<<UPDATESQL
			UPDATE orders
			SET completed = ?
			WHERE order_id = ?
			AND product_id = ?
UPDATESQL;

		// prepare the statement
		$stmt = $this->prepareStatement($sql);

		// execute the data statement and return whether it was successful
		return $this->executeDataStatement($stmt, [
			$completed,
			$orderId,
			$productId
		]);
	}
}