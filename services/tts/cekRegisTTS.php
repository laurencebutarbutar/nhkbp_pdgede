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
$pathClassTTS = "../../assets/class/";
$root = "../../";

session_start();

$usernameLogin = $_SESSION['usernameLogin'];
$activitiesId = 1; //Activities id - TTS
$appsId = 12; //Apps Id - TTS
$_SESSION['successRegisActivities']; //status Login 
$_SESSION['messageRegisActivities']; //message Login

if($usernameLogin == null){
    header("Location: ../../view/home/login.php");      
}

//========================================== DB CONNECTION ====================================
	include_once $pathClassTTS.'dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){	
	$selectRegisId = mysqli_query($con, "SELECT id, t_users_detail_id FROM users where name = '".$usernameLogin."'");

	if (mysqli_num_rows($selectRegisId) > 0){
		while ($rowSelectRegisId = mysqli_fetch_array($selectRegisId)):
            $usersDetailId[]=$rowSelectRegisId['t_users_detail_id'];
            $usersId[]=$rowSelectRegisId['id'];
		endwhile;
        $usersIdLogin = $usersId[0];
        
        //select TTS Activities
        $selectUsersActivities = mysqli_query($con, "SELECT 1 FROM t_rel_users_activities where t_users_detail_id = '".$usersDetailId[0]."' and t_activities_id = '".$activitiesId."'");
        if (mysqli_num_rows($selectUsersActivities) > 0){
            
            //select apps id
            $selectAppsId = mysqli_query($con, "SELECT 1 FROM apps where id = '".$appsId."'");
            if (mysqli_num_rows($selectAppsId) > 0){

                //select events id based on current date
                $selectEventsId = mysqli_query($con, "SELECT id FROM events WHERE apps_id = '".$appsId."' and CURRENT_TIMESTAMP BETWEEN start_at and end_at");

                if (mysqli_num_rows($selectEventsId) > 0){
                    while ($rowEventsId = mysqli_fetch_array($selectEventsId)):
                        $eventsId[]=$rowEventsId['id'];
                    endwhile;

                    //select High Score Users
                    $selectHighScoreUser = mysqli_query($con, "SELECT score, created_at FROM users_score where users_id = '".$usersIdLogin."' AND apps_id = '".$appsId."' AND events_id = '".$eventsId[0]."' ORDER BY score desc limit 1");

                    if (mysqli_num_rows($selectHighScoreUser) > 0){

                        while ($rowSelectHighScoreUser = mysqli_fetch_array($selectHighScoreUser)):
                            $scoreHighUsers[]=$rowSelectHighScoreUser['score'];
                        endwhile;
                        $_SESSION['highScoreUser'] = $scoreHighUsers[0];
                    }
                    else{
                        $_SESSION['highScoreUser'] = 0;
                    } 
                    
                    $_SESSION['loginTTS'] = 1;
                    $_SESSION['userIdLogin'] = $usersIdLogin;
                    $_SESSION['appsId'] = $appsId;
                    header("Location: ".$root."/tts");
                }
                else{
                    $_SESSION['successRegisActivities'] = 2;
                    $_SESSION['messageRegisActivities'] = "Sorry, Game Has Not Updated"; //message Login
                    header("Location: ".$root."/users");
                }
            }
            else{
                $_SESSION['successRegisActivities'] = 2;
                $_SESSION['messageRegisActivities'] = "Sorry, Game Not Exist"; //message Login
                header("Location: ".$root."/users");
            }
        }
        else{
            $_SESSION['successRegisActivities'] = 2;
            $_SESSION['messageRegisActivities'] = "Please Register Game First!"; //message Login
            header("Location: ".$root."/users");
        }
    }
    else{
        $_SESSION['failedLogin'] = "Username ".$usernameLogin." Not Exist";
        header("Location: ".$root."/users");
    }    
}
else{
	die("Connection error: " . mysqli_connect_errno());
}
?>	