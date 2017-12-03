<?php
	include 'computers.inc.php';
	include 'users.inc.php';
?>

<link rel="stylesheet" type="text/css" href="CSS/list.css">

<div class="wrapper">
	<div class="container">

		<h1>vmSHOP - Databáze počítačů</h1>

		<?php if (!isset($_GET['usr'])): ?>
			<?php echo $_SESSION['vmshop_uid']." "; ?>[<a href="users.inc.php?logout">Odhlásit</a>]
			<br>
			
			<?php inc_showUsers(); ?>

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
		<?php else: ?>

			<p><?php echo inc_getInfo_user($_GET['usr'], "uid"); ?></p>

			<section>
				<h4>Vytvořit</h4>
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
