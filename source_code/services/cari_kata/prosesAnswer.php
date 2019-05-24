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

$appsId = $_SESSION['appsIdCariKata']; //apps_id game
$eventsId = $_SESSION['events_idCariKata']; //events_id
$userIdLogin = $_SESSION['userIdLoginCariKata']; //userIdLogin
$validPlay = $_SESSION['validPlayCariKata']; //validasi back force

//score    
$err_insert=false;
$error=0;
$errorPerGame=0;
$validToCheck=true;
$gamePlayNumber=$_SESSION['game_numberCariKata'];
	
$right=0;
$score=0;
$tempAnswer=null;
$isRight=false;
$rightAnswer=$_SESSION['answerCariKata'];
$answer=$_POST['ansCariKata'];
$wrongAnswer=array();

// explode answer first
if ($rightAnswer!=null||$rightAnswer!=NULL||$rightAnswer!=''||$rightAnswer!=""):
    $rightAnswer = explode ("^", $rightAnswer);
endif;

//perhitungan score dan salah
for ($i=0; $i<count($rightAnswer)-1; $i++):
	$isRight=false;
	$checkExisting=true;	
	if ($answer[$i]!=""||$answer[$i]!=''||$answer[$i]!=null||$answer[$i]!=NULL):
		if ($tempAnswer==null):			
			for ($k=0; $k<count($rightAnswer); $k++):				
				if (strtoupper(trim(strip_tags($answer[$i])))==strtoupper(trim(strip_tags($rightAnswer[$k])))):
					$tempAnswer[]=strtoupper($rightAnswer[$k]);
					$isRight=true;
					break;
				endif;				
			endfor;			
		else:			
			for ($k=0; $k<count($tempAnswer); $k++):				
				if (strtoupper(trim(strip_tags($answer[$i])))==strtoupper(trim(strip_tags($tempAnswer[$k])))):
						$checkExisting=false;
						$isRight=false;
					break;					
				endif;				
			endfor;			
			if ($checkExisting):				
				for ($t=0; $t<count($rightAnswer); $t++):						
					if (strtoupper(trim(strip_tags($answer[$i])))==strtoupper(trim(strip_tags($rightAnswer[$t])))):
						$tempAnswer[]=strtoupper($rightAnswer[$t]);
						$isRight=true;
						break;
					endif;
				endfor;				
			endif;			
		endif;
	else:
		$isRight=false;
	endif;
	if ($isRight):
		$right++;
		$wrongAnswer[]=null;
	else:
		$error++;
		$errorPerGame++;
		$wrongAnswer[]="error";
	endif;
endfor;

$score=intval($right)*100;
    
//Validasi page
//Total Salah
if (isset($_SESSION['totalSalahCariKata'])){
    $_SESSION['totalSalahCariKata'] += $error;
}
else {
    $_SESSION['totalSalahCariKata'] = $error;
}
    //Total Score
if (isset($_SESSION['totalScoreCariKata'])){
    $_SESSION['totalScoreCariKata'] += $score;
}
else {
    $_SESSION['totalScoreCariKata'] = $score;
}
echo "total jawaban yang benar ". count($rightAnswer) . "<br>";
echo "jawaban anda ". $answer[0] . "<br>";
echo "score saat ini ". $score . "<br>";
echo "total salah saat ini ". $error . "<br>";
echo $_SESSION['totalScoreCariKata'];
echo $_SESSION['totalSalahCariKata'];
echo "total salah saat ini ". $gamePlayNumber . "<br>";
// ========================================== DB CONNECTION ====================================
include_once '../../assets/class/dbConnection.php';
// ========================================== DB CONNECTION ====================================
// validasi tamat
if($_SESSION['game_numberCariKata'] >= 15){
    // insert score db
    if (!mysqli_connect_errno()){
        //langsung di false, agar tidak dapat balik ke play
        $_SESSION['validPlayCariKata'] = false;

        $insertScoreUser = mysqli_query($con, "INSERT INTO users_score (users_id, apps_id, events_id, score, level, created_at) values ('".$userIdLogin."', '".$appsId."', '".$eventsId."', '".$_SESSION['totalScoreCariKata']."', '".$_SESSION['game_numberCariKata']."', CURRENT_TIMESTAMP);");
        if($_SESSION['totalScoreCariKata'] > $_SESSION['highScoreUserCariKata']){
            $_SESSION['highScoreUserCariKata'] = $_SESSION['totalScoreCariKata'];
        }
        header("Location: ../../view/cari_kata/winner.php"); 
    }
    else{
        die("Connection error: " . mysqli_connect_errno());
    }
}
else{
    //validasi total salah - game over
    if($_SESSION['totalSalahCariKata'] > 3){
        //langsung di false, agar tidak dapat balik ke play
        $_SESSION['validPlayCariKata'] = false;

        //insert db
        if (!mysqli_connect_errno()){
            $insertScoreUser = mysqli_query($con, "INSERT INTO users_score (users_id, apps_id, events_id, score, level, created_at) values ('".$userIdLogin."', '".$appsId."', '".$eventsId."', '".$_SESSION['totalScoreCariKata']."', '".$_SESSION['game_numberCariKata']."', CURRENT_TIMESTAMP);");
            if($_SESSION['totalScoreCariKata'] > $_SESSION['highScoreUserCariKata']){
                $_SESSION['highScoreUserCariKata'] = $_SESSION['totalScoreCariKata'];
            }
            header("Location: ../../view/cari_kata/gameOver.php"); 
        }
        else{
            die("Connection error: " . mysqli_connect_errno());
        }
    }
    else{
        //modifikasi di sini apabila tidak ingin memunculkan answer.php
        header("Location: ../../view/cari_kata/answer.php"); 
    }
}

?>