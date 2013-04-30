<?php
include 'session.php';
$rest = "http://phprestsql.ap01.aws.af.cm";

$user_id = $_POST['id'];
$cat_id = $_POST['cat'];

$result = simplexml_load_file($rest."/tasks?category=".$cat_id);
foreach ($result as $child) {
	$task = simplexml_load_file($rest."/tasks/".$child.".xml");
	$task_id = $task->id;
	$result1 = simplexml_load_file($rest."/assignees?task=".$task_id."&member=".$user_id.".xml");
	if (isset($result1->row[0]))
	{
		$primary = explode(" ", $result1->row[0]);
		$assignee = simplexml_load_file($rest."/assignees/".$primary[0]."/".$primary[1].".xml");
		echo "<a href='rinciantugas.php?id=".$task->id."'>".$task->name."</a><br />";
		echo "Deadline: <strong>".$task->deadline."</strong><br />";
		$res = simplexml_load_file($rest."/tags?tagged=".$task_id.".xml");
		$count_tag = 0;
		foreach ($res as $child2) {
			$tagged = explode(" ", $child2);
			$tag[$count_tag] = $tagged[0];
			$count_tag++;
		}
		echo "Tag: <strong>";
		for($i = 0; $i < $count_tag; $i++) {
			echo $tag[$i];
			if ($i < $count_tag - 1) echo ",";
		}
		echo "<strong><br />";
		echo "<div id='".$task_id."'>";
		echo "Status: <strong>";
		if ($assignee->finished == 1) echo "Selesai";
		else echo "Belum selesai";
		echo "</strong><br />";
		echo "<input name='YourChoice' type='checkbox' value='selesai' ";
		if ($assignee->finished == 1) echo "checked ";
		echo "onclick=change_status('".$task->id."',".$assignee->finished.",".$task_id.")> Selesai";
		echo "</div>";
		if ($task->creator == $user_id) {
			echo "<form action='deletetask.php' method='post'>";
			echo "<input type='hidden' name='deltask' value='".$task_id."' />";
			echo "<input type='submit' name='submit' value='Delete' />";
			echo "</form>";
		}
	}
	echo "<br />";
}
?>