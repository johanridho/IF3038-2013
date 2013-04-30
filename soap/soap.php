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
//    if ($_FILES["avatar"]["error"] > 0) {
//        $avatar="images/niouw.JPG";
//    } else {
//        if(move_uploaded_file($_FILES["avatar"]["tmp_name"], "avatars/".$username.".jpg")) {
//            $avatar="avatars/".$username.".jpg";
//        } else {
//            $avatar="images/niouw.JPG";
//        }
//    }
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




$POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($POST_DATA);
?>