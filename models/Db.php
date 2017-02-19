<?php

class Db {
	private static $connection;

	public static function connect($host, $user, $password, $database) {
		if (!isset(self::$connection)) {
			self::$connection = @new PDO(
				"mysql:host=$host;dbname=$database",
				$user,
				$password
			);
		}
	}

	public static function queryOne($query, $params)
	{
		$result = self::$connection->prepare($query);
		$result->execute($params);
		return $result->fetch();
	}

	public static function queryAll($query, $params = array())
	{
	        $result = self::$connection->prepare($query);
	        $result->execute($params);
	        return $result->fetchAll();
	}

	public static function query($query, $params = array())
	{
		$result = self::$connection->prepare($query);
		$result->execute($params);
		return $result->rowCount();
	}

	public static function insert($table, $params = array())
	{
	        return self::query("INSERT INTO `$table` (`".
	        implode('`, `', array_keys($params)).
	        "`) VALUES (".str_repeat('?,', sizeof($params)-1)."?)",
	                array_values($params));
	}

	public static function update($table, $values = array(), $condition, $params = array())
	{
	        return self::query("UPDATE `$table` SET `".
	        implode('` = ?, `', array_keys($values)).
	        "` = ? " . $condition,
	        array_merge(array_values($values), $params));
	}

	public static function getLastId()
	{
	        return self::$connection->lastInsertId();
	}
}