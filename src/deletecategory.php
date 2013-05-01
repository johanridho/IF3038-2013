<?php
include 'session.php';

$rest = "http://phprestsql.ap01.aws.af.cm";

$cat_id = $_POST['id'];
$ch = curl_init($rest."/categories/".$cat_id);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$response = curl_exec($ch);
var_dump($response);

header("location:dashboard.php");
?>