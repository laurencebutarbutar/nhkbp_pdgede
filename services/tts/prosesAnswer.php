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

$appsId = $_SESSION['appsId']; //apps_id game
$eventsId = $_SESSION['events_id']; //events_id
$userIdLogin = $_SESSION['userIdLogin']; //userIdLogin
//validasi back force
$validPlay = $_SESSION['validPlay'];

$jawaban_bener = null;
$gameNumber=null;

if($validPlay !== true || $userIdLogin === null || $eventsId === null || $appsId === null){
    $_SESSION['failedLogin'] = "Please Login!";
    header("Location: ../../view/home/login.php");  
}

if (isset($_SESSION['validGame'])){    
    if ($_SESSION['validGame']){        
        // make sure that user cannot replay the current game board        
        $jawaban_bener = $_SESSION['jawaban'];
        $gameNumber=intval($_SESSION['game_number']);        
    } else {
        $_SESSION['statusLoginTTS'] = 2; //status Login TTS
        $_SESSION['messageLoginTTS'] = "Sorry, Can't Resume Level"; //message Login TTS 
        header("Location: ".$root."tts");  
    }    
} else {    
    $_SESSION['failedLogin'] = "Please Login!";
    header("Location: ../../view/home/login.php");  
}

//score    
$answer=null;
foreach ($_POST as $field) {
    $answer = $field;
}

$kataMendatar[]="";
$jawabanMendatar[]="";
$idMendatar=0;
$idJwbMendatar=0;
$nilaiMendatar=0;
$totalBenarMendatar=0;
$totalSalahMendatar=0;

//Nilai Mendatar
for ($i=0; $i<10; $i++){
        $idMendatar++;
        $kataMendatar[$idMendatar]="";
    for ($j=0; $j<10; $j++){        
        if (isset($answer[$i][$j])){
            if ($answer[$i][$j]!="" && $answer[$i][$j]!='' && $answer[$i][$j]!=NULL && $answer[$i][$j]!=null){
                $kataMendatar[$idMendatar].=$answer[$i][$j];
            }
        }
        else {
            $idMendatar++;
            $kataMendatar[$idMendatar]="";
        }
    }
}

for ($i=0; $i<10; $i++){
        $idJwbMendatar++;
        $jawabanMendatar[$idJwbMendatar]="";
    for ($j=0; $j<10; $j++){        
        if ($jawaban_bener[$i][$j]!="" && $jawaban_bener[$i][$j]!="#"){
            if ($jawaban_bener[$i][$j]!="" && $jawaban_bener[$i][$j]!='' && $jawaban_bener[$i][$j]!=NULL && $jawaban_bener[$i][$j]!=null){
                $jawabanMendatar[$idJwbMendatar].=$jawaban_bener[$i][$j];
            }
        }
        else {
            $idJwbMendatar++;
            $jawabanMendatar[$idJwbMendatar]="";    
        }
    }
}

$temp=null;
for ($i=0; $i<count($kataMendatar); $i++){  
    if (strlen($kataMendatar[$i])>1){
        $temp[]=$kataMendatar[$i];
    }   
}
$kataMendatar=$temp;
$temp=null;
for ($i=0; $i<count($jawabanMendatar); $i++){   
    if (strlen($jawabanMendatar[$i])>1){
        $temp[]=$jawabanMendatar[$i];
    }   
}

$jawabanMendatar=$temp;
$tempSalahMendatar = NULL;
$countSalahMendatar = 0;
for ($i=0;$i<count($kataMendatar);$i++){
    for ($j=0; $j<count($jawabanMendatar);$j++){
            if(strtolower($kataMendatar[$i])== strtolower($jawabanMendatar[$j])){
                $nilaiMendatar += 100;
                $totalBenarMendatar++;
                $totalSalahMendatar+=0; 
            }   
            else{
                $tempSalahMendatar ++;
            }        
    }
    if($tempSalahMendatar == count($jawabanMendatar)){
        $nilaiMendatar += 0;
        $totalBenarMendatar+=0;
        $totalSalahMendatar++;
    }
    $tempSalahMendatar = NULL;
}

$countSalahMendatar = count($jawabanMendatar) - count($kataMendatar);
$totalSalahMendatar = $totalSalahMendatar + $countSalahMendatar;
$kataMenurun[]="";
$idMenurun=0;
$jawabanMenurun[]="";
$idJwbMenurun=0;
$nilaiMenurun=0;
$nilaiTotal=0;
$totalBenarMenurun=0;
$totalSalahMenurun=0;
$totalBenar=0;
$totalSalah=0;
for ($i=0; $i<10; $i++){
    $idMenurun++;
    $kataMenurun[$idMenurun]="";
    for ($j=0; $j<10; $j++){        
        if (isset($answer[$j][$i])){
            if ($answer[$j][$i]!="" && $answer[$j][$i]!='' && $answer[$j][$i]!=NULL && $answer[$j][$i]!=null){
                $kataMenurun[$idMenurun].=$answer[$j][$i];
            }
        }
        else {
            $idMenurun++;
            $kataMenurun[$idMenurun]="";
        }
    }
}

