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

$regisUsername = $_POST['usernameRegis'];
$statusRegisUsername = 0;

//========================================== DB CONNECTION ====================================
	include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){
	$selectRegisUsername = mysqli_query($con, "SELECT 1 FROM users where name = '".$regisUsername."'");	
		
		if (mysqli_num_rows($selectRegisUsername) > 0){
			$statusRegisUsername = 1;
		}
		else{
			$statusRegisUsername = 0;
		}
	}
else{
	die("Connection error: " . mysqli_connect_errno());
}
echo $statusRegisUsername;
?>