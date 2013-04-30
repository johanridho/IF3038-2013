<?php
include 'session.php';
include 'database.php';

$user_id = $_POST['id'];
$cat_id = $_POST['cat'];

$result = mysqli_query($con, "SELECT * 
						FROM tasks 
						WHERE category=$cat_id");
while ($task=mysqli_fetch_array($result)) {
	$task_id = $task['id'];
	$result1 = mysqli_query($con, "SELECT * 
								FROM assignees 
								WHERE task = $task_id 
								AND member = $user_id");
	if (mysqli_num_rows($result1) == 1) {
		$assignee = mysqli_fetch_array($result1);
		echo "<a href='rinciantugas.php?id=".$task['id']."'>".$task['name']."</a></br>";
		echo "Deadline: <strong>".$task['deadline']."</strong><br />";
		$res = mysqli_query($con, "SELECT * 
								FROM tags 
								WHERE tagged = $task_id");
		$count_tag = 0;
		while ($tagged = mysqli_fetch_array($res)) {
			$tag[$count_tag] = $tagged['name'];
			$count_tag++;
		}
		echo "Tag: <strong>";
		for ($i = 0; $i < $count_tag; $i++) {
			echo $tag[$i];
			if ($i < $count_tag - 1) echo ",";
		}
		echo "</strong><br />";
		echo "<div id='".$task_id."'>";
		echo "Status: <strong>";
		if ($assignee['finished'] == 1) echo 'Selesai';
		else echo 'Belum selesai';
		echo "</strong><br />";
		echo "<input name='YourChoice' type='checkbox' value='selesai' ";
		if ($assignee['finished'] == 1) echo "checked ";
		echo "onclick=change_status("."'".$task_id."'".",".$assignee['finished'].",".$task_id.")> Selesai";
		echo "</div>";
		if ($task['creator'] == $user_id) {
			echo "<form action='deletetask.php' method='post'>";
			echo "<input type='hidden' name='deltask' value='".$task_id."' />";
			echo "<input type='submit' name='submit' value='Delete' />";
			echo "</form>";
		}
	}
	echo "<br />";
}

mysqli_close($con);
?>