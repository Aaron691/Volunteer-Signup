<?php session_start(); ?>

<html lang="en">
<head>
  <title>Project 691 - Login</title>
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
                </a><h3 class="panel-title">Login</h3>
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities.php';
            
            // define variables and set to empty values
            $email = $password = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = clean_input($_POST["email"]);
                $password = clean_input($_POST["password"]); 
            

                if( empty($email) ){
                    error_return("An email address is required.");
                }
                if( strlen($email) > 50 ){
                    error_return("Please use an email address which is less than 50 characters.");
                }
                if( empty($password) ){
                    error_return("A password is required.");
                }
                if( strlen($password) > 25 ){
                    error_return("Please use a password of no more than 25 characters.");
                }

                check_password($email, $password);
                error_log("User validated");
                $_SESSION["username"] = $email;
                $_SESSION["timeout"] = time();
                
                close_database();
                echo "<script type='text/javascript'>";
                echo "location.replace('index.php')";
                echo "</script>";
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
                    error_return("The email address and password combination you entered are not valid.");
                } 
            }

            close_database();
            ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>