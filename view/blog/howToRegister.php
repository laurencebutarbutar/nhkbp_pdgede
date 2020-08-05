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
		<link href="https://fonts.googleapis.com/css?family=Black+Ops+One" rel="stylesheet">

		<style type="text/css">
			.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
				border-bottom: 2px solid #b63b4d
			}
      	</style>

      	<style type="text/css">
	        .body h1, h2, h3, h4{
	          color: black;
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
                <li class="active"><a href="../../view/users/news.php" style="color: #b63b4d">News</a></li>
                <li><a href="../../services/users/prosesRefreshUser.php" style="color: #2d2c41">Profile</a></li>
                <li><a href="../../services/users/prosesCheckAccount.php" style="color: #2d2c41">Update Account</a></li>
                <li><a href="logout.php" style="color: #2d2c41">Logout</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
    <!-- End Navbar -->

    <!-- Start Body -->
	  	<div class="container">
		  	<div class="row centered mt mb">
		  		<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-4" style="border: 2px solid #b63b4d;background-color: #f2f2f2; padding-top: 5px;padding-bottom: 5px; color: black">
	              <h1 style="color: black; font-weight: bold; margin-top: 0px">Bagaimana cara registrasi 1 tim?</h1>
                  <p>Untuk registrasi 1 tim, kamu harus memastikan terlebih dahulu bahwa semua anggota tim kamu sudah memiliki akun nhkbp pondok gede. Selanjutnya adalah sebagai berikut :</p>
                  <hr>
                  <p>1. Pilih salah satu event (Badminton, Basket, Cover Lagu Rohani, atau PUBG) yang tim kalian ingin ikuti. Di sini kami contohkan event Badminton</p>
                  <img src="../../assets/img/news/howTo1.jpg" style="width:260px";> 
                  <hr>
                  <p>2. Pada pilihan Mode, pilih registrasi mode: Team</p>
                  <img src="../../assets/img/news/howTo2.jpg" style="width:260px";> 
                  <hr>
                  <p>3. Pada pilihan Team Mode, pilih mode team: Create Team </p>
                  <img src="../../assets/img/news/howTo3.jpg" style="width:260px";> 
                  <hr>
                  <p>4. Pada pilihan Create Team, masukan nama dan password tim yang akan kalian buat, tekan register apabila telah selesai</p>
                  <img src="../../assets/img/news/howTo4.jpg" style="width:260px";>           
                  <hr>        
                  <p>5. Apabila sudah muncul notifikasi "Registration Create Team Success", maka kalian dapat beritahukan ke tim kalian nama dan password tim tersebut. Di sini user yang Create Team, akan kami jadikan statusnya sebagai kapten tim, dimana nantinya hanya kapten tim yang dapat merubah nama dan password tim. Kapten tim juga yang nantinya akan kami jadikan sebagai penghubung utama kami.</p>
                  <img src="../../assets/img/news/howTo5.jpg" style="width:260px";> 
                  <hr>
                  <p>6. Untuk anggota tim lainnya, ikuti langkah 1 dan 2. Pada pilihan Team Mode, pilih mode team: Join Team</p>
                  <img src="../../assets/img/news/howTo6.jpg" style="width:260px";> 
                  <hr>
                  <p>7. Pada pilihan Join Team, masukan nama tim dan password tim kalian yang telah dibuat sebelumnya,tekan register apabila telah selesai. </p>
                  <img src="../../assets/img/news/howTo7.jpg" style="width:260px";>       
                  <hr>
                  <p>8. Apabila sudah muncul notifikasi "Registration Join Team Success", maka kalian sudah 1 tim.</p>
                  <img src="../../assets/img/news/howTo8.jpg" style="width:260px";> 
                  <hr>
                  <p>9. Untuk memastikan anggota tim kalian, kalian dapat melihatnya pada menu "Update Account".</p>
                  <img src="../../assets/img/news/howTo9.jpg" style="width:260px";> 
                  <hr>
                  <p>10. Pada sub menu dibawah, pilih Events, dan pada tabel Team Member kalian akan melihat anggota tim kalian. Dimana icon C, menandakan kapten tim.</p>
                  <img src="../../assets/img/news/howTo10.jpg" style="width:260px";> 
                  <hr>
                  <p>Posted by : Admin</p>
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
	</body>
</html>