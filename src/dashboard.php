<?php 
include 'header.php';

$xml = simplexml_load_file($rest."/categories.xml");
$cats = 0;
foreach ($xml as $child) {
	$cats++;
}


$id = $_SESSION['id'];
?>
			
<div id="main2">
    <div id ="dashboardcontainer">
        <div id ="staticcomponentlist">
            <div class ="letterpanel">
            <a href="#login_form" id="login_pop">Kategori</a>
            </div>
            <!-- popup form #1 jadi ceritanya awalnya gk keliatan -->
            <a href="#x" class="overlay" id="login_form"></a>
            <div class="popup">
				<form name="add_category" method="post" action="category.php">
					<h2>Tambah Kategori Tugas</h2>
					<!--<h2>Welcome Guest!</h2>
					<p>Please enter your login and password here</p>-->
					<div>
						<label>Nama Kategori &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </label>
						<input type ="text" name="category_name"></input>
					</div>
					<div>
						<label for="password">Pengguna Terkait :</label>
						<input type ="text" name="relateduser"></input>
					</div>
					<input type="hidden" name="creator_id" value="<?php echo $id;?>" />
					<input type="submit" name="btn_addCat" value="Ok" />
				</form>

				<a class="close" href="#close"></a>
            </div>
            <?php
			$xml = simplexml_load_file($rest."/categories.xml");
			foreach ($xml as $child) {
				$found = false;
				$cat = simplexml_load_file($rest."/categories/".$child.".xml");
				$cat_id = $cat->id;
				$xml2 = simplexml_load_file($rest."/tasks?category=".$cat_id.".xml");
				foreach ($xml2 as $child2) {
					$task = simplexml_load_file($rest."/tasks/".$child2.".xml");
					$task_id = $task->id;
					$xml3 = simplexml_load_file($rest."/assignees?member=".$id."&task=".$task_id);
					if (!isset($xml3->row[1])) {
            ?>
            <br /><div onclick="javascript:gettask(<?php echo $_SESSION['id'];?>,<?php echo $cat->id;?>);"><a href="#"><?php echo $cat->name;?></a></div>
            <?php
			         	$xml3 = simplexml_load_file($rest."/editors?member=".$id."&category=".$cat_id.".xml");
			        	if (!isset($xml3->row[1])) {
        	?>
            <a href ="post.php?id=<?php echo $cat->id;?>"><input id ="newtask" type="button" name="Tugas Baru" value="New Task"/></a>
            <?php
            				if ($cat->creator == $id) {
            ?>
            <form action="deletecategory.php" method="post">
            	<input type="hidden" name="id" value="<?php echo $cat->id;?>" />
            	<input type="submit" value="Delete Category" />
            </form>
            <?php
            				} else {
            					echo "<br />";
            				}
        				}
            			$found = true;
            			break;
        			}
        		}
        		if ($found == false) {
        			$xml3 = simplexml_load_file($rest."/editors?member=".$id."&category=".$cat_id.".xml");
        			if (!isset($xml3->row[1])) {
        	?>
        	<br /><div onclick="javascript:gettask(<?php echo $_SESSION['id'];?>,<?php echo $cat->id;?>);"><a href="#"><?php echo $cat->name;?></a></div>
            <a href ="post.php?id=<?php echo $cat->id;?>"><input id ="newtask" type="button" name="Tugas Baru" value="New Task"/></a><br />
            <?php
            			if ($cat->creator == $id) {
            ?>
            <form action="deletecategory.php" method="post">
            	<input type="hidden" name="id" value="<?php echo $cat->id;?>" />
            	<input type="submit" value="Delete Category" />
            </form>
            <?php
            			} else {
            				echo "<br />";
            			}
        			}
        		}
			}
            ?>
        </div>
        <div id="rincian">
			<?php
			$getcat = simplexml_load_file($rest."/categories.xml");
			foreach ($getcat as $child3) {
				$temp = simplexml_load_file($rest."/categories/".$child3.".xml");
				$idc = $temp->id;
				$xml3 = simplexml_load_file($rest."/tasks?category=".$idc.".xml");
				foreach ($xml3 as $child4) {
					$task = simplexml_load_file($rest."/tasks/".$child4.".xml");
					$task_id = $task->id;
					$xml4 = simplexml_load_file($rest."/assignees?task=".$task_id."&member=".$id.".xml");
					if (isset($xml4->row[0])) {
						$primary = explode(" ", (string)$xml4->row[0]);
						$assignee = simplexml_load_file($rest."/assignees/".$primary[0]."/".$primary[1].".xml");
			?>
			<br /><a href="rinciantugas.php?id=<?php echo $task->id;?>"><?php echo $task->name;?></a><br />
			Deadline: <strong><?php echo $task->deadline;?></strong><br />
			<?php
						$res = simplexml_load_file($rest."/tags?tagged=".$task_id.".xml");
						$count_tag = 0;
						foreach ($res as $tagged) {
							$tagatt = explode(" ", $tagged);
							$tag[$count_tag] = $tagatt[0];
							$count_tag++;
						}
			?>
			Tag: <strong>
			<?php
						for ($i = 0; $i < $count_tag; $i++) {
							echo $tag[$i];
							if ($i < $count_tag - 1) echo ",";
						}
			?>
			</strong>
			<br />
			<div id="<?php echo $task_id;?>">
				Status : <strong><?php if ($assignee->finished == 1) echo 'Selesai'; else echo 'Belum selesai';?></strong><br />
				<input name="YourChoice" type="checkbox" value="selesai" <?php if($assignee->finished==1) echo "checked"; ?> onclick="change_status('<?php echo $task_id;?>',<?php echo $assignee->finished;?>,<?php echo $task_id;?>)"> Selesai
			</div>
			<?php
						if ($task->creator == $id) {
			?>
			<form action="deletetask.php" method="post">
				<input type="hidden" name="deltask" value="<?php echo $task_id?>" />
				<input type="submit" name="submit" value="Delete" />
			</form>
			<?php
						}
					}
				}
			}
			?>
            
		</div>
	</div>
	
<?php include 'footer.php';?>
