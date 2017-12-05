<link rel="stylesheet" type="text/css" href="CSS/header.css">

<header>
	<a href="index.php"><img src="imgs/logo_01.png"><h3>Databáze počítačů</h3></a>
	<ul>
		<li>
			<i class="fa fa-bell-o" id="notification_toggle"></i><sup id="notification_new"></sup>
			<div id="notification_div">
				<div class="arrow_up"></div>
				<span id="notification_div_content">
					<span id="notification_div_content_new"></span>
					<?php inc_getNotifications("initial", ""); ?>
				</span>
			</div>
		</li>
		<li>
			<i class="fa fa-user-o" id="users_toggle"></i>
			<div id="users_div">
				<div class="arrow_up"></div>
				<span id="user_div_content">
					<?php inc_showUsers(); ?>
				</span>
			</div>
		</li>
		<li><a href="index.php"><?php echo $_SESSION['vmshop_uid']; ?></a></li>
		<li><a href="users.inc.php?logout" class="logout">Odhlásit</a></li>
	</ul>
</header>


<script type="text/javascript" src="JS/UI/header.ui.js"></script>