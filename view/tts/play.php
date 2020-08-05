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

//variabel for soal
$grid=null;
$grid2=null;
$pertanyaanMendatar=null;
$pertanyaanMenurun=null;
$gameNumber=null;
$quest=NULL;
$contentUtama=NULL;
$answer=NULL;
$question=NULL;

$highScore = $_SESSION['highScoreUser'];
$nickName = $_SESSION['nickName'];
//session soal dan jawaban
$quest = $_SESSION['quest'];
$answer = $_SESSION['answer'];
//validasi back force
$validPlay = $_SESSION['validPlay'];

//validasi not login
if($nickName === null || $highScore === null){
    $_SESSION['failedLogin'] = "Please Login!";
    header("Location: ../../view/home/login.php");  
}

//validasi skip page
if($validPlay !== true |$quest === null || $answer === null){
    $_SESSION['statusLoginTTS'] = 3; //status Login CariKata - warning
    $_SESSION['messageLoginTTS'] = "Oopps, You skip the page !! "; //message Login CariKata 
    header("Location: ../../tts");    
}

$gameNumber=intval($_SESSION['game_number']);

$contentUtama = explode("^", $quest);
$content = $contentUtama[0];
if ($content!=null&&$content!=NULL&&$content!=''&&$content!=""):            
    $content_pr=explode("/", $content);    
    for ($i=0; $i<(count($content_pr)); $i++):
        $content_spr=  explode("-", $content_pr[$i]);
        for ($j=0; $j<(count($content_spr)); $j++):
            $grid[$i][$j] = $content_spr[$j];
        endfor;
    endfor;            
endif;
    
$content = $contentUtama[1];
if ($content!=null&&$content!=NULL&&$content!=''&&$content!=""):        
    $content_pr=explode("/", $content);
    for ($i=0; $i<(count($content_pr)); $i++):
        $content_spr=  explode("-", $content_pr[$i]);
        for ($j=0; $j<(count($content_spr)); $j++):
            $grid2[$i][$j] = $content_spr[$j];
        endfor;
    endfor;        
endif;        

$question = explode("^", $answer);
$content = $question [0];
if ($content!=null&&$content!=NULL&&$content!=''&&$content!=""):
    $pertanyaanMendatar=explode("#", $content);
endif;

$content = $question [1];
if ($content!=null&&$content!=NULL&&$content!=''&&$content!=""):
    $pertanyaanMenurun=explode("#", $content);
endif;

