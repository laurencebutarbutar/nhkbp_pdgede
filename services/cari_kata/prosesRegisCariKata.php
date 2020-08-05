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
$pathClassUsers = "../../assets/class/";
$root = "../../";

session_start();

$activities = 2;
$usersDetailId = $_SESSION['tUsersDetailId'];
$modeRegistration = "Solo";
$maritalStatus = $_SESSION['maritalStatus'];


$_SESSION['successRegisActivities'] = 0;

//========================================== DB CONNECTION ====================================
	include_once $pathClassUsers.'dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){
	$insertTRelUserActivities = mysqli_query($con, "INSERT into t_rel_users_activities (t_users_detail_id, t_activities_id, mode_registration, team_created, team_name, team_password) VALUES ('".$usersDetailId."', '".$activities."', '".$modeRegistration."', NULL, NULL, NULL);");

    $selectUsersCariKataActivities = mysqli_query($con, "SELECT 1 FROM t_rel_users_activities where t_users_detail_id = '".$usersDetailId."' and t_activities_id = 2");

    if (mysqli_num_rows($selectUsersCariKataActivities) > 0){
        if($maritalStatus == "Single"){
            $_SESSION['cariKata'] = 1;
            $_SESSION['successRegisActivities'] = 1;
            $_SESSION['messageRegisActivities'] = "Registration Success";
            header("Location: ".$root."users");
        }
        else{
            $_SESSION['cariKata'] = 1;
            $_SESSION['successRegisActivities'] = 3;
            $_SESSION['messageRegisActivities'] = "Registration Success! But, Your Score Not Will Be Recorded.";
            header("Location: ".$root."users");

        }
    }else{
        $_SESSION['cariKata'] = 0;
        $_SESSION['successRegisActivities'] = 2;
        $_SESSION['messageRegisActivities'] = "Registration Failed! You Already Registered.";
        header("Location: ".$root."users");
    }
}
else{
	die("Connection error: " . mysqli_connect_errno());
}
?>	