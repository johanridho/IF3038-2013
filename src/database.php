<?php
$username = "uHJZ3eUrQgs6T";
$password = "pawOngDWHEiUy";
$host = "localhost";
$port = "10000";
$db_name = "dde2c0010512a4c50b046f5095425615f";

// Connect to server and select databse.
$con=mysqli_connect($host,$username,$password,$db_name,$port);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
?>