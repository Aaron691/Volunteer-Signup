<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Project 691 - Events</title>
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
                                <h3 class="panel-title">Event</h3>
                            </div>
                            <div class="col text-right"><input type='button' class="btn btn-primary" style="background-color:red;" onClick='window.history.back();' value='Back' /></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <h5>
                        <?php
                            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
                            error_log("Event id: " . $_POST["event_id"]);
                            $row = get_event($_POST["event_id"]);
                            echo "<div class='row'><div class='col-2'>Name:</div><div class='col'>" . $row['name'] . "</div></div>";
                            echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                            echo "<div class='row'><div class='col-2'>Location:</div><div class='col'>" . $row['location'] . "</div></div>";
                            echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                            /*
                            echo "<div class='row'><div class='col-2'>Date:</div><div class='col'>" . $row['date'] . "</div></div>";
                            echo "<div class='row'><div class='col'>&nbsp;</div></div>";
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
                            echo "<div class='row'><div class='col-2'>Start Time:</div><div class='col'>" . $start_hour . ":" . sprintf("%02s",$row["start_min"]) . "&nbsp;" . $start_ampm . "</div></div>";
                            echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                            echo "<div class='row'><div class='col-2'>Stop Time:</div><div class='col'>" . $stop_hour . ":" . sprintf("%02s", $row["stop_min"]) . "&nbsp;" . $stop_ampm . "</div></div>";
                            echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                            echo "<div class='row'><div class='col-2'>Details:</div><div class='col'><textarea rows='5' cols='100'>" . $row['details'] . "</textarea></div></div>";
                            echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                            */
                            echo "<div class='row'><div class='col'><h4>Volunteer Signups</h4></div></div>";
                            ?>
                            <div class='border border-dark'>
                            <h5>
                            <div class="row">
                                <div class="col">
                                    <h4><b><u>Spots Available</u></b>
                                </div>
                                <div class="col">
                                    <h4><b><u>Description</u></b>
                                </div>
                                <div class="col">
                                    <h4><b><u>Date</u></b>
                                </div>
                                <div class="col">
                                    <h4><b><u>Start Time</u></b>
                                </div>
                                <div class="col">
                                    <h4><b><u>Stop Time</u></b>
                                </div>
                                <div class="col">
                                    <h4><b><u>Volunteer</u></b>
                                </div>
                            </div>
                            <?php
                                $res = get_signups($_POST['event_id']);
                                while ($row = mysqli_fetch_array($res))
                                {
                                    error_log(implode(", ", array_keys($row)));
                                    error_log(implode(", ", $row));
                                    echo "<form action='signup.php' id='event_form' role='form' method='post'>";
                                    echo "<input type='hidden' name='signup_id' value='" . $row["id"] . "' />";
                                    echo "<div class='row'>";
                                    echo "<div class='col'>" . $row['available'] . "</div>";
                                    echo "<div class='col'>" . $row['description'] . "</div>";
                                    echo "<div class='col'>" . $row['start_date'] . "</div>";
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
                                    echo "<div class='col'>" . $start_hour . ":" . sprintf("%02s",$row["start_min"]) . "&nbsp;" . $start_ampm . "</div>";
                                    echo "<div class='col'>" . $stop_hour . ":" . sprintf("%02s", $row["stop_min"]) . "&nbsp;" . $stop_ampm . "</div>";
                                    if( intval($row['available']) > 0){
                                        echo "<div class='col'><input type='submit' value='Volunteer' /></div>";
                                    }
                                    else {
                                        echo "<div class='col'>Unavailable</div>";
                                    }
                                    echo "</div>";
                                    echo "</form>";
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