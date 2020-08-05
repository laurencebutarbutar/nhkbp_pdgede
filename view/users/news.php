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

$usersDetailId = $_SESSION['tUsersDetailId'];
$nickName = $_SESSION['nickName'];

if($usersDetailId === null){
	$_SESSION['failedLogin'] = "Please Login";
	header("Location: ../../view/home/login.php");  
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

	    <title>NHKBP Pondok Gede</title>
	    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	    <link href="../../assets/css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="../../assets/css/font-awesome.min.css" />
      	<link href="../../assets/css/account-wo-dropdown.css" rel="stylesheet">
		<script src="../../assets/js/jquery.min.js"></script>
		<link href="../../assets/css/full-slider.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Black+Ops+One" rel="stylesheet">

		<style type="text/css">
			.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
				border-bottom: 2px solid #b63b4d
			}
      	</style>

      	<style type="text/css">
	        .body h1, h2, h3, h4{
	          color: #2d2c41;
	        }
      	</style>

	</head>
	<body style="color: #2d2c41; background-color: #2d2c41">

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
              <a class="navbar-brand" href="#" style="color: #2d2c41">Hi, <?php echo $nickName?></a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="news.php" style="color: #b63b4d">News</a></li>
                <li><a href="../../services/users/prosesRefreshUser.php" style="color: #2d2c41">Profile</a></li>
                <li><a href="../../services/users/prosesCheckAccount.php" style="color: #2d2c41">Update Account</a></li>
                <li><a href="logout.php" style="color: #2d2c41">Logout</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
    <!-- End Navbar -->

    <!-- Start Body -->
	 	<header id="myCarousel" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <!-- <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li> -->
        </ol>

        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('../../assets/img/news/news1.jpg');"></div>
                <div class="carousel-caption">
                    <h2 style="color: #00a68d; text-shadow:-2px -2px 0 #000,2px -2px 0 #000,-2px 2px 0 #000,2px 2px 0 #000; font-family: 'Black Ops One', cursive;">Info Search Vol.2</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </header>

	  	<div class="container">
		  	<div class="row centered mt mb">
		  		<div class="col-lg-5 col-md-5 col-sm-5" style="border: 2px solid #b63b4d;background-color: #f2f2f2; padding-top: 5px;padding-bottom: 5px;">
	              <div class="card h-100">
	                <a href="../../view/blog/howToRegister.php"><img class="card-img-top" src="../../assets/img/news/howTo.jpg" alt="" style="width:100%";></a>
	                <div class="card-body">
	                  <h4 class="card-title">
	                    <a href="../../view/blog/howToRegister.php">Bagaimana cara registrasi 1 tim?</a>
	                  </h4>
	                  <p class="card-text">Untuk registrasi 1 tim, kamu harus memastikan terlebih dahulu bahwa semua anggota tim kamu sudah memiliki akun nhkbp pondok gede. Klik gambar untuk lebih lanjut... </p>
	                </div>
	                <div class="card-footer">
	                  <small class="text-muted">Posted by : Admin</small>
	                </div>
	              </div>
	            </div>

	            <div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2 col-sm-5" style="border: 2px solid #b63b4d;background-color: #f2f2f2; padding-top: 5px;padding-bottom: 5px;">
	              <div class="card h-100">
	                <a href="../../view/blog/howToChangeMode.php"><img class="card-img-top" src="../../assets/img/news/howToChangeMode.jpg" alt="" style="width:100%";></a>
	                <div class="card-body">
	                  <h4 class="card-title">
	                    <a href="../../view/blog/howToChangeMode.php">Bagaimana cara rubah registrasi solo menjadi tim?</a>
	                  </h4>
	                  <p class="card-text">Apabila kamu tiba-tiba menemukan tim yang mengajak bergabung, tapi sudah terlanjur daftar mode solo. Klik gambar untuk lebih lanjut... </p>
	                </div>
	                <div class="card-footer">
	                  <small class="text-muted">Posted by : Admin</small>
	                </div>
	              </div>
	            </div>
        	</div>	  

      	</div>
	    <!-- /.container -->
	<!-- End Body -->

	<!-- Start Footer -->
		<div id="footerwrap">
			<div class="container">
				<div class="row centered">
					<div class="col-lg-4">
						<p><b>- We Can Do All Things Through Christ -</b></p>
					</div>				
					<div class="col-lg-4">
						<p>Jalan Taman Pondok Gede Blok D1 No.2, Jatirahayu, Pondokmelati, Jatirahayu, Pondokmelati, Kota Bks, Jawa Barat 17414.</p>
					</div>
					<div class="col-lg-4">
						<p>hkbp.pdgede@gmail.com</p>
					</div>
				</div>
			</div>
		</div>
	<!-- End Footer -->

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
		<script src="../../assets/js/bootstrap.min.js"></script>
    	<script src="../../assets/js/bootstrap.bundle.min.js"></script>    	
	</body>
</html>