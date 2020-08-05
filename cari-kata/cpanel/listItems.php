<?php
session_start();

if (isset($_SESSION['login_valid'])):
	if ($_SESSION['login_valid']==""||$_SESSION['login_valid']==''||$_SESSION['login_valid']==null||$_SESSION['login_valid']==NULL):
		header("Location: index.php");
	endif;
else:
	header("Location: index.php");
endif;

if (isset($_SESSION['login_name'])):
	if ($_SESSION['login_name']==""||$_SESSION['login_name']==''||$_SESSION['login_name']==null||$_SESSION['login_name']==NULL):
		header("Location: index.php");
	endif;
else:
	header("Location: index.php");
endif;

$message="";
$contentID=null;
$totalItem="";
$validToInput=true;
$counterEmptyField=0;

//========================================== DB CONNECTION ====================================
include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================


if (isset($_GET['del'])):
	
	$idContent=$_GET['del'];
	
	$result = mysqli_query($con, "DELETE FROM quests WHERE ID=".$idContent);
//	$result = mysql_query("DELETE FROM answer WHERE CONTENT =".$idContent);
	
	$message="<font color='green'>You have successfully</font> <font color='red'>delete</font> <font color='green'>content ( ID CONTENT = ".$idContent." )</font>";
	
endif;


$result = mysqli_query($con, "SELECT id FROM quests WHERE apps_id=13");

if (mysqli_connect_errno()):
	
	$message = "Sorry we are on maintenance right now, please comeback again in a few hours, Thank you";
	
else:
	
	if ($result!=null||$result!=NULL):
	
		while ($row = mysqli_fetch_array($result)):
		
			$contentID[]=$row['id'];
		
		endwhile;
		
	endif;
	
endif;

$result = mysqli_query($con, "SELECT COUNT(*) AS COUNTALL FROM quests WHERE apps_id=13");
if ($result!=null||$result!=NULL):
	while ($row = mysqli_fetch_array($result)):
	
		$totalItem=$row['COUNTALL'];
	
	endwhile;
endif;

if (isset($_POST['submit_change'])):
	
	if (isset($_POST['input_box'])&&isset($_POST['jawaban'])&&isset($_POST['IDCONTENT'])):
		$idContent=$_POST['IDCONTENT'];
		$inputBox = $_POST['input_box'];
		$jawaban = $_POST['jawaban'];
		$jawaban_value=null;
		$input_value="";
		
		for ($i=0; $i<count($jawaban); $i++):
			if ($jawaban[$i]==null||$jawaban[$i]==NULL||$jawaban[$i]==""||$jawaban[$i]==''):
				$counterEmptyField++;
			endif;
		endfor;

		if ($counterEmptyField>=count($jawaban)):
			$validToInput=false;
			$message="<font color='red'>Failed, Empty Jawaban ( ID CONTENT = ".$idContent." )</font><br/>";
		endif;
		
		if ($validToInput):
			$counterEmptyField=0;
			for ($i=0; $i<count($inputBox); $i++):
				if ($inputBox[$i]==null||$inputBox[$i]==NULL||$inputBox[$i]==""||$inputBox[$i]==''||$inputBox[$i]=='#'||$inputBox[$i]=='~'):
					$counterEmptyField++;
				endif;
			endfor;

			if ($counterEmptyField>=count($inputBox)):
				$validToInput=false;
				$message="<font color='red'>Failed, Empty Grid Value ( ID CONTENT = ".$idContent." )</font><br/>";
			endif;

		endif;
		
		if ($validToInput):
			
			for ($i=0; $i<count($jawaban); $i++):
				if ($jawaban[$i]!=null&&$jawaban[$i]!=NULL&&$jawaban[$i]!=""&&$jawaban[$i]!=''):
					$jawaban_value[]=$jawaban[$i];
				endif;
			endfor;
			
			$counter=0;
			for ($i=0; $i<count($inputBox); $i++):
				$input_value.=$inputBox[$i]."-";
				if ($counter==6){
					$counter=0;
					$input_value.="|";
				} else {
					$counter++;
				}
			endfor;
			
			$answer="";
					
			for ($i=0; $i<count($jawaban_value); $i++):

				if ($jawaban_value[$i]!=null||$jawaban_value[$i]!=NULL||$jawaban_value[$i]!=''||$jawaban_value[$i]!=""){
					$answer .= $jawaban_value[$i]."^";
				}

			endfor;
			
			$result = mysqli_query($con, "UPDATE quests SET quest='".$input_value."', answer='".$answer."' WHERE id=".$idContent." AND apps_id=13");
			if ($result!=null||$result!=NULL):
				
				$message="<font color='green'>You have successfully change content ( ID CONTENT = ".$idContent." )</font>";
				
			else:
				
				$message="<font color='blue'>Warning incomplete data content. ( ID CONTENT = ".$idContent." )</font>";
								
			endif;
			
		endif;
		
	endif;
	
endif;

?>

<html>
	<head>
		<title>Control Panel</title>
	</head>
	<body>
		
		<a href="panel.php" style="text-decoration: none; color:gray;">Home</a>
		|
		<a href="createNew.php" style="text-decoration: none; color:gray;">Create New Item</a>
		|
		<a href="listItems.php" style="text-decoration: none; color:black;">List of Items</a>
		|
		<a href="logout.php" style="text-decoration: none; color:black;">Logout</a>
		<hr/><br/>
		
<?php
	echo "<center>".$message."</center>";
?>
		<br/>
		
<?php
	echo "<center>Total Data Content : ".$totalItem." Data</center>";
?>
		
		<br/>
		<table width="80%" align="center" border="1">
			<tr>
				<td align="center">
					<b>NO.</b>
				</td>
				<td align="center">
					<b>ID CONTENT</b>
				</td>
				<td align="center" colspan="2">
					<b>ACTION</b>
				</td>
			</tr>
			
<?php

if($contentID!=null||$contentID!=NULL||$contentID!=''||$contentID!=""):
	
	$number=1;
	for ($i=0; $i<count($contentID); $i++):
		
		echo "
			<tr>
				<td valign='top'>".$number."</td>
				<td align='center' valign='top'>".$contentID[$i]."</td>
				<td align='center' valign='top'>
					<a href='createNew.php?edit=".$contentID[$i]."' style='text-decoration:none;color:green'>Edit</a>
				</td>
				<td align='center' valign='top'>
					<a href='listItems.php?del=".$contentID[$i]."' style='text-decoration:none;color:red'>Delete</a>
				</td>
			</tr>
					";
		$number++;
	
	endfor;
endif;

?>
			
		</table>
		
	</body>
</html>