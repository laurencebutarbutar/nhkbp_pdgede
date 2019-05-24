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

$pathImageHome = "../../assets/img/home/";
$pathServiceHome = "../../services/home/";
$pathViewHome = "../../view/home/";
$pathCSSHome = "../../assets/css/";
$pathJsHome = "../../assets/js/";
$pathClassHome = "../../assets/class/";

$fullName = $_POST['fullName'];
$phone = $_POST['phone'];
$birthday = $_POST['birthday'];
$gender = $_POST['gender'];
$maritalStatus = $_POST['maritalStatus'];
$wijk = $_POST['wijk'];
$address = $_POST['address'];
$email = $_POST['email'];
$hobbies = $_POST['hidden_hobbies'];
$username_regis = $_POST['username'];
$password_regis = $_POST['password'];
$confirmPasswordRegis = $_POST['confirmPassword'];
//explode text to array
$hobby = (explode(",",$hobbies));
// Hash password
$hashed_password = password_hash($password_regis, PASSWORD_DEFAULT);

$_SESSION['successRegis'] = 0;

//========================================== DB CONNECTION ====================================
	include_once $pathClassHome.'dbConnection.php';
//========================================== DB CONNECTION ====================================

//cek database ttg data yang diambil
if($fullName === null || $phone === null || $birthday === null || $gender === null || $maritalStatus === null || $wijk === null || $address === null || $email === null || $hobbies === null || $username_regis === null || $password_regis === null){
    $_SESSION['successRegis'] = 2;
    header("Location: ".$pathViewHome."registration.php");
}
else if($confirmPasswordRegis != $password_regis){
    $_SESSION['successRegis'] = 2;
    header("Location: ".$pathViewHome."registration.php");
}
else{
    if (!mysqli_connect_errno()){
        //cek regis phone
        $selectRegisPhone = mysqli_query($con, "SELECT 1 FROM t_users_detail where phone = '0".$phone."'");
    
        if (mysqli_num_rows($selectRegisPhone) > 0){
            $_SESSION['successRegis'] = 2;
            header("Location: ".$pathViewHome."registration.php");
        }
        else{
            $selectRegisUsername = mysqli_query($con, "SELECT 1 FROM users where name = '".$username_regis."'");
    
            if (mysqli_num_rows($selectRegisUsername) > 0){
                $_SESSION['successRegis'] = 2;
                header("Location: ".$pathViewHome."registration.php");
            }
            else{
                //insert database
                $insertUsersDetail = mysqli_query($con, "INSERT into t_users_detail (full_name, phone, birthday, gender, marital_status, wijk, address, email) VALUES ('".$fullName."', '0".$phone."', '".$birthday."', '".$gender."', '".$maritalStatus."', '".$wijk."', '".$address."', '".$email."');");

                $selectIdUsersDetail = mysqli_query($con, "SELECT id FROM t_users_detail where phone = '0".$phone."' AND birthday = '".$birthday."' AND gender = '".$gender."' AND marital_status = '".$maritalStatus."' AND wijk = '".$wijk."' AND email = '".$email."' AND full_name = '".$fullName."'");
                
                if (mysqli_num_rows($selectIdUsersDetail) > 0){
                    while ($rowselectIdUsersDetail = mysqli_fetch_array($selectIdUsersDetail)):
                        $t_users_detail_id[]=$rowselectIdUsersDetail['id'];
                    endwhile;

                    $insertUsers = mysqli_query($con, "INSERT into users (t_users_detail_id, name, password, created_at) VALUES ('".$t_users_detail_id[0]."', '".$username_regis."', '".$hashed_password."', CURRENT_TIMESTAMP);");     
                
                    // Select - insert hobbies
                    foreach ($hobby as $value) {
                        $idHobby = array();
                        $selectIdHobby = mysqli_query($con, "SELECT id FROM t_hobbies where hobby = '".$value."'");

                        if (mysqli_num_rows($selectIdHobby) > 0){
                            while ($rowSelectIdHobby = mysqli_fetch_array($selectIdHobby)):
                                $idHobby[]=$rowSelectIdHobby['id'];
                            endwhile;

                            $insertRelHobby = mysqli_query($con, "INSERT into t_rel_users_hobbies (t_users_detail_id, t_hobbies_id) VALUES ('".$t_users_detail_id[0]."', '".$idHobby[0]."');");

                             $_SESSION['successRegis'] = 1;
                            header("Location: ".$pathViewHome."registration.php");
                        }
                        else{
                            $_SESSION['successRegis'] = 3;
                            header("Location: ".$pathViewHome."registration.php");     
                        }            
                    }
                }
                else{
                    $_SESSION['successRegis'] = 3;
                    header("Location: ".$pathViewHome."registration.php");     
                } 
            }
        }
    }
    else{
        die("Connection error: " . mysqli_connect_errno());
    }


}


?>	