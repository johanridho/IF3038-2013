<?php
include 'session.php';

$rest = "http://phprestsql.ap01.aws.af.cm";
$task_id = $_POST['deltask'];

$ch = curl_init($rest."/tasks/".$task_id);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$response = curl_exec($ch);
var_dump($response);

header("location:dashboard.php");
?>