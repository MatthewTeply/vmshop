<?php
	error_reporting(0); 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>vmSHOP - List</title>

	<link rel="shortcut icon" type="image/png" href="imgs/logo_01.png"/>
	
	<link rel="stylesheet" type="text/css" href="CSS/root.css">
	<link rel="stylesheet" type="text/css" href="CSS/css/font-awesome.min.css">

	<script type="text/javascript" src="JS/external/jquery.js"></script>
	<script src="https://use.fontawesome.com/ce5690c480.js"></script>

</head>
<body>

<?php 
if(!isset($_SESSION['vmshop_uid']))
	include 'pages/login.php';
else 
	include 'pages/list.php';
?>

</body>
</html>