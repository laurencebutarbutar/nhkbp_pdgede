<?php
header("Cache-Control: post-check=0, pre-check=0", false);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
date_default_timezone_set('Asia/Jakarta');

function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
    );

    $replace = array(
        '>',
        '<',
        '\\1'
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("sanitize_output"); else ob_start("sanitize_output");
session_start();
$pathClassUsers = "../../assets/class/";
$usersDetailId = $_SESSION['tUsersDetailId'];
$path = null;
$path = $usersDetailId . "_";

$filename = $path.md5(mt_rand()).'.jpg';
$status = (boolean) move_uploaded_file($_FILES['photo']['tmp_name'], '../../assets/img/users/upload/'.$filename);

$response = (object) [
	'status' => $status
];

//========================================== DB CONNECTION ====================================
	include_once $pathClassUsers.'dbConnection.php';
//========================================== DB CONNECTION ====================================
if (!mysqli_connect_errno()){
	$updatePathUsersDetail = mysqli_query($con, "UPDATE t_users_detail SET path_image = '".$filename."' WHERE id = '".$usersDetailId."'");
	$_SESSION['pathImage'] = $filename;
}else{
	die("Connection error: " . mysqli_connect_errno());
}

if ($status) {
	$response->url = '../../assets/img/users/upload/'.$filename;
}

echo json_encode($response);
