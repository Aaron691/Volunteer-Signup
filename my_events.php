<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Project 691 - My Events</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="events.css">
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
                    <div class="panel-heading" >
                        <div class="row">
                            <div class="col">
                                <h3 class="panel-title">Event Volunteers</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <h5>
                        <div class="row">
                            <div class="col-2">
                                <h4><b><u>Name</u></b>
                            </div>
                            <div class="col-3">
                                <h4><b><u>Location</u></b>
                            </div>
                            <div class="col-3">
                                <h4><b><u>Description</u></b>
                            </div>
                            <div class="col-2">
                            <h4><b><u>Date</u></b>
                            </div>
                            <div class="col-1">
                                <h4><b><u>Start</u></b>
                            </div>
                            <div class="col-1">
                                <h4><b><u>Stop</u></b>
                            </div>
                        </div>
                        <?php
                            include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
                            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
                            include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities.php';
                            $email = clean_input($_POST["email"]);
                            if( strlen($email) <= 0 ){
                                error_return("Please enter a valid email address.");
                            }

                            $res = get_email_signups($email);
                            while ($row = mysqli_fetch_array($res))
                            {
                                error_log("Row: ");
                                error_log(implode(", ", array_keys($row)));
                                echo "<div class='row'>";
                                echo "<div class='col-2'>" . $row['name'] . "</div>";
                                echo "<div class='col-3'>" . $row['location'] . "</div>";
                                echo "<div class='col-3'>" . $row['description'] . "</div>";
                                echo "<div class='col-2'>" . $row['start_date'] . "</div>";
                                $start_hour = intval($row['start_hour']);
                                $start_ampm = "am";
                                if( $start_hour >= 12 )
                                {
                                    if( $start_hour > 12 ){
                                        $start_hour = $start_hour - 12;
                                    }
                                    
                                    $start_ampm = "pm";
                                }
                                $stop_hour = intval($row['stop_hour']);
                                $stop_ampm = "am";
                                if( $stop_hour >= 12 )
                                {
                                    if( $stop_hour > 12 ){
                                        $stop_hour = $stop_hour - 12;
                                    }
                                    
                                    $stop_ampm = "pm";
                                }
                                echo "<div class='col-1'>" . $start_hour . ":" . sprintf("%02s",$row["start_min"]) . "&nbsp;" . $start_ampm . "</div>";
                                echo "<div class='col-1'>" . $stop_hour . ":" . sprintf("%02s", $row["stop_min"]) . "&nbsp;" . $stop_ampm . "</div>";
                                echo "</div>";
                            }
                        ?>
                        </div> 
                        </h5>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>