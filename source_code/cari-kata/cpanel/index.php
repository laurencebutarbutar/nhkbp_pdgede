<?php
session_start();

if (isset($_SESSION['login_valid'])&&(isset($_SESSION['login_name']))):
	header("Location: panel.php");
endif;

$startChecking=true;
$con=null;

if (isset($_POST['submit_login'])):
	
	if (isset($_POST['input_box'])):
		
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
			
			if (mysqli_connect_errno()):
				
				$message = "Sorry we are on maintenance right now, please comeback again in a few hours, Thank you";
			
			else:
			
				$result = mysqli_query($con, "SELECT * FROM t_cms");
				if ($result!=null||$result!=NULL):
					
					while ($row = mysqli_fetch_array($result)):
					
						if (($input[0]==$row['username'])&&($input[1]==$row['password'])):
							
							$_SESSION['login_valid']=true;
							$_SESSION['login_name']=$row['username'];
							$_SESSION['username'] = $row['username'];
							$_SESSION['password'] = $row['password'];
							header("Location: panel.php");
							
						endif;
					
					endwhile;
					
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
		<form method="post">
		<table width="80%" align="center">
			<tr>
				<td>
					Username
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" value="" name="input_box[]" placeholder="Username" style="width: 100%" maxlength="50"/>
				</td>
			</tr>
			<tr>
				<td>
					Password
				</td>
			</tr>
			<tr>
				<td>
					<input type="password" value="" name="input_box[]" placeholder="Password" style="width: 100%" maxlength="50"/>
				</td>
			</tr>
			<tr>
				<td>
					<button id="submit_login" name="submit_login" value="Submit" style="width: 100%">Login</button>
				</td>
			</tr>
		</table>
		</form>
	</body>
</html>

<?php
if ($con!=null||$con!=NULL):
	mysqli_close($con);
endif;
?>