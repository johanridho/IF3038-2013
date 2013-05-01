<?php
include 'session.php';

$rest = "http://phprestsql.ap01.aws.af.cm";
//include 'database.php';

$user_id = $_SESSION['id'];
$data = array();

$fullname = $_POST['fullname'];
if (isset($_FILES["avatar"]))
{
	if ($_FILES["avatar"]["error"] <= 0) {
		if (move_uploaded_file($_FILES["avatar"]["tmp_name"], "avatars/".$_SESSION['myusername']."jpg")) {
			$avatar = "avatars/".$_SESSION['myusername']."jpg";
		}
	}
}
$birthdate = $_POST['birthdate'];
$password = $_POST['passwd'];
$cpassword = $_POST['cpasswd'];

if (strcmp($fullname, $_SESSION['fullname']) != 0) {
	// Update full name
	$ch = curl_init($rest."/members/".$user_id);
	$data = array("fullname" => $fullname);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	$response = curl_exec($ch);
	if (!$response) echo 'GAGAL';
	echo $fullname;
	$_SESSION['fullname'] = $fullname;
}

if (isset($avatar)) {
	// Update avatar
	$ch = curl_init($rest."/members/".$user_id);
	$data = array("avatar" => $avatar);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	$response = curl_exec($ch);
	if (!$response) echo 'GAGAL';
	echo $avatar;
	$_SESSION['avatar'] = $avatar;
}

if (strcmp($birthdate, $_SESSION['birthdate']) != 0) {
	// Update birthdate
	$ch = curl_init($rest."/members/".$user_id);
	$data = array("birthdate" => $birthdate);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	$response = curl_exec($ch);
	if (!$response) echo 'GAGAL';
	echo $birthdate;
	$_SESSION['birthdate'] = $birthdate;
}

if (strcmp($password, "") != 0) {
	// Update password
	if (strcmp($password, $cpassword) == 0) {
		// mysqli_query($con, "UPDATE members 
		$ch = curl_init($rest."/members/".$user_id);
		$data = array("password" => sha1($password));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$response = curl_exec($ch);
		if (!$response) echo 'GAGAL';
		echo $password;
	}
}


// mysqli_close($con);
header("location:profil.php");
?>