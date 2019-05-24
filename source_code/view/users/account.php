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
$address = $_SESSION['address'];
$email = $_SESSION['email'];
$usersDetailWijk = $_SESSION['usersDetailWijk'];
$hobbiesAccount = $_SESSION['hobbiesAccount'];
$path = $_SESSION['pathImage'];
$gender = $_SESSION['gender'];

$ttsActivities = $_SESSION['TTS'];
$cariKataActivities = $_SESSION['cariKata'];

$offlineEventsName = $_SESSION['offlineEventsName'];
$offlineEventsTeamCreated = $_SESSION['offlineEventsTeamCreated'];
$offlineEventsTeamName = $_SESSION['offlineEventsTeamName'];
$offlineEventsTeamPassword = $_SESSION['offlineEventsTeamPassword']; 

$offlineActivities = $_SESSION['offlineActivities'];
$retretActivities = $_SESSION['retret'];
$usernameLogin = $_SESSION['usernameLogin'];
$usersDetailId = $_SESSION['tUsersDetailId'];
$maritalStatus = $_SESSION['maritalStatus'];
$orderStatus = $_SESSION['orderStatus'];

$highScoreTTS = $_SESSION['highScoreTTSAccount'];
$highScoreCariKata = $_SESSION['highScoreCariKataAccount'];

$teamMemberName = $_SESSION['teamMemberName'];
$teamMemberPhone = $_SESSION['teamMemberPhone'];
$teamCreated = $_SESSION['teamCreated'];

$medSosName = $_SESSION['medSosName'];
$medSosId = $_SESSION['medSosId'];

$successUpdateAccount = $_SESSION['successUpdateAccount']; //status Update
$messageUpdateAccount = $_SESSION['messageUpdateAccount']; //message Update

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
      <link rel="stylesheet" href="../../assets/css/bootstrap-select.min.css">
      <link href="../../assets/css/style.css" rel="stylesheet">
      <link rel="stylesheet" href="../../assets/css/font-awesome.min.css" />
      <link href="../../assets/css/account-wo-dropdown.css" rel="stylesheet">
      <link rel="stylesheet" href="../../assets/css/bootstrapValidator.min.css"/>

      <script src="../../assets/js/uploadImage.js"></script>
      <script src="../../assets/js/jquery-3.3.1.min.js"></script>
      <script src="../../assets/js/jquery.min.js"></script>
      <script type="text/javascript" src="../../assets/js/bootstrapValidator.min.js"></script>
      <script type="text/javascript" src="../../assets/js/bootstrap-select.min.js"></script>

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

	  <!-- Cek username using AJAX -->
		<script type="text/javascript">
		$(document).ready(function(){
			$('#buttonUpdateAbout').click(function(){	
				$.post('../../services/home/getUserRegis.php', {usernameRegis:updateAbout.usernameUpd.value}, function(result){
					if(result == "1"){
						event.preventDefault();
						event.stopPropagation();   			
						document.getElementById("buttonUpdateAbout").disabled = true; 
						document.getElementById("usHintUpd").innerHTML="Username Already Exist";
					}
				})
			});

			$('#usernameUpd').keyup(function(){
				$.post('../../services/home/getUserRegis.php', {usernameRegis:updateAbout.usernameUpd.value}, function(result){
					if(result == "1"){
						document.getElementById("buttonUpdateAbout").disabled = true; 
						document.getElementById("usHintUpd").innerHTML="Username Already Exist";
					}
					else{
						document.getElementById("buttonUpdateAbout").disabled = false; 	
						document.getElementById("usHintUpd").innerHTML="";				
					}
				})
			});			
		});
		</script>

		<!-- Cek phone using AJAX -->
		<script type="text/javascript">
		$(document).ready(function(){
			$('#buttonUpdateAbout').click(function(){
				$.post('../../services/home/getPhoneRegis.php', {phoneRegis:updateAbout.phoneUpd.value}, function(result){
					if(result == "1"){
						event.preventDefault();
						event.stopPropagation();   		
						document.getElementById("buttonUpdateAbout").disabled = true; 
						document.getElementById("phHintUpd").innerHTML="Phone Already Exist";
					}
				})
			});

			$('#phoneUpd').keyup(function(){
				$.post('../../services/home/getPhoneRegis.php', {phoneRegis:updateAbout.phoneUpd.value}, function(result){
					if(result == "1"){
						document.getElementById("buttonUpdateAbout").disabled = true; 
						document.getElementById("phHintUpd").innerHTML="Phone Already Exist";
					}
					else{
						document.getElementById("buttonUpdateAbout").disabled = false; 	
						document.getElementById("phHintUpd").innerHTML="";				
					}
				})
			});			
		});
		</script>

		<!-- Cek Multiple Select .selectpicker -->
		<script type="text/javascript">
		$(document).ready(function() {
			$('#hobbiesUpd').on('change', function(){
				if ($('#hobbiesUpd option:selected').length == 2) {
			    	document.getElementById("buttonUpdateAbout").disabled = false;
			    	document.getElementById("hobHintUpd").innerHTML="";
			    	$('#hidden_hobbiesUpd').val($('#hobbiesUpd').val());
			  	}else{
			    	document.getElementById("buttonUpdateAbout").disabled = true;
			    	document.getElementById("hobHintUpd").innerHTML="Required 2 Hobbies";
			  	}
			});
		});
		</script>

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
                <li style=""><a href="../../view/users/news.php" style="color: #2d2c41">News</a></li>
                <li><a href="../../services/users/prosesRefreshUser.php" style="color: #2d2c41">Profile</a></li>
                <li class="active"><a href="account.php" style="color: #b63b4d">Update Account</a></li>
                <li><a href="logout.php" style="color: #2d2c41">Logout</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
    <!-- End Navbar -->
