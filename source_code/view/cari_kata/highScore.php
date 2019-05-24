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

//validasi Cari Kata
$loginEvents = $_SESSION['loginCariKata']; //validasi event, soal, dan user
$highScore = $_SESSION['highScoreUserCariKata']; //highscore
$nickName = $_SESSION['nickName']; //nickname
$appsId = $_SESSION['appsIdCariKata']; //apps_id game
$userIdLogin = $_SESSION['userIdLoginCariKata']; //userIdLogin

if($loginEvents === null || $highScore === null || $nickName === null || $appsId === null || $userIdLogin === null){
    $_SESSION['failedLogin'] = "Please Login!";
    header("Location: ../../view/home/login.php");  
}

//for Cari Kata Games
if (isset($_SESSION['validGameCariKata'])):
    unset($_SESSION['validGameCariKata']);
endif;

if (isset($_SESSION['totalScoreCariKata'])):
    unset($_SESSION['totalScoreCariKata']);
endif;

if (isset($_SESSION['totalSalahCariKata'])):
    unset($_SESSION['totalSalahCariKata']);
endif;

if (isset($_SESSION['getPlayedIDCariKata'])):
    unset($_SESSION['getPlayedIDCariKata']);
endif;

$_SESSION['game_numberCariKata']=0;
$_SESSION['game_idCariKata']=0;

//perhitungan high score
//========================================== DB CONNECTION ====================================
	include_once '../../assets/class/dbConnection.php';
//========================================== DB CONNECTION ====================================

if (!mysqli_connect_errno()){	
    //keluarga status yang sudah menikah
    $selectHighScoreAll = mysqli_query($con, "SELECT tu.full_name, us.score, us.level, us.created_at FROM users_score us JOIN events e on e.id = us.events_id AND e.apps_id = us.apps_id AND CURRENT_TIMESTAMP BETWEEN e.start_at AND e.end_at JOIN users u on u.id = us.users_id JOIN t_users_detail tu ON tu.id = u.t_users_detail_id WHERE e.apps_id = '".$appsId."' AND tu.marital_status != 'Married'  ORDER BY us.score DESC, us.created_at ASC LIMIT 10");

	if (mysqli_num_rows($selectHighScoreAll) > 0){
		while ($rowSelectHighScoreAll = mysqli_fetch_array($selectHighScoreAll)):
            $hsFullName[]=$rowSelectHighScoreAll['full_name'];
            $hsScore[]=$rowSelectHighScoreAll['score'];
            $hsLevel[]=$rowSelectHighScoreAll['level'];
            $hsDate[]=$rowSelectHighScoreAll['created_at'];
		endwhile;
    }    
}
else{
	die("Connection error: " . mysqli_connect_errno());
}

?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Cari Kata Games</title>

        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <link href="../../assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../../assets/css/font-awesome.min.css" />
        <link href="../../assets/css/full-slider.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Wallpoet|Skranji" rel="stylesheet">

        <style type="text/css">
			.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
				border-bottom: 2px solid #b63b4d
			}
        </style>     

