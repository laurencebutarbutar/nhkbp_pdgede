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
if($_SESSION['adminpage'] != true){
		header("location:index.php");
	}
	else{
	}
?>

<html>
<head>
<title></title>
<style type="text/css">
.boxGrid {
		font-family:Arial, Helvetica, sans-serif;
		font-size:18px;
		text-align:center;
		text-transform:uppercase;
		color:#000;
	}	
</style>
</head>
<body onLoad="defaultGridColor();">
<a href="admin.php" style='text-decoration:none; color:gray'>Home</a>
|
<a href="createNew.php" style='text-decoration:none; color:#000'>Create New Item</a>
|
<a href="listItem.php" style='text-decoration:none; color:gray'>List Of Item</a>
|
<a href="logout.php" style='text-decoration:none; color:#000'>Logout</a>
<hr>
<br>

		<table align="center">
			<tr>
				<td colspan="2" align="center">
					<b>Rules and(or) Prohibited Actions</b>
				</td>
			</tr>
			<tr>
				<td valign="top">
					Karakter '#' digunakan sebagai black grid atau empty box
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="top">
					Karakter '-' dan '|' digunakan sebagai delimeter (pemisah)
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="top">
					Textbox hanya dapat disi 1 karakter (alfabet) non numeric
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="top">
					Klik <i>add</i> untuk menambah jawaban sesuai dengan isi kata acak yang telah diinput pada grid
				</td>
			</tr>
		</table>
		<br/><hr/><br/>
		<center><font color="black"><b>GRID PLAY TTS</b></font></center>
        	
		<?php
		$inputCounter=0;
		$id = $_GET['id'];
		//echo $id;
//=================================================================================================
	
include_once '../../assets/class/dbConnection.php';
	
