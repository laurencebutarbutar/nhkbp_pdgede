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
$pathImageCariKata = "../../assets/img/cari_kata/";
$pathServiceCariKata = "../../services/cari_kata/";
$pathViewCariKata = "../../view/cari_kata/";
$pathCSSCariKata = "../../assets/css/";
$pathJsCariKata = "../../assets/js/";
$pathClassCariKata = "../../assets/class/";
$root = "../../";

session_start();

//validasi jump page
$_SESSION['validPlayCariKata'] = false;

//validasi CariKata
$loginEvents = $_SESSION['loginCariKata']; //validasi event, soal, dan user
$highScore = $_SESSION['highScoreUserCariKata']; //highscore
$nickName = $_SESSION['nickName']; //nickname
$appsId = $_SESSION['appsIdCariKata']; //apps_id game
$userIdLogin = $_SESSION['userIdLoginCariKata']; //userIdLogin

$timeLimit = 12; //batas waktu untuk user dapat login kembali
// $lastPlayedUsers = $_SESSION['lastPlayedUsers']; //terkahir kali player main

$statusLoginCariKata = $_SESSION['statusLoginCariKata']; //status Login CariKata
$messageLoginCariKata = $_SESSION['messageLoginCariKata']; //message Login CariKata

if($loginEvents === null || $highScore === null || $nickName === null || $appsId === null || $userIdLogin === null){
    $_SESSION['failedLogin'] = "Please Login!";
    header("Location: ../../view/home/login.php");  
}

