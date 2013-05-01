<?php
include 'session.php';
include 'soap.php';

$member = $_POST['id'];
$task = $_POST['task'];
date_default_timezone_set('Asia/Jakarta');
$timestamp = date('Y-m-d H:i:s', time());
$komentar = $_POST['komentar'];

$result = $client->call('commentGan',array('memberComment'=>$member, 'taskComment'=>$task,'timestampComment'=>$timestamp,'komentarComment'=>$komentar));
echo $result;
// header("location:rinciantugas.php?id=".$task);
// echo '<h2>Request</h2>';
// echo '<pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
// echo '<h2>Response</h2>';
// echo '<pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';

// echo '<h2>Debug</h2>';
// echo '<pre>'.htmlspecialchars($client->debug_str, ENT_QUOTES).'</pre>';
?>