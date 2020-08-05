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

$regisPhone = $_POST['phoneRegis'];
$statusRegisPhone = 0;

//========================================== DB CONNECTION ====================================
	include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){
	$selectRegisPhone = mysqli_query($con, "SELECT 1 FROM t_users_detail where phone = '0".$regisPhone."'");	
		if (mysqli_num_rows($selectRegisPhone) > 0){
			$statusRegisPhone = 1;
		}else{
			$statusRegisPhone = 0;			
		}
	}
else{
	die("Connection error: " . mysqli_connect_errno());
}
echo $statusRegisPhone;
?>