$_SESSION['jawaban']=$grid;
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
            
            .whiteGrid {
                width: 100%;
                height: 100%;
                background-color: transparent;
                border-collapse:collapse;
                padding:0px;
                margin:0px;
                border:none;
                /*
                border: 1px solid #999;
                background: #fff;
                padding: 10px;
                */
                font-family:Arial, Helvetica, sans-serif;
                font-size:18px;
                text-align:center;
                text-transform:uppercase;
                background:url(images/grid/white.png);
                background-size:cover;
            }   
            .greyGrid {
                width: 100%;
                height: 100%;
                background-color: transparent;
                border-collapse:collapse;
                padding:0px;
                margin:0px;
                border:none;
                /*
                border: 1px solid #999;
                background: #fff;
                padding: 10px;
                */
                font-family:Arial, Helvetica, sans-serif;
                font-size:18px;
                text-align:center;
                text-transform:uppercase;
                background:url(<?php echo $pathImageTTS?>grid/low_px/grey.png);
                background-size:cover;
            }   
            
        </style>

        <!-- validasi for back button -->
        <script type="text/javascript">
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
                    <a style="color: white; font-size: 20px; font-weight: bold;"> Level <?php echo $gameNumber?> </a>
                </div>
            </div>

            <form action='../../services/tts/prosesAnswer.php' method='post' enctype='multipart/form-data' autocomplete='off'>
            <div class="row" style="margin-top: 5px;">         
                <div class="col-sm-8 col-sm-offset-2">
                    <!-- <div class="table-responsive"> -->
                    <?php
                        echo "<table >";    

                        if ($grid!=null && $grid!=NULL && $grid!='' && $grid!="" && $grid2!=null && $grid2!=NULL && $grid2!='' && $grid2!=""){
                            $x=1;
                            for ($i=0; $i<10; $i++){
                                echo "<tr>";        
                                $y=1;       
                                //start of grid table
                                for ($j=0; $j<10; $j++){
                                        if(($x+$y) %2 > 0){
                                            if ($grid[$i][$j]=="" || $grid[$i][$j]=="#"){   
                                                echo "<td bgcolor='#000000' style='border-collapse:collapse; padding:0px; margin:0px; height:20px; width:10%'>"."<img src='../../assets/img/tts/blank.PNG' style='width:100%; height:auto'></td>";
                                            } 
                                            else {
                                                $val = $grid2[$i][$j];
                                                echo "<td bgcolor='#ffffff' style='border-collapse:collapse; padding:1 1 1 1; margin:0px; height:20px; width:10%'>";

                                                if ($val!='#'){
                                                    echo "<input name='teksboks[".$i."][".$j."]' type='text' maxlength='1' style='background:url(../../assets/img/tts/grid/low_px/white".$val.".png); background-color: transparent; border-collapse:collapse; padding:0px; margin:0px; border:none; height:100%; width:100%; background-size:cover; font-family:Arial, Helvetica, sans-serif; font-size:18px; text-align:center; text-transform:uppercase; -moz-box-sizing:border-box; display: inline-block;'>";
                                                } else {
                                                    echo "<input class='whiteGrid' name='teksboks[".$i."][".$j."]' type='text' maxlength='1' >";
                                                }

                                                echo "</td>";
                                            }                       
                                        } 
                                        else {
                                            if ($grid[$i][$j]=="" || $grid[$i][$j]=="#"){
                                                echo "<td bgcolor='#000000' style='border-collapse:collapse; padding:0px; margin:0px; height:20px; width:10%'><img src='../../assets/img/tts/blank.PNG' style='width:100%; height=auto'></td>";
                                            } 
                                            else {
                                                $val = $grid2[$i][$j];
                                                echo "<td bgcolor='#989898' style='border-collapse:collapse; padding:0px; margin:0px; height:20px; width:10%'>";
                                                if ($val!='#'){
                                                    echo "<input name='teksboks[".$i."][".$j."]' type='text' maxlength='1' style='background:url(../../assets/img/tts/grid/low_px/grey".$val.".png); background-color: transparent; border-collapse:collapse; padding:0px; margin:0px; border:none; height:100%; width:100%; background-size:cover; font-family:Arial, Helvetica, sans-serif; font-size:18px; text-align:center; text-transform:uppercase; -moz-box-sizing:border-box; display: inline-block;'>";
                                                } else {
                                                    echo "<input class='greyGrid' name='teksboks[".$i."][".$j."]' type='text' maxlength='1' >";
                                                }
                                                echo "</td>";
                                            }       
                                        }
                                        $y++;               
                                }
                                echo "</tr>";
                                $x++;                            
                            }                                               
                        }                            
                        echo "</table>";
                    ?>
                </div>
            </div>
            
            <div class="row" style="margin-top: 5px;">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-12">
                            <div class="col-xs-6 col-sm-6 col-lg-6">
                            <p align="center" style="font-size: 18px; font-weight: bold; color: white; text-decoration: underline;"><i class="fa fa-arrows-h">&nbsp;</i>Across</p>
                            <?php
                                for ($x=0; $x<count($pertanyaanMendatar); $x++){
                                    if ($pertanyaanMendatar[$x] != null && $pertanyaanMendatar[$x] != NULL && $pertanyaanMendatar[$x] !='' && $pertanyaanMendatar[$x] != ""){
                                            echo "<div class='row'>";
                                            echo "<p style='font-size: 14px; font-weight: bold; color: white;'>".$pertanyaanMendatar[$x]."</p>";
                                        echo "</div>";
                                    }   
                                }
                            ?>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-lg-6">
                            <p align="center" style="font-size: 18px; font-weight: bold; color: white; text-decoration: underline;"><i class="fa fa-arrows-v">&nbsp;</i>Down</p>
                            <?php
                                for ($x=0; $x<count($pertanyaanMenurun); $x++){
                                    if ($pertanyaanMenurun[$x]!=null&&$pertanyaanMenurun[$x]!=NULL&&$pertanyaanMenurun[$x]!=''&&$pertanyaanMenurun[$x]!=""){
                                        echo "<div class='row'>";
                                            echo "<p style='font-size: 14px; font-weight: bold; color: white;'>".$pertanyaanMenurun[$x]."</p>";
                                        echo "</div>";
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>


            <div class="row" style="margin-top: 5px; margin-bottom: 20px; ">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="col-xs-6 col-sm-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-lg-offset-3">
                                <button>
                                    <img src="../../assets/img/tts/answerTTS.png" class="img-responsive" />
                                </button>
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