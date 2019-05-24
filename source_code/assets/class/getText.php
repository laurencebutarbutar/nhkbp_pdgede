<?php
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
date_default_timezone_set('Asia/Jakarta');

include_once 'textToImage.php';

$text=null;
$size=null;
$bgCol=null;
$textCol=null;

if (isset($_GET['tx'])){
	$text=$_GET['tx'];
}

if (isset($_GET['sz'])){
	$size=$_GET['sz'];
}

if (isset($_GET['bg1'])&&isset($_GET['bg2'])&&isset($_GET['bg3'])){
	$bgCol[]=$_GET['bg1'];
	$bgCol[]=$_GET['bg2'];
	$bgCol[]=$_GET['bg3'];
}

if (isset($_GET['tx1'])&&isset($_GET['tx2'])&&isset($_GET['tx3'])){
	$textCol[]=$_GET['tx1'];
	$textCol[]=$_GET['tx2'];
	$textCol[]=$_GET['tx3'];
}

sendimagetext($text, $bgCol, $textCol, $size);

