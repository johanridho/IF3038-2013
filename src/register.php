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
$avatar=$_POST["avatar"];

$result = $client->call('registerGan',array('userReg' => $username, 'pwdReg' => $password,'$fullnameReg' => $fullname, 'birthReg' => $birthdate, 'emailReg' => $email, 'birthReg' => $birthdate, 'genderReg' => $gender, 'aboutReg' => $about));

//header("location:index.php?status=4");

?>
