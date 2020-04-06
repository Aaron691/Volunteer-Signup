<?php session_start(); ?>

<html lang="en">
<head>
  <title>Project 691 - Add Signup</title>
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
                <h3 class="panel-title">Add Signup</h3>
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities.php';
            
            $nbr_people_str = $description = $signup_start_date = $start_hour_str = $start_min_str = "";
            $start_ampm = $stop_hour_str = $stop_min_str = $stop_ampm = $reminder_str = "";
            $start_hour = $start_min = $stop_hour = $stop_min = $nbr_people = $reminder = 0;

            $event_id= clean_input($_POST["event_id"]);
            $nbr_people_str = clean_input($_POST["nbr_people"]);
            $description = clean_input($_POST["description"]);
            $signup_start_date = clean_input($_POST["start_date"]);
            $start_hour_str = clean_input($_POST["signup_start_hour"]);
            $start_min_str = clean_input($_POST["signup_start_min"]);
            $start_ampm = clean_input($_POST["signup_start_ampm"]);
            $stop_hour_str = clean_input($_POST["signup_stop_hour"]);
            $stop_min_str = clean_input($_POST["signup_stop_min"]);
            $stop_ampm = clean_input($_POST["signup_stop_ampm"]);
            $reminder_str = clean_input($_POST["signup_reminder"]);
        
            if( empty($nbr_people_str) ){
                error_return("Signup needs to have the number of people specified.");
            }
            if( empty($description)){
                error_return("Signup needs to have the description filled out.");
            }
            if( empty($signup_start_date)){
                error_return("Signup needs the start date specified.");
            }
            if( empty($start_hour_str) || empty($start_min_str)){
                error_return("Signup needs to have the start hour and minutes filled out.");
            }
            if( empty($stop_hour_str) || empty($stop_min_str)){
                error_return("Signup needs to have the stop hour and minutes filled out.");
            }

            if( empty($start_hour_str) || empty($start_min_str) ){
                error_return("The start hour and minutes are required fields.");
            }
            if( empty($stop_hour_str) || empty($stop_min_str)){
                error_return("The stop hour and minutes are required fields.");
            }
            if( !is_numeric($nbr_people_str)){
                error_return("The specified numbrer of people must be a valid number.");
            }
            if( !is_numeric($start_hour_str) || !is_numeric($start_min_str) ){
                error_return("The start hour and minutes must be valid numbers.");
            }
            if( !is_numeric($stop_hour_str) || !is_numeric($stop_min_str) ){
                error_return("The stop hour and minutes must be valid numbers.");
            }
            if( empty($reminder_str) ){
                $reminder_str = "1";
            }
            if( !is_numeric($reminder_str) ){
                error_return("The number of days for the reminder email must be a number.");
            }
            $reminder = intval($reminder_str);
            $nbr_people = intval($nbr_people_str);
            $start_hour = intval($start_hour_str);
            $start_min = intval($start_min_str);
            $stop_hour = intval($stop_hour_str);
            $stop_min = intval($stop_min_str);

            if( $nbr_people < 0 || $nbr_people > 99 ){
                error_return("Only 99 people are allowed to be specified for any event.");
            }
            if( $start_hour > 12 || $start_hour < 1 )
            {
                error_return("The start hour in signup number " . $x . " is invalid.");
            }
            if( $start_ampm == "pm" )
            {
                $start_hour = $start_hour + 12;
            }

            if( $start_min < 0 || $start_min > 59 ){
                error_return("The start minutes in signup number " . $x . " are invalid.");
            }

            if( $stop_hour > 12 || $stop_hour < 1 )
            {
                error_return("The stop hour in signup number " . $x . " is invalid.");
            }
            if( $stop_ampm == "pm" )
            {
                $stop_hour = $stop_hour + 12;
            }

            if( $stop_min < 0 || $stop_min > 59 ){
                error_return("The stop minutes in signup number " . $x . " must be a value between 0 and 59.");
            }
            
            add_signup( $event_id, $nbr_people, $description, $start_hour, $start_min, $stop_hour, $stop_min, $signup_start_date, $reminder);
            echo "<br /><br />Added signup successfully!  ";
            echo "Please click <a href='index.php'>here</a> to return to the events page.";
            close_database();
            ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>