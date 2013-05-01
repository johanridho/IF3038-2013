<?php 
include 'header.php';
if (isset($_GET['id']))
{
	$member_id = $_GET['id'];
}
else
{
	$member_id = $_SESSION['id'];
}
// $result = mysqli_query($con, "SELECT * FROM `members` WHERE id=$member_id");
// $member=mysqli_fetch_array($result);
$member = simplexml_load_file($rest."/members/".$member_id.".xml");
?>

<div id="main">
	<div id="konten">
		<div class="atas">
		</div>
		<div class="tengah">
			<div id="done">
				<div class="judul">
					PROFIL
				</div>
				<div class="isi">
					<img src=<?php echo $member->avatar;?> alt="avatar" width="150"/>
				</div>
				
				<div id="profiledetail">
					<div class="profilefont"> Username		: <?php echo $member->username;?> </div>
					<div class="profilefont"> Nama Lengkap	: <?php echo $member->fullname;?> </div>
					<div class="profilefont"> Tanggal lahir : <?php echo $member->birthdate;?> </div>
					<div class="profilefont"> Email			: <?php echo $member->email;?> </div>
					<div class="profilefont"> Jenis Kelamin : <?php if ($member->gender == 'M') echo 'laki-laki'; else echo 'perempuan';?> </div>
		            <div class="profilefont"> Tugas :<br/>
		            Sudah selesai:
		            <?php 
						// $result1=mysqli_query($con,"SELECT * FROM `assignees` WHERE member=$member_id AND finished=1");
						// $count=mysqli_num_rows($result1);
						// if ($count > 0) {
						// 	echo '<br /><ol>';
						// 	while ($row=mysqli_fetch_array($result1)) {
						// 		$task_id=$row['task'];
						// 		$result2=mysqli_query($con,"SELECT * FROM tasks WHERE id=$task_id");
						// 		$task=mysqli_fetch_array($result2);
						// 		echo '<li><a href="rinciantugas.php?id='.$task_id.'">'.$task['name'].'</a></li>';
						// 	}
						// 	echo '</ol>';
						// }
						$result1 = simplexml_load_file($rest."/assignees?member=".$member_id."&finished=1.xml");
						if (isset($result1->row[0])) {
							echo '<br /><ol>';
							foreach ($result1 as $child) {
								$row = simplexml_load_file($rest."/assignees/".str_replace(" ", "/", $child).".xml");
								$task_id = $row->task;
								$task = simplexml_load_file($rest."/tasks/".$task_id.".xml");
								echo '<li><a href="rinciantugas.php?id='.$task_id.'">'.$task->name.'</a></li>';
							}
							echo '</ol>';
						}
		            ?>
		            Belum selesai:
		            <?php 
						// $result1=mysqli_query($con,"SELECT * FROM `assignees` WHERE member=$member_id AND finished=0");
						// $count=mysqli_num_rows($result1);
						// if ($count > 0) {
						// 	echo '<br /><ol>';
						// 	while ($row=mysqli_fetch_array($result1)) {
						// 		$task_id=$row['task'];
						// 		$result2=mysqli_query($con,"SELECT * FROM tasks WHERE id=$task_id");
						// 		$task=mysqli_fetch_array($result2);
						// 		echo '<li><a href="rinciantugas.php?id='.$task_id.'">'.$task['name'].'</a></li>';
						// 	}
						// 	echo '</ol>';
						// }
			            $result1 = simplexml_load_file($rest."/assignees?member=".$member_id."&finished=0.xml");
						if (isset($result1->row[0])) {
							echo '<br /><ol>';
							foreach ($result1 as $child) {
								$row = simplexml_load_file($rest."/assignees/".str_replace(" ", "/", $child).".xml");
								$task_id = $row->task;
								$task = simplexml_load_file($rest."/tasks/".$task_id.".xml");
								echo '<li><a href="rinciantugas.php?id='.$task_id.'">'.$task->name.'</a></li>';
							}
							echo '</ol>';
						}
		            ?>
		            </div>
					<div class="profilefont"> About me		: <?php echo $member->about;?> </div>
					<?php
					if ($member->id == $_SESSION['id'])
					{
					?>
					<div class="register-submit"><input type="button" name="register" value="Edit" id="form-button" onclick="edit_task();" /></div>
					<?php
					}
					?>
				</div>
			</div>
			<form id="edit" enctyp="multipart/form-data" action="editprofil.php" method="post">
				<script type="text/javascript" src="mainpage.js"></script>
				Change fullname: <input type="text" name="fullname" value="<?php echo $_SESSION['fullname']?>"/><br />
				Upload new avatar: <input type="file" name="avatar"/ ><br />
				<div id="left">
					Change birth date: <input type="text" name="birthdate" id="form-tgl" value="<?php echo $_SESSION['birthdate'];?>" />
				</div>
				<div id="caldad">
					<div id="calendar"></div>
					<a href="javascript:showcal(3,2013);void(0);"><img src="images/cal.gif" alt="Calendar" /></a>
				</div><br /><br />
				Change password: <input type="password" name="passwd" /><br />
				Confirm change password: <input type="password" name="cpasswd" /><br />
				<input type="submit" name="submit" value="Submit" />
			</form>
			
		<div class="bawah">
		</div>
	</div>
</div>
		
<?php include 'footer.php';?>