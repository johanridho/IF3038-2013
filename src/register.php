<?php
include 'soap.php';

// post data 
$username=$_POST["username"];
$password=$_POST["password"];
$fullname=$_POST["nama"];
$birthdate=$_POST["tgl"];
$email=$_POST["email"];
$about=$_POST["about"];
$gender=$_POST["sex"];
if ($_FILES["avatar"]["error"] > 0) {
	$avatar="images/niouw.JPG";
} else {
	if(move_uploaded_file($_FILES["avatar"]["tmp_name"], "avatars/".$username.".jpg")) {
		$avatar="avatars/".$username.".jpg";
	} else {
		$avatar="images/niouw.JPG";
	}
}

$result = $client->call('registerGan',array('userReg' => $username, 'pwdReg' => $password,'fullnameReg' => $fullname, 'birthReg' => $birthdate, 'emailReg' => $email, 'avatarReg' => $avatar, 'genderReg' => $gender, 'aboutReg' => $about));

// header("location:index.php?status=4");
echo '<h2>Request</h2>';
echo '<pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
echo '<h2>Response</h2>';
echo '<pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';

echo '<h2>Debug</h2>';
echo '<pre>'.htmlspecialchars($client->debug_str, ENT_QUOTES).'</pre>';

?>
