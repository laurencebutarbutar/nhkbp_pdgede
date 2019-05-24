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
$pathImageTTS = "../../assets/img/tts/";
$pathServiceTTS = "../../services/tts/";
$pathViewTTS = "../../view/tts/";
$pathCSSTTS = "../../assets/css/";
$pathJsTTS = "../../assets/js/";
$pathClassTTS = "../../assets/class/";
$root = "../../";

session_start();

//validasi back force
$_SESSION['validPlay'] = false;

//validasi TTS
$loginEvents = $_SESSION['loginTTS']; //validasi event, soal, dan user
$highScore = $_SESSION['highScoreUser']; //highscore
$nickName = $_SESSION['nickName']; //nickname
$appsId = $_SESSION['appsId']; //apps_id game
$userIdLogin = $_SESSION['userIdLogin']; //userIdLogin

$timeLimit = 12; //batas waktu untuk user dapat login kembali
$lastPlayedUsers = $_SESSION['lastPlayedUsers']; //terkahir kali player main

$statusLoginTTS = $_SESSION['statusLoginTTS']; //status Login TTS
$messageLoginTTS = $_SESSION['messageLoginTTS']; //message Login TTS

if($loginEvents === null || $highScore === null || $nickName === null || $appsId === null || $userIdLogin === null){
    $_SESSION['failedLogin'] = "Please Login!";
    header("Location: ../../view/home/login.php");  
}

if (isset($_SESSION['game_number'])&&isset($_SESSION['game_id'])){
	//validasi agar tidak bisa di back
	$_SESSION['answerButton'] = $_POST['answerButton2'];	
	$_SESSION['answerPage'] = 0;

	$_SESSION['validGame'] = true;	
	$_SESSION['game_number'] = intval($_SESSION['game_number'])+1;
	$lastID=null;
	$randID=null;	
	$playedID=null;
	$counterRandom=0;

	//soal dan jawaban
	$_SESSION['quest'] = null;
	$_SESSION['answer'] = null;


	if (!isset($_SESSION['totalScore'])){
		$_SESSION['totalScore'] = 0;
	}
		
	if (!isset($_SESSION['totalSalah'])){
		$_SESSION['totalSalah'] = 0;
	}

	if (isset($_SESSION['getPlayedID'])){
		$playedID = $_SESSION['getPlayedID'];
	} else {
		$_SESSION['getPlayedID']=null;
	}	
	
	//========================================== DB CONNECTION ====================================
	include_once $pathClassTTS.'dbConnection.php';
	//========================================== DB CONNECTION ====================================

	if (!mysqli_connect_errno()){

		//cek soal join ke event untuk mendapatkan soal pada tanggal tersebut
		$result = mysqli_query($con, "SELECT q.id FROM quests q JOIN events ev ON ev.id = q.events_id AND ev.apps_id = q.apps_id AND CURRENT_TIMESTAMP BETWEEN ev.start_at AND ev.end_at WHERE ev.apps_id = '".$appsId."'");

		if (mysqli_num_rows($result) == 0){
			$_SESSION['statusLoginTTS'] = 3; //status Login TTS
			$_SESSION['messageLoginTTS'] = "Outdated Game, We Will Update Soon"; //message Login TTS 
		    header("Location: ".$root."tts");  
		}
		else{
			while ($row = mysqli_fetch_array($result)):
				$lastID[]=$row['id'];
			endwhile;
		}

		if ($_SESSION['game_id']==0){
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

		$_SESSION['game_id']=intval($lastID[$randID]);
		$_SESSION['getPlayedID'][]= $_SESSION['game_id'];

		if ($counterRandom>10){
			//pengecekan apabila soal yang baru kurang dari 10
			$_SESSION['statusLoginTTS'] = 3; //status Login TTS
			$_SESSION['messageLoginTTS'] = "Sorry, Outdated Game, We Will Update Soon"; //message Login TTS 
		    header("Location: ../../tts");  			
		} else {
			$_SESSION['validPlay'] = true;

			// load soal dan jawaban
			$result = mysqli_query($con, "SELECT quest, answer, events_id FROM quests WHERE apps_id=".$appsId." AND id ='".$_SESSION['game_id']."'");

			if (mysqli_num_rows($result) > 0){
				$rowResult = mysqli_fetch_assoc($result);
				$quest=$rowResult['quest'];
				$answer=$rowResult['answer'];
				$eventsId = $rowResult['events_id'];
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

					$_SESSION['statusLoginTTS'] = 2; //status Login TTS
					$_SESSION['messageLoginTTS'] = round(abs($timeLeft),1)." hours left, until you can play again."; //message Login TTS 
				    header("Location: ../../tts");  
				}
				else{
					$_SESSION['quest'] = $quest;
					$_SESSION['answer'] = $answer;
					$_SESSION['events_id'] = $eventsId;

					header("Location: ".$pathViewTTS."play.php");
				}				
			}
			else{
				$_SESSION['quest'] = $quest;
				$_SESSION['answer'] = $answer;
				$_SESSION['events_id'] = $eventsId;

				header("Location: ".$pathViewTTS."play.php");
			}			
		}		
	}		
	else{
		die("Connection error: " . mysqli_connect_errno());
	}	
} else {
	$_SESSION['statusLoginTTS'] = 2; //status Login TTS
	$_SESSION['messageLoginTTS'] = "Wrong Game !"; //message Login TTS 
	header("Location: ".$root."tts");
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
	$exist = intval($_SESSION['game_id']);
	$param = $prevID[$random=array_rand($prevID, 1)];

	while ($exist==$param){
		$param = $prevID[$random=array_rand($prevID, 1)];
	}
	
	return $random;
}
?>	