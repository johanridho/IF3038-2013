<?php 
include 'session.php';
include 'soap.php';

foreach ($_POST as $k => $v) {
	${$k} = $v;
}

$timestamp = date("Y-m-d h:i:s");
echo $timestamp."<br>";
echo "id saya adalah : ".$_SESSION['id']."<br>";
echo "judul 		: ".$judul."<br>"; 
echo "id category 	: ".$id."<br>";
echo "deadline		: ".$deadline."<br>";
echo "jam deadline : ".$time."<br>";
echo "asignee		: ".$asignee."<br>";
echo "tag			: ".$tag."<br>";
$file_name = $_FILES['xxx']['name']; 
$source = $_FILES['xxx']['tmp_name'];
$direktori = "uploads/$file_name"; 
echo "file type		: ".$file."<br>";
echo "file name		: ".$file_name."<br>";
move_uploaded_file($source,$direktori); 

$creator = $_SESSION['id'];

$result = $client->call('taskGan',array('idTaskGan'=>$id, 'judulTask'=>$judul,'creatorTask'=>$creator,'deadlineTask'=>$deadline,'timeTask'=>$time,'timestampTask'=>$timestamp));

//header("location:rinciantugas.php?id=".$TaskId);

?>