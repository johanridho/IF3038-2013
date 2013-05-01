<?php
require_once('lib/nusoap.php');

$server = new soap_server();
$server->configureWSDL('soap','urn:soap');
$server->register('hello', 
	array('name' => 'xsd:string'), 
	array('return' => 'xsd:string'), 
	'urn:soap', 
	'urn:soap#hello', 
	'rpc', 
	'encoded', 
	'Says hello'
);
$server->register('insertCategory', 
	array('name' => 'xsd:string', 'user' => 'xsd:string', 'id' => 'xsd:string'), 
	array('return' => 'xsd:string'), 
	'urn:soap', 
	'urn:soap#insertCategory', 
	'rpc', 
	'encoded', 
	'Insert Category'
);

$server->register('registerGan',
        array('userReg'=>'xsd:string', 'pwdReg'=>'xsd:string','fullnameReg'=>'xsd:string','birthReg'=>'xsd:string','emailReg'=>'xsd:string','avatarReg'=>'xsd:string','genderReg'=>'xsd:string','aboutReg'=>'xsd:string'),
        array('return' => 'xsd:string'), 
        'urn:soap', 
        'urn:soap#registerGan', 
        'rpc', 
        'encoded', 
        'Register'        
        );

$server->register('taskGan',
        array('idTaskGan'=>'xsd:string', 'judulTask'=>'xsd:string','creatorTask'=>'xsd:string','deadlineTask'=>'xsd:string','timeTask'=>'xsd:string','timestampTask'=>'xsd:string','assignee'=>'xsd:string','tag'=>'xsd:string'),
        array('return' => 'xsd:string'), 
        'urn:soap', 
        'urn:soap#taskGan', 
        'rpc', 
        'encoded', 
        'Task'        
        );

$server->register('commentGan',
        array('memberComment'=>'xsd:string', 'taskComment'=>'xsd:string','timestampComment'=>'xsd:string','komentarComment'=>'xsd:string'),
        array('return' => 'xsd:string'), 
        'urn:soap', 
        'urn:soap#taskGan', 
        'rpc', 
        'encoded', 
        'Task'        
        );

$server->register('searchAllGan',
        array('qsearch'=>'xsd:string', 'osearch'=>'xsd:string'),
        array('return' => 'xsd:string'), 
        'urn:soap', 
        'urn:soap#taskGan', 
        'rpc', 
        'encoded', 
        'Task'        
        );

function hello($name)
{
	return 'Hello, '. $name;
}

