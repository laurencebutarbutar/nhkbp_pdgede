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


?>

<html>
<head>
<title></title>
</head>
<body>	
        <?php
		$inputBox = $_POST['gridBox'];
		$numContent = $_POST['numContent'];
		$pertanyaanMendatar = $_POST['mendatar'];
		$pertanyaanMenurun = $_POST['menurun'];
		$contentMain = "";
		$contentNum = "";
		$totalMendatar="";
		$totalMenurun="";
		$content=NULL;
		$question=NULL;
		$_SESSION['messageInsert']=0;
		//echo $_POST['ID'];
		$id = $_POST['ID'];
		
		
		for($x=0; $x<10; $x++){
			for($y=0; $y<10; $y++){
				if(isset($inputBox [$x][$y])){
					$contentMain .= $inputBox [$x][$y]."-";
				}
			}
			$contentMain = $contentMain."/";			
		}
		//echo $contentMain;
		
		for($x=0; $x<10; $x++){
			for($y=0; $y<10; $y++){
				if(isset($numContent [$x][$y])){
					$contentNum .= $numContent [$x][$y]."-";
				}
			}
			$contentNum = $contentNum."/";			
		}
		echo "<br>";
		//echo $contentNum;
		echo "<br>";
		//String Content = Main Content + Num COntent
		$content = $contentMain . "^" . $contentNum;
		echo $content;
		
		for($x=0; $x<10; $x++){			
				if(isset($pertanyaanMendatar [$x])){
					//echo $pertanyaanMendatar [$x];
					//echo "isi";		
					//var_dump($pertanyaanMendatar);			
					$totalMendatar.=$pertanyaanMendatar[$x]."#";;
				}
				else{
					//echo "kosong";
				}
		}	
		//echo $totalMendatar;
		echo "<br>";
			for($y=0; $y<10; $y++){
				if(isset($pertanyaanMenurun [$y])){
					//echo $pertanyaanMenurun [$y];
					//echo "<br>";
					$totalMenurun.=$pertanyaanMenurun [$y]."#";
				}
			}	
		//echo $totalMenurun;
		//echo "<br>";
		$question = $totalMendatar."^".$totalMenurun;
		echo $question;
//=================================================================================================
	
include_once '../../assets/class/dbConnection.php';
	
//=================================================================================================

		$sqlUpdateContent = "UPDATE quests SET "
						. "quest='".strtoupper($content)."', "
						. "answer='".$question."' "
						. "WHERE apps_id=12 AND id='".$id."'";
		$rowUpdateContent = mysqli_query($con, $sqlUpdateContent);
		
		$_SESSION['messageUpdate'] = 1;
		$_SESSION['updateID'] = $id;
		header("location:listItem.php");
		
		?>
	</body>
</body>
</html>