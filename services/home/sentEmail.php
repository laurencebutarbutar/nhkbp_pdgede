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

$nameAttribute = $_SESSION['nameAttribute'];
$valueAttribute = $_SESSION['valueAttribute'];
$emailUser = $_SESSION['emailUser'];
$subjectEmail = $_SESSION['subjectEmail'];
$fullName = $_SESSION['fullName'];

$_SESSION['statusSentEmail'] = null;

$redirectEmail = explode(" ", $subjectEmail);

//========================================== Setting Mail ====================================
    include_once "../../assets/class/class.phpmailer.php";
//========================================== Setting Mail ====================================
$mail = new PHPMailer; 
$mail->IsSMTP();
//host masing2 provider email -> JAGOANHOSTING
// $mail->SMTPSecure = 'ssl'; 
// $mail->Host = "nhkbp-pdgede.com"; 
// $mail->SMTPDebug = 2;
// $mail->Port = 465;
// $mail->SMTPAuth = true;
// $mail->Username = "admin@nhkbp-pdgede.com"; //user email
// $mail->Password = "@dminP0nd0kG3d3"; //password email 

//host masing2 provider email -> Yahoo
$mail->SMTPSecure = 'tls'; 
$mail->Host = "smtp.mail.yahoo.com"; 
$mail->SMTPDebug = 3;
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = "xxxx@yahoo.com"; //user email
$mail->Password = "xxxx"; //password email 

//host masing2 provider email -> Gmail
//if use gmail dont forget to set Less secure app access for gmail turn on in gmail setting
//turn off Signing in to Google with phone to sign in
// $mail->SMTPSecure = 'tls'; 
// $mail->Host = "smtp.gmail.com"; 
// $mail->SMTPDebug = 3;
// $mail->Port = 587;
// $mail->SMTPAuth = true;
// $mail->Username = "xxxx@gmail.com"; //user email
// $mail->Password = "xxxx"; //password email 

$emailName = $mail->Username;
$emailNameAlias = "Admin NHKBP Pondok Gede";
$msgHtml = "Dear ".$fullName.", <br><br>We got message if you forgot your ".$nameAttribute.". <br>So, we emailing you to give your ".$nameAttribute.". <br>Your ".$nameAttribute." is ".$valueAttribute.". <br><br>Regards, <br>Admin";

$mail->SetFrom($emailName,$emailNameAlias); //set email pengirim
$mail->Subject = $subjectEmail; //subyek email
$mail->AddAddress($emailUser,$fullName);  //tujuan email
$mail->MsgHTML($msgHtml);
if($mail->Send()){
    $_SESSION['nameAttribute'] = null;
    $_SESSION['valueAttribute'] = null;
    $_SESSION['emailUser'] = null;
    $_SESSION['subjectEmail'] = null;
    $_SESSION['fullName'] = null;
    $_SESSION['statusSentEmail'] = "Please Check Your Email";
    if($redirectEmail[1] == "Password"){
        header("Location: ../../view/home/forgotPassword.php");
    }else if($redirectEmail[1] == "Username"){
        header("Location: ../../view/home/forgotUsername.php");
    }
}else{    
    $_SESSION['statusSentEmail'] = "Connection Problem, Please Try Again";
    if($redirectEmail[1] == "Password"){
        header("Location: ../../view/home/forgotPassword.php");
    }else if($redirectEmail[1] == "Username"){
        header("Location: ../../view/home/forgotUsername.php");
    }
}

?>