<?php

include_once 'db.inc.php';
session_start();

class Computer {

	private $conn;

	public function __construct() {

		$this->conn = DBConnection::getDB();
	}

	public function getInfo_computer($id, $opt) {

		$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE id=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();
		$results = $stmnt->get_result();

		$row = $results->fetch_assoc();

		return $row[$opt];
	}

	public function getAddons($mid, $opt) {

		$stmnt = $this->conn->prepare("SELECT * FROM addons WHERE mid=?");
		$stmnt->bind_param("i", $mid);

		$stmnt->execute();
		$results = $stmnt->get_result();

		$numRows = $results->num_rows;

		if($opt == "num")
			return $numRows;

		while($row = $results->fetch_assoc()) {

			if($opt == "content")
				echo 
				"
				<p>[<i>".$row['cdate']."</i>] <b>".$row['op']."</b> : ".$row['content']."</p>
				";
		}
	}

	function showAddons($mid) {
		echo 	
		"
			<div class='addons_toggle' id='".$mid."'><b>
			".$this->getAddons($mid, "num");

		if($this->getAddons($mid, "num") == 1)
			echo " dodatek";
		else if($this->getAddons($mid, "num") < 5)
			echo " dodatky";
		else
			echo " dodatků";

		echo
		" 		
				</b>
				<div class='addons_div' id='addons_".$mid."'>";
					$this->getAddons($mid, "content");
		echo "
				</div>
			</div>
			";
	}

	public function setNotification($type, $item_id, $username) {

		$stmnt = $this->conn->prepare("INSERT INTO notifications (type, item_id, uid) VALUES (?, ?, ?)");
		$stmnt->bind_param("sis", $type, $item_id, $username);

		$stmnt->execute();
	}

	public function setComputer($name, $tasks, $comments, $who) {

		include_once 'users.inc.php';

		//SET COMPUTER

		$tasks_array = explode(",", $tasks);
		$done_array = array();

		foreach ($tasks_array as $key) {

			$done_array[$key] = "0";
		}

		$done_string = implode(",", $done_array);
		$cdate = date("Y:m:d");

		$stmnt = $this->conn->prepare("INSERT INTO computers (name, tasks, done, who, comments, cdate) VALUES (?, ?, ?, ?, ?, ?)");
		
		if(!empty($who))
			$stmnt->bind_param("ssssss", $name, $tasks, $done_string, $who, $comments, $cdate);
		else
			$stmnt->bind_param("ssssss", $name, $tasks, $done_string, $_SESSION['vmshop_uid'], $comments, $cdate);

		$stmnt->execute();

		//GET COMPUTER

		$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE name=? AND who=?");
		$stmnt->bind_param("ss", $name, $_SESSION['vmshop_uid']);

		$stmnt->execute();
		$results = $stmnt->get_result();

		$row = $results->fetch_assoc();

		//SET NOTIFICATION

		$this->setNotification("c", $row['id'], $_SESSION['vmshop_uid']);

		//REDIRECT

		if(!empty($who))
			header("Location: index.php?posted=".$name."&usr=".inc_getId_user($who)."");
		else
			header("Location: index.php?posted=".$name."");
		
		return true;
	}

	public function getComputer($id, $opt, $user) {

		include_once 'users.inc.php';

		if(!empty($id)) {
			$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE id=?");
			$stmnt->bind_param("i", $id);
		}

		else if(!empty($user)) {
			$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE who=? ORDER BY id desc");
			$stmnt->bind_param("s", $user);
		}
		
		else {
			$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE who=? ORDER BY id desc");
			$stmnt->bind_param("s", $_SESSION['vmshop_uid']);
		}
	
		$stmnt->execute();
		$results = $stmnt->get_result();

		while($row = $results->fetch_assoc()) {

			echo
			"
			<article id='computer_".$row['id']."' 
			";

			if($row['finished'] == 1)
				echo "class='computer_finished'";

			echo 
			"
			>
				<h2 style='display:inline-block;'>".$row['name']."</h2><i>".$row['cdate']."</i>
				
				<span id='computer_contents_".$row['id']."' ";

			if($row['hidden'] == 1)
				echo "class='computer_contents_hidden'";

			echo 
			"
			>
			";

			$tasks_array = explode(",", $row['tasks']);
			$done_array = explode(",", $row['done']);

			echo 
			"
			<p><b>Co je potřeba</b></p>
			<ul>
			";
			for ($i = 0; $i < sizeof($tasks_array); $i++) {

				if($done_array[$i] == 1)
					echo "<li>[<input type='checkbox' class='task_done' checked='true' id='".$row['id']."-".$tasks_array[$i]."'>] - ".$tasks_array[$i]."</li>";
				else
					echo "<li>[<input type='checkbox' class='task_done' id='".$row['id']."-".$tasks_array[$i]."'>] - ".$tasks_array[$i]."</li>";
			}

			echo 
			"
			</ul>
			";

			if(!empty($row['comments']))
				echo "<p><b>Komentáře</b></p><div>".$row['comments']."</div>";

			echo
			"
			<p><b>Opravuje : </b>".$row['who']."</p>
			
			</span>
			
			<p></p>
			<div class='computer_controls'>

			";

			if(isset($_GET['usr']) && $_GET['usr'] == inc_getId_user($_SESSION['vmshop_uid']) || !isset($_GET['usr']))
				echo
				"
					<form method='POST' action='computers.inc.php'>
						<input name='id' type='hidden' value=".$row['id'].">
						<button type='submit' class='un_setComputer_subm' name='un_setComputer_subm'>Smazat</button>
					</form>
				";

			echo 
			"
				<button type='button' class='hideComputer' value=".$row['id'].">Schovat/Ukázat</button>
			<button type='button' class='addon_form_toggle' value=".$row['id'].">Přidat dodatek &#9660;</button>
			<br>
			<form method='POST' action='computers.inc.php' id='addon_form_".$row['id']."' style='display:none;'>
				<input type='hidden' name='mid' value=".$row['id'].">
				<textarea name='content' placeholder='Dodatek...' cols='77' rows='5'></textarea>
				<br>
				<button type='submit' class='setAddon_subm bttn_focus' name='setAddon_subm'>Poslat</button>
			</form>
			</div>
			</article>
			";

			if($this->getAddons($row['id'], "num") > 0) {
				
				$this->showAddons($row['id']);
			}

			if($opt == "latest")
				exit();
		}
	}