</head>
    <body style="background-color: #2d2c41">

    <!-- Start Navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" style="color: #2d2c41"><?php echo $nickName?></a>
              <a class="navbar-brand" style="color: #2d2c41"><i class="fa fa-trophy"></i></a>
              <a class="navbar-brand" style="color: #2d2c41"><?php echo $highScore?></a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="../../users" style="color: #2d2c41">Profile</a></li>
                <li><a href="../../services/tts/cekRegisTTS.php" style="color: #2d2c41">TTS</a></li>
                <li class="active"><a href="../../cari-kata" style="color: #b63b4d">Cari Kata</a></li>
                <li><a href='../../view/users/logout.php' style="color: #2d2c41">Logout</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
    <!-- End Navbar -->

    <!-- Carousel Start -->
    <header id="myCarousel" class="carousel slide" style="height: 100px; margin-top: 50px;">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('../../assets/img/bannerGame/bannerGame1.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('../../assets/img/bannerGame/bannerGame2.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('../../assets/img/bannerGame/bannerGame3.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
        </div>

        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>
    <!-- Carousel End -->

	<!-- Start Account Page -->
		<div class="container">		
			<div class="row" style="margin-top: 5px;">		   
			    <div class="col-sm-8 col-sm-offset-2">
				    	<img class="img-responsive" src="../../assets/img/cari_kata/headerCariKata.jpg">
			    </div>
		    </div>

			<div class="row" style="margin-top: 5px; margin-bottom: 5px;">		   
			    <div class="col-sm-8 col-sm-offset-2" style="overflow-x:auto;">	
			    	<table style="background-image:url('../../assets/img/cari_kata/borderCariKata.jpg'); background-repeat: repeat; font-family:'Skranji', cursive; color: black; width: 100%; font-size: 15px; text-align: center;text-shadow: 1px 0 0 #fff, -1px 0 0 #fff, 0 1px 0 #fff, 0 -1px 0 #fff, 1px 1px #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;border-collapse: collapse;border-collapse: separate;border-spacing: 10px;">
			    		<thead>
			    		<tr>
			    			<td style="font-size: 40px;font-family: 'Wallpoet', cursive; color: #c33d44; text-shadow: 2px 0 0 #fff, -2px 0 0 #fff, 0 2px 0 #fff, 0 -2px 0 #fff, 1px 1px #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;" colspan="4">HIGH SCORE</td>
			    		</tr>		    			
			    			
			    		</thead>
			    		<tbody>
			    			<!-- space -->
							<tr style="height: 15px;">
			    			<td></td>
			    			</tr>
			    			<!-- Header -->
			    			<tr>
			    				<th style="width: 30%; font-size: 20px; text-align: center; color: #c33d44;border-bottom: 2px solid white;">Nickname</th>
			    				<th style="width: 20%; font-size: 20px; text-align: center; color: #c33d44;border-bottom: 2px solid white;">Level</th>
			    				<th style="width: 20%; font-size: 20px; text-align: center; color: #c33d44;border-bottom: 2px solid white;">Score</th>
			    				<th style="width: 30%; font-size: 20px; text-align: center; color: #c33d44;border-bottom: 2px solid white;">Date/Time</th>
			    			</tr>
			    			<?php                                
			    				for($i=0; $i<count($hsFullName); $i++){
                                    $nickname = null;
                                    $nickname = explode(" ", $hsFullName[$i]);
			    					echo "<tr>";
			    						if ($i == 0){
			    							echo "<td><i class='fa fa-trophy' style='color:#8B4513'>&nbsp</i>".$nickname[0]."</td>";
	    								}else{
			    							echo "<td>".$nickname[0]."</td>";
	    								}
			    						echo "<td>".$hsLevel[$i]."</td>";
			    						echo "<td>".$hsScore[$i]."</td>";
			    						echo "<td>".$hsDate[$i]."</td>";
			    					echo "</tr>";
			    				}
			    			?>
			    		</tbody>
			    	</table>
			    </div>
		    </div>

		    <div class="row" style="margin-top: 5px; margin-bottom: 10px;">
			    <div class="col-sm-8 col-sm-offset-2">
				    <div class="row" style="margin-top: 5px;">
					    <div class="col-sm-8 col-sm-offset-2">
				    		<div class="col-xs-6 col-sm-6 col-lg-6"><a href="../../services/cari_kata/checkPlay.php"><img class="img-responsive" src="../../assets/img/cari_kata/playCariKata.png" align="right"></a></div>
				    		<div class="col-xs-6 col-sm-6 col-lg-6"><a href="../../cari-kata"><img class="img-responsive" src="../../assets/img/cari_kata/homeCariKata.png"" align="left"></a></div>
			    		</div>
		    		</div>
			    </div>   	
			</div>			 
		</div>
	<!-- End Account Page -->    
	
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
        <script src="../../assets/js/jquery.min.js"></script>
        <script src="../../assets/js/bootstrap.min.js"></script>
    </body>
</html>