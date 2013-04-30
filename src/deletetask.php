<?php
include 'session.php';
include 'database.php';

$task_id = $_POST['deltask'];
mysqli_query($con, "DELETE FROM tasks
				WHERE id=$task_id");

mysqli_close($con);
header("location:dashboard.php");
?>