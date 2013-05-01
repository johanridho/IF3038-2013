<?php
include 'header.php';

$id_task= $_GET['id'];

// Get task
$task = simplexml_load_file($rest."/tasks/".$id_task.".xml");
$id_creator = $task->creator;

// Get creator
$creator = simplexml_load_file($rest."/members/".$id_creator.".xml");

// Get tags
$result5 = simplexml_load_file($rest."/tags?tagged=".$id_task.".xml");
$count_tag = 0;
foreach ($result5 as $tagged) {
	$temp = explode(" ", $tagged);
	$tag[$count_tag] = $temp[0];
	$count_tag++;
}

// Get attachments
$result6 = simplexml_load_file($rest."/attachments?task=".$id_task.".xml");
$count_attachment = 0;
foreach ($result6 as $child) {
	$attachment[$count_attachment] = simplexml_load_file($rest."/attachments/".$child.".xml");
	$count_attachment++;
}

// Get comments
$result7 = simplexml_load_file($rest."/comments?task=".$id_task.".xml");
$count_comment = 0;
foreach ($result7 as $child) {
	$commented = simplexml_load_file($rest."/comments/".$child.".xml");
	$comment[$count_comment] = $commented;
	$id_commenter = $commented->member;
	$result8 = simplexml_load_file($rest."/members/".$id_commenter.".xml");
	$commenter[$count_comment] = $result8;
	$count_comment++;
}

