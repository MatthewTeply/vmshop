<?php
	include 'computers.inc.php';
	include 'users.inc.php';
?>

<link rel="stylesheet" type="text/css" href="CSS/list.css">

<?php include 'pages/header.php'; ?>

<div class="wrapper">
	<div class="container">

		<?php if (!isset($_GET['usr']) || $_GET['usr'] == inc_getId_user($_SESSION['vmshop_uid'])): ?>

			<section>
				<h4>Vytvořit</h4>
				<form id="setComputer_form" method="POST" action="computers.inc.php">
					<span>
						<input type="text" name="name" placeholder="Jméno počítače"><br>
						<input type="text" name="tasks" placeholder="Co je potřeba (oddělit čárkami)"><br>
						<input type="hidden" name="who" value="">
						<textarea name="comments" placeholder="Komentáře" cols="80" rows="14"></textarea><br>
						<button name="setComputer_subm" class="bttn_focus">Vložit</button>
					</span>
				</form>
			</section>

			<section>
				<h4>Počítače</h4>
				<span id="computers_list_latest"></span>
				<span id="computers_list">
					<?php inc_getComputer("", "content", ""); ?>
				</span>
			</section>
		<?php endif ?>

		<?php if (isset($_GET['usr']) && $_GET['usr'] != inc_getId_user($_SESSION['vmshop_uid'])): ?>
			
			<h1><?php echo inc_getInfo_user($_GET['usr'], "uid"); ?></h1>

			<section>
				<h4>Vytvořit pro <?php echo inc_getInfo_user($_GET['usr'], "uid"); ?></h4>
				<form id="setComputer_form" method="POST" action="computers.inc.php">
					<span>
						<input type="text" name="name" placeholder="Jméno počítače"><br>
						<input type="text" name="tasks" placeholder="Co je potřeba (oddělit čárkami)"><br>
						<input type="hidden" name="who" value="<?php echo inc_getInfo_user($_GET['usr'], "uid"); ?>">
						<textarea name="comments" placeholder="Komentáře" cols="80" rows="14"></textarea><br>
						<button name="setComputer_subm" class="bttn_focus">Vložit</button>
					</span>
				</form>
			</section>

			<section>
				<h4>Počítače</h4>
				<span id="computers_list_latest"></span>
				<span id="computers_list">
					<?php inc_getComputer("", "content", inc_getInfo_user($_GET['usr'], "uid")); ?>
				</span>
			</section>

		<?php endif ?>

		<script type="text/javascript" src="JS/ajax/computers.ajax.js"></script>
		<script type="text/javascript" src="JS/UI/computers.ui.js"></script>
		
	</div>
</div>
