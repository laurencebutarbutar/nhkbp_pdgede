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

session_start();

if (!isset($_SESSION['textUsername']) && !isset($_SESSION['textPassword'])) {
    header("location:index.php");
}

?>

<html>
<head>
<title></title>
</head>
<body>
<a href="admin.php" style='text-decoration:none; color:#000'>Home</a>
|
<a href="createNew.php" style='text-decoration:none; color:gray'>Create New Item</a>
|
<a href="listItem.php" style='text-decoration:none; color:gray'>List Of Item</a>
|
<a href="logout.php" style='text-decoration:none; color:#000'>Logout</a>
<hr>
<br>
<?php
	
	if (isset($_SESSION['messageupdate'])){
		if($_SESSION['messageupdate']==1){
		echo "<center><font color='green'>"."You have successfully change administrator account"."</font><center>";
		}
		else if($_SESSION['messageupdate']==2){
		echo "<center><font color='red'>"."Failed Update, Username or Password Empty"."</font><center>";
		}
	}
	else {
		
	}
	echo "<br>";
	$_SESSION['messageupdate']=0;
	echo "<form id='updateAdmin' action='updateAdmin.php' method='post'>";
	echo "<table border='0' width='100%' style='margin:0; padding:0; border-collapse:collapse;table-layout: fixed'>";
        	echo "<tr>";
        		echo "<td style='padding:0; margin:0; height:8%; width:10%'</td>";
				echo "<td style='padding:3px; margin:0; width:82%'>"."New Username"."</td>";
				echo "<td style='padding:0; margin:0; width:10%'></td>";
        	echo "</tr>";
			echo "<tr>";
        		echo "<td style='padding:0; margin:0; width:10%'></td>";
				echo "<td style='padding:3px; margin:0'><input type='text' name='username' id='username' placeholder='New Username' style='width:100%'></td>";
				echo "<td style='padding:0; margin:0'; width:10%></td>";
        	echo "</tr>";
			echo "<tr>";
        		echo "<td style='padding:0; margin:0'></td>";
				echo "<td style='padding:3px; margin:0'>"."New Password"."</td>";
				echo "<td style='padding:0; margin:0'></td>";
        	echo "</tr>";
			echo "<tr>";
        		echo "<td style='padding:0; margin:0'></td>";
				echo "<td style='padding:3px; margin:0'><input type='password' name='password' id='password' placeholder='New Password' style='width:100%'></td>";
				echo "<td style='padding:0; margin:0'></td>";
        	echo "</tr>";
			echo "<tr>";
        		echo "<td style='padding:0; margin:0'></td>";				
				//echo "<form action='admin.php' method='post' style='height:10px'>";
				echo "<td style='padding:3px; margin:0'><input type='submit' name='submit' value='Change' style='width:100%'></input></td>";
				//echo "</form>";
				echo "<td style='padding:0; margin:0'></td>";
        	echo "</tr>";
			echo "</table>";
			echo "</form>";
?>

</body>
</html>