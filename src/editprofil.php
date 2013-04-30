<?php
include 'session.php';
include 'database.php';

$user_id = $_SESSION['id'];
$fullname = $_POST['fullname'];
if ($_FILES["avatar"]["error"] <= 0) {
	if (move_uploaded_file($_FILES["avatar"]["tmp_name"], "avatars/".$_SESSION['myusername']."jpg")) {
		$avatar = "avatars/".$_SESSION['myusername']."jpg";
	}
}
$birthdate = $_POST['birthdate'];
$password = $_POST['passwd'];
$cpassword = $_POST['cpasswd'];

if (strcmp($fullname, $_SESSION['fullname']) != 0) {
	// Update full name
	mysqli_query($con, "UPDATE members 
					SET fullname='$fullname' 
					WHERE id=$user_id");
	$_SESSION['fullname'] = $fullname;
}

if (isset($avatar)) {
	// Update avatar
	mysqli_query($con, "UPDATE members 
					SET avatar='$avatar' 
					WHERE id=$user_id");
}

if (strcmp($birthdate, $_SESSION['birthdate']) != 0) {
	// Update birthdate
	mysqli_query($con, "UPDATE members 
					SET birthdate='$birthdate' 
					WHERE id=$user_id");
	$_SESSION['birthdate'] = $birthdate;
}

if (strcmp($password, "") != 0) {
	// Update password
	if (strcmp($password, $cpassword) == 0) {
		mysqli_query($con, "UPDATE members 
					SET password=sha1('$password') 
					WHERE id=$user_id");
	}
}

mysqli_close($con);
header("location:profil.php");
?>