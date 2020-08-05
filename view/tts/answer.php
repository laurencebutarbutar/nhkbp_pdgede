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

//validasi back force
$validPlay = $_SESSION['validPlay'];

$highScore = $_SESSION['highScoreUser'];
$nickName = $_SESSION['nickName'];

$jawaban_bener = null;
$gameNumber = null;

$jawaban_bener = $_SESSION['jawaban'];
$gameNumber=intval($_SESSION['game_number']);

//validasi not login
if($nickName === null || $highScore === null){
    $_SESSION['failedLogin'] = "Please Login!";
    header("Location: ../../view/home/login.php");  
}

//validasi skip page
if($validPlay !== true |$gameNumber === null || $jawaban_bener === null){
    $_SESSION['statusLoginTTS'] = 3; //status Login CariKata - warning
    $_SESSION['messageLoginTTS'] = "Oopps, You skip the page !! "; //message Login CariKata 
    header("Location: ../../tts");    
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

		<style type="text/css">
			body{
				margin:0;
				padding:0 0 0 0;
				color:#fff;
				height:100%;
				width:100%;
			}
			#grad1{
				height:auto;
				width:100%;
				background: -webkit-linear-gradient(#2c0c57, #853538); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(#2c0c57, #853538); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(#2c0c57, #853538); /* For Firefox 3.6 to 15 */
				background: linear-gradient(#2c0c57, #853538); /* Standard syntax (must be last) */
			}
			.boxGrid {
				font-family:Arial, Helvetica, sans-serif;
				font-size:18px;
				text-align:center;
				text-transform:uppercase;
				color:#000;
				
			}
		</style>

        <!-- validasi for back button -->
		<script>
			history.pushState(null, null, location.href);
	    	window.onpopstate = function () {
	        	history.go(1);
	    	};
		</script>    

	</head>
<body style="background-color: #2d2c41; color: black;">

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
                    <a style="color: white; font-size: 20px; font-weight: bold;">Answer Level <?php echo $gameNumber?> </a>
                </div>
            </div>

            <form action='../../services/tts/prosesAnswer.php' method='post' enctype='multipart/form-data' autocomplete='off'>
            <div class="row" style="margin-top: 5px;">         
                <div class="col-sm-8 col-sm-offset-2">
                    <!-- <div class="table-responsive"> -->
                    <?php
                        echo "<table align='center' border='0px' width='100%' height='auto' style='border-collapse:collapse;'>";
						$x=1;
						for ($i=0; $i<10; $i++){
							echo "<tr bgcolor='#000000'>";
							$y=1;							
							//start of grid table
							for ($j=0; $j<10; $j++){
									if(($x+$y) %2 > 0){
										if ($jawaban_bener[$i][$j]!="" && $jawaban_bener[$i][$j]!="#"){	
											echo "<td class='boxGrid' bgcolor='#ffffff' style='border-collapse:collapse; padding:0px; margin:0px'>"
											.($jawaban_bener[$i][$j]).
											"</td>";
											} 
										else {
											echo "<td style='border-collapse:collapse; padding:0px; margin:0px'><img src='../../assets/img/tts/blank.PNG' style='width:100%; height=auto'></td>";										
											}						
									} 
									else {
										if ($jawaban_bener[$i][$j]!="" && $jawaban_bener[$i][$j]!="#"){	
											echo "<td class='boxGrid' bgcolor='#989898' style='border-collapse:collapse; padding:0px; margin:0px'>"
											.($jawaban_bener[$i][$j]).
											"</td>";
											} 
										else {
											echo "<td style='border-collapse:collapse; padding:0px; margin:0px'><img src='../../assets/img/tts/blank.PNG' style='width:100%; height=auto'></td>";										
											}	
									}
									$y++;				
							}
							echo "</tr>";
							$x++;						
						}					
					//end of grid table	
					echo "</table>";
                    ?>
                </div>
            </div>
            
            <div class="row" style="margin-top: 5px;">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <p align="center" style="font-size: 18px; font-weight: bold; color: white; text-decoration: underline;">
                            Your Score is : <?php echo $_SESSION['totalScore'] ?>
                            </p>
                            <p align="center" style="font-size: 18px; font-weight: bold; color: white; text-decoration: underline;">
                            Total Wrong Answer : <?php echo $_SESSION['totalSalah']?>
                            </p>
                            <p align="center" style="font-size: 18px; font-weight: bold; color: red;">
                            Remember ! This Is Just A Game, Not Relationship. So, No Need To Cheating.
                            </p>
                        </div>
                    </div>
                </div>      
            </div>


            <div class="row" style="margin-top: 5px; margin-bottom: 20px; ">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="col-xs-6 col-sm-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-lg-offset-3">
	                           	<a href="../../services/tts/checkPlay.php">
	                           		<img class="img-responsive" src="../../assets/img/tts/nextTTS.png" align="right">
	                           	</a>
                           	</div>
                        </div>
                    </div>
                </div>      
            </div>

            </form>           
        </div>
        <!-- End Account Page -->    

    <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
            <script src="../../assets/js/jquery.min.js"></script>
            <script src="../../assets/js/bootstrap.min.js"></script>        
    </body>    
</html>