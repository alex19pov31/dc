<?php

	namespace \DC\Mongo; 

	class Connection extends \DC\Connection
	{
		public static function set($host, $user, $pass, $db, $port = false)
		{
			self::$_conn = new \MongoDB\Client("mongodb://{$user}:{$pass}@{$host}")->$db;
		}

		public static function getCollection($name)
		{
			if(!self::$_conn) return false;

			return self::$_conn->$name;
		}
	}