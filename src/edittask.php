<?php
include 'session.php';
include 'database.php';

$id_task = $_POST['id'];

$deadlinedate = $_POST['inputdeadline'];
$deadlinehour = $_POST['hour'];
$deadlineminute = $_POST['minute'];
$deadlinesecond = $_POST['second'];
$deadlinestring = $deadlinedate." ".$deadlinehour.":".$deadlineminute.":".$deadlinesecond;

$assignee = $_POST['inputassignee'];
$assignees = array();
$assignees = explode(",",$assignee);
$count_assignee = count($assignees);

$tag = $_POST['inputtag'];
$tags = array();
$tags = explode(",",$tag);
$count_tag = count($tags);

// Update deadline
mysqli_query($con, "UPDATE tasks 
				SET deadline='$deadlinestring'
				WHERE id=$id_task");

// Update assignee
// Delete assignee
$del = mysqli_query($con, "SELECT * 
						FROM assignees 
						WHERE task=$id_task");
if (mysqli_num_rows($del) > 0) {
	while ($try = mysqli_fetch_array($del)) {
		// check user id
		$id_user = $try['member'];
		$check = mysqli_query($con, "SELECT * 
								FROM members 
								WHERE id=$id_user");
		$user = mysqli_fetch_array($check);
		$found = false;
		for ($i = 0; $i < $count_assignee; $i++) {
			$current = $assignees[$i];
			if (strcmp($assignees[$i],$user['username']) == 0) {
				$found = true;
				break;
			}
		}
		if ($found == false) {
			mysqli_query($con, "DELETE FROM assignees 
							WHERE member=$id_user");
		}
	}
}
for ($i = 0; $i < $count_assignee; $i++) {
	$current = $assignees[$i];
	$current = trim($current," ");
	// Get user id
	$check = mysqli_query($con, "SELECT * 
							FROM members 
							WHERE username='$current'");
	$user = mysqli_fetch_array($check);
	$id_user = $user['id'];
	// Check user id
	$check = mysqli_query($con, "SELECT * 
							FROM assignees 
							WHERE member=$id_user 
							AND task=$id_task");
	$exist = mysqli_num_rows($check);
	if ($exist == 0) {
		mysqli_query($con, "INSERT INTO assignees
						VALUES ($id_user,$id_task,0)");
	}
}

// Update tag
// Delete all tags
mysqli_query($con, "DELETE FROM tags 
				WHERE tagged=$id_task");
// Insert tags
for ($i = 0; $i < $count_tag; $i++) {
	$current = $tags[$i];
	$current = trim($current," ");
	mysqli_query($con, "INSERT INTO tags 
					VALUES ('$current',$id_task)");
}

mysqli_close($con);
header("location:rinciantugas.php?id=".$id_task);
?>