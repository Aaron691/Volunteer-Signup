<?php session_start(); ?>

<html lang="en">
<head>
  <title>Change Password</title>
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
                </a><h3 class="panel-title">Change Password</h3>
			 	
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
            
            // define variables and set to empty values
            $email = $password1 = $password2 = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = test_input($_POST["email"]);
                $old_password = test_input($_POST["old_password"]);
                $password1 = test_input($_POST["password1"]); 
                $password2 = test_input($_POST["password2"]); 
            
                if( empty($email) ){
                    error_return("An email address is required.");
                }
                if( strlen($email) > 50 ){
                    error_return("Please use an email address which is less than 50 characters.");
                }
                if( empty($old_password) ){
                    error_return("The old password can't be empty.");
                }
                if( empty($password1) || ($password1 != $password2) ){
                    error_return("The two passwords do not match or are empty.");
                }
                if( strlen($password1) > 25 ){
                    error_return("Please use a password of no more than 25 characters.");
                }
                
                check_password($email, $old_password);
                $hashed_password = password_hash($password1, PASSWORD_BCRYPT);
                $res = update_password($email, $hashed_password);
                if( $res < 0 ){
                    error_return("There was an error with the system.");
                }
                else {
                    error_log("Added user " . $email . " successfully!");
                }

                echo "<br /><br />Changed the password successfully!  ";
                echo "Please click <a href='index.php'>here</a> to return to the events page and login.";
                close_database();
                exit;    
            }
            else {
                error_return("This page expects a POST method for incoming data.");
            }

            function check_password($email, $password){
                $res = -1;
                error_log("Checking password");
                if( ($res = user_exists($email)) > 0 ){
                    error_log("User exists, checking that the password is correct");
                    $res = password_valid($email, $password);
                }
                else {
                    error_return("The specified user doesn't exist in the system.");
                }
                
                if( $res < 0 ){
                    error_return("There was an error with the system.");
                }   
                if( $res == 0 ){
                    error_return("The email address and old password combination you entered are not valid.");
                } 
            }

            function error_return($error_str){
                echo $error_str . "<br /><br />";
                echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
                close_database();
                exit;    
            }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            close_database();
            ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>