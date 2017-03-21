<?php

/*
* Simple database wrapper over the PDO class
*/
class Db {
	// Connection to the database
	private static $connection;

	// Connect to the database using the given credentials
	public static function connect($host, $user, $password, $database) {
		if (!isset(self::$connection)) {
			self::$connection = @new PDO(
				"mysql:host=$host;dbname=$database",
				$user,
				$password
			);
		}
	}

	// Execute a query and return the first row of the result
	public static function queryOne($query, $params)
	{
		$result = self::$connection->prepare($query);
		$result->execute($params);

		return $result->fetch(\PDO::FETCH_ASSOC);
	}

	// Execute a query and return all resulting rows as an associative array
	public static function queryAll($query, $params = array())
	{
        $result = self::$connection->prepare($query);
        $result->execute($params);

        return $result->fetchAll(\PDO::FETCH_ASSOC);
	}

	// Execute a query and return the number of affected rows
	public static function query($query, $params = array())
	{
		$result = self::$connection->prepare($query);
		$result->execute($params);

		return $result->rowCount();
	}

	public static function queryTest($query, $params = array())
	{
		$result = self::$connection->prepare($query);
		$result->execute(array_values($params));
		
		return $result->rowCount();
	}

	// Insert data from an associative array into the database as a new row
	public static function insert($table, $params = array())
	{
        return self::query("INSERT INTO `$table` (`".
        implode('`, `', array_keys($params)).
        "`) VALUES (".str_repeat('?,', sizeof($params)-1)."?)",
                array_values($params));
	}

	// Execute an update and pass data from an associative array to it
	public static function update($table, $values = array(), $condition, $params = array())
	{
        return self::query("UPDATE `$table` SET `".
        implode('` = ?, `', array_keys($values)).
        "` = ? " . $condition,
        array_merge(array_values($values), $params));
	}

	// Return the id of the last inserted row
	public static function getLastId()
	{
        return self::$connection->lastInsertId();
	}
}