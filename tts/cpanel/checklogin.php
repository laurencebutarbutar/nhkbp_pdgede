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
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
	session_start();
	
//=================================================================================================
	
include_once '../../assets/class/dbConnection.php';
	
//=================================================================================================
	
	$myusername=$_POST['username']; 
	$mypassword=$_POST['password']; 
	$_SESSION['textUsername'] = $myusername;
	$_SESSION['textPassword'] = $mypassword;
	
	$sqlUsername= "SELECT USERNAME, PASSWORD from t_cms WHERE USERNAME='".$myusername."' AND PASSWORD ='".$mypassword."'";

	$result=mysqli_query($con, $sqlUsername);
	
	$isValidAccount=false;
	$existUsername=null;
	$existPassword=null;
	
	if ($result!=''&& $result!="" && $result!=NULL && $result!=null){
		while ($row = mysqli_fetch_array($result)){
			$existUsername = $row['USERNAME'];
			$existPassword = $row['PASSWORD'];
		}		
		if (isset($existUsername) && isset($existPassword)){
			if ($mypassword == $existPassword && $myusername == $existUsername){			
				$isValidAccount = true;
			}
		}		
	}

	$_SESSION['adminpage'] = $isValidAccount;
	if ($isValidAccount){
			$_SESSION['myusername']=$existUsername;
			$_SESSION['mypassword']=$existPassword;	
			header("location:admin.php");		
	}
	else {
			header("location:index.php");
	}
?>
</body>
</html>