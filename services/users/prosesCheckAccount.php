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
if($usernameLogin === null){
    header("Location: ../../view/home/login.php");      
}

//========================================== DB CONNECTION ====================================
	include_once $pathClassUsers.'dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){
    //hobbies
    $selectUsersHobbies = mysqli_query($con, "SELECT th.hobby FROM t_rel_users_hobbies truh JOIN t_users_detail tud ON tud.id = truh.t_users_detail_id JOIN t_hobbies th ON truh.t_hobbies_id = th.id WHERE tud.id = '".$usersDetailId."'");

    if (mysqli_num_rows($selectUsersHobbies) > 0){
        while ($rowSelectUsersHobbies = mysqli_fetch_array($selectUsersHobbies)):
            $hobbiesAccount[]=$rowSelectUsersHobbies['hobby'];
        endwhile;   
        $_SESSION['hobbiesAccount'] = $hobbiesAccount;
    }

    //offline activities registered
    $selectOfflineActivities = mysqli_query($con, "SELECT ta.name, trua.team_created, trua.team_name, trua.team_password FROM t_rel_users_activities trua JOIN t_activities ta ON ta.id = trua.t_activities_id AND ta.group = 'offline events' WHERE trua.t_users_detail_id = '".$usersDetailId."'");

    if (mysqli_num_rows($selectOfflineActivities) > 0){
        $rowSelectOfflineActivities = mysqli_fetch_assoc($selectOfflineActivities);
        $_SESSION['offlineEventsName'] = $rowSelectOfflineActivities['name'];
        $_SESSION['offlineEventsTeamCreated'] = $rowSelectOfflineActivities['team_created'];
        $_SESSION['offlineEventsTeamName'] = $rowSelectOfflineActivities['team_name'];
        $_SESSION['offlineEventsTeamPassword'] = $rowSelectOfflineActivities['team_password'];        
    }

    //highscore TTS
    $selectHighScore = mysqli_query($con, "SELECT us.score FROM users_score us JOIN events e on e.id = us.events_id AND e.apps_id = us.apps_id AND CURRENT_TIMESTAMP BETWEEN e.start_at AND e.end_at JOIN users u on u.id = us.users_id JOIN t_users_detail tu ON tu.id = u.t_users_detail_id WHERE e.apps_id = 12 AND u.t_users_detail_id = '".$usersDetailId."' ORDER BY us.score DESC, us.created_at ASC LIMIT 1");

    if (mysqli_num_rows($selectHighScore) > 0){
        $rowSelectHighScore = mysqli_fetch_assoc($selectHighScore);
        $_SESSION['highScoreTTSAccount'] = $rowSelectHighScore['score'];  
    }

    //highscore Cari Kata
    $selectHighScore = mysqli_query($con, "SELECT us.score FROM users_score us JOIN events e on e.id = us.events_id AND e.apps_id = us.apps_id AND CURRENT_TIMESTAMP BETWEEN e.start_at AND e.end_at JOIN users u on u.id = us.users_id JOIN t_users_detail tu ON tu.id = u.t_users_detail_id WHERE e.apps_id = 13 AND u.t_users_detail_id = '".$usersDetailId."' ORDER BY us.score DESC, us.created_at ASC LIMIT 1");

    if (mysqli_num_rows($selectHighScore) > 0){
        $rowSelectHighScore = mysqli_fetch_assoc($selectHighScore);
        $_SESSION['highScoreCariKataAccount'] = $rowSelectHighScore['score'];  
    }

    //Team member
    $selectTeamMember = mysqli_query($con, "select tud.full_name, tud.phone, trua.team_created from t_rel_users_activities trua JOIN t_users_detail tud ON tud.id = trua.t_users_detail_id WHERE trua.team_name = '".$_SESSION['offlineEventsTeamName']."' AND trua.mode_registration = 'Team'");

    if (mysqli_num_rows($selectTeamMember) > 0){
        while ($rowSelectTeamMember = mysqli_fetch_array($selectTeamMember)):
            $teamMemberName[] =$rowSelectTeamMember['full_name'];
            $teamMemberPhone[]=$rowSelectTeamMember['phone'];
            $teamCreated[]=$rowSelectTeamMember['team_created'];
        endwhile;
        $_SESSION['teamMemberName'] = $teamMemberName;
        $_SESSION['teamMemberPhone'] = $teamMemberPhone;
        $_SESSION['teamCreated'] = $teamCreated;

    }

    //social media
    $selectMedSos = mysqli_query($con, "select name, id_medsos from t_users_medsos where t_users_detail_id = '".$usersDetailId."'");

    if (mysqli_num_rows($selectMedSos) > 0){
        while ($rowSelectTeamMember = mysqli_fetch_array($selectMedSos)):
            $medSosName[]=$rowSelectTeamMember['name'];
            $medSosId[]=$rowSelectTeamMember['id_medsos'];
        endwhile;
        $_SESSION['medSosName'] = $medSosName;
        $_SESSION['medSosId'] = $medSosId;
    }

    header("Location: ".$root."view/users/account.php");
	
}
else{
	die("Connection error: " . mysqli_connect_errno());
}
?>	