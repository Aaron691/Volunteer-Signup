<?php 

    session_start(); 
?>

<html lang="en">
<head>
  <title>Project 691 - Register</title>
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
                </a><h3 class="panel-title">Registration</h3>
			 	
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities.php';
            check_captcha();
            
            // define variables and set to empty values
            $first_name = $last_name = $email = $gender = $comment = $website = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $first_name = clean_input($_POST["first_name"]);
                $last_name = clean_input($_POST["first_name"]);
                $email = clean_input($_POST["email"]);
                $password = clean_input($_POST["password"]); 
            

                if ( empty($first_name) || empty($last_name) ){
                    error_return("First name and last name are required fields.");
                }
                if ( strlen($first_name) > 50 || strlen($last_name) > 50 )
                {
                    error_return("First name and last name must be less than 50 characters.");
                }
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

                check_user_exists($email);
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $res = add_user($first_name, $last_name, $email, $hashed_password);
                if( $res < 0 ){
                    error_return("There was an error with the system.");
                }
                else {
                    error_log("Added user " . $email . " successfully!");
                }

                $to      = $email;
                $subject = 'Project 691 - Registration';
                $message = "
                    <html>
                      <head>
                        <title> Project 691 </title>
                      </head>
                      <body>
                        <a href='https://team691.org/'>
                        <img src='https://team691.org/wp-content/uploads/2018/08/full_logo_691.png' alt='Project 691 Robotics' id='logo' data-height-percentage='80' />
                        </a>
                        <br /><br /><h2>Thanks for registering to create events for Project 691!</h2>
                      </body>
                    </html>";
                
                send_events_email($to, $subject, $message);
                
                echo "<br /><br />Registered successfully!  ";
                echo "Please click <a href='index.php'>here</a> to return to the events page and login.";
                close_database();
                exit;    
            }
            else {
                error_return("This page expects a POST method for incoming data.");
            }

            function check_user_exists($email){
                $res = user_exists($email);
                if( $res < 0 ){
                    error_return("There was an error with the system.");
                }    
                if( $res > 0 ){
                    error_return("That email address is already registered as a user.");
                }
            }

            function check_captcha(){
                $securimage = new Securimage();
                
                if ($securimage->check($_POST['captcha_code']) == false) {
                    // the code was incorrect
                    // you should handle the error so that the form processor doesn't continue
                  
                    // or you can use the following code if there is no validation or you do not know how
                    error_return("The security code entered was incorrect.");
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