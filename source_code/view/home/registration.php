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

$successRegis = $_SESSION['successRegis'];
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
	    <link rel="stylesheet" href="../../assets/css/bootstrap-select.min.css">

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
		<script type="text/javascript" src="../../assets/js/bootstrap-select.min.js"></script>

		<!-- Custom CSS For Registration -->
		<style type="text/css">			
		body, html{
		    height: 100%;
		 	/*background-repeat: repeat;*/
		 	background-color: #d3d3d3;
		 	/*font-family: 'Oxygen', sans-serif;*/
		 	/*font-family: 'Oxygen', sans-serif;*/
		 	background-image: url("../../assets/img/home/background.jpg");
		 	/*width: 100%;*/
		 	/*background-position: center;*/
		 	/*background-size: cover;*/
		}

		.main{
		 	margin-top: 70px;
		}

		h1.title { 
			font-size: 40px;
			font-family: 'Passion One', cursive; 
			font-weight: 400; 
		}

		p.desc { 
			font-size: 30px;
			font-family: 'Passion One', cursive; 
			font-weight: 400; 
			/*color:#3e9ac3;*/
			/*color:white;*/
			text-shadow:
				-1px -1px 0 #FFFFFF,
				1px -1px 0 #FFFFFF,
				-1px 1px 0 #FFFFFF,
				1px 1px 0 #FFFFFF;
		}

		hr{
			width: 10%;
			color: #fff;
			margin-left: 45%;
			margin-right: 45%;
		}

		.form-group{
			margin-bottom: 15px;
		}

		label{
			margin-bottom: 15px;
		}

		input,
		input::-webkit-input-placeholder {
		    font-size: 11px;
		    padding-top: 3px;
		}

		.main-login{
		 	background-color: #fff;
		    /* shadows and rounded borders */
		    -moz-border-radius: 2px;
		    -webkit-border-radius: 2px;
		    border-radius: 2px;
		    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

		}

		.main-center{
		 	margin-top: 30px;
		 	margin: 0 auto;
		 	max-width: 330px;
		    padding: 40px 40px;

		}

		.login-button{
			margin-top: 5px;
		}

		.login-register{
			font-size: 11px;
			text-align: center;
		}			
		</style>

		<!-- Cek username using AJAX -->
		<script type="text/javascript">
		$(document).ready(function(){
			$('#buttonRegister').click(function(){	
				$.post('../../services/home/getUserRegis.php', {usernameRegis:regis.username.value}, function(result){
					if(result == "1"){
						event.preventDefault();
						event.stopPropagation();   			
						document.getElementById("buttonRegister").disabled = true; 
						document.getElementById("usHint").innerHTML="Username Already Exist";
					}
				})
			});

			$('#username').keyup(function(){
				$.post('../../services/home/getUserRegis.php', {usernameRegis:regis.username.value}, function(result){
					if(result == "1"){
						document.getElementById("buttonRegister").disabled = true; 
						document.getElementById("usHint").innerHTML="Username Already Exist";
					}
					else{
						document.getElementById("buttonRegister").disabled = false; 	
						document.getElementById("usHint").innerHTML="";				
					}
				})
			});			
		});
		</script>

		<!-- Cek phone using AJAX -->
		<script type="text/javascript">
		$(document).ready(function(){
			$('#buttonRegister').click(function(){
				$.post('../../services/home/getPhoneRegis.php', {phoneRegis:regis.phone.value}, function(result){
					if(result == "1"){
						event.preventDefault();
						event.stopPropagation();   		
						document.getElementById("buttonRegister").disabled = true; 
						document.getElementById("phHint").innerHTML="Phone Already Exist";
					}
				})
			});

			$('#phone').keyup(function(){
				$.post('../../services/home/getPhoneRegis.php', {phoneRegis:regis.phone.value}, function(result){
					if(result == "1"){
						document.getElementById("buttonRegister").disabled = true; 
						document.getElementById("phHint").innerHTML="Phone Already Exist";
					}
					else{
						document.getElementById("buttonRegister").disabled = false; 	
						document.getElementById("phHint").innerHTML="";				
					}
				})
			});			
		});
		</script>

		<!-- Cek Multiple Select .selectpicker -->
		<script type="text/javascript">
		$(document).ready(function() {	
			$('#buttonRegister').click(function(){
				if($('#hobbies').val() == ""){					
					event.preventDefault();
   					event.stopPropagation();   					
			    	document.getElementById("buttonRegister").disabled = true;  			
			    	document.getElementById("hobHint").innerHTML="Required 2 Hobbies"; 		
				}
				else{
					$('#hidden_hobbies').val($('#hobbies').val());
				}
			});
			$('#hobbies').on('change', function(){
				if ($('#hobbies option:selected').length == 2) {
			    	document.getElementById("buttonRegister").disabled = false;
			    	document.getElementById("hobHint").innerHTML="";
			    	$('#hidden_hobbies').val($('#hobbies').val());
			  	}else{
			    	document.getElementById("buttonRegister").disabled = true;
			    	document.getElementById("hobHint").innerHTML="Required 2 Hobbies";
			  	}
			});
		});
		</script>

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
	            <li class="active"><a href="registration.php">Registration</a></li>
	            <li><a href='login.php'>Login</a></li>
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
	               		<p class="desc">Registration Account NHKBP Pondok Gede</p>
	               		<hr style="text-align: center;" />
	               	</div>
	            </div> 
				<div class="main-login main-center">

				<!-- Start Message Success -->
				<?php
					if($successRegis == 1){
						echo "<div class='form-group'>";
			        	echo "<div class='cols-sm-2 control-label'>";
			        	echo "<div class='alert alert-success text-center'>Registration Success</div>";
			        	echo "</div>";
			    		echo "</div>";
					}else if($successRegis == 2){
						echo "<div class='form-group'>";
			        	echo "<div class='cols-sm-2 control-label'>";
			        	echo "<div class='alert alert-danger text-center'>Registration Failed</div>";
			        	echo "</div>";
			    		echo "</div>";
					}else if($successRegis == 3){
						echo "<div class='form-group'>";
			        	echo "<div class='cols-sm-2 control-label'>";
			        	echo "<div class='alert alert-warning text-center'>Registration With Warning !</div>";
			        	echo "</div>";
			    		echo "</div>";
					}
			    ?>
			    <!-- End Message Success -->

				<form id="regis" name="regis" class="form-horizontal"
				    data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
				    data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
				    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"					
					method="post"
				    action="../../services/home/prosesRegis.php">

						<div class="form-group">
							<label for="fullName" class="cols-sm-2 control-label">Full Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="fullName" id="fullName"  placeholder="Enter your Full Name"
									required data-bv-notempty-message="The Full Name is required"
									/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="phone" class="cols-sm-2 control-label">Mobile Phone Number</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-mobile-phone" aria-hidden="true" style="font-size:20px"></i></span>
									<span class="input-group-addon">+62</span>
									<input type="text" class="form-control" name="phone" id="phone"  placeholder="Enter your Mobile Phone Number"
									data-bv-integer="true" data-bv-integer-message="Wrong Number"
									required data-bv-notempty-message="The Mobile Phone Number is required" 
									/>
								</div>								
        						<div id="phHint" class="text-danger"></div>
							</div>
						</div>

						<div class="form-group">
							<label for="birthday" class="cols-sm-2 control-label">Birthday</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>	
									<input type="date" class="form-control"  name="birthday" id="birthday" placeholder="Select your Birthday"
									required data-bv-notempty-message="The Birthday is required" 
									/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="gender" class="cols-sm-2 control-label">Gender</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-venus-mars" aria-hidden="true"></i></span>
									<select class="form-control" name="gender" id="gender"
									required data-bv-notempty-message="The Gender is required" >
										<option disabled selected value> -- Choose your Gender -- </option>
									  	<option>Male</option>
									  	<option>Female</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="maritalStatus" class="cols-sm-2 control-label">Marital Status</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-check" aria-hidden="true"></i></span>
									<select class="form-control" name="maritalStatus" id="maritalStatus"
									required data-bv-notempty-message="The Marital Status is required" >
										<option disabled selected value> -- Choose your Status -- </option>
									  	<option>Single</option>
									  	<option>Married</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="wijk" class="cols-sm-2 control-label">Wijk</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-users" aria-hidden="true"></i></span>
									<select class="form-control" name="wijk" id="wijk"
									required data-bv-notempty-message="The Wijk is required" >
										<option disabled selected value> -- Choose your Wijk -- </option>
									  	<option>1</option>
									  	<option>2</option>
									  	<option>3</option>
									  	<option>4</option>
									  	<option>5</option>
									  	<option>6</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="address" class="cols-sm-2 control-label">Address</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-home" aria-hidden="true" style="font-size:18px"></i></span>
									<textarea rows="2" class="form-control" name="address" id="address"  placeholder="Enter your Address"
									required data-bv-notempty-message="The Address is required">
									</textarea>
								</div>
							</div>
						</div>

						<!-- <div class="form-group">
							<label for="events" class="cols-sm-2 control-label">Events</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-star" aria-hidden="true" style="font-size:18px"></i></span>
									<select class="form-control" name="events" id="events"
									required data-bv-notempty-message="The Events is required" >
										<option disabled selected value> -- Choose your Events -- </option>
									  	<option>Badminton</option>
									  	<option>Color Run</option>
									  	<option>Basketball (3 on 3)</option>
									  	<option>Musical Arrangement</option>
									</select>
								</div>
							</div>
						</div>
 -->
						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" 
									required data-bv-notempty-message="The Email is required"
									/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="hobbies" class="cols-sm-2 control-label" multiple data-max-options="2">Hobbies</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-futbol-o" aria-hidden="true"></i></span>				
									<select class="selectpicker form-control" name="hobbies" id="hobbies" multiple data-max-options="2"
  									data-size="7"
  									data-validation="required"
									>
										<optgroup label="Sport">										
										  	<option>Football</option>
										  	<option>Basketball</option>								
										  	<option>Badminton</option>
										  	<option>Table Tenis</option>								
										  	<option>Volleyball</option>
										  	<option>ESports</option>								
										  	<option>Others Sport</option>
									  	<optgroup label="Art">									
										  	<option>Drawing</option>
										  	<option>Photography</option>
										  	<option>Writing</option>								
										  	<option>Drama</option>
										  	<option>Dancing</option>								
										  	<option>Stand-up</option>
										  	<option>Others Art</option>
									  	<optgroup label="Music">									
										  	<option>Singing</option>
										  	<option>Musician</option>
										  	<option>Others Music</option>				
									</select>
								</div>
								<input type="hidden" name="hidden_hobbies" id="hidden_hobbies" />
        						<div id="hobHint" class="text-danger"></div>	
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true" style="font-size:15px"></i></span>
									<input type="text" class="form-control" id="username" name="username" placeholder="Enter your Username" 
									required data-bv-notempty-message="The Username is required"
									/>
								</div>
        						<div id="usHint" class="text-danger"></div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" minlength=6 required name="password" id="password" placeholder="Enter your Password"
									required data-bv-notempty-message="The Password is required"
									data-bv-identical="true"
					                data-bv-identical-field="confirmPassword"
					                data-bv-identical-message="The password and its confirm are not the same"
									/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirmPassword" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword"
									required data-bv-notempty-message="The Confirm Password is required"
									data-bv-identical="true"
					                data-bv-identical-field="password"
					                data-bv-identical-message="The password and its confirm are not the same" 
					                />
								</div>								
        						<div class="help-block with-errors"></div>
							</div>
						</div> 

						<div class="form-group ">
							<button type="submit" id="buttonRegister" name="buttonRegister" class="btn btn-primary btn-lg btn-block login-button">Register</button>
						</div>
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
		    $('#regis').bootstrapValidator();
		});
	</script>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
		<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>  -->
		<script src="../../assets/js/bootstrap.min.js"></script>
	</body>

	<!-- Restart Message Success -->
	<?php
		$_SESSION['successRegis'] = 0;
	?>
</html>