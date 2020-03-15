<?php session_start(); ?>

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
                </a><h3 class="panel-title">Volunteer</h3>
			 	
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities.php';

            error_log( implode(",", array_keys($_POST)));    
            error_log(implode(",", $_POST));
            check_captcha();
            
            // define variables and set to empty values
            $first_name = $last_name = $email = $phone = $nbr_volunteers_str = $signup_id = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $first_name = clean_input($_POST["first_name"]);
                $last_name = clean_input($_POST["last_name"]);
                $email = clean_input($_POST["email"]);
                $email2 = clean_input($_POST["email2"]);
                $phone = clean_input($_POST["phone"]); 
                $nbr_volunteers_str = clean_input($_POST["nbr_volunteers"]); 
                $signup_id = clean_input($_POST["signup_id"]);
            

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

                if( empty($nbr_volunteers_str) ){
                    error_return("Please enter the number of volunteers");
                }
                if( !is_numeric($nbr_volunteers_str) ){
                    error_return("The number of volunteers must be a valid numbers.");
                }

                $nbr_volunteers = intval($nbr_volunteers_str);
                $remaining_volunteers = get_remaining_volunteers($signup_id);
                if( $nbr_volunteers <= 0 || $nbr_volunteers > $remaining_volunteers ){
                    error_return("The specified number of volunteers must be between 1 and " . $remaining_volunteers);
                }

                $res = add_volunteer($signup_id, $first_name, $last_name, $email, $phone, $nbr_volunteers, $email2);
                if( $res < 0 ){
                    error_return("There was an error with the system.");
                }
                else {
                    error_log("Added volunteer " . $email . " successfully!");
                }

                $signup_info = get_signup($signup_id);
                $event_info = get_event($signup_info["event_id"]);

                $start_time = sprintf("%d:%02d %s",
                    (intval($signup_info["start_hour"]) % 12) == 0 ? 12 : (intval($signup_info["start_hour"]) % 12), 
                    $signup_info["start_min"],
                    (intval($signup_info["start_hour"]) > 11 ? "pm" : "am"));
                
                $stop_time = sprintf("%d:%02d %s",
                    (intval($signup_info["stop_hour"]) % 12) == 0 ? 12 : (intval($signup_info["stop_hour"]) % 12),
                    $signup_info["stop_min"],
                    (intval($signup_info["stop_hour"]) > 11 ? "pm" : "am"));

                $to      = $email;
                $subject = 'Project 691 - Your event - ' . $event_info["name"];
                $message = "
                            <html>
                                <head>
                                    <title> Project 691 </title>
                                </head>
                                <body>
                                    <a href='https://team691.org/'>
                                    <img src='https://team691.org/wp-content/uploads/2018/08/full_logo_691.png' alt='Project 691 Robotics' id='logo' data-height-percentage='80' />
                                    </a>
                                    <br /><br /><h2>Thank you for volunteering for \"<i>" . $signup_info["description"] . "</i>\" for event <i>\"" . $event_info["name"] . "\"</i>. 
                                    <br />Here are the event and volunteer details:
                                    <br />Event Details: " . $event_info["details"] . "
                                    <br />Event Location: " . $event_info["location"] . "
                                    <br />Volunteer Date: " . $signup_info["start_date"] . "
                                    <br />Volunteer Start Time: " . $start_time . "
                                    <br />Volunteer Stop Time: " . $stop_time . "
                                    <br /><br />Thank you for your support!
                                </body>
                            </html>";

                send_events_email($to, $subject, $message);    
                if (strlen($email2) > 1) {
                    send_events_email($email2, $subject, $message);
                }
                echo "<br /><br />Volunteered successfully!  ";
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