<?php
include 'database.php';

// username and password sent from form 
$myusername=$_POST['inputusername']; 
$mypassword=$_POST['inputpass']; 

$result = mysqli_query($con,"SELECT * FROM `members` WHERE username='$myusername' and password=sha1('$mypassword')");

// Mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){

	// Register $_SESSION
	session_start(); 
	$_SESSION['myusername'] = $myusername;
	$row = mysqli_fetch_array($result);
	$_SESSION['id'] = $row['id'];
	$_SESSION['fullname'] = $row['fullname'];
	$_SESSION['birthdate'] = $row['birthdate'];
	$_SESSION['email'] = $row['email'];
	$_SESSION['avatar'] = $row['avatar'];
	$_SESSION['gender'] = $row['gender'];
	$_SESSION['about'] = $row['about'];
	mysqli_close($con);
	header("location:dashboard.php");
}
else {
	mysqli_close($con);
	//header("location:index.php?status=1");
}

?>
