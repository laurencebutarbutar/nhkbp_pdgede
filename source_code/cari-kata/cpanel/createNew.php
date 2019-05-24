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
$validToInput=true;
$counterEmptyField=0;

if(isset($_GET['edit'])):
	
	$editContentID=intval($_GET['edit']);
	$content=null;
	$jawab=null;

//========================================== DB CONNECTION ====================================
include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================
	
	if (mysqli_connect_errno()):
		
		$message = "Sorry we are on maintenance right now, please comeback again in a few hours, Thank you";
		
	else:
		
		$result = mysqli_query($con, "SELECT quest, answer FROM quests WHERE id =".$editContentID." AND apps_id=13");
		if ($result!=null||$result!=NULL):
			
			while ($row = mysqli_fetch_array($result)):
				$content=$row['quest'];
				$jawab=$row['answer'];
			endwhile;
			
		endif;
		
	endif;
	
else:

	if (isset($_POST['submit_new'])):

		if (isset($_POST['input_box'])&&isset($_POST['jawaban'])):
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
				$message="<font color='red'>Failed, Empty Jawaban</font><br/>";
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
					$message="<font color='red'>Failed, Empty Grid Value</font><br/>";
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
				
//========================================== DB CONNECTION ====================================
include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================

				if (mysqli_connect_errno()):

					echo "Sorry we are on maintenance right now, please comeback again in a few hours, Thank you";

				else:
					$eventsId = $_POST['eventsId'];
					$category = $_POST['category'];
					$answer="";
					
					for ($i=0; $i<count($jawaban_value); $i++):
						
						if ($jawaban_value[$i]!=null||$jawaban_value[$i]!=NULL||$jawaban_value[$i]!=''||$jawaban_value[$i]!=""){
							$answer .= $jawaban_value[$i]."^";
						}

					endfor;
					
					$result = mysqli_query($con, "INSERT INTO quests VALUES (null, 13, '".$eventsId."', '".$input_value."', '".$answer."', '".$category."', 0, 100)");
					if ($result!=null||$result!=NULL):

						$contentID=mysqli_insert_id($con);

						if ($contentID!=null || $contentID!=NULL || $contentID!='' || $contentID!=""){
							$message="<font color='green'>You have successfully add new content</font>";
						} else {
							$message="<font color='yellow'>Warning incomplete data content.</font><font color='green'>You have successfully add new content</font>";
						}

					else:
						$message="<font color='red'>Failed, please check your input(s) or contact your head administrator</font>";
					endif;

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
		
		<a href="panel.php" style="text-decoration: none; color:gray;">Home</a>
		|
		<a href="createNew.php" style="text-decoration: none; color:black;">Create New Item</a>
		|
		<a href="listItems.php" style="text-decoration: none; color:gray;">List of Items</a>
		|
		<a href="logout.php" style="text-decoration: none; color:black;">Logout</a>
		<hr/><br/>

<?php
	echo "<center>".$message."</center>";
?>
		<br/>
		
<?php
if(isset($_GET['edit'])):
	echo '<form action="listItems.php" method="post">';
else:
	echo '<form method="post">';
endif;
?>
		
		
		<table align="center">
			<tr>
				<td colspan="2" align="center">
					<b>Rules and(or) Prohibited Actions</b>
				</td>
			</tr>
			<tr>
				<td valign="top">
					Karakter '#' digunakan sebagai image
				</td>
				<td valign="top">
					<img src="../res/corner_orna_play.png"/>
				</td>
			</tr>
			<tr>
				<td valign="top">
					Karakter '~' digunakan sebagai image
				</td>
				<td valign="top">
					<img src="../res/side_orna_play.png"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="top">
					Karakter '-' dan '|' digunakan sebagai delimeter (pemisah)
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="top">
					Textbox hanya dapat disi 1 karakter
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="top">
					Klik <i>add</i> untuk menambah jawaban sesuai dengan isi kata acak yang telah diinput pada grid
				</td>
			</tr>
		</table>
		<br/><hr/><br/>
		<label>INPUT EVENTS ID</label>
		<input type="text" name="eventsId" id="eventsId">
		<label>INPUT CATEGORY</label>
		<input type="text" name="category" id="category">
		<center><font color="gray"><b>Grid Active 5 x 5</b></font></center>
		<table align="center" width="100%">
