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
$offlineEventsTeamName = $_SESSION['offlineEventsTeamName'];
$offlineEventsTeamPassword = $_SESSION['offlineEventsTeamPassword']; 
$offlineEventsName = $_SESSION['offlineEventsName'];
$teamMemberName = $_SESSION['teamMemberName'];
$teamMemberPhone = $_SESSION['teamMemberPhone'];

$updateTeamName = $_POST['updateTeamName'];
$updateTeamPassword = $_POST['updateTeamPassword'];
$buttonDeleteEvents = $_POST['buttonDeleteEvents'];
$buttonUpdateEvents = $_POST['buttonUpdateEvents'];
$teamCreated = null;
$modeRegistration = null;
$activitiesId = null;

if($usersDetailId === null){
    $_SESSION['failedLogin'] = "Please Login";
    header("Location: ../../view/home/login.php");      
}

//========================================== DB CONNECTION ====================================
	include_once $pathClassUsers.'dbConnection.php';
//========================================== DB CONNECTION ====================================
if (!mysqli_connect_errno()){
    //select created events
    $selectTeamCreated = mysqli_query($con, "SELECT trua.team_created, trua.mode_registration, trua.t_activities_id FROM t_rel_users_activities trua JOIN t_activities ta ON ta.id = trua.t_activities_id AND ta.group = 'offline events' WHERE trua.t_users_detail_id = '".$usersDetailId."'");
                
    if (mysqli_num_rows($selectTeamCreated) > 0){
        $rowSelectTeamCreated=mysqli_fetch_assoc($selectTeamCreated); 
        $teamCreated = $rowSelectTeamCreated['team_created']; 
        $modeRegistration = $rowSelectTeamCreated['mode_registration']; 
        $activitiesId = $rowSelectTeamCreated['t_activities_id']; 
    }

    //delete events
    if($buttonDeleteEvents == "delete"){
        //cek apakah udah ada register offline event
        if($modeRegistration === null){
            $_SESSION['successUpdateAccount'] = 2; //status Update
            $_SESSION['messageUpdateAccount'] = "You don't have events to delete";
            header("Location: ".$root."view/users/account.php");         
        }else if($modeRegistration == "Solo"){
            //delete for solo mode
            $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'delete events', '".$activitiesId."', NULL, CURRENT_TIMESTAMP);");

            $deleteEvents = mysqli_query($con, "DELETE FROM t_rel_users_activities WHERE t_activities_id = '".$activitiesId."' AND t_users_detail_id = '".$usersDetailId."'");

            $_SESSION['offlineEventsName'] = null;

            $_SESSION['successUpdateAccount'] = 1; //status Update
            $_SESSION['messageUpdateAccount'] = "Success delete events";
            header("Location: ".$root."view/users/account.php");
        }
        else{
            if($teamCreated == 1){
                //select team member
                $selectCountTeamMember = mysqli_query($con, "SELECT t_users_detail_id FROM t_rel_users_activities WHERE team_name = '".$offlineEventsTeamName."'");
                if (mysqli_num_rows($selectCountTeamMember) > 1){
                    $_SESSION['successUpdateAccount'] = 2; //status Update
                    $_SESSION['messageUpdateAccount'] = "Sorry, you can't delete, you still have team member";
                    header("Location: ".$root."view/users/account.php");              
                }else{
                    //delete for team leader
                    $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'delete events', '".$activitiesId."', NULL, CURRENT_TIMESTAMP);");

                    $deleteEvents = mysqli_query($con, "DELETE FROM t_rel_users_activities WHERE t_activities_id = '".$activitiesId."' AND t_users_detail_id = '".$usersDetailId."'");

                    $_SESSION['offlineEventsTeamName'] = null;
                    $_SESSION['offlineEventsTeamPassword'] = null;
                    $_SESSION['offlineEventsName'] = null; 
                    $_SESSION['teamMemberName'] = null;
                    $_SESSION['teamMemberPhone'] = null;

                    $_SESSION['successUpdateAccount'] = 1; //status Update
                    $_SESSION['messageUpdateAccount'] = "Success delete events";
                    header("Location: ".$root."view/users/account.php");        
                }
            }else{
                //delete for team member
                $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'delete events', '".$activitiesId."', NULL, CURRENT_TIMESTAMP);");

                $deleteEvents = mysqli_query($con, "DELETE FROM t_rel_users_activities WHERE t_activities_id = '".$activitiesId."' AND t_users_detail_id = '".$usersDetailId."'");

                $_SESSION['offlineEventsTeamName'] = null;
                $_SESSION['offlineEventsTeamPassword'] = null;
                $_SESSION['offlineEventsName'] = null; 
                $_SESSION['teamMemberName'] = null;
                $_SESSION['teamMemberPhone'] = null;

                $_SESSION['successUpdateAccount'] = 1; //status Update
                $_SESSION['messageUpdateAccount'] = "Success delete events";
                header("Location: ".$root."view/users/account.php");
            }
        }

    }

    //update team
    if($buttonUpdateEvents == "update"){
        //cek apakah udah ada register offline event
        if($modeRegistration === null){
            $_SESSION['successUpdateAccount'] = 2; //status Update
            $_SESSION['messageUpdateAccount'] = "You don't have events to update";
            header("Location: ".$root."view/users/account.php");         
        }else if($modeRegistration == "Solo"){
            //update for solo mode           
            $_SESSION['successUpdateAccount'] = 2; //status Update
            $_SESSION['messageUpdateAccount'] = "You are in solo mode";
            header("Location: ".$root."view/users/account.php");
        }
        else{
            if($teamCreated == 1){               
                //update name team
                if($updateTeamName != ""){
                    //select nama team dan password
                    $selectTeamNameAndPass = mysqli_query($con, "SELECT trua.team_name, trua.team_password FROM t_rel_users_activities trua JOIN t_activities ta ON ta.id = trua.t_activities_id AND ta.group = 'offline events' WHERE trua.t_users_detail_id = '".$usersDetailId."'");
                                
                    if (mysqli_num_rows($selectTeamNameAndPass) > 0){
                        $rowSelectTeamNameAndPass=mysqli_fetch_assoc($selectTeamNameAndPass); 
                        $teamName = $rowSelectTeamNameAndPass['team_name']; 
                        $teamPassword = $rowSelectTeamNameAndPass['team_password']; 
                    }

                    if(strcmp($teamName,$updateTeamName)){
                        $_SESSION['successUpdateAccount'] = 2; //status Update
                        $_SESSION['messageUpdateAccount'] = "Team name already exist"; //message Update   
                    }else{
                        $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'update team name', '".$teamName."', '".$updateTeamName."', CURRENT_TIMESTAMP);");

                        $updateTeamNameQuery =  mysqli_query($con, "UPDATE t_rel_users_activities SET team_name ='".$updateTeamName."' WHERE team_name = '".$teamName."' AND team_password = '".$teamPassword."'");  

                        $_SESSION['offlineEventsTeamName'] = $updateTeamName;

                        if($_SESSION['messageUpdateAccount'] !== null){
                            $_SESSION['successUpdateAccount'] = 1; //status Update
                            $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
                        }else{  
                            $_SESSION['successUpdateAccount'] = 1; //status Update
                            $_SESSION['messageUpdateAccount'] = "Update Team Name Success"; //message Update
                        }
                    }
                }
                if($updateTeamPassword != ""){
                    //select nama team dan password
                    $selectTeamNameAndPass = mysqli_query($con, "SELECT trua.team_name, trua.team_password FROM t_rel_users_activities trua JOIN t_activities ta ON ta.id = trua.t_activities_id AND ta.group = 'offline events' WHERE trua.t_users_detail_id = '".$usersDetailId."'");
                                
                    if (mysqli_num_rows($selectTeamNameAndPass) > 0){
                        $rowSelectTeamNameAndPass=mysqli_fetch_assoc($selectTeamNameAndPass); 
                        $teamName = $rowSelectTeamNameAndPass['team_name']; 
                        $teamPassword = $rowSelectTeamNameAndPass['team_password']; 
                    }

                    $insertTUsersHistory = mysqli_query($con, "INSERT into t_users_history (t_users_detail_id, name, old_value, new_value, update_at) VALUES ('".$usersDetailId."', 'update team password', '".$teamPassword."', '".$updateTeamPassword."', CURRENT_TIMESTAMP);");

                    $updateTeamPasswordQuery =  mysqli_query($con, "UPDATE t_rel_users_activities SET team_password ='".$updateTeamPassword."' WHERE team_name = '".$teamName."' AND team_password = '".$teamPassword."'");  

                    $_SESSION['offlineEventsTeamPassword'] = $updateTeamPassword;

                    if($_SESSION['messageUpdateAccount'] !== null){
                        $_SESSION['successUpdateAccount'] = 1; //status Update
                        $_SESSION['messageUpdateAccount'] = "Update Success"; //message Update            
                    }else{  
                        $_SESSION['successUpdateAccount'] = 1; //status Update
                        $_SESSION['messageUpdateAccount'] = "Update Team Password Success"; //message Update
                    }
                }
                header("Location: ".$root."view/users/account.php");  
            }else{
                $_SESSION['successUpdateAccount'] = 2; //status Update
                $_SESSION['messageUpdateAccount'] = "Only team leader can update";
                header("Location: ".$root."view/users/account.php");
            }
        }
    }
}
else{
	die("Connection error: " . mysqli_connect_errno());
}

?>	