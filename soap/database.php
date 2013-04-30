<?php
$services_json = json_decode(getenv("VCAP_SERVICES"),true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];

$username = $mysql_config["username"];
$password = $mysql_config["password"];
$host = $mysql_config["hostname"];
$db_name = $mysql_config["name"];

// Connect to server and select databse.
$con=mysqli_connect($host,$username,$password,$db_name);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
?>