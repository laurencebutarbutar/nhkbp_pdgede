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
$nameFood = $_POST['nameFood'];
$noteOrder = $_POST['noteOrder'];
$foodDate = $_POST['orderFoodDate'];
$foodTime = $_POST['orderFoodTime'];
$totalPayHidden = $_POST['totalPayHidden'];

if($usersDetailId === null || $nameFood === null || $foodDate === null || $foodTime === null || $totalPayHidden === null){
	$_SESSION['successRegisActivities'] = 2;
    $_SESSION['messageRegisActivities'] = "Oops, There's Missing Field, Please Check Again";
    header("Location: ../../users");
}

$explodeTime = explode(" ", $foodTime);
$newDateTimeStamp = $foodDate . " ".$explodeTime[1];
$dtime = DateTime::createFromFormat("D, j F Y G:i", $newDateTimeStamp);
$timestamp = $dtime->getTimestamp();
$netTimestampDelivery = date("Y-m-d H:i:s",$timestamp);

//========================================== DB CONNECTION ====================================
    include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================

$current = null;
$currentValue = null;
$cnt = 0;
$num = 1;
$numArray = 0;
$nameFoodNew = array();
$priceFoodNew = array();
$qtyFoodNew = array();

sort($nameFood);
for ($i = 0; $i < count($nameFood); $i++) {
    if ($nameFood[$i] != $current) {
        if ($cnt > 0) {
            $tempCurrentValue = substr($current, strlen($current)-8, 7);
            $currentValue = str_replace(".","",$tempCurrentValue);
            $currentNew = substr($current, 0, strlen($current)-13);
            $nameFoodNew [$numArray] = $currentNew;
            $priceFoodNew [$numArray] = $currentValue;
            $qtyFoodNew [$numArray] = $cnt;
            $num ++;
            $numArray ++;
        }
        $current = $nameFood[$i];
        $cnt = 1;
    } else {
        $cnt++;
    }
}
if ($cnt > 0) {
    $tempCurrentValue = substr($current, strlen($current)-8, 7);
    $currentValue = str_replace(".","",$tempCurrentValue);
    $currentNew = substr($current, 0, strlen($current)-13); 
    $nameFoodNew [$numArray] = $currentNew;
    $priceFoodNew [$numArray] = $currentValue;
    $qtyFoodNew [$numArray] = $cnt;
    $num ++;
    $numArray ++;
}

if (!mysqli_connect_errno()){
    //cek order dulu ada pesanan yang pending atau tidak, kalau ada gak bisa pesen
    $selectTOrder = mysqli_query($con, "SELECT 1 FROM t_order where t_users_detail_id = '".$usersDetailId."' and status = 0");

    if (mysqli_num_rows($selectTOrder) > 0){
        $_SESSION['successRegisActivities'] = 2;
        $_SESSION['messageRegisActivities'] = "Sorry, you already have pending order.";
        header("Location: ../../users");
    }else{
        //insert order
        $inserOrder = mysqli_query($con, "INSERT into t_order (t_users_detail_id, note, delivery_date, total_payment, created_at, status) VALUES ('".$usersDetailId."', '".$noteOrder."', '".$netTimestampDelivery."', '".$totalPayHidden."', CURRENT_TIMESTAMP,0);");
        $lastIdOrder = mysqli_insert_id($con);

        //insert orders detail
        for($x=0; $x<count($nameFoodNew);$x++){
            $inserOrdersDetail = mysqli_query($con, "INSERT into t_orders_detail (t_order_id, name, price_unit, quantity) VALUES ('".$lastIdOrder."', '".$nameFoodNew[$x]."', '".$priceFoodNew[$x]."', '".$qtyFoodNew[$x]."');");
        }
        //sent session
        $_SESSION['note'] = $noteOrder;
        $_SESSION['delivery_date'] = $netTimestampDelivery;
        $_SESSION['total_payment'] = $totalPayHidden;
        $_SESSION['nameFoodNew'] = $nameFoodNew;
        $_SESSION['price_unit'] = $priceFoodNew;
        $_SESSION['quantity'] = $qtyFoodNew;
        $lastIdOrderNew = 'RO-'.date("Ymd").'-'.$lastIdOrder;
        $_SESSION['lastIdOrder'] = $lastIdOrderNew;
        //sent email
        header("Location: generatePdf.php");
    }	
}else{
 	die("Connection error: " . mysqli_connect_errno());
}
?>	