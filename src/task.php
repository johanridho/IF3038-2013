<?php 
include 'session.php';
include 'database.php';

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

$mem = "SELECT * FROM tasks WHERE creator='{$id}'";
	$getMem = mysqli_query($con, $mem);
	$resulta = mysqli_fetch_array($getMem);
	$idMember = $resulta['name'];
	
echo "nama task : ".$idMember;

mysqli_query($con, "INSERT INTO tasks (
				name,
				creator,
				deadline,
				category,
				timestamp
				)
				VALUES (
					'$judul',
					'$creator',
					'$deadline $time',
					'$id',
					'$timestamp'
				)");

$TaskId = "SELECT id FROM tasks WHERE name='{$judul}'";
$GetTaskId = mysqli_query($con, $TaskId);
$result = mysqli_fetch_array($GetTaskId);
$idTask = $result['id'];
echo "<br><br>id task : ".$idTask."<br>";



$member = array();
$member = explode(",", $asignee);
$i=1;
$j=count($member);

echo "banyak asignee : ".$j."<br>";

while($i<=$j)
  {
	$k=$i-1;
  	$member[$k] = trim($member[$k]," ");	
	$mem = "SELECT * FROM members WHERE username='{$member[$k]}'";
	$getMem = mysqli_query($con, $mem);
	$resulta = mysqli_fetch_array($getMem);
	$idMember = $resulta['id'];
	echo "<br>nama member : ".$member[$k]." id : ".$idMember;
	mysqli_query($con, "INSERT INTO assignees (
				member,
				task,
				finished
				)
				VALUES (
					$idMember,
					$idTask,
					0
				)");
	
 	$i++;
  }

mysqli_query($con, "INSERT INTO assignees (
				member,
				task,
				finished
				)
				VALUES (
					$creator,
					$idTask,
					0
				)");

$tagx = array();
$tagx = explode(",", $tag);
$i=1;
$j=count($member);
echo "<br><br>banyak tag [new] : ".$j."<br>";

while($i<=$j)
  {
	$k=$i-1;  
	echo "tag ke-".$i." : ".$tagx[$k]."<br>";
	mysqli_query($con, "INSERT INTO tags (
				name,
				tagged
				)
				VALUES (
					'$tagx[$k]',
					'$idTask'
				)");
	$i++;
  }

mysqli_query($con, "INSERT INTO attachments (path,filetype,task) VALUES ('$direktori','$file','$idTask')");
echo "<br>".$direktori;
echo "<br>".$file;
echo "<br>".$idTask;

header("location:rinciantugas.php?id=".$TaskId);

?>