$temp=null;
for ($i=0; $i<count($kataMenurun); $i++){   
    if (strlen($kataMenurun[$i])>1){
        $temp[]=$kataMenurun[$i];
    }   
}

$kataMenurun=$temp;

for ($i=0; $i<10; $i++){
        $idJwbMenurun++;
        $jawabanMenurun[$idJwbMenurun]="";
    for ($j=0; $j<10; $j++){        
        if ($jawaban_bener[$j][$i]!="" && $jawaban_bener[$j][$i]!="#"){
            if ($jawaban_bener[$j][$i]!="" && $jawaban_bener[$j][$i]!='' && $jawaban_bener[$j][$i]!=NULL && $jawaban_bener[$j][$i]!=null){
                $jawabanMenurun[$idJwbMenurun].=$jawaban_bener[$j][$i];
            }
        }
        else {
            $idJwbMenurun++;
            $jawabanMenurun[$idJwbMenurun]="";  
        }
    }
}

$temp=null;
for ($i=0; $i<count($jawabanMenurun); $i++){    
    if (strlen($jawabanMenurun[$i])>1){
        $temp[]=$jawabanMenurun[$i];
    }   
}

$jawabanMenurun=$temp;
$tempSalahMenurun = NULL;
$countSalahMenurun = 0;
for ($i=0;$i<count($kataMenurun);$i++){
    for ($j=0; $j<count($jawabanMenurun);$j++){     
            if(strtolower($kataMenurun[$i])== strtolower($jawabanMenurun[$j])){
                $nilaiMenurun += 100;
                $totalBenarMenurun++;
                $totalSalahMenurun+=0;  
            }   
            else{
                $tempSalahMenurun ++;
            }
        
    }

    if($tempSalahMenurun == count($jawabanMenurun)){
        $nilaiMenurun += 0;
        $totalBenarMenurun+=0;
        $totalSalahMenurun++;
    }
    else{
    }
    $tempSalahMenurun = NULL;
}

$countSalahMenurun = count($jawabanMenurun) - count($kataMenurun);
$totalSalahMenurun = $totalSalahMenurun + $countSalahMenurun;

$nilaiTotal = $nilaiMenurun + $nilaiMendatar;
$totalBenar = $totalBenarMenurun + $totalBenarMendatar;
$totalSalah = $totalSalahMenurun + $totalSalahMendatar;
//akhir score
    
//Validasi page
//Total Salah
if (isset($_SESSION['totalSalah'])){
    $_SESSION['totalSalah'] += $totalSalah;
}
else {
    $_SESSION['totalSalah'] = $totalSalah;
}
    //Total Score
if (isset($_SESSION['totalScore'])){
    $_SESSION['totalScore'] += $nilaiTotal;
}
else {
    $_SESSION['totalScore'] = $nilaiTotal;
}

//========================================== DB CONNECTION ====================================
include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================
// validasi tamat
if($_SESSION['game_number'] >= 10){
    //insert score db
    if (!mysqli_connect_errno()){
        //langsung di false, agar tidak dapat balik ke play
        $_SESSION['validPlay'] = false;
        $insertScoreUser = mysqli_query($con, "INSERT INTO users_score (users_id, apps_id, events_id, score, level, created_at) values ('".$userIdLogin."', '".$appsId."', '".$eventsId."', '".$_SESSION['totalScore']."', '".$_SESSION['game_number']."', CURRENT_TIMESTAMP);");
        if($_SESSION['totalScore'] > $_SESSION['highScoreUser']){
            $_SESSION['highScoreUser'] = $_SESSION['totalScore'];
        }
        header("Location: ../../view/tts/winner.php"); 
    }
    else{
        die("Connection error: " . mysqli_connect_errno());
    }
}
else{
    //validasi total salah - game over
    if($_SESSION['totalSalah'] > 5){
        //insert db
        if (!mysqli_connect_errno()){
            //langsung di false, agar tidak dapat balik ke play
            $_SESSION['validPlay'] = false;
            $insertScoreUser = mysqli_query($con, "INSERT INTO users_score (users_id, apps_id, events_id, score, level, created_at) values ('".$userIdLogin."', '".$appsId."', '".$eventsId."', '".$_SESSION['totalScore']."', '".$_SESSION['game_number']."', CURRENT_TIMESTAMP);");
            if($_SESSION['totalScore'] > $_SESSION['highScoreUser']){
                $_SESSION['highScoreUser'] = $_SESSION['totalScore'];
            }
            header("Location: ../../view/tts/gameOver.php"); 
        }
        else{
            die("Connection error: " . mysqli_connect_errno());
        }
    }
    else{
        //modifikasi di sini apabila tidak ingin memunculkan answer.php
        header("Location: ../../view/tts/answer.php"); 
    }
}

?>