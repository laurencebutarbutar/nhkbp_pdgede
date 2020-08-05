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
$fullName = $_SESSION['fullName'];
$nickName = $_SESSION['nickName'];
$phone = $_SESSION['phone'];
$address = $_SESSION['address'];
$email = $_SESSION['email'];
$usersDetailWijk = $_SESSION['usersDetailWijk'];
$hobbiesAccount = $_SESSION['hobbiesAccount'];
$maritalStatus = $_SESSION['maritalStatus'];
$usernameLogin = $_SESSION['usernameLogin'];
$usersDetailId = $_SESSION['tUsersDetailId'];
$orderStatus = $_SESSION['orderStatus'];

$fullNameUpd = $_POST['fullNameUpd'];
$phoneUpd = $_POST['phoneUpd'];
$maritalStatusUpd = $_POST['maritalStatusUpd'];
$wijkUpd = $_POST['wijkUpd'];
$addressUpd = $_POST['addressUpd'];
$emailUpd = $_POST['emailUpd'];
$hobbiesUpd = $_POST['hidden_hobbiesUpd'];
$usernameUpd = $_POST['usernameUpd'];
// $oldPasswordUpd = $_POST['oldPasswordUpd'];
$newPasswordUpd = $_POST['newPasswordUpd'];

if($usersDetailId === null){
    $_SESSION['failedLogin'] = "Please Login";
    header("Location: ../../view/home/login.php");      
}

//check ada order status yang pending, maka gak bisa update
if(count($orderStatus) >0){
    for($x=0; $x<count($orderStatus); $x++){
        if($orderStatus[$x] == 0){
            $_SESSION['successUpdateAccount'] = 3; //status Update
            $_SESSION['messageUpdateAccount'] = "Sorry, you can't update right now, you have pending order";
            header("Location: ".$root."view/users/account.php");               
        }
    }    
}

//========================================== DB CONNECTION ====================================
	include_once $pathClassUsers.'dbConnection.php';
