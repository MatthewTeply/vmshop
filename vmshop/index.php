<?php
	error_reporting(0); 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>VMShop - List</title>
	
	<link rel="stylesheet" type="text/css" href="CSS/root.css">
	<link rel="stylesheet" type="text/css" href="CSS/login.css">

	<script type="text/javascript" src="JS/external/jquery.js"></script>
	<script src="https://use.fontawesome.com/ce5690c480.js"></script>

</head>
<body>

<?php if (!isset($_SESSION['vmshop_uid'])): include 'pages/login.php'; ?>
<?php else: include 'pages/list.php'; ?>
<?php endif ?>

</body>
</html>