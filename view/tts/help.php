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

//validasi TTS
$loginEvents = $_SESSION['loginTTS']; //validasi event, soal, dan user
$highScore = $_SESSION['highScoreUser']; //highscore
$nickName = $_SESSION['nickName']; //nickname
$appsId = $_SESSION['appsId']; //apps_id game
$userIdLogin = $_SESSION['userIdLogin']; //userIdLogin

if($loginEvents === null || $highScore === null || $nickName === null || $appsId === null || $userIdLogin === null){
    $_SESSION['failedLogin'] = "Please Login!";
    header("Location: ../../view/home/login.php");  
}

//for TTS Games
if (isset($_SESSION['validGame'])):
    unset($_SESSION['validGame']);
endif;

if (isset($_SESSION['totalScore'])):
    unset($_SESSION['totalScore']);
endif;

if (isset($_SESSION['totalSalah'])):
    unset($_SESSION['totalSalah']);
endif;

if (isset($_SESSION['getPlayedID'])):
    unset($_SESSION['getPlayedID']);
endif;

if (isset($_SESSION['allow_notification'])):
    unset($_SESSION['allow_notification']);
endif;

$_SESSION['game_number']=0;
$_SESSION['game_id']=0;

?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>TTS Games</title>

        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <link href="../../assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../../assets/css/font-awesome.min.css" />
        <link href="../../assets/css/full-slider.css" rel="stylesheet">

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
                <li class="active"><a href="../../tts" style="color: #b63b4d">TTS</a></li>
                <li><a href="../../services/cari_kata/cekRegisCariKata.php" style="color: #2d2c41">Cari Kata</a></li>
                <!-- <li class="active"><a href="registration.php" style="color: #2d2c41">Registration</a></li> -->
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
				    	<img class="img-responsive" src="../../assets/img/tts/headerTTS.jpg">
			    </div>
		    </div>

		    <div class="row" style="margin-top: 5px;">
			    <div class="col-sm-8 col-sm-offset-2">
					<img class="img-responsive" src="../../assets/img/tts/howToPlay.jpg">

				    <div class="row" style="margin-top: 5px;">
					    <div class="col-sm-8 col-sm-offset-2">
				    		<div class="col-xs-6 col-sm-6 col-lg-6"><a href="../../services/tts/checkPlay.php"><img class="img-responsive" src="../../assets/img/tts/playTTS.png" align="right"></a></div>
				    		<div class="col-xs-6 col-sm-6 col-lg-6"><a href="../../view/tts/highScore.php"><img class="img-responsive" src="../../assets/img/tts/highScoreTTS.png"" align="left"></a></div>
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