<?php

require('classes/users.class.php');

function inc_setUser($username, $password) {
	$obj = new User;
	$obj->setUser($username, $password);
}

function inc_getUser($username, $password) {
	$obj = new User;
	$obj->getUser($username, $password);
}

function inc_un_getUser($username) {
	$obj = new User;
	$obj->un_getUser($username);
}

function inc_showUsers() {
	$obj = new User;
	$obj->showUsers();
}

function inc_getInfo_user($id, $opt) {
	$obj = new User;
	return $obj->getInfo_user($id, $opt);
}

function inc_getId_user($username) {
	$obj = new User;
	return $obj->getId_user($username);
}

//Ajax (_call)

//PHP (_subm)
if(isset($_POST['signup_subm']))
	inc_setUser($_POST['uid'], $_POST['pwd']);

if(isset($_POST['login_subm']))
	inc_getUser($_POST['uid'], $_POST['pwd']);

//PHP (GET)
if(isset($_GET['logout']))
	inc_un_getUser($_SESSION['vmshop_uid']);