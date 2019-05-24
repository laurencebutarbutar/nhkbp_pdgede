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
$pathViewHome = "../../view/home/";
$pathClassHome = "../../assets/class/";
session_start();

$_SESSION['TTS'] = 0;
$_SESSION['cariKata'] = 0;
$_SESSION['offlineActivities'] = 0;
$_SESSION['retret'] = 0;
$usernameLogin = $_SESSION['usernameLogin'];
$usersDetailId = $_SESSION['tUsersDetailId'];


//========================================== DB CONNECTION ====================================
	include_once $pathClassHome.'dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){

    $selectUsersDetail = mysqli_query($con, "SELECT full_name, phone, birthday, gender, address, email, marital_status, wijk, path_image FROM t_users_detail where id = '".$usersDetailId."'");

    if (mysqli_num_rows($selectUsersDetail) > 0){
        //select user detail
        $rowSelectUsersDetail = mysqli_fetch_assoc($selectUsersDetail);
        $fullName=$rowSelectUsersDetail['full_name'];
        $phone=$rowSelectUsersDetail['phone'];
        $birthday=$rowSelectUsersDetail['birthday'];
        $gender=$rowSelectUsersDetail['gender'];
        $address=$rowSelectUsersDetail['address'];
        $email=$rowSelectUsersDetail['email'];
        $maritalStatus=$rowSelectUsersDetail['marital_status'];                

        $_SESSION['usersDetailWijk']=$rowSelectUsersDetail['wijk'];
        $_SESSION['pathImage']=$rowSelectUsersDetail['path_image'];
        $_SESSION['tUsersDetailId'] = $usersDetailId;
        $_SESSION['fullName'] = $fullName;
        $_SESSION['phone'] = $phone;
        $_SESSION['birthday'] = $birthday;
        $_SESSION['gender'] = $gender;
        $_SESSION['address'] = $address;
        $_SESSION['email'] = $email;
        $_SESSION['maritalStatus'] = $maritalStatus;
        
        //select activities
        $selectUsersActivities = mysqli_query($con, "SELECT t_activities_id FROM t_rel_users_activities where t_users_detail_id = '".$usersDetailId."'");
        if (mysqli_num_rows($selectUsersActivities) > 0){
            while ($rowSelectUsersActivities = mysqli_fetch_array($selectUsersActivities)):
                //select TTS Activities
                if($rowSelectUsersActivities['t_activities_id'] == 1){
                    $_SESSION['TTS'] = 1;
                }
                //select Cari Kata Activities
                else if($rowSelectUsersActivities['t_activities_id'] == 2){
                    $_SESSION['cariKata'] = 1;
                }
                //select Offline Activities
                else if($rowSelectUsersActivities['t_activities_id'] == 3 || $rowSelectUsersActivities['t_activities_id'] == 4 || $rowSelectUsersActivities['t_activities_id'] == 5 || $rowSelectUsersActivities['t_activities_id'] == 6){
                    $_SESSION['offlineActivities'] = 1;
                }
                //select retret Activities
                else if($rowSelectUsersActivities['t_activities_id'] == 7){
                    $_SESSION['retret'] = 1;
                }
            endwhile;
        }

        //select order
        $selectUsersOrder = mysqli_query($con, "SELECT id, created_at, status FROM t_order where t_users_detail_id = '".$usersDetailId."'");
        if (mysqli_num_rows($selectUsersOrder) > 0){
            while ($rowSelectUsersOrder = mysqli_fetch_array($selectUsersOrder)):
                $orderId[] = $rowSelectUsersOrder['id'];
                $orderCreated[] = $rowSelectUsersOrder['created_at'];
                $orderStatus[] = $rowSelectUsersOrder['status'];
            endwhile;
        }
        
        $_SESSION['orderId'] = $orderId;
        $_SESSION['orderCreated'] = $orderCreated;
        $_SESSION['orderStatus'] = $orderStatus;

        $nickName = explode(' ', $_SESSION['fullName']);
        $_SESSION['nickName'] = $nickName[0];
        header("Location: ../../users");
    }
}
else{
	die("Connection error: " . mysqli_connect_errno());
}
?>	