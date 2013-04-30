<?php
include('./httpful-0.2.0.phar');

$myusername=$_POST['inputusername'];
$mypassword=sha1($_POST['inputpass']);

$uri = "http://phprestsql.ap01.aws.af.cm/members?username=%22".$myusername."%22&password=%22".$mypassword."%22";
$response = \Httpful\Request::get($uri)  
    ->expectsXml()              
    ->send();                   

if (!isset($response->body->{'row'}))
{
	echo "fail";
	header("location:index.php?status=1");
}
else
{
	echo $response->body->{'row'};
	echo "success";
	$uri = "http://phprestsql.ap01.aws.af.cm/members/".$response->body->{'row'};
	$response = \Httpful\Request::get($uri)  
	    ->expectsXml()              
	    ->send();

	session_start();
	$_SESSION['myusername'] = $myusername;
	$_SESSION['id'] = (string)$response->body->{'id'};
	$_SESSION['fullname'] = (string)$response->body->{'fullname'};
	$_SESSION['birthdate'] = (string)$response->body->{'birthdate'};
	$_SESSION['email'] = (string)$response->body->{'email'};
	$_SESSION['avatar'] = (string)$response->body->{'avatar'};
	$_SESSION['gender'] = (string)$response->body->{'gender'};
	$_SESSION['about'] = (string)$response->body->{'about'};
	//header("location:dashboard.php");
}
?>
