<?php session_start(); ?>

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
                </a><h3 class="panel-title">Forgot Password</h3>
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
            
            // define variables and set to empty values
            $email = $password = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = test_input($_POST["email"]);
                
                if( empty($email) ){
                    error_return("An email address is required.");
                }
                if( strlen($email) > 50 ){
                    error_return("Please use an email address which is less than 50 characters.");
                }

                check_user_exists($email, $password);
                $password = password_generate(10);
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $res = update_password($email, $hashed_password);
                if( $res < 0 ){
                    error_return("There was an error generating a new password for you.");
                }
                else {
                    error_log("Updated user " . $email . " password successfully!");
                }
                $to      = $email;
                $subject = 'Project 691 - Your password has been changed!';
                $message = '<html><body><a href="https://team691.org/">';
                $message .= '<img src="https://team691.org/wp-content/uploads/2018/08/full_logo_691.png" alt="Project 691 Robotics" id="logo" data-height-percentage="80" /></a>';
                $message .= '<br /><br /><h2>Your password for username ' . $email . ' has been changed to ' . $password . '.  Please login again with this password and change it again.</h2>';
                $message .= '</body></html>';
                
                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                
                // Create email headers
                $headers .= 'From: events@team691.org\r\n' .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);
                close_database();
                echo "<script type='text/javascript'>";
                echo "location.replace('index.php')";
                echo "</script>";
                exit;    
            }
            else {
                error_return("This page expects a POST method for incoming data.");
            }

            function password_generate($chars) 
            {
                $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz!@';
                return substr(str_shuffle($data), 0, $chars);
            }

            function check_user_exists($email){
                $res = user_exists($email);
                if( $res < 0 ){
                    error_return("No user with that email address exists in the system.");
                }    
            }

            function error_return($error_str){
                echo $error_str . "<br /><br />";
                echo "Please go <a href='login.php'>back</a> and try again.";
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