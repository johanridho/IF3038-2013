<?php
include 'session.php';
include 'database.php';

$filter = $_POST['filter'];
$string = $_POST['string'];
$start = $_POST['start'];
$next = intval($start) + 10;

if (strcmp($filter,"User") == 0) {
	$qres = mysqli_query($con, "SELECT * 
							FROM members 
							WHERE username LIKE '%$string%' 
							OR email LIKE '%$string%' 
							OR fullname LIKE '%$string%' 
							OR about LIKE '%$string%' 
							LIMIT $start, 10");
	$count = mysqli_num_rows($qres);
	if ($count > 0) {
		while ($row=mysqli_fetch_array($qres)) {
			echo '<div class="judul">';
			echo '<img class="search-img" align="middle" src="'.$row['avatar'].'" alt="avatar" height="150" />';
			echo '<a href = "profile.php?id='.$row['id'].'">'.$row['username']."</a>";
			echo '</div>';
		}
		echo '<input type="button" value="More" onclick="search_more('."'User'".",'".$string."'".','.$next.');this.style.display=\'none\'">';
	}
} else if (strcmp($filter,"Category") == 0) {
	$qres = mysqli_query($con, "SELECT * 
							FROM categories 
							WHERE name LIKE '%$string%' 
							LIMIT $start, 10");
	$count = mysqli_num_rows($qres);
	if ($count > 0) {
		while ($row = mysqli_fetch_array($qres)) {
			echo '<div class="judul">'.$row['name'].'</div>';
			echo '<div class="detail">';
			$cat_id = $row['id'];
			$tasks = mysqli_query($con, "SELECT * 
									FROM tasks 
									WHERE category=$cat_id");
			if (mysqli_num_rows($tasks) > 0) {
				echo "<li><a href='rinciantugas.php?id=".$task['id']."'>".$task['name']."</a></li>";
			}
			echo '</div>';
		}
		echo '<input type="button" value="More" onclick="search_more('."'Category'".",'".$string."'".','.$next.');this.style.display=\'none\'">';
	}
} else if (strcmp($filter,"Content") == 0) {
	mysqli_query($con, "CREATE VIEW task_tags AS SELECT tasks.*, tags.name as tag FROM tasks, tags WHERE tasks.id = tags.tagged");
	$qres = mysqli_query($con, "SELECT DISTINCT id, name, creator, timestamp, deadline, category FROM task_tags WHERE name LIKE '%$q%' OR tag LIKE '%$q%' LIMIT 0, 10");
	$count = mysqli_num_rows($qres);
	if ($count > 0) {
		while ($row=mysqli_fetch_array()) {
			echo '<div class="judul">';
			echo '<a href="rinciantugas.php?id='.$row['id'].'">'.$row['name'].'</a>';
			echo '</div>';
			echo '<div class="detail">';
			echo '<div>';
			echo 'Deadline :';

			echo 'Tags :';
			$task_id = $row['id'];
			$tags = mysqli_query($con, "SELECT name FROM tags WHERE tagged=$task_id");
			$tag = mysqli_fetch_array($tags);
			echo $tag['name'];
			while ($tag=mysqli_fetch_array($tags)) {
				echo ", ".$tag['name'];
			}
			echo '</div>';
			echo '<div class="dkonten-clear">';
			echo '</div>';
			echo '</div>';
		}
		echo '<input type="button" value="More" onclick="search_more('."'Content'".",'".$q."'".','.$next.');this.style.display=\'none\'">';
		echo '</div>';
	}
	// mysqli_query($con, "DROP VIEW task_tags");
} 

mysqli_close($con);
?>