	public function updateComputer($id, $task_name) {

		$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE id=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();
		$results = $stmnt->get_result();

		$row = $results->fetch_assoc();

		$tasks_array = explode(",", $row['tasks']);
		$done_array = explode(",", $row['done']);

		$key = array_search($task_name, $tasks_array);

		if($done_array[$key] == "0")
			$done_array[$key] = "1";
		else 
			$done_array[$key] = "0";

		$done_string = implode(",", $done_array);

		if(in_array("0", $done_array))
			$finished = 0;
		else {
			$finished = 1;
			$this->setNotification("cf", $id, $_SESSION['vmshop_uid']);
		}

		$stmnt = $this->conn->prepare("UPDATE computers SET done=?, finished=? WHERE id=?");
		$stmnt->bind_param("sii", $done_string, $finished, $id);			

		$stmnt->execute();

		return $finished;
	}

	public function un_setComputer($id) {

		//SELECT COMPUTER

		$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE id=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();
		$results = $stmnt->get_result();

		$row = $results->fetch_assoc();

		if($row['who'] != $_SESSION['vmshop_uid'])
			exit("Nemůžete smazat příspěvky jiného uživatele! [<a href='index.php'>Zpět</a>]");

		//DELETE COMPUTER

		$stmnt = $this->conn->prepare("DELETE FROM computers WHERE id=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();

		//DELETE ADDONS

		$stmnt = $this->conn->prepare("DELETE FROM addons WHERE mid=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();

		//DELETE NOTIFICATIONS

		$stmnt = $this->conn->prepare("DELETE FROM notifications WHERE item_id=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();

		header("Location: index.php?del_succ=".$row['name']."");
	}

	public function toggleComputer($id) {

		$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE id=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();
		$results = $stmnt->get_result();

		$row = $results->fetch_assoc();

		$stmnt = $this->conn->prepare("UPDATE computers SET hidden=? WHERE id=?");
		
		if($row['hidden'] == 0)
			$isHidden = 1;
		else
			$isHidden = 0;

		$stmnt->bind_param("ii", $isHidden, $id);

		$stmnt->execute();

		return $isHidden;
	}

	public function setAddon($mid, $content) {

		$cdate = date("Y:m:d");

		$stmnt = $this->conn->prepare("INSERT INTO addons (mid, content, op, cdate) VALUES (?, ?, ?, ?)");
		$stmnt->bind_param("isss", $mid, $content, $_SESSION['vmshop_uid'], $cdate);

		$stmnt->execute();

		//SET NOTIFICATION

		$this->setNotification("a", $mid, $_SESSION['vmshop_uid']);

		header("Location: index.php");
	}

	public function getNotificationsNumber($number) {

		//GET NUMBER
		$stmnt = $this->conn->prepare("SELECT * FROM notifications");

		$stmnt->execute();
		$results = $stmnt->get_result();

		$numRows = $results->num_rows;

		$numNewRows = $numRows - $number;

		return $numNewRows;
	}

	public function getNotifications($opt, $number) {

		include_once 'users.inc.php';

		$numNewRows = $this->getNotificationsNumber($number);

		//GET NOTIFICATIONS
		if(empty($number)) {
			$stmnt = $this->conn->prepare("SELECT * FROM notifications WHERE uid != ? ORDER BY id desc");
			$stmnt->bind_param("s", $_SESSION['vmshop_uid']);
		}
		else {
			$stmnt = $this->conn->prepare("SELECT * FROM notifications WHERE uid != ? ORDER BY id desc LIMIT ?");
			$stmnt->bind_param("si", $_SESSION['vmshop_uid'], $numNewRows);
		}

		$stmnt->execute();
		$results = $stmnt->get_result();
		
		if($opt == "initial")
			echo "<input type='hidden' id='notifications_number' value='".$this->getNotificationsNumber(0)."'>";

		while($row = $results->fetch_assoc()) {

			$mid = inc_getId_user($row['uid']);

			if($row['type'] == "c")
				echo "<p><a href='index.php?usr=".$mid."'>".$row['uid']."</a> přidal počítač <a href='index.php?usr=".$mid."#computer_".$row['item_id']."'> ".$this->getInfo_computer($row['item_id'], "name")."</a></p>";
			else if($row['type'] == "cf")
				echo "<p><a href='index.php?usr=".$mid."'>".$row['uid']."</a> dokončil počítač <a href='index.php?usr=".$mid."#computer_".$row['item_id']."'> ".$this->getInfo_computer($row['item_id'], "name")."</a></p>";
			else
				echo "<p><a href='index.php?usr=".$mid."'>".$row['uid']."</a> přidal dodatek k <a href='index.php?usr=".$mid."#computer_".$row['item_id']."'> ".$this->getInfo_computer($row['item_id'], "name")."</a></p>";
		}
	}
}