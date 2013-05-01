<?php include 'header.php';?>
<?include 'soap.php';?>

<div id="main">
	<div id="konten">
		<?php
		$q = $_GET['q'];
		$o = $_GET['o'];
		?>
		<div class='atas-search'></div>
		<div class='tengah'>
			<div id='search-judul'>SEARCH RESULT</div>
			<div id='search-keyword'>Keyword: <?php echo $q;?></div>
			<div class='line-konten'></div>
		<?php
        $result = $client->call('searchAllGan',array('qsearch'=>$q, 'osearch'=>$o));
        
        ?>
		<div class='line-konten'></div>
		<?php

		if ((strcmp($o,"All") == 0) || (strcmp($o,"Category") == 0)) {
			$qres = mysqli_query($con, "SELECT * FROM categories WHERE name LIKE '%$q%' LIMIT 0, 10");
			$count = mysqli_num_rows($qres);
			echo "<span id='searchtype'>[Category]</span><br />";
			if ($count == 0) {
				echo "<div id='message'>No ResultsFound</div>";
			} else {
				echo '<div id="result2">';
				while ($row = mysqli_fetch_array($qres)) {
		?>
			<div class='judul'>
				<?php echo $row['name'];?>
			</div>
			<div class='detail'>
				<?php
				$cat_id = $row['id'];
				$tasks = mysqli_query($con, "SELECT * FROM `tasks` WHERE category=$cat_id");
				if (mysqli_num_rows($tasks) > 0) {
					echo "<ol>";
					while ($task = mysqli_fetch_array($tasks)) {
						echo "<li><a href='rinciantugas.php?id=".$task['id']."'>".$task['name']."</a></li>";
					}
					echo "</ol>";
				}
				?>
			</div>
		<?php
				}
				echo '<input type="button" value="More" onclick="search_more('."'Category'".",'".$q."'".',10);this.style.display=\'none\'">';
				echo '</div>';
			}
		}
		?>
		<div class='line-konten'></div>
		<?php

		if (strcmp($o,"All") == 0 || (strcmp($o,"Content") == 0)) {
			mysqli_query($con, "CREATE VIEW task_tags AS SELECT tasks.*, tags.name as tag FROM tasks, tags WHERE tasks.id = tags.tagged");
			$qres = mysqli_query($con, "SELECT DISTINCT id, name, creator, timestamp, deadline, category FROM task_tags WHERE name LIKE '%$q%' OR tag LIKE '%$q%' LIMIT 0, 10");
			$count = mysqli_num_rows($qres);
			echo "<span id='searchtype'>[Content]</span><br />";
			if ($count == 0) {
				echo "<div id='message'>No results found</div>";
			} else {
				echo '<div id="result2">';
				while ($row=mysqli_fetch_array($qres)) {
					$task_id = $row['id'];
					$member_id = $_SESSION['id'];
					$result4=mysqli_query($con,"SELECT * FROM `assignees` WHERE task=$task_id AND member=$member_id");
		?>
			<div class='judul'>
				<a href="rinciantugas.php?id=<?php echo $row['id'];?>"><?php echo $row['name']?></a>
			</div>
			<div class='detail'>
				<div>
					Tanggal deadline : <?php echo $row['deadline']?><br />
					Tags : 
					<?php
					$task_id = $row['id'];
					$tags = mysqli_query($con, "SELECT name FROM tags WHERE tagged=$task_id");
					$tag = mysqli_fetch_array($tags);
					echo $tag['name'];
					while ($tag=mysqli_fetch_array($tags)) {
						echo ", ".$tag['name'];
					}
					if (mysqli_num_rows($result4) > 0)
					{
						$assignee = mysqli_fetch_array($result4);
					?>
					<div id="<?php echo $task_id;?>">
						Status : <strong><?php if ($assignee['finished'] == 1) echo 'Selesai'; else echo 'Belum selesai';?></strong><br />
						<input name="YourChoice" type="checkbox" value="selesai" <?php if($assignee['finished']==1) echo "checked"; ?> onclick="change_status('<?php echo $task_id;?>',<?php echo $assignee['finished'];?>,<?php echo $task_id;?>)"> Selesai
					</div>
					<?php
					}
					?>
				</div>
				<div class='dkonten-clear'>
				</div>
			</div>
		<?php
				}
				echo '<input type="button" value="More" onclick="search_more('."'Content'".",'".$q."'".',10);this.style.display=\'none\'">';
				echo '</div>';
			}
			mysqli_query($con, "DROP VIEW task_tags");
		}
		?>
		</div>
		<div class='bawah-search'></div>
	</div>
</div>

<?php include 'footer.php';?>