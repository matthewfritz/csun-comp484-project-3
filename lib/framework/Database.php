<?php

/**
* Database.php
* Wraps a PDO connection to a MySQL database in an abstraction layer as a Singleton.
*
* Author: Matthew Fritz <mattf@burbankparanormal.com>
*/

class Database
{
	private static $instance; // will hold an instance of this class

	private $pdo; // will hold the PDO object

	/**
	 * Constructs a new Database class.
	 *
	 * @param string $host The host to use when connecting
	 * @param string $port The port number to use when connecting
	 * @param string $username The database user account name
	 * @param string $password The database user account password
	 * @param string $database The name of the database
	 */
	private function __construct($host, $port, $username,
		$password, $database) {
		try {
			// attempt to connect to the database through PDO; this also
			// sets-up a persistent connection by default
			$this->pdo = new PDO(
				"mysql:host=${host};port=${port};dbname=${database}",
				$username,
				$password,
				[PDO::ATTR_PERSISTENT => true]
			);
		}
		catch(PDOException $e)
		{
			// prevents a default full stack trace by being caught
			die("Could not connect to database: " . $e->getMessage());
		}
	}

	/**
	 * Returns the single instance of this class.
	 *
	 * @return Database
	 */
	public static function instance() : Database {
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
	 * Returns all records from the specified table name. Returns FALSE
	 * if something has gone wrong.
	 *
	 * @param string $table The name of the table to query
	 * @return array|boolean
	 */
	public function all($table) {
		// executes selectWhere() with no conditional columns to return
		// everything
		return $this->selectWhere($table, []);
	}

	/**
	 * Retrieves the row from the specified table with the largest $column
	 * value. Returns FALSE if something has gone wrong.
	 *
	 * @param string $table The name of the table to query
	 * @param string $column The column name to search
	 *
	 * @return array|boolean
	 */
	public function max($table, $column) {
		// prepare and execute the statement
		$stmt = $this->pdo->prepare(
			"SELECT * FROM $table ORDER BY $column DESC LIMIT 1"
		);
		return $this->retrieveAll($stmt);
	}

	/**
	 * Retrieves the row from the specified table with the largest sum $column
	 * value. Returns FALSE if something has gone wrong.
	 *
	 * @param string $table The name of the table to query
	 * @param string $column The column name for which to calculate the sum
	 * @param string $alias The alias to use for the sum name; default is "total"
	 * @param string $groupBy The column to group the results by; default is "id"
	 *
	 * @return array|boolean
	 *
	 * @example
	 * // Calculate the sum of the 'quantity' column, alias it as 'total', group
	 * // the results by the 'product_id' column, and then return the largest.
	 * // This is equivalent to asking for the ID of most-sold product.
	 * $db->maxSum('sales', 'quantity', 'total', 'product_id');
	 */
	public function maxSum($table, $column, $alias="total", $groupBy="id") {
		// prepare and execute the statement
		$stmt = $this->pdo->prepare(
			"SELECT $groupBy,SUM($column) AS $alias FROM $table GROUP BY 
				$groupBy ORDER BY $alias DESC LIMIT 1"
		);
		return $this->retrieveAll($stmt);
	}

	/**
	 * Retrieves the row from the specified table with the smallest $column
	 * value. Returns FALSE if something has gone wrong.
	 *
	 * @param string $table The name of the table to query
	 * @param string $column The column name to search
	 *
	 * @return array|boolean
	 */
	public function min($table, $column) {
		// prepare and execute the statement
		$stmt = $this->pdo->prepare(
			"SELECT * FROM $table ORDER BY $column ASC LIMIT 1"
		);
		return $this->retrieveAll($stmt);
	}

	/**
	 * Returns all records from the specified table name matching all chained
	 * conditionals from the optional $columns array. Returns FALSE if
	 * something has gone wrong.
	 *
	 * @param string $table The name of the table to query
	 * @param array $columns Optional multidimensional array of three-element column conditionals
	 * @param string $conditional Optional verb for conditionals (default is AND)
	 *
	 * @return array|boolean
	 *
	 * @example
	 * $db->selectWhere('table', [['id', '=', 4]]);
	 * $db->selectWhere('table', [['id', '>', 2], ['id', '<', 5]]);
	 * $db->selectWhere('table', [['price', '>', 5], ['size', '<', 8]], 'OR');
	 */
	public function selectWhere($table, $columns=[], $conditional="AND") {
		// build up the conditionals for the WHERE
		$conditionals = [];
		foreach($columns as $column) {
			// transform the final element in the column array to be a
			// question-mark so we can support a prepared statement
			$column[2] = "?";

			// create the piece of the conditional from this column
			$conditionals[] = implode(" ", $column);
		}

		// figure out the chaining of the conditionals
		$condition = implode(" $conditional ", $conditionals);

		// should a WHERE be prepended?
		if(!empty($conditionals)) {
			$condition = " WHERE $condition";
		}

		// prepare the statement and execute with bound parameters
		$stmt = $this->pdo->prepare(
			"SELECT * FROM ${table}${condition}"
		);

		if(!empty($columns)) {
			// execute with the last parameter of each array element
			// in the columns array
			return $this->retrieveAll($stmt, array_column($columns, 2));
		}
		
		// execute with no bound parameters whatsoever
		return $this->retrieveAll($stmt);
	}

	/**
	 * Executes a prepared statement with a set of optional parameters. Returns
	 * all rows retrieved on success. Returns FALSE on failure.
	 *
	 * @param PDOStatement $stmt The prepared statement object to execute
	 * @param array $params Optional parameters to bind to the statement
	 *
	 * @return array|boolean
	 */
	protected function retrieveAll($stmt, $params=[]) {
		$result = true;

		// parameters passed-in through the second parameter
		// will be used for executing with bound data
		if(!empty($params)) {
			$result = $stmt->execute($params);
		}
		else
		{
			$result = $stmt->execute();
		}

		// if the statement executed successfully, return all of
		// the results
		if($result) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		// something went wrong
		return FALSE;
	}

}