$id_user = $_SESSION['id'];
$res = simplexml_load_file($rest."/assignees?member=".$id_user."&task=".$id_task.".xml");
$tmp = str_replace(" ", "/", $res->row[0]);
$assignee = simplexml_load_file($rest."/assignees/".$tmp.".xml");
?>
;
<!-- created by Enjella-->
<div id="main">
	<div id="konten">
		<div class="atas">
		</div>
		<div class="tengah">
			<div class="judul">
				<?php echo $task->name;?>
			</div>
			<div class="isi">
			</div>
            
			<div class="detail">
				<div class="byon">
					Posted by <strong><span class="by"><?php echo $creator->username;?></span></strong> on <strong><?php echo $task->timestamp;?></strong>
				</div>
				<div class="byon" id="<?php echo $id_task;?>">
					Status : <strong><?php if ($assignee->finished == 1) echo 'Selesai'; else echo 'Belum selesai';?></strong><br />
					<input name="YourChoice" type="checkbox" value="selesai" <?php if($assignee->finished==1) echo "checked"; ?> onclick="change_status('<?php echo $id_task;?>',<?php echo $assignee->finished;?>,<?php echo $id_task;?>)"> Selesai
				</div>
				<div id="done">
					<br />
					<div class="byon">
						Deadline : <strong><?php echo $task->deadline;?></strong>
					</div>
					<br />
					<div class="byon">
						Assignee : <strong>
						<?php
						unset($assignee);
						// Get assignee
						$result3 = simplexml_load_file($rest."/assignees?task=".$id_task.".xml");
						$count_assignee = 0;
						foreach ($result3 as $child2) {
							$assigned = simplexml_load_file($rest."/assignees/".str_replace(" ", "/", $child2).".xml");
							$id_assignee = $assigned->member;
							$result4 = simplexml_load_file($rest."/members/".$id_assignee.".xml");
							$assignee[$count_assignee] = $result4;
							$count_assignee++;
						}

						for ($i = 0; $i < $count_assignee; $i++) {
							$current=$assignee[$i];
							echo $current->username;
							if ($i < $count_assignee - 1) echo ", ";
						}
						?>
						</strong>
					</div>
					<br />
	                <div class="byon">
						Tag : <strong>
						<?php
						for ($i = 0; $i < $count_tag; $i++) {
							echo $tag[$i];
							if ($i < $count_tag - 1) echo ",";
						}
						?>
						</strong>
					</div>
					<br />
					<?php
					if ($task->creator == $_SESSION['id']) {
					?>
					<div class="count"><input type="button" name="edit" onclick="edit_task()" value="Edit"/></div>
					<?php
					}
					?>
				</div>
				<form id="edit" action="edittask.php" method="post">
					<script type="text/javascript" src="mainpage.js"></script>
					<div class="byon">
						<?php
						$partdead = array();
						$partdead = explode(" ", $task->deadline);
						?>
						<div id="left">
							Deadline : <input type="text" name="inputdeadline" id="form-tgl" value="<?php echo $partdead[0];?>"/>
						</div>
						<div id="caldad">
							<div id="calendar"></div>
							<a href="javascript:showcal(3,2013);void(0);"><img src="images/cal.gif" alt="Calendar" /></a>
						</div>
						Jam: 
						<?php
						$parthour = array();
						$parthour = explode(":", $partdead[1]);
						?>
						<select name="hour">
							<?php
							for ($i = 0; $i < 24; $i++) {
								echo "<option value='".$i."'";
								if ($i == $parthour[0]) {
									echo " selected";
								}
								echo ">".$i."</option>";
							}
							?>
						</select>
						<select name="minute">
							<?php
							for ($i = 0; $i < 60; $i++) {
								echo "<option value='".$i."'";
								if ($i == $parthour[1]) {
									echo " selected";
								}
								echo ">".$i."</option>";
							} 
							?>
						</select>
						<select name="second">
							<?php
							for ($i = 0; $i < 60; $i++) {
								echo "<option value='".$i."'";
								if ($i == $parthour[2]) {
									echo " selected";
								}
								echo ">".$i."</option>";
							} 
							?>
						</select>
					</div>
					<br />
					<div class="byon">
						Assignee : <input type="text" name="inputassignee"
						<?php
						echo " value='";
						for ($i = 0; $i < $count_assignee; $i++) {
							$current=$assignee[$i];
							echo $current->username;
							if ($i < $count_assignee - 1) echo ", ";
						}
						echo "' ";
						?>
						list="user"/>
						<datalist id ="user" />
						<option value = "enjella" />
						<option value = "kevin" />
						<option value = "vincentius" />
						</datalist>
					</div>
					
	                <div class="byon">
						Tag : <input type="text" name="inputtag"
						<?php
						echo " value='";
						for ($i = 0; $i < $count_tag; $i++) {
							echo $tag[$i];
							if ($i < $count_tag - 1) echo ",";
						}
						echo "' ";
						?>
						autocomplete="on"/>
					</div>
					<input type="hidden" name="id" value="<?php echo $id_task;?>" />
                	<div class="count"><input type="submit" name="submit" value="Submit"/></div>
				</form>
                
			</div><br /><br /><br />
			<form action="deletetask.php" method="post">
				<input type="hidden" name="deltask" value="<?php echo $id_task?>" />
				<input type="submit" name="submit" value="Delete" />
			</form>
			<div class="videomode" align="center"> <br> Attachment :
				<?php
				for ($i = 0; $i < $count_attachment; $i++) {
					$current = $attachment[$i];
					if (strcmp($current->filetype,"file") == 0) {
						$pos = strrpos($current->path,"/");
						if ($pos === false) {
							$filename = $current->path;
						} else {
							$filename = substr($current->path,$pos + 1);
						}
				?>
				<a href="<?php echo $current['path'];?>"><?php echo $filename;?></a><br />
				<?php
					} else if (strcmp($current->filetype,"image") == 0) {
				?>
				<img src="<?php echo $current->path;?>" /><br />
				<?php	
					} else if (strcmp($current->filetype,"video") == 0) {
				?>
				<video width="320" height="240" controls src="<?php echo $current->path;?>"></video><br />
				<?php	
					}
				}
				?>
				<!--<a href="images/Up.png" target="images/Up.png">Up.png</a><br><img src="images/gajah.png"></img><br><video width="320" height="240" controls src="images/movie.ogg"></video>-->
				</div>
			<div class="komen">
				<div class="komenjudul">Comments</div>
				<div id="konten-commenter">
					<strong><span id="jmlkomen"><?php echo $count_comment;?></span></strong> comments
				</div>
				<div class="line-konten"></div>
				<div id="komen-tulis"><strong>Tulis Komentar</strong></div>
					<input type="hidden" id="id" name="id" value="<?php echo $_SESSION['id'];?>">
					<input type="hidden" id="task" name="task" value="<?php echo $id_task;?>">
					<textarea id="komentar" name="komentar" rows="3" cols="60" id="form-komen"></textarea>
					<div class="komen-submit"><input type="button" name="submit" value="Submit" onclick="comment();"/></div>
				<div class="line-konten"></div>
				<div id="lkomen">
					<?php
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
				</div>
				
					
				
			</div>
		</div>
		<div class="bawah">
		</div>
	</div>
</div>

<?php include 'footer.php';?>