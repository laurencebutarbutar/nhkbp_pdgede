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

$usernameForgotUser = $_POST['username'];
$emailForgotUser = $_POST['email'];

$_SESSION['statusSentEmail'] = null;

//========================================== DB CONNECTION ====================================
    include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){   
    $selectTUsersDetailId = mysqli_query($con, "SELECT t_users_detail_id FROM users where name = '".$usernameForgotUser."'");
    
    if (mysqli_num_rows($selectTUsersDetailId) > 0) {
        $rowSelectTUsersDetailId = mysqli_fetch_assoc($selectTUsersDetailId);
        $tUsersDetailId=$rowSelectTUsersDetailId['t_users_detail_id'];

        $selectDetailUsers = mysqli_query($con, "SELECT full_name FROM t_users_detail where id = '".$tUsersDetailId."' and email = '".$emailForgotUser."'");
        if (mysqli_num_rows($selectDetailUsers) > 0){
            $rowSelectDetailUsers = mysqli_fetch_assoc($selectDetailUsers);
            $detailUsers=$rowSelectDetailUsers['full_name'];

            // function generate new password
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }

            $newPassword = implode($pass);
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePassword = mysqli_query($con, "UPDATE users SET password = '".$hashedNewPassword."' WHERE name = '".$usernameForgotUser."'");

            $_SESSION['subjectEmail'] = "Forgot Password Account NHKBP Pondok Gede";
            $_SESSION['valueAttribute'] = $newPassword;
            $_SESSION['nameAttribute'] = "Password";
            $_SESSION['emailUser'] = $emailForgotUser;
            $_SESSION['fullName'] = $detailUsers;

            header("Location: sentEmail.php");
        }        
        else{
           $_SESSION['statusSentEmail'] = "Username/Email Not Exist";
            header("Location: ../../view/home/forgotPassword.php");
        }
    }
    else{
        $_SESSION['statusSentEmail'] = "Username/Email Not Exist";
        header("Location: ../../view/home/forgotPassword.php");
    }    
}
else{
    die("Connection error: " . mysqli_connect_errno());
}
?>  