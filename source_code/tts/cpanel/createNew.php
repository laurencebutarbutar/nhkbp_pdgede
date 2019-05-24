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
<style type="text/css">
.boxGrid {
		font-family:Arial, Helvetica, sans-serif;
		font-size:18px;
		text-align:center;
		text-transform:uppercase;
		color:#fff;
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
<?php
		if (isset($_SESSION['messageInsert'])){
			if($_SESSION['messageInsert']==1){
			echo "<center><font color='green'>"."You have successfully add new content"."</font><center>";
			}
		else if($_SESSION['messageInsert']==2){
			echo "<center><font color='red'>"."Failed Insert, Grid Play or Grid Number or Pertanyaan Empty"."</font><center>";
			}
		}
		else {
			
		}
		$_SESSION['messageInsert']=0;
		echo "<br>";
?>
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
		
		
		
		echo "<form action='insertGrid.php' method='post'>";
		?>
			<label>INPUT EVENTS ID</label>
			<input type="text" name="eventsId" id="eventsId">
		<?php
       	echo "<table align='center' border='0px' width='100%' height='auto' style='border-collapse:collapse;'>";
		for ($i=0; $i<10; $i++){
			echo "<tr>";
			for ($j=0; $j<10; $j++){
					echo "<td style='padding:5px; margin:0px width:100%; height:auto'>";
					echo "<input class='boxGrid' id='gridLaurence".$inputCounter."' name='gridBox[".$i."][".$j."]' type='text' value='#' maxlength='1' style='width:100%; height:auto' onChange='changeGridColor();'>";
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
					echo "<input class='boxGrid' id='gridLaurence".$inputCounter."' name='numContent[".$i."][".$j."]' type='text' value='#' maxlength='1' style='width:100%; height:auto' onChange='changeGridColor();'>";
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
        <tr>
        <td>
		<div id="add_more_div_mendatar" style="width: 100%;">				
		<div style="width: 100%"><input type="text" id="add_more" name="mendatar[]" width="100%" /></div> 
		</div> 
		<a href="javascript:;" onClick="return add_more_mendatar_box('add_more_div_mendatar','mendatar[]',child());"><center>add</center></a>
        </td>
        <td>
        <div id="add_more_div_menurun" style="width: 100%;">				
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
        <center><button id='submit_new' name='submit_new' style='width: 80%'>Submit</button></center>
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