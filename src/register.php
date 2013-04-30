<?php
include 'database.php';

// post data 
$username=$_POST["username"];
$password=$_POST["password"];
$fullname=$_POST["nama"];
$birthdate=$_POST["tgl"];
$email=$_POST["email"];
if ($_FILES["avatar"]["error"] > 0) {
	$avatar="images/niouw.JPG";
} else {
	if(move_uploaded_file($_FILES["avatar"]["tmp_name"], "avatars/".$username.".jpg")) {
		$avatar="avatars/".$username.".jpg";
	} else {
		$avatar="images/niouw.JPG";
	}
}
if ($_POST["sex"]=="male") {
	$gender='M';
} else {
	$gender='F';
}
$about=$_POST["about"];

mysqli_query($con,"INSERT INTO `members` (username,password,fullname,birthdate,email,avatar,gender,about) 
				VALUES ('$username',sha1('$password'),'$fullname','$birthdate','$email','$avatar','$gender','$about')");
mysqli_close($con);

header("location:index.php?status=4");

?>
