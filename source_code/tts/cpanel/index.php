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
<title>Login</title>
</head>

<body>
<?php
	session_start();
	$_SESSION['textUsername'] = NULL;
	$_SESSION['textPassword'] = NULL;
	echo "<form id='login' action='checklogin.php' method='post' accept-charset='UTF-8'>";
	echo "<table border='0' width='100%' style='margin:0; padding:0; border-collapse:collapse;table-layout: fixed'>";
        	echo "<tr>";
        		echo "<td style='padding:0; margin:0; height:8%; width:10%'</td>";
				echo "<td style='padding:3px; margin:0; width:82%'>"."Username"."</td>";
				echo "<td style='padding:0; margin:0; width:10%'></td>";
        	echo "</tr>";
			echo "<tr>";
        		echo "<td style='padding:0; margin:0; width:10%'></td>";
				echo "<td style='padding:3px; margin:0'><input type='text' name='username' id='username' placeholder='Username' style='width:100%'></td>";
				echo "<td style='padding:0; margin:0'; width:10%></td>";
        	echo "</tr>";
			echo "<tr>";
        		echo "<td style='padding:0; margin:0'></td>";
				echo "<td style='padding:3px; margin:0'>"."Password"."</td>";
				echo "<td style='padding:0; margin:0'></td>";
        	echo "</tr>";
			echo "<tr>";
        		echo "<td style='padding:0; margin:0'></td>";
				echo "<td style='padding:3px; margin:0'><input type='password' name='password' id='password' placeholder='Password' style='width:100%'></td>";
				echo "<td style='padding:0; margin:0'></td>";
        	echo "</tr>";
			echo "<tr>";
        		echo "<td style='padding:0; margin:0'></td>";				
				//echo "<form action='admin.php' method='post' style='height:10px'>";
				echo "<td style='padding:3px; margin:0'><input type='submit' name='submit' value='Login' style='width:100%'></input></td>";
				//echo "</form>";
				echo "<td style='padding:0; margin:0'></td>";
        	echo "</tr>";
			echo "</table>";
?>
</body>
</html>