function registerGan($userReg,$pwdReg,$fullnameReg,$birthReg,$emailReg,$avatarReg,$genderReg,$aboutReg){
    include 'database.php';

    // post data 
    $username=$userReg;
    $password=$pwdReg;
    $fullname=$fullnameReg;
    $birthdate=$birthReg;
    $email=$emailReg;
    $avatar=$avatarReg;
    if ($genderReg=="male") {
        $gender='M';
    } else {
        $gender='F';
    }
    $about=$aboutReg;

    mysqli_query($con,"INSERT INTO `members` (username,password,fullname,birthdate,email,avatar,gender,about) 
                    VALUES ('$username',sha1('$password'),'$fullname','$birthdate','$email','$avatar','$gender','$about')");
    mysqli_close($con);
}

function insertCategory($name, $user, $id)
{
	include 'database.php';

	mysqli_query($con, "INSERT INTO categories (name, creator) 
		VALUES ('$name', $id)");
	
	$CatId = "SELECT id FROM categories WHERE name='$name'";
	$GetCatId = mysqli_query($con, $CatId);

	if (mysqli_num_rows($GetCatId) == 0)
	{
		return 'Add category fail';
	}
	$result = mysqli_fetch_array($GetCatId);
	$idCategory = $result['id'];

	mysqli_query($con, "INSERT INTO editors (member, category) 
		VALUES ($id, $idCategory)");

	$member = array();
	$member = explode(",", $user);
	for ($i = 0; $i < count($member); $i++)
	{
		$current = trim($member[$i]," ");

		$mem = "SELECT * FROM members WHERE username='$current'";
		$getMem = mysqli_query($con, $mem);
		$resulta = mysqli_fetch_array($getMem);
		$idMember = $resulta['id'];

		mysqli_query($con, "INSERT INTO editors (member, category) 
			VALUES ($idMember, $idCategory)");
	}

	mysqli_close($con);

	return 'Add category success';
}

function taskGan($idTaskGan,$judulTask,$creatorTask,$deadlineTask, $timeTask,$timestampTask,$assignee,$tag){
     include 'database.php';
    //$creator = $_SESSION['id'];

    // $mem = "SELECT * FROM tasks WHERE creator='$idTaskGan'";
    //     $getMem = mysqli_query($con, $mem);
    //     $resulta = mysqli_fetch_array($getMem);
    //     $idMember = $resulta['name'];   

    mysqli_query($con, "INSERT INTO tasks (
                    name,
                    creator,
                    deadline,
                    category,
                    timestamp
                    )
                    VALUES (
                        '$judulTask',
                        '$creatorTask',
                        '$deadlineTask $timeTask',
                        '$idTaskGan',
                        '$timestampTask'
                    )");

    $TaskId = "SELECT id FROM tasks WHERE name='$judulTask'";
    $GetTaskId = mysqli_query($con, $TaskId);
    $result = mysqli_fetch_array($GetTaskId);
    $idTask = $result['id'];
   // echo "<br><br>id task : ".$idTask."<br>";

    $member = array();
    $member = explode(",", $assignee);
    $i=1;
    $j=count($member);

   // echo "banyak asignee : ".$j."<br>";

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
                        $creatorTask,
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
        $tagx[$k] = trim($tagx[$k]," ");
        echo "tag ke-".$i." : ".$tagx[$k]."<br>";
        mysqli_query($con, "INSERT INTO tags (
                    name,
                    tagged
                    )
                    VALUES (
                        '{$tagx[$k]}',
                        $idTask
                    )");
        $i++;
      }

    mysqli_query($con, "INSERT INTO attachments (path,filetype,task) VALUES ('$direktori','$file','$idTask')");
//    echo "<br>".$direktori;
//    echo "<br>".$file;
//    echo "<br>".$idTask;

    // header("location:rinciantugas.php?id=".$TaskId);
    mysqli_close($con);
    return $TaskId;
}//end taskGan

function commentGan($memberComment,$taskComment,$timestampComment,$komentarComment){
    
    include 'database.php';
    
    $member=$memberComment;
    $task=$taskComment;
    $timestamp=$timestampComment;
    $komentar=$komentarComment;
    
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
    // if ($count_comment > 10) $count_comment = 10;
    $hasilComment="";
    for ($i = 0; $i < $count_comment; $i++) {
        $current1=$comment[$i];
        $current2=$commenter[$i];
        $hasilComment.='<div class="komen-avatar"><img src="'.$current2['avatar'].'" height="24"/></div>';
        $hasilComment.='<div class="komen-nama">'.$current2['fullname'].'</div>';
        $hasilComment.='<div class="komen-tgl">'.$current1['timestamp'].'</div>';
        $hasilComment.='<div class="komen-isi">'.$current1['comment'].'</div>';
        if ($_SESSION['id'] == $current2['id']) {
            $hasilComment.='<input type="button" name="delete" value="Delete" onclick="delete_comment('.$task.",".$current1['id'].')"/>';
        }
        $hasilComment.='<div class="line-konten"></div>';
    }
    // $hasilComment.='<input type="button" value="More" onclick="comment_more('.$task['id'].',10);this.style.display=\'none\'">';
    mysqli_close($con);
    return $hasilComment;
}

function searchAllGan($qsearch,$osearch){
    include 'database.php';
    $q=$qsearch;
    $o=$osearch;
    $hasilALL="";
        
		if ((strcmp($o, "All") == 0) || (strcmp($o, "User") == 0)) {
			$qres = mysqli_query($con, "SELECT * FROM members WHERE username LIKE '%$q%' OR email LIKE '%$q%' OR fullname LIKE '%$q%' OR about LIKE '%$q%' LIMIT 0, 10");
            
			$count = mysqli_num_rows($qres);
			$hasilALL.= "<span id='searchtype'>[User]</span><br />";
			if ($count == 0) {
				$hasilALL.= "<div id='message'>No results found</div>";
			} else {
				$hasilALL.= '<div id="result1">';
				while ($row=mysqli_fetch_array($qres)) {	
                    $hasilALL.= '<div class="judul">';
                    $hasilALL.=' <img class="search-img" align="middle" src="';
                    $hasilALL.= $row['avatar'];
                    $hasilALL.= ' alt="avatar" height="150" />  ';
                    $hasilALL.= '<a href="profil.php?id=';
                    $hasilALL.= $row['id'];
                    $hasilALL.= '">';
                    $hasilALL.= $row['username'];                
                    $hasilALL.= '</a><br />';
                    $hasilALL.= $row['fullname'];
                    $hasilALL.= '</div>';		
				}
                
				$hasilALL.= '<input type="button" value="More" onclick="search_more('."'User'".",'".$q."'".',10);this.style.display=\'none\'">';
				$hasilALL.= '</div>';
			}
		}
        mysqli_close($con);

        return $hasilALL;
}

$POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($POST_DATA);
?>