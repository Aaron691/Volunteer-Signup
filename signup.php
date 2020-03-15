<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Project 691 - Volunteer Signup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row" style="background-color:red;">
        <div style="background-color:red;" >
            <a href="https://team691.org/">
                    <img src="full_logo_691.png" alt="Project 691 Robotics" id="logo" data-height-percentage="50" />
            </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row centered-form">
        <div class="col-md-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
                    <div class="row">
                        <div class="col"><h3 class="panel-title">Volunteer</h3></div>
                        <div class="col text-right"><input type='button' class="btn btn-primary" style="background-color:red;" onClick='window.history.back();' value='Back' /></div>
                    </div>
			 	</div>
                <div class="panel-body">
                    <form action="signup_process.php" role="form" method="post">
                        <?php
                            echo "<input type='hidden' name='signup_id' id='signup_id' value='" . $_POST["signup_id"] . "' />";
                        ?>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name" maxlength='50'>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name" maxlength='50'>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email 1" maxlength='50'>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email2" id="email2" class="form-control input-sm" placeholder="Email 2" maxlength='50'>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="phone" id="phone" class="form-control input-sm" placeholder="Phone" maxlength='20'>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="nbr_volunteers" id="nbr_volunteers" class="form-control input-sm" placeholder="Number of Volunteers" maxlength='20'>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="captcha_code" size="10" maxlength="6" />
                                    <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
                                </div>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <input type="submit" value="Volunteer" class="btn btn-primary" style="background-color:red;">
                            </div>
                        </div>
                    </form>
			    </div>
	    	</div>
    	</div>
    </div>
</div>
</body>
</html>