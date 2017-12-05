<?php

error_reporting(0); 
require('classes/computers.class.php');

function inc_setComputer($name, $tasks, $comments, $who) {
	$obj = new Computer;
	$obj->setComputer($name, $tasks, $comments, $who);
}

function inc_getComputer($id, $opt, $user) {
	$obj = new Computer;
	$obj->getComputer($id, $opt, $user);
}

function inc_updateComputer($id, $task_name) {
	$obj = new Computer;
	echo $obj->updateComputer($id, $task_name);
}

function inc_un_setComputer($id) {
	$obj = new Computer;
	echo $obj->un_setComputer($id);
}

function inc_toggleComputer($id) {
	$obj = new Computer;
	echo $obj->toggleComputer($id);
}

function inc_setAddon($mid, $content) {
	$obj = new Computer;
	$obj->setAddon($mid, $content);
}

function inc_getNotifications($opt, $number) {
	$obj = new Computer;
	echo $obj->getNotifications($opt, $number);
}

function inc_getNotificationsNumber($number) {
	$obj = new Computer;
	echo $obj->getNotificationsNumber($number);
}

//Ajax (_call)
if(isset($_POST['getComputer_call']))
	inc_getComputer($_POST['id'], $_POST['opt']);

if(isset($_POST['updateComputer_call']))
	inc_updateComputer($_POST['id'], $_POST['task_name']);

if(isset($_POST['toggleComputer_call']))
	inc_toggleComputer($_POST['id']);

if(isset($_POST['getNotifications_call']))
	inc_getNotifications($_POST['opt'], $_POST['number']);

if(isset($_POST['getNotificationsNumber_call']))
	inc_getNotificationsNumber($_POST['number']);

//PHP (_subm)
if(isset($_POST['setComputer_subm']))
	inc_setComputer($_POST['name'], $_POST['tasks'], $_POST['comments'], $_POST['who']);

if(isset($_POST['un_setComputer_subm']))
	inc_un_setComputer($_POST['id']);

if(isset($_POST['setAddon_subm']))
	inc_setAddon($_POST['mid'], $_POST['content']);

//PHP (GET)
	