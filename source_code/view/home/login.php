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

$failedLogin = $_SESSION['failedLogin'];
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>NHKBP Pondok Gede</title>

	    <!-- Bootstrap core CSS -->
	    <!-- <link href="../../assets/css/bootstrap.css" rel="stylesheet"> -->
	    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
	    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css"> -->
	    <!-- <link rel="stylesheet" href="../../assets/css/bootstrap-select.min.css"> -->

	    <!-- Custom styles for this template -->
	    <link href="../../assets/css/style.css" rel="stylesheet">

		<!-- Website Font style -->
	    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />  -->
		<link rel="stylesheet" href="../../assets/css/font-awesome.min.css" />
		<!-- Google Fonts -->
		<!-- <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'> -->
		<link href="../../assets/css/passionOne.min.css" rel='stylesheet' type='text/css'>
		<!-- <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'> -->

		<!-- Website CSS style -->
		<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/> -->
		<link rel="stylesheet" href="../../assets/css/bootstrapValidator.min.css"/>

		<!-- JS, Jquery Validator Field Form -->
		<!-- <script src="//code.jquery.com/jquery-3.3.1.min.js"></script> -->
		<script src="../../assets/js/jquery-3.3.1.min.js"></script>
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
		<script src="../../assets/js/jquery.min.js"></script>

		<!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script> -->
		<script type="text/javascript" src="../../assets/js/bootstrapValidator.min.js"></script>
		<!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.js"></script> -->

		<!-- JS Select Picker -->
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script> -->
		<!-- <script type="text/javascript" src="../../assets/js/bootstrap-select.min.js"></script> -->

		<!-- Custom CSS For Registration -->
		<style type="text/css">			
		body,html{height:100%;background-color:#d3d3d3;background-image:url(../../assets/img/home/background.jpg)}.main{margin-top:70px}h1.title{font-size:40px;font-family:'Passion One',cursive;font-weight:400}p.desc{font-size:30px;font-family:'Passion One',cursive;font-weight:400;text-shadow:-1px -1px 0 #FFFFFF,1px -1px 0 #FFFFFF,-1px 1px 0 #FFFFFF,1px 1px 0 #FFF}hr{width:10%;color:#fff;margin-left:45%;margin-right:45%}.form-group{margin-bottom:15px}label{margin-bottom:15px}input,input::-webkit-input-placeholder{font-size:11px;padding-top:3px}.main-login{background-color:#fff;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;-moz-box-shadow:0 2px 2px rgba(0,0,0,.3);-webkit-box-shadow:0 2px 2px rgba(0,0,0,.3);box-shadow:0 2px 2px rgba(0,0,0,.3)}.main-center{margin-top:30px;margin:0 auto;max-width:330px;padding:40px 40px}.login-button{margin-top:5px}.login-register{font-size:11px;text-align:center}
		</style>	

	</head>
	<body>

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
	          <a class="navbar-brand" href="http://nhkbp-pdgede.com">NHKBP Pondok Gede</a>
	        </div>
	        <div class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="http://nhkbp-pdgede.com">Home</a></li>
	            <!-- <li><a href="#games">Events</a></li> -->
	            <li><a href="donation.html">Donation</a></li>
	            <li><a href="product.html">Products</a></li>
	            <li><a href="registration.php">Registration</a></li>
	            <li class="active"><a href='login.php'>Login</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>
    <!-- End Navbar -->

    <!-- Start Body -->
		<div class="container">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<!-- <h1 class="title">Parheheon NHKBP Pondok Gede 2018</h1> -->
	               		<img src="../../assets/img/home/logo.png" class="img-responsive center-block" style="width: 330; height: auto;">
	               		<p class="desc">Login Account NHKBP Pondok Gede</p>
	               		<hr style="text-align: center;" />
	               	</div>
	            </div> 
				<div class="main-login main-center">

				<!-- Start Message Success -->
				<?php
					if($failedLogin != Null || $failedLogin != null){
						echo "<div class='form-group'>";
			        	echo "<div class='cols-sm-2 control-label'>";
			        	echo "<div class='alert alert-danger text-center'>".$failedLogin."</div>";
			        	echo "</div>";
			    		echo "</div>";
					}
			    ?>
			    <!-- End Message Success -->

				<form id="login" name="login" class="form-horizontal"
				    data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
				    data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
				    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"					
					method="post"
				    action="../../services/home/prosesLogin.php">

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true" style="font-size:15px"></i></span>
									<input type="text" class="form-control" id="username" name="username" placeholder="Enter your Username" 
									required data-bv-notempty-message="Please enter your username"
									/>
								</div>
								<a href="forgotUsername.php"><p style="font-size: 14px; text-align: right;">Forgot Username?</p></a>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" required name="password" id="password" placeholder="Enter your Password"
									required data-bv-notempty-message="Please enter your password"
									/>
								</div>
							<a href="forgotPassword.php"><p style="font-size: 14px; text-align: right;">Forgot Password?</p></a>
							</div>
						</div>

						<div class="form-group ">
							<button type="submit" id="buttonLogin" name="buttonLogin" class="btn btn-primary btn-lg btn-block login-button">Login</button>
						</div>
						<p style="font-size: 14px; text-align: center;">Please Contact Us If You Have A Problem To Login</p>
					</form>		
				</div>
			</div>
		</div>
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

	<script>
		$(document).ready(function() {
		    $('#login').bootstrapValidator();
		});
	</script>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
		<script src="../../assets/js/bootstrap.min.js"></script>
	</body>

	<!-- Restart Message Success -->
	<?php
		$_SESSION['failedLogin'] = null;
	?>
</html>