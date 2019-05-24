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
$usersDetailId = $_SESSION['tUsersDetailId'];
$medSosName = $_SESSION['medSosName'];
$medSosId = $_SESSION['medSosId'];

$facebook = $_POST['facebook'];
$instagram = $_POST['instagram'];
$linkedin = $_POST['linkedin'];
$steam = $_POST['steam'];
$twitter = $_POST['twitter'];
$quora = $_POST['quora'];
$youtube = $_POST['youtube'];

$cekFacebook = null;
$cekInstagram = null;
$cekLinkedin = null;
$cekSteam = null;
$cekTwitter = null;
$cekQuora = null;
$cekYoutube = null;

if($usersDetailId === null){
    $_SESSION['failedLogin'] = "Please Login";
    header("Location: ../../view/home/login.php");      
}

//========================================== DB CONNECTION ====================================
	include_once $pathClassUsers.'dbConnection.php';
//========================================== DB CONNECTION ====================================
if (!mysqli_connect_errno()){
    //select created events
    $selectUsersMedsos = mysqli_query($con, "SELECT name, id_medsos FROM t_users_medsos WHERE t_users_detail_id = '".$usersDetailId."'");
    if (mysqli_num_rows($selectUsersMedsos) > 0){ 
        while ($rowSelectUsersMedsos = mysqli_fetch_array($selectUsersMedsos)):
            if($rowSelectUsersMedsos['name'] == "Facebook"){
                $cekFacebook = $rowSelectUsersMedsos['id_medsos']; 
            }else if($rowSelectUsersMedsos['name'] == "Instagram"){
                $cekInstagram = $rowSelectUsersMedsos['id_medsos']; 
            }else if($rowSelectUsersMedsos['name'] == "LinkedIn"){
                $cekLinkedin = $rowSelectUsersMedsos['id_medsos']; 
            }else if($rowSelectUsersMedsos['name'] == "Steam"){
                $cekSteam = $rowSelectUsersMedsos['id_medsos']; 
            }else if($rowSelectUsersMedsos['name'] == "Twitter"){
                $cekTwitter = $rowSelectUsersMedsos['id_medsos']; 
            }else if($rowSelectUsersMedsos['name'] == "Quora"){
                $cekQuora = $rowSelectUsersMedsos['id_medsos']; 
            }else if($rowSelectUsersMedsos['name'] == "Youtube"){
                $cekYoutube = $rowSelectUsersMedsos['id_medsos']; 
            }
        endwhile;
    }

    if($facebook !=""){
        if($cekFacebook == null){
            $insertTUsersMedsos = mysqli_query($con, "INSERT into t_users_medsos (t_users_detail_id, name, id_medsos) VALUES ('".$usersDetailId."', 'Facebook', '".$facebook."');");
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Facebook link Success"; //message Update
            }
        }else{
            $updateTUsersMedsos =  mysqli_query($con, "UPDATE t_users_medsos SET id_medsos ='".$facebook."' WHERE t_users_detail_id = '".$usersDetailId."' AND name = 'Facebook'"); 
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Facebook link Success"; //message Update
            }
        }
    }
    if($instagram !=""){
        if($cekInstagram == null){
            $insertTUsersMedsos = mysqli_query($con, "INSERT into t_users_medsos (t_users_detail_id, name, id_medsos) VALUES ('".$usersDetailId."', 'Instagram', '".$instagram."');");
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Instagram link Success"; //message Update
            }
        }else{
            $updateTUsersMedsos =  mysqli_query($con, "UPDATE t_users_medsos SET id_medsos ='".$instagram."' WHERE t_users_detail_id = '".$usersDetailId."' AND name = 'Instagram'"); 
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Instagram link Success"; //message Update
            }
        }
    }
    if($linkedin !=""){
        if($cekLinkedin == null){
            $insertTUsersMedsos = mysqli_query($con, "INSERT into t_users_medsos (t_users_detail_id, name, id_medsos) VALUES ('".$usersDetailId."', 'LinkedIn', '".$linkedin."');");
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update LinkedIn link Success"; //message Update
            }
        }else{
            $updateTUsersMedsos =  mysqli_query($con, "UPDATE t_users_medsos SET id_medsos ='".$linkedin."' WHERE t_users_detail_id = '".$usersDetailId."' AND name = 'LinkedIn'"); 
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update LinkedIn link Success"; //message Update
            }
        }
    }
    if($steam !=""){
        if($cekSteam == null){
            $insertTUsersMedsos = mysqli_query($con, "INSERT into t_users_medsos (t_users_detail_id, name, id_medsos) VALUES ('".$usersDetailId."', 'Steam', '".$steam."');");
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Steam link Success"; //message Update
            }
        }else{
            $updateTUsersMedsos =  mysqli_query($con, "UPDATE t_users_medsos SET id_medsos ='".$steam."' WHERE t_users_detail_id = '".$usersDetailId."' AND name = 'Steam'"); 
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Steam link Success"; //message Update
            }
        }
    }
    if($twitter !=""){
        if($cekTwitter == null){
            $insertTUsersMedsos = mysqli_query($con, "INSERT into t_users_medsos (t_users_detail_id, name, id_medsos) VALUES ('".$usersDetailId."', 'Twitter', '".$twitter."');");
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Twitter link Success"; //message Update
            }
        }else{
            $updateTUsersMedsos =  mysqli_query($con, "UPDATE t_users_medsos SET id_medsos ='".$twitter."' WHERE t_users_detail_id = '".$usersDetailId."' AND name = 'Twitter'"); 
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Twitter link Success"; //message Update
            }
        }
    }
    if($quora !=""){
        if($cekQuora == null){
            $insertTUsersMedsos = mysqli_query($con, "INSERT into t_users_medsos (t_users_detail_id, name, id_medsos) VALUES ('".$usersDetailId."', 'Quora', '".$quora."');");
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Quora link Success"; //message Update
            }
        }else{
            $updateTUsersMedsos =  mysqli_query($con, "UPDATE t_users_medsos SET id_medsos ='".$quora."' WHERE t_users_detail_id = '".$usersDetailId."' AND name = 'Quora'"); 
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Quora link Success"; //message Update
            }
        }
    }
    if($youtube !=""){
        if($cekYoutube == null){
            $insertTUsersMedsos = mysqli_query($con, "INSERT into t_users_medsos (t_users_detail_id, name, id_medsos) VALUES ('".$usersDetailId."', 'Youtube', '".$youtube."');");
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Youtube link Success"; //message Update
            }
        }else{
            $updateTUsersMedsos =  mysqli_query($con, "UPDATE t_users_medsos SET id_medsos ='".$youtube."' WHERE t_users_detail_id = '".$usersDetailId."' AND name = 'Youtube'"); 
            if($_SESSION['messageUpdateAccount'] !== null){
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
            }else{  
                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Update Youtube link Success"; //message Update
            }
        }
    }

    //refresh ulang medsos
    $selectUsersMedsos = mysqli_query($con, "SELECT name, id_medsos FROM t_users_medsos WHERE t_users_detail_id = '".$usersDetailId."'");
    if (mysqli_num_rows($selectUsersMedsos) > 0){ 
        while ($rowSelectUsersMedsos = mysqli_fetch_array($selectUsersMedsos)):
            $nameMedsos[] = $rowSelectUsersMedsos['name']; 
            $idMedsos[] = $rowSelectUsersMedsos['id_medsos']; 
        endwhile;
    }

    $_SESSION['medSosName'] = $nameMedsos;
    $_SESSION['medSosId'] = $idMedsos;

    header("Location: ".$root."view/users/account.php");
}
else{
	die("Connection error: " . mysqli_connect_errno());
}

?>	