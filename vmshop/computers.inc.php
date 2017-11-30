<?php

require('classes/computers.class.php');

function inc_setComputer($name, $tasks, $comments) {
	$obj = new Computer;
	$obj->setComputer($name, $tasks, $comments);
}

function inc_getComputer($id, $opt) {
	$obj = new Computer;
	$obj->getComputer($id, $opt);
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

//Ajax (_call)
if(isset($_POST['getComputer_call']))
	inc_getComputer($_POST['id'], $_POST['opt']);

if(isset($_POST['updateComputer_call']))
	inc_updateComputer($_POST['id'], $_POST['task_name']);

if(isset($_POST['toggleComputer_call']))
	inc_toggleComputer($_POST['id']);

//PHP (_subm)
if(isset($_POST['setComputer_subm']))
	inc_setComputer($_POST['name'], $_POST['tasks'], $_POST['comments']);

if(isset($_POST['un_setComputer_subm']))
	inc_un_setComputer($_POST['id']);

//PHP (GET)
	