<!-- <hr> -->
  <div class="container" style="margin-top: 70px;">   
      <div class="row">      
        <!-- Notif Success Update Account -->
        <?php
          if($successUpdateAccount == 1){//sukses
            echo "<div class='alert alert-success alert-dismissible fade in' style='text-align: center;'>";
            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
            echo "<strong>".$messageUpdateAccount."</strong>";
            echo "</div>";
          }else if($successUpdateAccount == 2){//danger
            echo "<div class='alert alert-danger alert-dismissible fade in' style='text-align: center;'>";
            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
            echo "<strong>".$messageUpdateAccount."</strong>";
            echo "</div>";
          }else if($successUpdateAccount == 3){//warning
            echo "<div class='alert alert-warning alert-dismissible fade in' style='text-align: center;'>";
            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
            echo "<strong>".$messageUpdateAccount."</strong>";
            echo "</div>";
          }
        ?>
      </div>
    </div>
  <!-- Start Body -->
  <div class="container bootstrap snippet" style="margin-bottom: 20px; padding-bottom: 10px; padding-top: 5px; background: #f2f2f2; border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px; color: #2d2c41">
    <div class="row">
    </div>

    <div class="row" style="color: #2d2c41">
  		<div class="col-sm-3"><!--left col-->
      <div class="text-center">
        <img id="thumbnailAccount" name="thumbnailAccount" class="avatar img-circle img-thumbnail img-responsive" alt="avatar" style="color: #2d2c41; display: block; width: 100%; min-height: 240px; margin: auto;" src="../../assets/img/users/<?php
              if($path === null){
                echo "gender/".$gender.".jpg";
              }else{
                echo "upload/".$path;
              }
            ?>">

        <h6>Upload Your Photo [1:1]</h6>
        <!-- <input type="file" class="text-center center-block file-upload" style="color: #2d2c41"> -->
        <form>
          <input type="file" accept="image/jpeg, image/png"/>
        </form>
      </div>
      <hr><br>               
          <div class="panel panel-default">
            <div class="panel-heading" style="color: #2d2c41"><i class="fa fa-clipboard"></i> Registered Events</div>
            <?php if($ttsActivities == 1){ echo "<div class='panel-body' style='margin-bottom: -15px'>TTS Games</div>";}?>
            <?php if($cariKataActivities == 1){ echo "<div class='panel-body' style='margin-bottom: -15px'>Cari Kata Games</div>";}?>
            <?php if($offlineEventsName !== null){ echo "<div class='panel-body' style='margin-bottom: -15px'>".$offlineEventsName."</div>";}?>
            <?php if($retretActivities == 1){ echo "<div class='panel-body' style='margin-bottom: -15px'>Retret</div>";}?>
            <div style='margin-bottom: 15px'></div>
          </div>
          
          <ul class="list-group">
            <li class="list-group-item"><i class="fa fa-trophy"></i> High Score</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>TTS</strong></span> <?php if($highScoreTTS !== null){ echo $highScoreTTS;}else{echo "0";}?></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Cari Kata</strong></span> <?php if($highScoreCariKata !== null){ echo $highScoreTTS;}else{echo "0";}?></li>
          </ul> 
               
          <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-share-alt"></i> Social Media</div>
            <div class="panel-body">
              <?php
            	   if(count($medSosName) == 0){
                    echo "Please Register Your Social Media";
                 }else{
                    for($x=0;$x<count($medSosName);$x++){
                        if($medSosName[$x] == 'Facebook'){$facebookLink = $medSosId[$x]; echo "<a href='".$medSosId[$x]."'><i class='fa fa-facebook-square fa-2x'></i></a>"." ";}
                        else if($medSosName[$x] == 'Instagram'){$instagramLink = $medSosId[$x]; echo "<a href='".$medSosId[$x]."'><i class='fa fa-instagram fa-2x'></i></a>"." ";}
                        else if($medSosName[$x] == 'LinkedIn'){ $linkedInLink = $medSosId[$x]; echo "<a href='".$medSosId[$x]."'><i class='fa fa-linkedin-square fa-2x'></i></a>"." ";}
                        else if($medSosName[$x] == 'Steam'){ $steamLink = $medSosId[$x]; echo "<a href='".$medSosId[$x]."'><i class='fa fa-steam fa-2x'></i>"." ";}
                        else if($medSosName[$x] == 'Twitter'){ $twitterLink = $medSosId[$x]; echo "<a href='".$medSosId[$x]."'><i class='fa fa-twitter-square fa-2x'></i></a>"." ";}
                        else if($medSosName[$x] == 'Quora'){ $quoraLink = $medSosId[$x]; echo "<a href='".$medSosId[$x]."'><i class='fa fa-quora fa-2x'></i>"." ";}
                        else if($medSosName[$x] == 'Youtube'){ $youtubeLink = $medSosId[$x]; echo "<a href='".$medSosId[$x]."'><i class='fa fa-youtube-square fa-2x'></i></a>"." ";}
                    }
                 }              
              ?>
            </div>
          </div>          
      </div><!--/col-3-->

    	<div class="col-sm-9" style="color: #2d2c41">
        
          <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#about">About</a></li>
              <li><a data-toggle="tab" href="#events">Events</a></li>
              <li><a data-toggle="tab" href="#socialMedia">Social Media</a></li>
          </ul>

          <div class="tab-content">
            <!-- Home -->
            <div class="tab-pane active" id="about">
                  <form id="updateAbout" name="updateAbout" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" method="post" action="../../services/users/prosesUpdateAbout.php">
                      <div class="form-group">                          
                          <div class="col-xs-12">
                              <label for="fullName" class="control-label"><h4><i class="fa fa-user" aria-hidden="true"></i> Full Name</h4></label>
                              <input readonly class="form-control" placeholder="<?php echo $fullName?>" style="font-weight: bold;">
                              <input type="text" class="form-control" name="fullNameUpd" id="fullNameUpd" placeholder="Update your Full Name" title="Update Here If You Wanna Change.">
                          </div>
                      </div>
          
                      <div class="form-group">                          
                          <div class="col-xs-12">
                              <label for="phone" class="control-label"><h4><i class="fa fa-mobile-phone" aria-hidden="true" style="font-size:20px"></i> Phone</h4></label>
                              <input readonly class="form-control" placeholder="<?php echo $phone?>" style="font-weight: bold;">
                              <div class="input-group">
                                <span class="input-group-addon">+62</span>
                                <input type="text" class="form-control" name="phoneUpd" id="phoneUpd"  placeholder="Update your Mobile Phone Number" data-bv-integer="true" data-bv-integer-message="Wrong Number" title="Update Here If You Wanna Change."/>
                              </div>  
                              <div id="phHintUpd" class="text-danger"></div>
                          </div>
                      </div>

                      <div class="form-group">                          
                          <div class="col-xs-12">
                              	<label for="maritalStatus" class="control-label"><h4><i class="fa fa-check" aria-hidden="true"></i> Marital Status</h4></label>
                              	<input readonly class="form-control" placeholder="<?php echo $maritalStatus?>" style="font-weight: bold;">
                              	<div class="input-group" style="width: 100%;">				
									<select class="form-control" name="maritalStatusUpd" id="maritalStatusUpd" title="Update Here If You Wanna Change.">
										<option disabled selected value> -- Update your Status -- </option>
									  	<option>Single</option>
									  	<option>Married</option>
									</select>
								</div>
                          </div>
                      </div>
                       
  					<div class="form-group">                          
                      	<div class="col-xs-12">
                          	<label for="wijk" class="control-label"><h4><i class="fa fa-users" aria-hidden="true"></i> Wijk</h4></label>
                          	<input readonly class="form-control" placeholder="<?php echo $usersDetailWijk?>" style="font-weight: bold;">
							<div class="input-group" style="width: 100%;">
								<select class="form-control" name="wijkUpd" id="wijkUpd">
									<option disabled selected value> -- Update your Wijk -- </option>
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
                      	<div class="col-xs-12">
                          	<label for="address" class="control-label"><h4><i class="fa fa-home" aria-hidden="true" style="font-size:20px"></i> Address</h4></label>
                          	<textarea rows="2" readonly class="form-control" style="font-weight: bold;" placeholder="<?php echo $address?>"></textarea>
							<div class="input-group" style="width: 100%;">
								<textarea rows="2" class="form-control" name="addressUpd" id="addressUpd" placeholder="Update your Address">
								</textarea>
							</div>
                      	</div>
                  	</div>

                  	<div class="form-group">                          
                      	<div class="col-xs-12">
                          	<label for="email" class="control-label"><h4><i class="fa fa-envelope" aria-hidden="true"></i> Email</h4></label>
                          	<input readonly class="form-control" placeholder="<?php echo $email?>" style="font-weight: bold;">
							<div class="input-group" style="width: 100%;">
								<input type="email" class="form-control" id="emailUpd" name="emailUpd" placeholder="Update your Email"/>
							</div>
                      	</div>
                  	</div>

                  	<div class="form-group">                          
                      	<div class="col-xs-12">
                          	<label for="hobbies" class="control-label"><h4><i class="fa fa-futbol-o" aria-hidden="true"></i> Hobbies</h4></label>
                            <?php $hobbyPlaceholder = null; 
                                foreach ($hobbiesAccount as $hobbyAc){
                                  $hobbyPlaceholder .= $hobbyAc.", ";
                                }
                                $hobbyPlaceholder = substr($hobbyPlaceholder, 0, strlen($hobbyPlaceholder)-2)
                            ?>
                          	<input readonly class="form-control" placeholder="<?php echo $hobbyPlaceholder?>" style="font-weight: bold;">
							<div class="input-group" style="width: 100%;">
								<select class="selectpicker form-control" name="hobbiesUpd" id="hobbiesUpd" multiple data-max-options="2" data-validation="required">
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
							<input type="hidden" name="hidden_hobbiesUpd" id="hidden_hobbiesUpd" />
    						<div id="hobHintUpd" class="text-danger"></div>	
                      	</div>
                  	</div>

                  	<div class="form-group">                          
                      	<div class="col-xs-12">
                          	<label for="username" class="control-label"><h4><i class="fa fa-user-circle-o" aria-hidden="true"></i> Username</h4></label>
                          	<input readonly class="form-control" placeholder="<?php echo $usernameLogin?>" style="font-weight: bold;">
							<div class="input-group" style="width: 100%;">
								<input type="text" class="form-control" id="usernameUpd" name="usernameUpd" placeholder="Update your Username"/>
							</div>
							<div id="usHintUpd" class="text-danger"></div>
                      	</div>
                  	</div>

                  	<div class="form-group">                          
                      	<div class="col-xs-12">
                          	<label for="newPassword" class="control-label"><h4><i class="fa fa-lock" aria-hidden="true"></i> New Password</h4></label>
							<div class="input-group" style="width: 100%;">
								<input type="password" class="form-control" minlength=6 name="newPasswordUpd" id="newPasswordUpd" placeholder="Enter your New Password" data-bv-identical="true" data-bv-identical-field="confirmNewPasswordUpd" data-bv-identical-message="The new password and its confirm are not the same"/>
							</div>
                      	</div>
                  	</div>

                  	<div class="form-group">                          
                      	<div class="col-xs-12">
                          	<label for="newPasswordConfirm" class="control-label"><h4><i class="fa fa-lock" aria-hidden="true"></i> Confirm New Password</h4></label>
							<div class="input-group" style="width: 100%;">
								<input type="password" class="form-control" minlength=6 name="confirmNewPasswordUpd" id="confirmNewPasswordUpd" placeholder="Confirm your New Password" data-bv-identical="true" data-bv-identical-field="newPasswordUpd" data-bv-identical-message="The new password and its confirm are not the same"/>
							</div>
							<div class="help-block with-errors"></div>
                      	</div>
                  	</div>

                  	<div class="form-group">
                       	<div class="col-xs-12" align="right">
                            <br>
                          	<button class="btn btn-lg btn-primary" type="submit" name="buttonUpdateAbout" id="buttonUpdateAbout"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>
                           	<!-- <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button> -->
                        </div>
                  	</div>
              	</form>              
              <hr>              
            </div> <!--/tab-pane -->

            <!-- Menu 1 -->
            <div class="tab-pane" id="events">
                <form id="updateEvents" name="updateEvents" class="form-horizontal" method="post" action="../../services/users/prosesUpdateEvents.php" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">

                      <div class="form-group">                          
                          <div class="col-xs-12">
                              <label for="updateTeamName" class="control-label"><h4><i class="fa fa-group" aria-hidden="true"></i> Team Name</h4></label>
                              <input readonly class="form-control" placeholder="<?php echo $offlineEventsTeamName?>" style="font-weight: bold;">
                              <input type="text" class="form-control" name="updateTeamName" id="updateTeamName" placeholder="Update your Team Name" title="Update Here If You Wanna Change.">
                          </div>
                      </div>
          
                      <div class="form-group">                          
                          <div class="col-xs-12">
                              <label for="updateTeamPassword" class="control-label"><h4><i class="fa fa-group" aria-hidden="true"></i> Team Password</h4></label>
                              <input readonly class="form-control" placeholder="<?php echo $offlineEventsTeamPassword?>" style="font-weight: bold;">
                              <input type="text" class="form-control" name="updateTeamPassword" id="updateTeamPassword" placeholder="Update your Team Password" title="Update Here If You Wanna Change.">
                          </div>
                      </div>

                      <div class="form-group">                          
                          <div class="col-xs-12">
                              <label for="Team Member" class="control-label"><h4><i class="fa fa-group" aria-hidden="true"></i> Team Member</h4></label>
                              <div class="table-responsive">
                                <table class="table">
                                  <th>Name</th>
                                  <th>Phone</th>
                                  <?php
                                    if(count($teamMemberName)>0){
                                      for($z=0; $z<count($teamMemberName);$z++){
                                          echo "<tr>";
                                          if($teamCreated[$z] == 1){
                                            echo "<td>".$teamMemberName[$z]." "."<i class='fa fa-copyright' aria-hidden='true'></i></td>";
                                          }else{
                                            echo "<td>".$teamMemberName[$z]."</td>";                                            
                                          }
                                            echo "<td>".$teamMemberPhone[$z]."</td>";

                                          echo "</tr>";
                                      }
                                    }else{
                                      echo "<tr>";
                                        echo "<td colspan='2' style='text-align:center; font-weight:bold'>"."You Are In Solo Mode/Not Registered Events"."</td>";
                                      echo "</tr>";
                                    }
                                  ?>
                                </table>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                        <div class="col-xs-12" align="right">
                            <br>
                            <button class="btn btn-lg btn-danger" type="submit" value="delete" name="buttonDeleteEvents" id="buttonDeleteEvents"><i class="glyphicon glyphicon-remove"></i> Delete</button>
                            <button class="btn btn-lg btn-primary" type="submit" value="update" name="buttonUpdateEvents" id="buttonUpdateEvents"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>
                        </div>
                    </div>                      
                </form> 
                <hr>                       
            </div><!--/tab-pane
            
            <!-- Menu 2 -->
              <div class="tab-pane" id="socialMedia">   
                <form id="updateSocialMedia" name="updateSocialMedia" class="form-horizontal" method="post" action="../../services/users/prosesUpdateSocialMedia.php" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">

                    <div class="form-group">                          
                        <div class="col-xs-12">
                            <label for="facebook" class="control-label"><h4><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</h4></label>
                            <input readonly class="form-control" placeholder="<?php 
                            if($facebookLink !== null){
                              echo $facebookLink;
                            }else{
                              echo 'https://www.facebook.com/your.id';
                            }?>" style="font-weight: bold;">
                            <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Update your Facebook link" title="Update Here If You Wanna Change.">
                        </div>
                    </div>

                    <div class="form-group">                          
                        <div class="col-xs-12">
                            <label for="instagram" class="control-label"><h4><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</h4></label>
                            <input readonly class="form-control" placeholder="<?php 
                            if($instagramLink !== null){
                              echo $instagramLink;
                            }else{
                              echo 'https://www.instagram.com/your.id';
                            }?>" style="font-weight: bold;">
                            <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Update your Instagram link" title="Update Here If You Wanna Change.">
                        </div>
                    </div>

                    <div class="form-group">                          
                        <div class="col-xs-12">
                            <label for="linkedin" class="control-label"><h4><i class="fa fa-linkedin-square" aria-hidden="true"></i> LinkedIn</h4></label>
                            <input readonly class="form-control" placeholder="<?php 
                            if($linkedInLink !== null){
                              echo $linkedInLink;
                            }else{
                              echo 'https://www.linkedin.com/in/your-id';
                            }?>" style="font-weight: bold;">
                            <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="Update your LinkedIn link" title="Update Here If You Wanna Change.">
                        </div>
                    </div>

                    <div class="form-group">                          
                        <div class="col-xs-12">
                            <label for="steam" class="control-label"><h4><i class="fa fa-steam" aria-hidden="true"></i> Steam</h4></label>
                            <input readonly class="form-control" placeholder="<?php 
                            if($steamLink !== null){
                              echo $steamLink;
                            }else{
                              echo 'https://steamcommunity.com/profiles/yourid';
                            }?>" style="font-weight: bold;">
                            <input type="text" class="form-control" name="steam" id="steam" placeholder="Update your Steam link" title="Update Here If You Wanna Change.">
                        </div>
                    </div>

                    <div class="form-group">                          
                        <div class="col-xs-12">
                            <label for="twitter" class="control-label"><h4><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</h4></label>
                            <input readonly class="form-control" placeholder="<?php 
                            if($twitterLink !== null){
                              echo $twitterLink;
                            }else{
                              echo 'https://twitter.com/your_id';
                            }?>" style="font-weight: bold;">
                            <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Update your Twitter link" title="Update Here If You Wanna Change.">
                        </div>
                    </div>

                    <div class="form-group">                          
                        <div class="col-xs-12">
                            <label for="quora" class="control-label"><h4><i class="fa fa-quora" aria-hidden="true"></i> Quora</h4></label>
                            <input readonly class="form-control" placeholder="<?php 
                            if($quoraLink !== null){
                              echo $quoraLink;
                            }else{
                              echo 'https://id.quora.com/profile/your-id';
                            }?>" style="font-weight: bold;">
                            <input type="text" class="form-control" name="quora" id="quora" placeholder="Update your Quora link" title="Update Here If You Wanna Change.">
                        </div>
                    </div>

                    <div class="form-group">                          
                        <div class="col-xs-12">
                            <label for="youtube" class="control-label"><h4><i class="fa fa-youtube-square" aria-hidden="true"></i> Youtube</h4></label>
                            <input readonly class="form-control" placeholder="<?php 
                            if($youtubeLink !== null){
                              echo $youtubeLink;
                            }else{
                              echo 'https://www.youtube.com/user/your.id';
                            }?>" style="font-weight: bold;">
                            <input type="text" class="form-control" name="youtube" id="youtube" placeholder="Update your Youtube link" title="Update Here If You Wanna Change.">
                        </div>
                    </div>                    

                    <div class="form-group">
                         <div class="col-xs-12" align="right">
                              <br>
                            	<button class="btn btn-lg btn-primary" type="submit" name="buttonUpdateSocialMedia" id="buttonUpdateSocialMedia"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>
                          </div>
                    </div>
              	</form>   
                <hr>             
              </div><!-- tab-pane -->

          </div><!--/tab-content-->

      </div><!--/col-9-->
    </div><!--/row-->
    <!-- End Account Page --> 
  </div>   
    <!-- End Body -->

        <script>
          $(document).ready(function() {
              $('#updateAbout').bootstrapValidator();
          });
        </script>
        
        <!-- <script src="../assets/js/index-account.js"></script> -->
        <script src="../../assets/js/canvas-to-blob.min.js"></script>
        <script src="../../assets/js/resizeImage.js"></script>
        <script src="../../assets/js/bootstrap.min.js"></script>
    </body>
    <!-- Restart Message Update -->
    <?php
        $_SESSION['successUpdateAccount'] = 0;
        $_SESSION['messageUpdateAccount'] = null;
    ?>
</html>