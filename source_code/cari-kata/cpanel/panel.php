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

if (isset($_POST['submit_change'])):
	
	if (isset($_POST['input_box'])):
		
		$startChecking=true;
		$input = $_POST['input_box'];
		for ($i=0; $i<count($input); $i++):
			
			if ($input[$i]==null||$input[$i]==NULL||$input[$i]=="null"||$input[$i]==""||$input[$i]==''):
				$startChecking=false;
			endif;
			
		endfor;
		
		if ($startChecking):
			
//========================================== DB CONNECTION ====================================
include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================
	// $newUsername=$_POST['username']; 
	// $newPassword=$_POST['password']; 
	// $oldUsername=$_SESSION['myusername'];	
	// $oldPassword=$_SESSION['mypassword'];

	$newUsername=$input[0]; 
	$newPassword=$input[1]; 
	$oldUsername=$_SESSION['username'];	
	$oldPassword=$_SESSION['password'];

	// echo "newUsername".$newUsername; 
	// echo "newPassword".$newPassword;

	// echo "oldUsername".$oldUsername;
	// echo "oldPassword".$oldPassword;
		
	//$sql= "UPDATE t_cms SET USERNAME='".$newUsername."', PASSWORD='".$newPassword."' WHERE USERNAME='".$oldUsername."' AND PASSWORD = '".$oldPassword."'";

			if (mysqli_connect_errno()):
				
				$message = "Sorry we are on maintenance right now, please comeback again in a few hours, Thank you";
			
			else:
			
				//$result = mysqli_query($con, "UPDATE admin SET USERNAME='".$input[0]."', PASSWORD='".$input[1]."' WHERE ID='1'");
				$result= mysqli_query($con, "UPDATE t_cms SET USERNAME='".$newUsername."', PASSWORD='".$newPassword."' WHERE USERNAME='".$oldUsername."' AND PASSWORD = '".$oldPassword."'");
				if ($result!=null||$result!=NULL):
					$message="<font color='green'>You have successfully change administrator account</font>";
				else:
					$message="<font color='red'>Failed, please check your input(s) or contact your head administrator</font>";
				endif;
				
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
		
		<a href="panel.php" style="text-decoration: none; color:black;">Home</a>
		|
		<a href="createNew.php" style="text-decoration: none; color:gray;">Create New Item</a>
		|
		<a href="listItems.php" style="text-decoration: none; color:gray;">List of Items</a>
		|
		<a href="logout.php" style="text-decoration: none; color:black;">Logout</a>
		<hr/><br/>
		
<?php
	echo "<center>".$message."</center>";
?>
		<br/><br/>
		<form method="post">
		<table width="80%" align="center">
			<tr>
				<td>
					New Username
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" value="" name="input_box[]" placeholder="New Username" style="width: 100%" maxlength="50"/>
				</td>
			</tr>
			<tr>
				<td>
					New Password
				</td>
			</tr>
			<tr>
				<td>
					<input type="password" value="" name="input_box[]" placeholder="New Password" style="width: 100%" maxlength="50"/>
				</td>
			</tr>
			<tr>
				<td>
					<button id="submit_change" name="submit_change" value="Change" style="width: 100%">Change</button>
				</td>
			</tr>
		</table>
		</form>
	</body>
</html>