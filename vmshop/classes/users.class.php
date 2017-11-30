<?php

include_once 'db.inc.php';
session_start();

class User {

	private $conn;

	public function __construct() {

		$this->conn = DBConnection::getDB();
	}

	//SIGNUP
	public function setUser($username, $password) {

		if(empty($username) || empty($password))
			exit("Empty fields! [<a href='index.php'>Back</a>]");

		$hash_password = password_hash($password, PASSWORD_DEFAULT);

		$stmnt = $this->conn->prepare("INSERT INTO users (uid, pwd) VALUES (?, ?)");
		$stmnt->bind_param("ss", $username, $hash_password);

		$stmnt->execute();
	
		header("Location: index.php?signup_success&uid=".$username);
		return true;
	}

	//LOGIN
	public function getUser($username, $password) {

		$stmnt = $this->conn->prepare("SELECT * FROM users WHERE uid=?");
		$stmnt->bind_param("s", $username);

		$stmnt->execute();
		$results = $stmnt->get_result();

		if($results->num_rows == 0)
			exit("Wrong username! [<a href='index.php'>Back</a>]");

		$row = $results->fetch_assoc();

		if(!password_verify($password, $row['pwd']))
			exit("Wrong password! [<a href='index.php'>Back</a>]");

		else {

			$_SESSION['vmshop_uid'] = $row['uid'];
			header("Location: index.php?login&uid=".$username);
		}

		return true;
	}

	//LOGOUT
	public function un_getUser($username) {

		session_unset();
		session_destroy();

		header("Location: index.php?logout&uid=".$username);
		return true;
	}
}