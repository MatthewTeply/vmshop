<?php
	include 'computers.inc.php';
?>

<link rel="stylesheet" type="text/css" href="CSS/list.css">

<div class="wrapper">
	<div class="container">

		<h1>VMshop - Počítače</h1>
		<?php echo $_SESSION['vmshop_uid']." "; ?>[<a href="users.inc.php?logout">Odhlásit</a>]
		<br>
		
		<section>
			<h4>Vytvořit</h4>
			<form id="setComputer_form" method="POST" action="computers.inc.php">
				<span>
					<input type="text" name="name" placeholder="Jméno počítače"><br>
					<input type="text" name="tasks" placeholder="Co je potřeba (oddělit čárkami)"><br>
					<textarea name="comments" placeholder="Komentáře" cols="80" rows="14"></textarea><br>
					<button name="setComputer_subm">Vložit</button>
				</span>
			</form>
		</section>

		<section>
			<h4>Počítače</h4>
			<span id="computers_list_latest"></span>
			<span id="computers_list">
				<?php inc_getComputer(""); ?>
			</span>
		</section>

		<script type="text/javascript" src="JS/ajax/computers.ajax.js"></script>
		<script type="text/javascript" src="JS/UI/computers.ui.js"></script>
		
	</div>
</div>
