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
        array('idTaskGan'=>'xsd:string', 'judulTask'=>'xsd:string','creatorTask'=>'xsd:string','deadlineTask'=>'xsd:string','timeTask'=>'xsd:string','timestampTask'=>'xsd:string'),
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

function taskGan($idTaskGan,$judulTask,$creatorTask,$deadlineTask, $timeTask,$timestampTask){
     include 'database.php';
    //$creator = $_SESSION['id'];

    $mem = "SELECT * FROM tasks WHERE creator='{$idTaskGan}'";
        $getMem = mysqli_query($con, $mem);
        $resulta = mysqli_fetch_array($getMem);
        $idMember = $resulta['name'];   

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
                        '$deadline $timeTask',
                        '$idTaskGan',
                        '$timestampTask'
                    )");

    $TaskId = "SELECT id FROM tasks WHERE name='{$judulTask}'";
    $GetTaskId = mysqli_query($con, $TaskId);
    $result = mysqli_fetch_array($GetTaskId);
    $idTask = $result['id'];
   // echo "<br><br>id task : ".$idTask."<br>";

    $member = array();
    $member = explode(",", $asignee);
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
                        $creator,
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
        echo "tag ke-".$i." : ".$tagx[$k]."<br>";
        mysqli_query($con, "INSERT INTO tags (
                    name,
                    tagged
                    )
                    VALUES (
                        '$tagx[$k]',
                        '$idTask'
                    )");
        $i++;
      }

    mysqli_query($con, "INSERT INTO attachments (path,filetype,task) VALUES ('$direktori','$file','$idTask')");
//    echo "<br>".$direktori;
//    echo "<br>".$file;
//    echo "<br>".$idTask;

    header("location:rinciantugas.php?id=".$TaskId);
}//end taskGan


$POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($POST_DATA);
?>