//=================================================================================================
		
		//explode//
		$sqlSelect = "SELECT * from quests where apps_id=12 AND id = '".$id."'";
		$resultSelect = mysqli_query ($con, $sqlSelect);
		
		$mainContent=null;
		$dataMainGrid=null;
		$content=null;
		//$contentDivide=null;
		$quest=null;
		
		//quest content
		if ($resultSelect == null && $resultSelect == NULL & $resultSelect == '' & $resultSelect == ""){
			echo "Something was wrong in query data";
		} else {
			while ($row = mysqli_fetch_array($resultSelect)){
				$quest = $row['quest'];
			}
		}
		$content = explode("^", $quest);
				
		$mainContent = $content [0];
		
		$rowMainContent = explode("/", $mainContent);
		
		for ($i=0; $i<10; $i++){
			$rowDataMain = explode ("-", $rowMainContent[$i]);
			for ($j=0; $j<10; $j++){
				$dataMainGrid[$i][$j] = $rowDataMain[$j];
			}
		}
				
		$mainNumContent = $content [1];
		$rowNumMainContent = explode("/", $mainNumContent);
		
		for ($i=0; $i<10; $i++){
			$rowDataNumMain = explode ("-", $rowNumMainContent[$i]);
			for ($j=0; $j<10; $j++){
				$dataNumMainGrid[$i][$j] = $rowDataNumMain[$j];
			}
		}
				
		echo "<form action='updateGrid.php' method='post'>";
       	echo "<table align='center' border='0px' width='100%' height='auto' style='border-collapse:collapse;'>";
		for ($i=0; $i<10; $i++){
			echo "<tr>";
			for ($j=0; $j<10; $j++){
				
					echo "<td style='padding:5px; margin:0px width:100%; height:auto'>";
					echo "<input class='boxGrid' id='gridLaurence".$inputCounter."' name='gridBox[".$i."][".$j."]' type='text' value='".$dataMainGrid[$i][$j]."' maxlength='1' style='width:100%; height:auto' onChange='changeGridColor();'>";
					echo "</td>";
					$inputCounter++;
			}						
		echo "</tr>";
		}   
		
		echo "</table>";
		
		echo "<hr>";
		echo "<br>";
		
		echo "<center><font color='black'><b>GRID NUMBER TTS</b></font></center>";
		echo "<table align='center' border='0px' width='100%' height='auto' style='border-collapse:collapse;'>";	
		for ($i=0; $i<10; $i++){
			echo "<tr>";
			for ($j=0; $j<10; $j++){
					echo "<td style='padding:5px; margin:0px width:100%; height:auto'>";
					echo "<input class='boxGrid' id='gridLaurence".$inputCounter."' name='numContent[".$i."][".$j."]' type='text' value='".$dataNumMainGrid[$i][$j]."' maxlength='1' style='width:100%; height:auto' onChange='changeGridColor();'>";
					echo "</td>";					
					$inputCounter++;
			}						
		echo "</tr>";
		}   
		echo "</table>";
		echo "<hr>";
		echo "<br>";
		echo "<br>";
           
		?>
        
        <center><b>PERTANYAAN :</b>
        <table align="center">
        <tr>
        <td><center><b>MENDATAR</b></center></td>
        <td><center><b>MENURUN</b></center></td>
        </tr>
        
        <?php
		
		
		$sqlMendatar = "SELECT * from quests where apps_id=12 and id = '".$id."'";
		$resultMendatar = mysqli_query ($con, $sqlMendatar);
		
		$mainQMendatar=null;
		$dataQMendatar=null;
		$answer=null;
		$question=null;
		
		//question explode
		if ($resultMendatar == null && $resultMendatar == NULL & $resultMendatar == '' & $resultMendatar == ""){
			echo "Something was wrong in query data";
		} else {
			while ($rowQMendatar = mysqli_fetch_array($resultMendatar)){
				$answer = $rowQMendatar['answer'];
			}
		}
		
		$question = explode("^", $answer);
				
		$mainQMendatar = $question [0];
		$rowMainQMendatar = explode("#", $mainQMendatar);
		
		$mainQMenurun=null;
		$dataQMenurun=null;

		$mainQMenurun = $question [1];
		$rowMainQMenurun = explode("#", $mainQMenurun);
		
		echo "<tr>";
		echo "<td>";		
			echo "<table>";
		for ($x=0; $x<count($rowMainQMendatar); $x++){				
			echo "<tr>";
			if($rowMainQMendatar[$x] == null && $rowMainQMendatar[$x] == NULL && $rowMainQMendatar[$x] == "" && $rowMainQMendatar[$x] == ''){
				//echo "Something was wrong in query data";
			}
			else{		
				echo "<td><input type='text' id='add_more' name='mendatar[]' width='100%' value='".$rowMainQMendatar[$x]."' />";
			echo "</td>";			
			}
			echo "</tr>";
		}
		echo "</table>";
		echo "</td>";
				
			echo "<td>";
			echo "<table>";
		for ($x=0; $x<count($rowMainQMenurun); $x++){
			echo "<tr>";
			if($rowMainQMenurun[$x] == null && $rowMainQMenurun[$x] == NULL && $rowMainQMenurun[$x] == "" && $rowMainQMenurun[$x] == ''){
				//echo "Something was wrong in query data";
			}
			else{
			echo "<td><input type='text' id='add_more' name='menurun[]' width='100%' value='".$rowMainQMenurun[$x]."' />";
			echo "</td>";			
			}
			
			echo "</tr>";
		}
		echo "</table>";
		echo "</td>";
		
		echo "</tr>";
		?>      
         
        <tr>
        <td>
		<div id="add_more_div_mendatar" style="width: 100%; margin-left:3px;">				
		<div style="width: 100%"><input type="text" id="add_more" name="mendatar[]" width="100%" /></div> 
		</div> 
		<a href="javascript:;" onClick="return add_more_mendatar_box('add_more_div_mendatar','mendatar[]',child());"><center>add</center></a>
        </td>
        <td>
        <div id="add_more_div_menurun" style="width: 100%; margin-left:3px;">				
		<div style="width: 100%"><input type="text" id="add_more" name="menurun[]" width="100%" /></div> 
		</div> 
		<a href="javascript:;" onClick="return add_more_menurun_box('add_more_div_menurun','menurun[]',child());"><center>add</center></a>
        </td>
        </tr>
        </table>
		<script> 
		
			
			function add_more_mendatar_box(parent_id, child_name, child_id) 
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
			
			function add_more_menurun_box(parent_id, child_name, child_id) 
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
		
		<br>
        <center>
        <input type="hidden" name="ID" value="<?php echo $id; ?>"/>
        <button id='submit_new' name='submit_new' style='width: 80%'>Change</button>
        </center>
         
		</form>
        
        <script>
		function defaultGridColor(){
			
			<?php
			
			for ($z=0; $z<$inputCounter; $z++){
			?>
			
			var elm = document.getElementById("gridLaurence<?php echo $z; ?>").value;
			if (elm == "#"){
				document.getElementById("gridLaurence<?php echo $z; ?>").style.backgroundColor = "Black";
			}
			
			<?php
			}
			?>
			
		}
		
		function changeGridColor(){
			<?php
			for ($z=0; $z<$inputCounter; $z++){
			?>
			
			var elm = document.getElementById("gridLaurence<?php echo $z; ?>").value;
			if (elm == "#"){
				document.getElementById("gridLaurence<?php echo $z; ?>").style.backgroundColor = "Black";
			} else {
				document.getElementById("gridLaurence<?php echo $z; ?>").style.backgroundColor = "White";
				document.getElementById("gridLaurence<?php echo $z; ?>").style.color = "Black";
			}
			
			<?php
			}
			?>
		}
        </script>
        
	</body>
</body>
</html>