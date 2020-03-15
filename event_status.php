<?php session_start(); 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    $authorized = user_authorized($_SESSION['username']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Project 691 - Event Status</title>
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
            <?php
            if( isset($_SESSION["username"]) ){
                echo '<div class="col text-right">';
                echo ' <div class="dropdown" style="background-color:red;">';
                echo '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="background-color:red;">' . $_SESSION['username'];
                echo '<span class="caret" style="background-color:red;""></span></button>';
                echo '<ul class="dropdown-menu" style="background-color:red;">';
                echo '<li><a id="change_password" href="#" style="color:white;">Change Password</a></li>';
                echo '<li><a id="logout" href="#" style="color:white;">Logout</a></li>';
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            }
            else {
                echo "<div class='col text-right'><input type='button' onClick='location.href = \"login.php\";' value='Login' /></div>";
            }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="row centered-form">
            <div class="col-md-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <div class="row">
                            <div class="col text-left">
                                <h3 class="panel-title">Event Status</h3>
                            </div>
                            
                            <?php
                            if( $authorized ){
                                echo '<div class="col text-right">';
                                echo '<input type="button" id="create_event" value="Create Event" class="btn btn-primary" style="background-color:red;" />';
                                echo '</div>';
                            }
                            ?>
                            <div class="col text-right"><input type='button' class="btn btn-primary" style="background-color:red;" onClick='window.history.back();' value='Back' /></div>
                        </div>
                        <div class="row">
                        &nbsp;
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
                            
                            echo "<div class='row'><div class='col'><h4>Volunteer Signups</h4></div></div>";
                            ?>
                            <div class='border border-dark'>
                            <h5>
                            <div class="row">
                                <div class="col-2">
                                    <h4><b><u>Available</u></b>
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
                                    <h4><b><u>Volunteers</u></b>
                                </div>
                            </div>
                            <?php
                                $res = get_signups($_POST['event_id']);
                                while ($row = mysqli_fetch_array($res))
                                {
                                    error_log(implode(", ", array_keys($row)));
                                    error_log(implode(", ", $row));
                                    echo "<form action='volunteer_list.php' id='event_form" . $idx . "' role='form' method='post'>";
                                    echo "<input type='hidden' name='signup_id' value='" . $row["id"] . "' />";
                                    echo "<div class='row'>";
                                    echo "<div class='col-2'>" . $row['available'] . "</div>";
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
                                    echo "<div class='col-2'><input type='submit' value='Volunteers' /></div>";
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
<script type="text/javascript">
    document.getElementById("create_event").onclick = function () {
        location.href = "login.php";
    };
    document.getElementById("change_password").onclick = function(){
        location.href = "change_password.php";
    };
    document.getElementById("logout").onclick = function () {
        location.href = "logout.php";
    };
  </script>
</html>