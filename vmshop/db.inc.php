<?php

class DBConnection {

	private static $instance = null;

	private $conn;

	private function __construct() {
		$this->conn = mysqli_connect("localhost", "root", "", "vmshop");
	}

	public function getDB() {

		if(self::$instance == null)
			self::$instance = new self();

		return self::$instance->conn;
	}
}