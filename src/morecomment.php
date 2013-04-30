<?php
include 'session.php';
include 'database.php';

$task = $_POST['task'];
$start = $_POST['start'];
$next = intval($start) + 10;

$result = mysqli_query($con, "SELECT * 
						FROM comments 
						WHERE task=$task 
						ORDER BY timestamp DESC 
						LIMIT $start, 10");
if (mysqli_num_rows($result) > 0) {
	$count_comment = 0;
	while ($commented = mysqli_fetch_array($result)) {
		$comment[$count_comment] = $commented;
		$id_commenter = $commented['member'];
		$result1=mysqli_query($con,"SELECT * FROM members WHERE id=$id_commenter");
		$commenter[$count_comment] = mysqli_fetch_array($result1);
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
	echo '<input type="button" value="More" onclick="comment_more('.$task['id'].','.$next.');this.style.display=\'none\'">';
}

mysqli_close($con);
?>