<?php
header("Cache-Control: no-cache, must-revalidate");
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

$usersDetailId = $_SESSION['tUsersDetailId'];
$maritalStatus = $_SESSION['maritalStatus'];
$usersDetailWijk =  $_SESSION['usersDetailWijk'];
$events = $_POST['events'];
$mode = $_POST['mode'];
$teamMode = $_POST['teamMode'];
$nameJoinTeam = $_POST['nameJoinTeam'];
$passwordJoinTeam = $_POST['passwordJoinTeam'];
$nameCreateTeam = $_POST['nameCreateTeam'];
$passwordCreateTeam = $_POST['passwordCreateTeam'];
$activities = null; //activities id

$_SESSION['successRegisActivities'] = 0;

if($maritalStatus != "Single"){
    $_SESSION['successRegisActivities'] = 2;
    $_SESSION['messageRegisActivities'] = "Sorry, You Can't Register Naposo Events";
    header("Location: ../../users");
}else{
    //========================================== DB CONNECTION ====================================
        include_once '../../assets/class/dbConnection.php';
    //========================================== DB CONNECTION ====================================
    if($events !== null){
        if($events == "Retret"){
            $activities = 7; //retret
            $mode = "Solo"; //default selain perlombaan -> apabila ada promo bisa diubah
            if (!mysqli_connect_errno()){
                //insert event
                $insertTRelUserActivitiesRetret = mysqli_query($con, "INSERT into t_rel_users_activities (t_users_detail_id, t_activities_id, mode_registration, team_created, team_name, team_password) VALUES ('".$usersDetailId."', '".$activities."', '".$mode."', NULL, NULL, NULL);");
                //select event
                $selectTRelUserActivitiesRetret = mysqli_query($con, "SELECT 1 FROM t_rel_users_activities where t_users_detail_id = '".$usersDetailId."' and t_activities_id = '".$activities."'");
                
                if (mysqli_num_rows($selectTRelUserActivitiesRetret) > 0){
                    $_SESSION['retret'] = 1;                
                    $_SESSION['successRegisActivities'] = 1;
                    $_SESSION['messageRegisActivities'] = "Registration Retret Success";
                    header("Location: ../../users");
                }else{
                    $_SESSION['retret'] = 0;                
                    $_SESSION['successRegisActivities'] = 2;
                    $_SESSION['messageRegisActivities'] = "Something's Wrong, Please Try Again Later";
                    header("Location: ../../users");
                }
            }else{
                die("Connection error: " . mysqli_connect_errno());
            }
        }else{
            $selectTActivitiesId = mysqli_query($con, "SELECT id, number_of_teams, total_gender_m_f FROM t_activities where name = '".$events."'");
            if (mysqli_num_rows($selectTActivitiesId) > 0){
                $rowActivitiesId=mysqli_fetch_assoc($selectTActivitiesId);
                $activities = $rowActivitiesId['id'];
                $numberOfTeams = $rowActivitiesId['number_of_teams'];
                $totalGender = $rowActivitiesId['total_gender_m_f'];
            }
            else{
                $_SESSION['successRegisActivities'] = 2;
                $_SESSION['messageRegisActivities'] = "There's No Events";
                header("Location: ../../users");
            }

            if($mode == "Solo"){
                if (!mysqli_connect_errno()){
                    //insert event
                    $insertTRelUserActivitiesOffline = mysqli_query($con, "INSERT into t_rel_users_activities (t_users_detail_id, t_activities_id, mode_registration, team_created, team_name, team_password) VALUES ('".$usersDetailId."', '".$activities."', '".$mode."', NULL, NULL, NULL);");
                    //select event
                    $selectTRelUserActivitiesOffline = mysqli_query($con, "SELECT 1 FROM t_rel_users_activities where t_users_detail_id = '".$usersDetailId."' and t_activities_id = '".$activities."'");
                    
                    if (mysqli_num_rows($selectTRelUserActivitiesOffline) > 0){
                        $_SESSION['offlineActivities'] = 1;                
                        $_SESSION['successRegisActivities'] = 1;
                        $_SESSION['messageRegisActivities'] = "Registration Success, We will find another solo mode";
                        header("Location: ../../users");
                    }else{
                        $_SESSION['offlineActivities'] = 0;                
                        $_SESSION['successRegisActivities'] = 2;
                        $_SESSION['messageRegisActivities'] = "Something's Wrong, Please Try Again Later";
                        header("Location: ../../users");
                    }
                }else{
                    die("Connection error: " . mysqli_connect_errno());
                }
            }else{
                if($teamMode == "Create Team"){
                    if($nameCreateTeam != "" && $passwordCreateTeam != ""){
    
                        //select team
                        $selectNameTeam = mysqli_query($con, "SELECT 1 FROM t_rel_users_activities where team_name = '".$nameCreateTeam."'");
                        if (mysqli_num_rows($selectNameTeam) > 0){          
                            $_SESSION['successRegisActivities'] = 2;
                            $_SESSION['messageRegisActivities'] = "Team Name Already Exist";
                            header("Location: ../../users");
                        }else{
                            //insert event
                            $insertTActivitiesTeamUsersDetail = mysqli_query($con, "INSERT into t_rel_users_activities (t_users_detail_id, t_activities_id, mode_registration, team_created, team_name, team_password) VALUES ('".$usersDetailId."', '".$activities."', '".$mode."', 1, '".$nameCreateTeam."', '".$passwordCreateTeam."');");

                            //select event
                            $selectTRelUserActivitiesOffline = mysqli_query($con, "SELECT 1 FROM t_rel_users_activities where t_users_detail_id = '".$usersDetailId."' and t_activities_id = '".$activities."'");
                            
                            if (mysqli_num_rows($selectTRelUserActivitiesOffline) > 0){
                                $_SESSION['offlineActivities'] = 1;                
                                $_SESSION['successRegisActivities'] = 1;
                                $_SESSION['messageRegisActivities'] = "Registration Create Team Success";
                                header("Location: ../../users");
                            }else{
                                $_SESSION['offlineActivities'] = 0;                
                                $_SESSION['successRegisActivities'] = 2;
                                $_SESSION['messageRegisActivities'] = "Something's Wrong, Please Try Again Later";
                                header("Location: ../../users");
                            }
                        }
                    }else{
                        $_SESSION['successRegisActivities'] = 2;
                        $_SESSION['messageRegisActivities'] = "Team Name/Password Empty";
                        header("Location: ../../users");
                    }
                }
                else{
                    if($nameJoinTeam != "" && $passwordJoinTeam != ""){
                        //validasi wijk orang di team
                        $selectNameTeam = mysqli_query($con, "SELECT tud.wijk FROM t_rel_users_activities trua JOIN t_users_detail tud ON tud.id = trua.t_users_detail_id WHERE team_name = '".$nameJoinTeam."' AND team_password = '".$passwordJoinTeam."' AND team_created = 1 AND t_activities_id = '".$activities."'");
                        if (mysqli_num_rows($selectNameTeam) > 0){
                            $rowSelectNameTeam=mysqli_fetch_assoc($selectNameTeam);
                            $teamWijk = $rowSelectNameTeam ['wijk'];
                            if($teamWijk == $usersDetailWijk){
                                //count jumlah team
                                $selectJumlahUserTeam = mysqli_query($con, "SELECT COUNT(t_users_detail_id) as totalUser FROM `t_rel_users_activities` WHERE team_name = '".$nameJoinTeam."' AND team_password = '".$passwordJoinTeam."' AND t_activities_id = '".$activities."'");
                                $rowSelectJumlahUserTeam=mysqli_fetch_assoc($selectJumlahUserTeam);
                                $jumlahUserTeam = $rowSelectJumlahUserTeam['totalUser'];
                                if($jumlahUserTeam < $numberOfTeams){
                                    //insert event
                                    $insertTActivitiesTeamUsersDetail = mysqli_query($con, "INSERT into t_rel_users_activities (t_users_detail_id, t_activities_id, mode_registration, team_created, team_name, team_password) VALUES ('".$usersDetailId."', '".$activities."', '".$mode."', 0, '".$nameJoinTeam."', '".$passwordJoinTeam."');");

                                    //select event
                                    $selectTRelUserActivitiesOffline = mysqli_query($con, "SELECT 1 FROM t_rel_users_activities where t_users_detail_id = '".$usersDetailId."' and t_activities_id = '".$activities."'");
                                    
                                    if (mysqli_num_rows($selectTRelUserActivitiesOffline) > 0){
                                        $_SESSION['offlineActivities'] = 1;                
                                        $_SESSION['successRegisActivities'] = 1;
                                        $_SESSION['messageRegisActivities'] = "Registration Join Team Success";
                                        header("Location: ../../users");
                                    }else{
                                        $_SESSION['offlineActivities'] = 0;                
                                        $_SESSION['successRegisActivities'] = 2;
                                        $_SESSION['messageRegisActivities'] = "Something's Wrong, Please Try Again Later";
                                        header("Location: ../../users");
                                    }
                                }
                                else{
                                    $_SESSION['successRegisActivities'] = 2;
                                    $_SESSION['messageRegisActivities'] = "Max Alowed User For This Events Is : ".$numberOfTeams;
                                    header("Location: ../../users");
                                }

                            }else{
                                $_SESSION['successRegisActivities'] = 2;
                                $_SESSION['messageRegisActivities'] = "Different Wijk! You Can Only Join With The Same Wijk";
                                header("Location: ../../users");
                            }
                        }else{
                            $_SESSION['offlineActivities'] = 0;                
                            $_SESSION['successRegisActivities'] = 2;
                            $_SESSION['messageRegisActivities'] = "Wrong Team Name/Password/Events";
                            header("Location: ../../users");
                        }
                    }else{
                        $_SESSION['offlineActivities'] = 0;                
                        $_SESSION['successRegisActivities'] = 2;
                        $_SESSION['messageRegisActivities'] = "Team Name/Password Empty";
                        header("Location: ../../users");
                    }
                }
            }
        }
    }
}

?>	