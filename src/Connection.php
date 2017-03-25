<?php

	namespace DC;

	abstract class Connection
	{
		protected static $_conn;
		private function __construct(){};
		private function __clone(){};
		private function __wakeup(){};
		abstract public function set($host, $user, $pass, $db, $port = false) {}

		public function get() 
		{
			return self::$_conn;
		}

		public static function getInstance()
		{
			return self::$instance===null
			? self::$instance = new static()
			: self::$instance;
		}
	}