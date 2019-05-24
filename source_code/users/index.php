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

$fullName = $_SESSION['fullName'];
$nickName = $_SESSION['nickName'];
$phone = $_SESSION['phone'];
$birthday = $_SESSION['birthday'];
$gender = $_SESSION['gender'];
$address = $_SESSION['address'];
$email = $_SESSION['email'];
$path = $_SESSION['pathImage'];
$ttsActivities = $_SESSION['TTS'];
$cariKataActivities = $_SESSION['cariKata'];
$offlineActivities = $_SESSION['offlineActivities'];
$retretActivities = $_SESSION['retret'];
$usernameLogin = $_SESSION['usernameLogin'];
$usersDetailId = $_SESSION['tUsersDetailId'];
$maritalStatus = $_SESSION['maritalStatus'];
$orderId = $_SESSION['orderId'];
$orderCreated = $_SESSION['orderCreated'];
$orderStatus = $_SESSION['orderStatus'];

$successRegisActivities = $_SESSION['successRegisActivities']; //status Regis
$messageRegisActivities = $_SESSION['messageRegisActivities']; //message Regis


if($fullName === null || $nickName === null || $phone === null || $birthday===null || $gender===null || $address === null || $email === null || $ttsActivities === null || $cariKataActivities === null || $offlineActivities === null || $retretActivities === null || $usernameLogin === null || $usersDetailId === null || $maritalStatus === null){
	$_SESSION['failedLogin'] = "Please Login";
	header("Location: ../view/home/login.php");  
}
   
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
	    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	    <link href="../assets/css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="../assets/css/font-awesome.min.css" />
        <link href="../assets/css/index-account.css" rel="stylesheet">

        <style type="text/css">
			.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
				border-bottom: 2px solid #b63b4d
			}
        </style>

        <style type="text/css">
			#customers {
			    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			    border-collapse: collapse;
			    width: 100%;
			}

			#customers td, #customers th {
			    border: 1px solid #ddd;
			    padding: 8px;
			}

			#customers tr:nth-child(even){background-color: #f2f2f2;}

			#customers tr:hover {background-color: #ddd;}

			#customers th {
			    padding-top: 12px;
			    padding-bottom: 12px;
			    text-align: left;
			    background-color: #4CAF50;
			    color: white;
			}
        </style>     
        <style type="text/css">
			#customers2 {
			    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			    border-collapse: collapse;
			    width: 100%;
			}

			#customers2 td, #customers th {
			    border: 1px solid #ddd;
			    padding: 8px;
			}

			#customers2 tr:nth-child(even){background-color: #f2f2f2;}

			#customers2 tr:hover {background-color: #ddd;}

			#customers2 th {
			    padding-top: 12px;
			    padding-bottom: 12px;
			    text-align: left;
			    background-color: #4CAF50;
			    color: white;
			}
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
              <a class="navbar-brand" href="#" style="color: #2d2c41">Hi, <?php echo $nickName?></a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li style=""><a href="../../view/users/news.php" style="color: #2d2c41">News</a></li>
                <li class="active"><a href="http://nhkbp-pdgede.com/users" style="color: #b63b4d">Profile</a></li>
                <li><a href="../../services/users/prosesCheckAccount.php" style="color: #2d2c41">Update Account</a></li>
                <li><a href="../../view/users/logout.php" style="color: #2d2c41">Logout</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
    <!-- End Navbar -->

	<!-- Start Account Page -->
		<div class="container" style="margin-top: 40px;">		
			<div class="row">		   

				<!-- Notif Success Regis Activities -->
				<?php
					if($successRegisActivities == 1){//sukses
						echo "<div class='alert alert-success alert-dismissible fade in' style='text-align: center; margin-top: 15px;''>";
						echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
						echo "<strong>".$messageRegisActivities."</strong>";
					  	echo "</div>";
				  	}else if($successRegisActivities == 2){//danger
						echo "<div class='alert alert-danger alert-dismissible fade in' style='text-align: center; margin-top: 15px;''>";
						echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
						echo "<strong>".$messageRegisActivities."</strong>";
					  	echo "</div>";
				  	}else if($successRegisActivities == 3){//warning
						echo "<div class='alert alert-warning alert-dismissible fade in' style='text-align: center; margin-top: 15px;''>";
						echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
						echo "<strong>".$messageRegisActivities."</strong>";
					  	echo "</div>";
				  	}
			  	?>

				<!-- Contenedor -->
				<ul id="accordion" class="accordion">
			    <li>
					<div class="col col_4 iamgurdeep-pic">
						<img class="img-responsive iamgurdeeposahan" style="display: block; width: 360px; height: 360px; margin: auto;" alt="avatar" src="../assets/img/users/<?php
							if($path === null){
								echo "gender/".$gender.".jpg";
							}else{
								echo "upload/".$path;
							}
						?>">
						<div class="edit-pic">
							<a href="#" target="_blank" class="fa fa-facebook"></a>
							<a href="#" target="_blank" class="fa fa-instagram"></a>
							<a href="#" target="_blank" class="fa fa-twitter"></a>
						</div>

						<div class="username">
						    <h2 style="text-align: center;color: #b63b4d"><?php echo $fullName?></h2>   
						</div>		    
					</div>		        
		    	</li>
				<li>
					<div class="link"><i class="fa fa-globe"></i>About<i class="fa fa-chevron-down"></i></div>
						<ul class="submenu">
							<li><a href="#">Date of Birth : <?php echo $birthday?></a></li>
							<li><a href="#">Address : <?php echo $address?></a></li>
							<li><a href="mailto:<?php echo $email?>">Email : <?php echo $email?></a></li>
							<li><a href="#">Phone : <?php echo $phone?></a></li>
						</ul>
				</li>
				<li class="default open">
					<div class="link"><i class="fa fa-gamepad"></i>Games<i class="fa fa-chevron-down"></i></div>
					<ul class="submenu">
			            <li style="background-color: #b63b4d;"><a style="font-weight: 900;color: #2d2c41;">Teka-Teki Silang</a></li>
			            <?php 
			            if($ttsActivities == 0){
				            echo "<li><a href='../services/tts/prosesRegisTTS.php' style='margin-left: 30px;'>Register Teka-Teki Silang</a></li>";
		        		}else if($ttsActivities == 1){
				            echo "<li><a href='../services/tts/cekRegisTTS.php' style='margin-left: 30px;'>Play Teka-Teki Silang</a></li>";
				        	}
			            ?>
			            <li style="background-color: #b63b4d;"><a style="font-weight: 900;color: #2d2c41;">Cari Kata</a></li>
			            <?php 
			            if($cariKataActivities == 0){
				            echo "<li><a href='../services/cari_kata/prosesRegisCariKata.php' style='margin-left: 30px;'>Register Cari Kata</a></li>";
		            	}else if($cariKataActivities == 1){
				            echo "<li><a href='../services/cari_kata/cekRegisCariKata.php' style='margin-left: 30px;'>Play Cari Kata</a></li>";
			            	}
			            ?>
					</ul>
				</li>
				
				<li>
					<form id="regisEvent" name="regisEvent" class="form-horizontal" method="post" action="../services/users/prosesRegisOfflineEvent.php">

						<div class="link"><i class="fa fa-clipboard"></i>Registration Events<i class="fa fa-chevron-down"></i></div>
						<ul class="submenu" id="registerEvents">
							<li style="background-color: #b63b4d;"><a style="font-weight: 900;color: #2d2c41;">Events</a></li>
							<li><a style="margin-left: 30px;">
								<select class="form-control" name="events" id="events" required>
									<option disabled selected value> -- Choose your Events -- </option>
									<?php  if($offlineActivities == 0){
											echo "<option>Badminton</option>";
											echo "<option>Basket (3 on 3)</option>";
											echo "<option>Cover Lagu Rohani</option>";
											echo "<option>PUBG</option>";
								  		}
								  		if($retretActivities == 0){
							  				echo "<option>Retret</option>";									  	
								  		}
								  	?>
								</select>
							</a></li>
							<li style="background-color: #b63b4d;"><a style="font-weight: 900;color: #2d2c41;">Mode</a></li>
							<li><a style="margin-left: 30px;">
								<select class="form-control" name="mode" id="mode">
									<option disabled selected value> -- Choose your Mode -- </option>
								  	<option>Solo</option>
								  	<option>Team</option>
								</select>
							</a></li>

							<li style="background-color: #b63b4d;"><a style="font-weight: 900;color: #2d2c41;">Team Mode</a></li>
							<li><a style="margin-left: 30px;">
								<select class="form-control" name="teamMode" id="teamMode">
									<option disabled selected value> -- Choose your Team Mode -- </option>
								  	<option>Create Team</option>
								  	<option>Join Team</option>
								</select>
							</a></li>

							<li style="background-color: #b63b4d;"><a style="font-weight: 900;color: #2d2c41;">Join Team</a></li>
							<li><a style="margin-left: 30px;">
								<input type="text" class="form-control" name="nameJoinTeam" id="nameJoinTeam"  placeholder="Input Team Name"/>
							</a></li>
							<li><a style="margin-left: 30px;">
								<input type="text" class="form-control" name="passwordJoinTeam" id="passwordJoinTeam" placeholder="Enter your Team Password"/>
							</a></li>

							<li style="background-color: #b63b4d;"><a style="font-weight: 900;color: #2d2c41;">Create Team</a></li>
							<li><a style="margin-left: 30px;">
								<input type="text" class="form-control" name="nameCreateTeam" id="nameCreateTeam"  placeholder="Input Team Name"/>
							</a></li>
							<li><a style="margin-left: 30px;">
								<input type="text" class="form-control" name="passwordCreateTeam" id="passwordCreateTeam" placeholder="Enter your Team Password"/>
							</a></li>
			                <li><a>
			                <button style="margin-left: -15px;" type="submit" id="buttonRegisterEvent" onclick="return registCheck()" name="buttonRegisterEvent" class="btn btn-primary btn-lg btn-block login-button">Register</button>
			                </a></li>
						</ul>					
					</form>		
				</li>

				<li>
					<form id="regisOrder" name="regisOrder" class="form-horizontal" method="post" action="../services/users/prosesRegisOrder.php">
						<div class="link"><i class="fa fa-cutlery"></i>Order Food<i class="fa fa-chevron-down"></i></div>
						<ul class="submenu">

							<div class="input_fields_wrap" style="width: 100%;">
								<li><a>
			                		<input style="text-align: right;" type="hidden" class="form-control" name="priceBefore[0]" id="priceBefore[0]" value="0" readonly required></input>
			                		<input style="text-align: right;" type="hidden" class="form-control" name="nameFood[0]" id="nameFood[0]" value="0" readonly required></input>
									<select class="form-control" name="orderFood[0]" id="orderFood[0]" onchange="change(0)" style="margin-left: -15px;" required>
										<option disabled selected value> -- Choose Food -- </option>										
									  	<optgroup label="B2">
										  	<option value="200000">B2 Panggang (Rp 200.000)</option>
										  	<option value="200000">B2 Kecap (Rp 200.000)</option>
										  	<option value="200000">Saksang (Rp 200.000)</option>
									  	<optgroup label="Ayam">
									  		<option value="250000">Ayam Pinadar (Rp 250.000)</option>
									  		<option value="250000">Ayam Gota (Rp 250.000)</option>
									  		<option value="150000">Ayam Balado (Rp 150.000)</option>
								  		</optgroup>
									  	<optgroup label="Ikan Mas">
									  		<option value="150000">Ikan Mas Arsik (Rp 150.000)</option>
									  		<option value="150000">Ikan Mas Tombur (Rp 150.000)</option>
								  		</optgroup>
									  	<optgroup label="Parcel">
									  		<option value="150000">Parcel Buah (Rp 150.000)</option>
								  		</optgroup>
									</select>
								</a></li>
							</div>

							<li><a>
								<select class="form-control" name="orderFoodDate" id="orderFoodDate" style="margin-left: -15px;" required>
									<option disabled selected value> -- Choose Date -- </option>
									  	<option>Saturday, 1 September 2018</option>
									  	<option>Sunday, 2 September 2018</option>
									  	<option>Saturday, 8 September 2018</option>
									  	<option>Sunday, 9 September 2018</option>
									  	<option>Saturday, 15 September 2018</option>
									  	<option>Sunday, 16 September 2018</option>
									  	<option>Saturday, 22 September 2018</option>
									  	<option>Sunday, 23 September 2018</option>
								</select>
							</a></li>

							<li><a>
								<select class="form-control" name="orderFoodTime" id="orderFoodTime" style="margin-left: -15px;" required>
									<option disabled selected value> -- Choose Time -- </option>
									  	<option>Pkl 09:00</option>
									  	<option>Pkl 12:00</option>
									  	<option>Pkl 15:00</option>
								</select>
							</a></li>

							<li style="background-color: #b63b4d;">
								<a style="font-weight: 900;color: #2d2c41;">
									<table style="width: 100%; margin-left: -15px;">
										<tr>
											<td style="width: 35%;">Total Payment</td>
							                <td style="width: 5%;"></td>
							                <td  style="width: 60%;" align="center">
						                		<input style="text-align: right;" type="text" class="form-control" name="totalPay" id="totalPay" value="Rp 0" readonly required></input>
						                		<input style="text-align: right;" type="hidden" class="form-control" name="totalPayHidden" id="totalPayHidden" value="0" readonly required></input>
							                </td>
						                </tr>
					                </table>
				                </a>
			                </li>
							
							<li>
								<a>
									<table style="width: 100%; margin-left: -15px;">
										<tr>
											<td style="width: 45%; text-align: center;" align="center">
							                	<button id="buttonAddFood" name="buttonAddFood" class="btn btn-success btn-lg btn-block login-button add_field_button">Add</button>
							                </td>
							                <td style="width: 10%;"></td>
							                <td  style="width: 45%;" align="center">
						                		<button style="width: 100%" type="button" id="buttonOrderFood" name="buttonOrderFood" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Order</button>
							                </td>
						                </tr>
					                </table>
				                </a>
			                </li>

						</ul>

					<!-- Modal -->
					<div id="myModal" class="modal fade" role="dialog">
					  <div class="modal-dialog">

					    <!-- Modal content-->
					    <div class="modal-content">
					      <div class="modal-header" style="background-color: #b63b4d;">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title" style="color: white">Confirmation Order</h4>
					      </div>

					      <div class="modal-body">
					        <h4>Your Order :</h4>
					        <div style="overflow-x:auto">
						        <table id="customers" style="width: 100%; text-align: center">
						        	<tr>
						        		<th>No</th>
							        	<th>Name</th>
							        	<th>Quantity</th>
							        	<th>Price</th>
							        	<th>Subtotal</th>
						        	</tr>
						        	<tr>
						        		<td colspan="4" style="text-align: center; font-weight: bold">Total Payment</td>
						        		<td style="text-align: right"><span id="modalTotalPayment"></span></td>
						        	</tr>
					        	</table>
				        	</div>
				        	<h4>Detail Information :</h4>
				        	<table id="customers2" >
					        	<tr>
					        		<td>Name</td><td><?php echo $fullName?></td>
				        		</tr>
				        		<tr>
					        		<td>Phone</td><td><?php echo $phone?></td>
				        		</tr>
				        		<tr>
					        		<td>Address</td><td><?php echo $address?></td>
				        		</tr>
					        	<tr>
					        		<td>Delivery Date</td><td><span id="modalDateDelivery"></span></td>
				        		</tr>
				        		<tr>
					        		<td>Delivery Time</td><td><span id="modalTimeDelivery"></span></td>					        		
					        	</tr>
					        	<tr>
					        		<td>Note</td><td><textarea rows="2" name="noteOrder" id="noteOrder" class="form-control"></textarea></td>
					        	</tr>
					        </table>
					      </div>

					      <div class="modal-footer">
					        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
					        <button type="submit" id="buttonSubmitFood" name="buttonSubmitFood" class="btn btn-primary">Confirm</button>
					      </div>
					    </div>

					  </div>
					</div>
				<!-- End Modal -->

						
					</form>
				</li>

				<li>
					<div class="link"><i class="fa fa-check"></i>Order Status<i class="fa fa-chevron-down"></i></div>
					<ul class="submenu">
			            <li><a>
			            <table style="width: 100%; margin-left: -15px;">
			            <?php 
			            if($orderId != null){
			            	for($z=0;$z<(count($orderId));$z++){
			            		echo "<tr>";
				            		echo "<td style='width: 45%; text-align: center; font-weight:bold' align='center'>";	
									echo "RO-".date("Ymd", strtotime($orderCreated[$z]))."-".$orderId[$z];	
									echo "</td>";			
								    echo "<td style='width: 10%;'></td>";           	
								    echo "<td  style='width: 45%; font-weight:bold;' align='center'; >";
								    if($orderStatus[$z] == 0){
							    		echo "<span style='color:red;'>Pending Order</span>";
								    }else if($orderStatus[$z] == 1){
								    	echo "<span style='color:yellow;'>Follow Up</span>";
								    }else{
								    	echo "<span style='color:#00FF00;'>Completed</span>";
								    }
								    echo "</td>";            
						        echo "</tr>"; 
			            	}
				        }else{
				        	echo "<tr>";
		            		echo "<td style='width: 100%; text-align: center; font-weight:bolder' align='center'>";	
							echo "<span>You Don't Have Any Request Order</span>";
							echo "</td>";            
					        echo "</tr>"; 	
				        }
			            ?>	           
			            </table>
			            </a></li>
					</ul>
				</li>

			</ul>
			</div>
		</div>
	<!-- End Account Page -->    

		<script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/index-account.js"></script>
        <script src="../assets/js/usersJs.js?v=2"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
    </body>

    <!-- Restart Message Success -->
    <?php
        $_SESSION['successRegisActivities'] = 0;
        $_SESSION['messageRegisActivities'] = null;
    ?>
</html>