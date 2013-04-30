<?php
include 'session.php';
include 'soap.php';

$member = $_POST['id'];
$task = $_POST['task'];
date_default_timezone_set('Asia/Jakarta');
$timestamp = date('Y-m-d H:i:s', time());
$komentar = $_POST['komentar'];

$result = $client->call('commentGan',array('memberComment'=>$member, 'taskComment'=>$task,'timestampComment'=>$timestamp,'komentarComment'=>$komentar));
// header("location:rinciantugas.php?id=".$task);

?>