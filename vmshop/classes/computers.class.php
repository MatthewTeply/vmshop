<?php

include_once 'db.inc.php';
session_start();

class Computer {

	private $conn;

	public function __construct() {

		$this->conn = DBConnection::getDB();
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
				<p><b>".$row['op']."</b> : ".$row['content']." [<i>".$row['cdate']."</i>]</p>
				";
		}
	}

	function showAddons($mid) {
		echo 
			"
			<div class='addons_toggle' id='".$mid."'>
			".$this->getAddons($mid, "num")." dodatků
				<div class='addons_div' id='addons_".$mid."'>";
					$this->getAddons($mid, "content");
		echo "
				</div>
			</div>
			";
	}

	public function setComputer($name, $tasks, $comments) {

		$tasks_array = explode(",", $tasks);
		$done_array = array();

		foreach ($tasks_array as $key) {

			$done_array[$key] = "0";
		}

		$done_string = implode(",", $done_array);
		$cdate = date("Y:m:d");

		/*
		TESTING

		echo "<b>Tasks</b><br>";
		var_dump($tasks_array);
		echo "<br><b>Done</b><br>";
		var_dump($done_array);

		echo "<br><b>Tasks</b><br>";
		echo $tasks;
		echo "<br><b>Tasks string</b><br>";
		echo $done_string;
		*/

		$stmnt = $this->conn->prepare("INSERT INTO computers (name, tasks, done, who, comments, cdate) VALUES (?, ?, ?, ?, ?, ?)");
		$stmnt->bind_param("ssssss", $name, $tasks, $done_string, $_SESSION['vmshop_uid'], $comments, $cdate);

		$stmnt->execute();

		header("Location: index.php?posted=".$name."");
		return true;
	}

	public function getComputer($id, $opt) {

		if(!empty($id)) {
			$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE id=?");
			$stmnt->bind_param("i", $id);
		}
		
		else {
			$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE who=? ORDER BY id desc");
			$stmnt->bind_param("s", $_SESSION['vmshop_uid']);
		}
	
		$stmnt->execute();
		$results = $stmnt->get_result();

		while($row = $results->fetch_assoc()) {

			$cookie_name = "computer_contents_".$row['id']."_hidden";


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

			echo "<p><b>Co je potřeba</b></p>";
			for ($i = 0; $i < sizeof($tasks_array); $i++) {

				if($done_array[$i] == 1)
					echo "[<input type='checkbox' class='task_done' checked='true' id='".$row['id']."-".$tasks_array[$i]."'>] - ".$tasks_array[$i]."<br>";
				else
					echo "[<input type='checkbox' class='task_done' id='".$row['id']."-".$tasks_array[$i]."'>] - ".$tasks_array[$i]."<br>";
			}

			if(!empty($row['comments']))
				echo "<p><b>Komentáře</b></p><div>".$row['comments']."</div>";

			echo
			"
			<p><b>Opravuje : </b>".$row['who']."</p>
			
			</span>
			
			<p></p>
			<div class='computer_controls'>
				<form method='POST' action='computers.inc.php'>
					<button type='button' class='un_setComputer_subm'>Smazat</button>
					<input name='id' type='hidden' value=".$row['id'].">
				</form>
				<button type='button' class='hideComputer' value=".$row['id'].">";
			
			if($row['hidden'] == 1)
				echo "Ukázat";
			else
				echo "Schovat";

			echo"</button>
			<button>Přidat dodatek</button>
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
		else
			$finished = 1;

		$stmnt = $this->conn->prepare("UPDATE computers SET done=?, finished=? WHERE id=?");
		$stmnt->bind_param("sii", $done_string, $finished, $id);			

		$stmnt->execute();

		return $finished;
	}

	public function un_setComputer($id) {

		$stmnt = $this->conn->prepare("SELECT * FROM computers WHERE id=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();
		$results = $stmnt->get_result();

		$row = $results->fetch_assoc();

		if($row['who'] != $_SESSION['vmshop_uid'])
			exit("Nemůžete smazat příspěvky jiného uživatele! [<a href='index.php'>Zpět</a>]");

		$stmnt = $this->conn->prepare("DELETE FROM computers WHERE id=?");
		$stmnt->bind_param("i", $id);

		$stmnt->execute();

		return $row['name'];
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

		$stmnt = $this->conn->prepare("INSERT INTO addons (mid, content, op, cdate)");
		$stmnt->bind_param("isss", $mid, $content, $_SESSION['vmshop_uid'], $cdate);

		$stmnt->execute();

		header("Location: index.php");
	}
}