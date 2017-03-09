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

	/**
	 * Creates and adds the user order to the database. The items are specified
	 * as an array where the key is the product ID and the value is the quantity.
	 * Returns whether the creation was succesful.
	 *
	 * @param string $userId The ID of the user for whom we are creating the order
	 * @param array $items The array of items to add to the order
	 *
	 * @return boolean
	 */
	public function createOrder($userId, $items) {
		// figure out the most recent order ID and then generate a new one
		$orderObj = $this->max('orders', 'order_id');
		if(!empty($orderObj)) {
			$oid = (int)($orderObj[0]->order_id) + 1;
		}
		else
		{
			$oid = 1;
		}

		// begin the query
		$sql = <<<INSERTSQL
			INSERT INTO orders (order_id, user_id, product_id, quantity)
			VALUES
INSERTSQL;

		$params = [];

		// get all the values from the items
		foreach($items as $pid => $quantity) {
			$sql .= "(?, ?, ?, ?),";

			// prepare the parameters
			$params[] = $oid;
			$params[] = $userId;
			$params[] = $pid;
			$params[] = $quantity;
		}

		// drop off the last comma by performing a substring operation
		$sql = substr($sql, 0, strlen($sql)-1);
		
		// prepare the statement
		$stmt = $this->prepareStatement($sql);

		// execute the data statement and return whether it was successful
		return $this->executeDataStatement($stmt, $params);
	}
}