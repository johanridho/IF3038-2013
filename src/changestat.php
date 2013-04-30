<?php
include 'session.php';
include 'database.php';

$user = $_SESSION['id'];
$task = $_POST['task'];
$stat = $_POST['stat'];

mysqli_query($con, "UPDATE assignees 
				SET finished=$stat 
				WHERE member=$user 
				AND task=$task");

if ($stat == 1) {
	echo "Status : <strong>Selesai</strong><br />";
	echo "<input name='YourChoice' type='checkbox' value='selesai' checked onclick=change_status('".$task."',".$stat.",".$task.")> Selesai";
} else if ($stat == 0) {
	echo "Status : <strong>Belum selesai</strong><br />";
	echo "<input name='YourChoice' type='checkbox' value='selesai' onclick=change_status('".$task."',".$stat.",".$task.")> Selesai";
}

mysqli_close($con);
?>