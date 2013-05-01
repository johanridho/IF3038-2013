<?php
include 'session.php';

$rest = "http://phprestsql.ap01.aws.af.cm";

$id = $_POST['id'];
$task = $_POST['task'];

$ch = curl_init($rest."/comments/".$id);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$response = curl_exec($ch);

$result7 = simplexml_load_file($rest."/comments?task=".$task.".xml");
$count_comment = 0;
foreach ($result7 as $child) {
	$commented = simplexml_load_file($rest."/comments/".$child.".xml");
	$comment[$count_comment] = $commented;
	$id_commenter = $commented->member;
	$result8 = simplexml_load_file($rest."/members/".$id_commenter.".xml");
	$commenter[$count_comment] = $result8;
	$count_comment++;
}
// if ($count_comment > 10) $count_comment = 10;
	for ($i = 0; $i < $count_comment; $i++) {
		$current1=$comment[$i];
		$current2=$commenter[$i];
		echo '<div class="komen-avatar"><img src="'.$current2->avatar.'" height="24"/></div>';
		echo '<div class="komen-nama">'.$current2->fullname.'</div>';
		echo '<div class="komen-tgl">'.$current1->timestamp.'</div>';
		echo '<div class="komen-isi">'.$current1->comment.'</div>';
		if ($_SESSION['id'] == (string)$current2->id) {
			echo '<input type="button" name="delete" value="Delete" onclick="delete_comment('.$id_task.",".$current1->id.')"/>';
		}
		echo '<div class="line-konten"></div>';
	}
	// echo '<input type="button" value="More" onclick="comment_more('.$task->id.',10);this.style.display=\'none\'">';

?>