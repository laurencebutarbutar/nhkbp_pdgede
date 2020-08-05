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

$subjectEmail = "Your Food Receipt in Parheheon NHKBP Pondok Gede 2018";
$emailUser = $_SESSION['email'];
$fullName = $_SESSION['fullName'];
$address = $_SESSION['address'];
$phone = $_SESSION['phone'];
$emailOrder = "yyy@gmail.com";
$fullNameOrder = "yyy";
// $emailOrder2 = "xxxx@gmail.com";
// $fullNameOrder2 = "XX XX";

$lastIdOrder = $_SESSION['lastIdOrder'];
$file_name = "../../assets/pdf/".$lastIdOrder.".pdf";
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
$mail->Username = "yyyy@yahoo.com"; //user email
$mail->Password = "yyy"; //password email 

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
$msgHtml = "<h3>Dear ".$fullName.",</h3>
<p>Thank you for ordering food from us.
<br>Your food receipt is attached in this email.
<br>We will contact you by phone to confirm your order.
<br>By buying foods from us you have donated some of your money for <b>Parheheon NHKBP Pondok Gede 2018</b>.
<br>Please don't reply this email, this is automated email.</p>
<h4>Best Regards,</h4>
<h4>Panitia Parheheon 
<br>NHKBP Pondok Gede 2018</h4>";

$mail->SetFrom($emailName,$emailNameAlias); //set email pengirim
$mail->Subject = $subjectEmail; //subyek email
$mail->AddAddress($emailUser,$fullName);  //tujuan email
$mail->AddAddress($emailOrder,$fullNameOrder);  //tujuan email
$mail->AddAddress($emailOrder2,$fullNameOrder2);  //tujuan email
// $mail->AddCC($emailOrder,$fullNameOrder);  //tujuan cc email
$mail->addAttachment($file_name); //attach file
$mail->MsgHTML($msgHtml);

if($mail->Send()){
    $_SESSION['successRegisActivities'] = 1;
    $_SESSION['messageRegisActivities'] = "Order has been created, please check your email";
    header("Location: ../../users");
} 
else{        
    $_SESSION['successRegisActivities'] = 2;
    $_SESSION['messageRegisActivities'] = "Something's Wrong, Please Try Again Later";
    header("Location: ../../users");
}
?>	