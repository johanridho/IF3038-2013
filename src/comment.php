<?php
include 'session.php';
include 'database.php';

$member = $_POST['id'];
$task = $_POST['task'];
date_default_timezone_set('Asia/Jakarta');
$timestamp = date('Y-m-d H:i:s', time());
$komentar = $_POST['komentar'];

mysqli_query($con, "INSERT INTO `comments` (member,task,timestamp,comment) 
				VALUES ($member, $task, '$timestamp', '$komentar')");

$result7=mysqli_query($con,"SELECT * FROM `comments` WHERE task=$task ORDER BY timestamp DESC");
$count_comment = 0;
while ($commented = mysqli_fetch_array($result7)) {
	$comment[$count_comment] = $commented;
	$id_commenter = $commented['member'];
	$result8=mysqli_query($con,"SELECT * FROM members WHERE id=$id_commenter");
	$commenter[$count_comment] = mysqli_fetch_array($result8);
	$count_comment++;
}
if ($count_comment > 10) $count_comment = 10;
for ($i = 0; $i < $count_comment; $i++) {
	$current1=$comment[$i];
	$current2=$commenter[$i];
	echo '<div class="komen-avatar"><img src="'.$current2['avatar'].'" height="24"/></div>';
	echo '<div class="komen-nama">'.$current2['fullname'].'</div>';
	echo '<div class="komen-tgl">'.$current1['timestamp'].'</div>';
	echo '<div class="komen-isi">'.$current1['comment'].'</div>';
	if ($_SESSION['id'] == $current2['id']) {
		echo '<input type="button" name="delete" value="Delete" onclick="delete_comment('.$task.",".$current1['id'].')"/>';
	}
	echo '<div class="line-konten"></div>';
}
echo '<input type="button" value="More" onclick="comment_more('.$task['id'].',10);this.style.display=\'none\'">';

mysqli_close($con);
// header("location:rinciantugas.php?id=".$task);

?>