if (isset($_SESSION['game_numberCariKata'])&&isset($_SESSION['game_idCariKata'])){
	//validasi agar tidak bisa di back
	// $_SESSION['answerButton'] = $_POST['answerButton2'];	
	// $_SESSION['answerPage'] = 0;

	$_SESSION['validGameCariKata'] = true;	
	$_SESSION['game_numberCariKata'] = intval($_SESSION['game_numberCariKata'])+1;
	$lastID=null;
	$randID=null;	
	$playedID=null;
	$counterRandom=0;

	//soal dan jawaban
	$_SESSION['questCariKata'] = null;
	$_SESSION['answerCariKata'] = null;


	if (!isset($_SESSION['totalScoreCariKata'])){
		$_SESSION['totalScoreCariKata'] = 0;
	}
		
	if (!isset($_SESSION['totalSalahCariKata'])){
		$_SESSION['totalSalahCariKata'] = 0;
	}

	if (isset($_SESSION['getPlayedIDCariKata'])){
		$playedID = $_SESSION['getPlayedIDCariKata'];
	} else {
		$_SESSION['getPlayedIDCariKata']=null;
	}	
	
	//========================================== DB CONNECTION ====================================
	include_once $pathClassCariKata.'dbConnection.php';
	//========================================== DB CONNECTION ====================================

	if (!mysqli_connect_errno()){

		//cek soal join ke event untuk mendapatkan soal pada tanggal tersebut
		// $result = mysqli_query($con, "SELECT id FROM quests WHERE apps_id='".$appsId."'");
		$result = mysqli_query($con, "SELECT q.id FROM quests q JOIN events ev ON ev.id = q.events_id AND ev.apps_id = q.apps_id AND CURRENT_TIMESTAMP BETWEEN ev.start_at AND ev.end_at WHERE ev.apps_id = '".$appsId."'");

		if (mysqli_num_rows($result) == 0){
			$_SESSION['statusLoginCariKata'] = 3; //status Login CariKata
			$_SESSION['messageLoginCariKata'] = "Outdated Game, We Will Update Soon"; //message Login CariKata 
		    header("Location: ".$root."cari-kata");  
		}
		else{
			while ($row = mysqli_fetch_array($result)):
				$lastID[]=$row['id'];
			endwhile;
		}

		if ($_SESSION['game_idCariKata']==0){
			$randID=array_rand($lastID, 1);
		}
		else{
			if (mysqli_num_rows($result)==1){
				//make it trough to notification's page

				$counterRandom=11;			
			}
			else{
				$randID = checkForAnotherID($lastID);
				while (!checkPlayedIDGames($playedID, $lastID[$randID])){
					$randID = checkForAnotherID($lastID);
					$counterRandom++;
					if ($counterRandom>10){ // max itteration
						break;
					}
				}
			}
		}

		$_SESSION['game_idCariKata']=intval($lastID[$randID]);
		$_SESSION['getPlayedIDCariKata'][]= $_SESSION['game_idCariKata'];

		if ($counterRandom>10){
			//pengecekan apabila soal yang baru kurang dari 10
			$_SESSION['statusLoginCariKata'] = 3; //status Login CariKata
			$_SESSION['messageLoginCariKata'] = "Sorry, Outdated Game, We Will Update Soon"; //message Login CariKata 
		    header("Location: ../../cari-kata");  			
		} else {
			$_SESSION['validPlayCariKata'] = true;

			// load soal dan jawaban
			$result = mysqli_query($con, "SELECT quest, answer, events_id, additional FROM quests WHERE apps_id=".$appsId." AND id ='".$_SESSION['game_idCariKata']."'");

			if (mysqli_num_rows($result) > 0){
				$rowResult = mysqli_fetch_assoc($result);
				$quest=$rowResult['quest'];
				$answer=$rowResult['answer'];
				$eventsId = $rowResult['events_id'];
				$additional = $rowResult['additional'];
			}

			//validasi terakhir kali user bermain
			$selectlastPlayedUsers = mysqli_query($con, "SELECT created_at FROM users_score where users_id = '".$userIdLogin."' AND apps_id = '".$appsId."' AND events_id = '".$eventsId."' ORDER BY created_at desc limit 1");

			if (mysqli_num_rows($selectlastPlayedUsers) > 0){
				$rowSelectlastPlayedUsers = mysqli_fetch_assoc($selectlastPlayedUsers);
				$lastPlayedUsers = $rowSelectlastPlayedUsers['created_at'];

				$now = date("Y-m-d H:i:s");
				$date2Timestamp = strtotime($now);
				$date1Timestamp = strtotime($lastPlayedUsers);

				$timeStampHours = $date2Timestamp - $date1Timestamp;
				$hours = $timeStampHours / 60 / 60;

				if($hours < $timeLimit){				
					$timeLeft = $hours - $timeLimit;

					$_SESSION['statusLoginCariKata'] = 2; //status Login CariKata
					$_SESSION['messageLoginCariKata'] = round(abs($timeLeft),1)." hours left, until you can play again."; //message Login CariKata 
				    header("Location: ../../cari-kata");  
				}
				else{
					$_SESSION['questCariKata'] = $quest;
					$_SESSION['answerCariKata'] = $answer;
					$_SESSION['events_idCariKata'] = $eventsId;
					$_SESSION['additionalCariKata'] = $additional;

					header("Location: ".$pathViewCariKata."play.php");
				}				
			}
			else{
				$_SESSION['questCariKata'] = $quest;
				$_SESSION['answerCariKata'] = $answer;
				$_SESSION['events_idCariKata'] = $eventsId;
				$_SESSION['additionalCariKata'] = $additional;
				header("Location: ".$pathViewCariKata."play.php");
			}			
		}		
	}		
	else{
		die("Connection error: " . mysqli_connect_errno());
	}	
} else {
	$_SESSION['statusLoginCariKata'] = 2; //status Login CariKata
	$_SESSION['messageLoginCariKata'] = "Wrong Game !"; //message Login CariKata 
	header("Location: ".$root."cari-kata");
}

function checkPlayedIDGames($objPlayed, $selectedID){
	$isAllowed=true;
	if ($objPlayed != null){
		if (count($objPlayed)>1){
			for ($i=0; $i<count($objPlayed); $i++){
				if ($objPlayed[$i] == $selectedID){
					$isAllowed=false;
					break;
				}
			}
		}
	}
	return $isAllowed;
}

function checkForAnotherID($prevID){
	$random=null;
	$exist = intval($_SESSION['game_idCariKata']);
	$param = $prevID[$random=array_rand($prevID, 1)];

	while ($exist==$param){
		$param = $prevID[$random=array_rand($prevID, 1)];
	}
	
	return $random;
}
?>	