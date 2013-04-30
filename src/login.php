<?php
$myusername=$_POST['inputusername'];
$mypassword=sha1($_POST['inputpass']);

$uri = "http://phprestsql.ap01.aws.af.cm/members?username=%22".$myusername."%22&password=%22".$mypassword."%22.xml";
$xml = simplexml_load_file($uri);
if (!isset($xml->row[0]))
{
	echo "fail";
	// header("location:index.php?status=1");
}
else
{
	echo "success";
	$uri = "http://phprestsql.ap01.aws.af.cm/members/".$xml->row[0].".xml";
	$xml = simplexml_load_file($uri);
	session_start();
	$_SESSION['myusername'] = $myusername;
	$_SESSION['id'] = (string)$xml->id;
	$_SESSION['fullname'] = (string)$xml->fullname;
	$_SESSION['birthdate'] = (string)$xml->birthdate;
	$_SESSION['email'] = (string)$xml->email;
	$_SESSION['avatar'] = (string)$xml->avatar;
	$_SESSION['gender'] = (string)$xml->gender;
	$_SESSION['about'] = (string)$xml->about;
	echo $_SESSION['myusername'];
	//header("location:dashboard.php");
}
?>
