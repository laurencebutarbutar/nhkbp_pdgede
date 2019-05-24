<?php
//========================================== DB CONNECTION ====================================

$hostname="localhost";
$username="nhkr3131_root";//galr7971
$password="h9H7e1wbbgcP23";//logger-016!

//$dbname="wap_tts_ramadhan";//galr7971_wap_tts
$dbname="nhkr3131_dbGames";//galr7971_wap_tts

$con = mysqli_connect($hostname, $username, $password);
//$selected = mysqli_select_db($dbname,$con);
$selected = mysqli_select_db($con, $dbname);
//========================================== DB CONNECTION ====================================
?>