<?php
	
if(isset($_GET['edit'])):
	
	if ($content!=null&&$content!=NULL&&$content!=''&&$content!=""):
		
		$content_pr=explode("|", $content);
	
		for ($i=0; $i<(count($content_pr)-1); $i++):
			$content_spr=  explode("-", $content_pr[$i]);
			
			for ($j=0; $j<(count($content_spr)-1); $j++):
				
				$obj[$i][$j] = $content_spr[$j];
				
			endfor;
		
		endfor;
		
	else:
		
		$obj = array(
		array("#","~","~","~","~","~","#"),
		array("~","","","","","","~"),
		array("~","","","","","","~"),
		array("~","","","","","","~"),
		array("~","","","","","","~"),
		array("~","","","","","","~"),
		array("#","~","~","~","~","~","#")
		);
		
	endif;
	
else:
	
	$obj = array(
  array("#","~","~","~","~","~","#"),
	array("~","","","","","","~"),
	array("~","","","","","","~"),
	array("~","","","","","","~"),
	array("~","","","","","","~"),
	array("~","","","","","","~"),
	array("#","~","~","~","~","~","#")
  );
	
endif;

	for ($i=0; $i<7; $i++):
		echo "<tr>";
		for ($j=0; $j<7; $j++):
		
			echo "<td>";
				
			if ($i==0||$i==6):
				echo "<input type='hidden' name='input_box[]' value='".$obj[$i][$j]."' maxlength='1' style='width:100%;text-align:center;' readonly/>";
			elseif($j==0||$j==6):
				echo "<input type='hidden' name='input_box[]' value='".$obj[$i][$j]."' maxlength='1' style='width:100%;text-align:center;' readonly/>";
			else:
				echo "<input type='text' name='input_box[]' value='".$obj[$i][$j]."' maxlength='1' style='width:100%;text-align:center;' />";
			endif;
		
			echo "</td>";
			
		endfor;
		echo "</tr>";
	endfor;

?>
		</table>
		
		<br/><hr/><br/>
		
		<center>
			JAWABAN<br/>
			<div id="add_more_div" style="width: 100%;">

<?php
if(isset($_GET['edit'])):
	
	if ($jawab!=null&&$jawab!=NULL&&$jawab!=''&&$jawab!=""):
		$jawab = explode("^", $jawab);
		for ($i=0; $i<count($jawab)-1; $i++):
		
			echo "<div style='width: 100%'><input type='text' id='add_more' name='jawaban[]' width='100%' value='".$jawab[$i]."' /></div> ";
			
		endfor;
		
	endif;
	
endif;
?>
				
				<div style="width: 100%"><input type="text" id="add_more" name="jawaban[]" width="100%" /></div> 
			</div> 
			<a href="javascript:;" onclick="return add_more_text_box('add_more_div','jawaban[]',child());">add</a>
			<br/><br/>
			
<?php
if(isset($_GET['edit'])):
	echo '<input type="hidden" name="IDCONTENT" value="'.$_GET['edit'].'"/>';
	echo '<button id="submit_change" name="submit_change" value="Change" style="width: 80%">Change</button>';
else:
	echo '<button id="submit_new" name="submit_new" value="Submit" style="width: 80%">Submit</button>';
endif;
?>
			
		</center>
		
		</form>
		
		<script> 
		function add_more_text_box(parent_id, child_name, child_id) 
		{ 
			var myTable=document.getElementById(parent_id); 
			var oDiv, oInput; 
			oDiv = document.createElement('div'); 
			oDiv.setAttribute('id', 'Name'); 
			myTable.appendChild(oDiv); 

			oInput = document.createElement('input'); 
			oInput.setAttribute('type', 'text'); 
			oInput.setAttribute('name', child_name); 
			oInput.setAttribute('id', child_id); 
			oDiv.appendChild(oInput); 
		} 
		var child_id = 1; 
		function child() 
		{
			return child_id++; 
		}
		</script>
		
	</body>
</html>