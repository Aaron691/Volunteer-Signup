<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Project 691 - Forgot Password</title>
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
                    <h3 class="panel-title">Forgot Password</h3>
			 	</div>
                <div class="panel-body">
                    <form action="forgot_password_process.php" role="form" method="post">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="email" id="email" class="form-control input-sm" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Submit" class="btn btn-primary" style="background-color:red;">
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