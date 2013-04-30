<?php
include 'session.php';
include 'database.php';

$cat_id = $_POST['id'];
mysqli_query($con, "DELETE FROM categories 
				WHERE id=$cat_id");

mysqli_close($con);
header("location:dashboard.php");
?>