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

$phoneForgotUser = $_POST['phone'];
$emailForgotUser = $_POST['email'];

$_SESSION['statusSentEmail'] = null;

//========================================== DB CONNECTION ====================================
	include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){	
	$selectTUsersDetailId = mysqli_query($con, "SELECT id, full_name FROM t_users_detail where phone = '0".$phoneForgotUser."' and email = '".$emailForgotUser."'");
	
    if (mysqli_num_rows($selectTUsersDetailId) > 0) {
        $rowSelectTUsersDetailId = mysqli_fetch_assoc($selectTUsersDetailId);
		$idTUsersDetail=$rowSelectTUsersDetailId['id'];
        $fullName=$rowSelectTUsersDetailId['full_name'];

        $selectUsername = mysqli_query($con, "SELECT name FROM users where t_users_detail_id = '".$idTUsersDetail."'");
        if (mysqli_num_rows($selectUsername) > 0){

            $rowSelectUsername = mysqli_fetch_assoc($selectUsername);
            $name=$rowSelectUsername['name'];

            $_SESSION['subjectEmail'] = "Forgot Username Account NHKBP Pondok Gede";
            $_SESSION['valueAttribute'] = $name;
            $_SESSION['nameAttribute'] = "Username";
            $_SESSION['emailUser'] = $emailForgotUser;
            $_SESSION['fullName'] = $fullName;

            header("Location: sentEmail.php");
        }        
        else{
           $_SESSION['statusSentEmail'] = "Phone/Email Not Exist";
            header("Location: ../../view/home/forgotUsername.php");
        }
    }
    else{
        $_SESSION['statusSentEmail'] = "Phone/Email Not Exist";
        header("Location: ../../view/home/forgotUsername.php");
    }    
}
else{
	die("Connection error: " . mysqli_connect_errno());
}
?>	