//========================================== DB CONNECTION ====================================
if (!mysqli_connect_errno()){
    if($fullNameUpd != ""){
        $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'full_name', '".$fullName."', '".$fullNameUpd."', CURRENT_TIMESTAMP);");
        $updateUsersDetail =  mysqli_query($con, "UPDATE t_users_detail SET full_name = '".$fullNameUpd."' WHERE id = '".$usersDetailId."'");

        $_SESSION['fullName'] = $fullNameUpd;
        $nickName = explode(' ', $_SESSION['fullName']);
        $_SESSION['nickName'] = $nickName[0];

        if($_SESSION['messageUpdateAccount'] !== null){
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
        }else{        
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Full Name Success"; //message Update
        }
    }
    if($phoneUpd != ""){
        $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'phone', '".$phone."', '".'0'.$phoneUpd."', CURRENT_TIMESTAMP);");
        $updateUsersDetail =  mysqli_query($con, "UPDATE t_users_detail SET phone = '".'0'.$phoneUpd."' WHERE id = '".$usersDetailId."'");   

        $_SESSION['phone'] = '0'.$phoneUpd;        

        if($_SESSION['messageUpdateAccount'] !== null){
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
        }else{        
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Phone Success"; //message Update
        }
    }
    if($maritalStatusUpd != ""){
        if($maritalStatus == "Married"){
            $_SESSION['successUpdateAccount'] = 3; //status Update
            $_SESSION['messageUpdateAccount'] = "Sorry, you can't update Marital Status"; //message Update
        }else{
            $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'marital_status', '".$maritalStatus."', '".$maritalStatusUpd."', CURRENT_TIMESTAMP);");
            $updateUsersDetail =  mysqli_query($con, "UPDATE t_users_detail SET marital_status = '".$maritalStatusUpd."' WHERE id = '".$usersDetailId."'");   

            $_SESSION['maritalStatus'] = $maritalStatusUpd;

            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Marital Status Success"; //message Update
            }
        }
    }

    if($wijkUpd != ""){
        $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'wijk', '".$usersDetailWijk."', '".$wijkUpd."', CURRENT_TIMESTAMP);");
        $updateUsersDetail =  mysqli_query($con, "UPDATE t_users_detail SET wijk = '".$wijkUpd."' WHERE id = '".$usersDetailId."'");   

        $_SESSION['usersDetailWijk'] = $wijkUpd;

        if($_SESSION['messageUpdateAccount'] !== null){
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
        }else{
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Wijk Success"; //message Update
        }
    }
    if($addressUpd != ""){
        $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'address', '".$address."', '".$addressUpd."', CURRENT_TIMESTAMP);");
        $updateUsersDetail =  mysqli_query($con, "UPDATE t_users_detail SET address = '".$addressUpd."' WHERE id = '".$usersDetailId."'");   

        $_SESSION['address'] = $addressUpd;

        if($_SESSION['messageUpdateAccount'] !== null){
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
        }else{       
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Address Success"; //message Update
        }
    }
    if($emailUpd != ""){  
        $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'email', '".$email."', '".$emailUpd."', CURRENT_TIMESTAMP);");
        $updateUsersDetail =  mysqli_query($con, "UPDATE t_users_detail SET email = '".$emailUpd."' WHERE id = '".$usersDetailId."'");  

        $_SESSION['email'] = $emailUpd;

        if($_SESSION['messageUpdateAccount'] !== null){
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
        }else{  
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Email Success"; //message Update
        }
    }
    if($hobbiesUpd != ""){
        $tempHobbies = explode(",", $hobbiesUpd);        

        for($z = 0; $z < 2; $z++){
            $oldHobbiesId = null;
            $newHobbiesId = null;
             $selectOldHobbiesId = mysqli_query($con, "SELECT id FROM t_hobbies where hobby = '".$hobbiesAccount[$z]."'");
                
            if (mysqli_num_rows($selectOldHobbiesId) > 0){
                $rowSelectOldHobbiesId=mysqli_fetch_assoc($selectOldHobbiesId); 
                $oldHobbiesId = $rowSelectOldHobbiesId['id']; 
            }

            $selectNewHobbiesId = mysqli_query($con, "SELECT id FROM t_hobbies where hobby = '".$tempHobbies[$z]."'");
                
            if (mysqli_num_rows($selectNewHobbiesId) > 0){
                $rowSelectNewHobbiesId=mysqli_fetch_assoc($selectNewHobbiesId); 
                $newHobbiesId = $rowSelectNewHobbiesId['id'];  
            }

            $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'hobbies', '".$oldHobbiesId[$zz]."', '".$newHobbiesId[$zz]."', CURRENT_TIMESTAMP);");

            $updateTRelUsersHobbies =  mysqli_query($con, "UPDATE t_rel_users_hobbies SET t_hobbies_id = '".$newHobbiesId."' WHERE id = '".$usersDetailId."' AND t_hobbies_id = '".$oldHobbiesId."'");  
        }

        $_SESSION['hobbiesAccount'] = $tempHobbies;
        
        if($_SESSION['messageUpdateAccount'] !== null){
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
        }else{    
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Hobbies Success"; //message Update
        }
    }
    if($usernameUpd != ""){
        $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'username', '".$usernameLogin."', '".$usernameUpd."', CURRENT_TIMESTAMP);");
        $updateUsersDetail =  mysqli_query($con, "UPDATE users SET name = '".$usernameUpd."' WHERE t_users_detail_id = '".$usersDetailId."'");  

        $_SESSION['usernameLogin'] = $usernameUpd;

        if($_SESSION['messageUpdateAccount'] !== null){
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
        }else{    
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Username Success"; //message Update
        }
    }
    if($newPasswordUpd != ""){        
        // Hash password
        $hashed_password = password_hash($newPasswordUpd, PASSWORD_DEFAULT);

        $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'password', '-', '-', CURRENT_TIMESTAMP);");
        $updateUsersDetail =  mysqli_query($con, "UPDATE users SET password = '".$hashed_password."' WHERE t_users_detail_id = '".$usersDetailId."'");  

        if($_SESSION['messageUpdateAccount'] !== null){
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
        }else{
            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Update Password Success"; //message Update            
        }
    }

    header("Location: ".$root."view/users/account.php");               

}
else{
	die("Connection error: " . mysqli_connect_errno());
}

?>	