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

if (!isset($_SESSION['textUsername']) && !isset($_SESSION['textPassword'])) { //not logged in
//if ($_SESSION['adminpage'] == 1){
    //redirect to homepage
    header("location:index.php");
    //die();
}

?>

<html>
<head>
<title></title>
</head>
<body>
<a href="admin.php" style='text-decoration:none; color:gray'>Home</a>
|
<a href="createNew.php" style='text-decoration:none; color:gray'>Create New Item</a>
|
<a href="listItem.php" style='text-decoration:none; color:#000'>List Of Item</a>
|
<a href="logout.php" style='text-decoration:none; color:#000'>Logout</a>
<hr>
<br>
</font>
<style>
test{
	
	text-align:center;
	font-weight:bold;
	
</style>
<?php
//=================================================================================================
	
include_once '../../assets/class/dbConnection.php';
	
//=================================================================================================
		
		$resultCount = mysqli_query($con, "SELECT * FROM quests where apps_id=12");
		$resultSelect = mysqli_query($con, "SELECT * FROM quests where apps_id=12");
		$num_rows = mysqli_num_rows($resultCount);
		$noContent = 1;	
		
	if (isset($_SESSION['messageDelete']) && isset($_SESSION['deleteID'])){
		if($_SESSION['messageDelete'] == 1){
		echo "<center><font color='green'>"."You have successfully "."</font>"."<font color='red'>"."delete "."</font>"."<font color='green'>"."content ( ID CONTENT = ".$_SESSION['deleteID']." )"."</font></center>";
		}		
	}
	else{
		
	}
	
	if (isset($_SESSION['messageUpdate']) && isset($_SESSION['updateID'])){
		if($_SESSION['messageUpdate'] == 1){
		echo "<center><font color='green'>"."You have successfully "."</font>"."<font color='red'>"."update "."</font>"."<font color='green'>"."content ( ID CONTENT = ".$_SESSION['updateID']." )"."</font></center>";
		}		
	}
	else{
		
	}
	
	$_SESSION['messageDelete'] = NULL;
	$_SESSION['messageUpdate'] = NULL;
	echo "<br>";
	echo "<center><b>"."Total Data Content : ".$num_rows." Data"."<b><center>";
	echo "<br>";
	echo "<form id='updateAdmin' action='updateAdmin.php' method='post'>";
	echo "<table border='1px' width='80%' style='margin:0; padding:1px; table-layout: fixed'>";
	
        	echo "<tr>";			
        		echo "<td style='width:10%; padding:0; margin:0;text-align:center;	font-weight:bold;'>"."NO."."</td>";
				echo "<td style='width:10%; padding:0; margin:0;text-align:center;	font-weight:bold;'>"."ID CONTENT"."</td>";
				echo "<td colspan='2' style='width:30%; padding:0; margin:0;text-align:center;	font-weight:bold;'>"."ACTION"."</td>";
        	echo "</tr>";
			//for ($x=1; $x<=$num_rows; $x++){
			while($row = mysqli_fetch_array($resultSelect)){
				echo "<tr>";	
        		echo "<td style='width:10%; padding:0; margin:0;text-align:center;'>".$noContent."</td>";
				echo "<td style='width:10%; padding:0; margin:0;text-align:center;'>".$row['id']."</td>";
				echo "<td style='width:10%; padding:0; margin:0;text-align:center;'><a href='editTable.php?id={$row['id']}' style='color:#093; text-decoration:none;'>"."Edit"."</a></td>";
				echo "<td style='width:10%; padding:0; margin:0;text-align:center;'><a href='deleteTable.php?id={$row['id']}' style='color:red; text-decoration:none;'>"."Delete"."</a></td>";
			echo "</tr>";
			$noContent++;
			}
			
			echo "</table>";
			echo "</form>";
?>

</body>
</html>