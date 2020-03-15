<?php session_start(); 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    $authorized = user_authorized($_SESSION['username']); 
?>
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
                                <h3 class="panel-title">Events</h3>
                            </div>
                            <?php
                            if( $authorized ){
                                echo '<div class="col text-right">';
                                echo '<input type="button" id="create_event" value="Create Event" class="btn btn-primary" style="background-color:red;" />';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div class="row">
                        &nbsp;
                        </div>    
                    </div>

                    <div class="panel-body">
                        <h5>
                        <form action="my_events.php" id="my_events_form" role="form" method="post">
                        <div class="row">
                            <div class="col">See your signed up events:</div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="email" id="email" class="form-control input-sm" placeholder="Email">
                                </div>
                            </div>
                            <div class="col">
                                <input type="submit" value="Get Events" class="btn btn-primary" style="background-color:red;">
                            </div>
                        </div>
                        </form>
                        </h5>
                    </div>
                    <div class="panel-body">
                        <h5>
                        <div class="row">
                            <div class="col-2">
                                <h4><b><u>Name</u></b>
                            </div>
                            <div class="col-4 text-left">
                                <h4><b><u>Location</u></b>
                            </div>
                            <div class="col-2">
                                &nbsp;
                            </div>
                            <div class="col-2">
                                <h4><b><u>Volunteer</u></b>
                            </div>
                            <?php
                            echo "<div class'col-2'>";
                            if( $authorized ){
                                echo "<h4><b><u>Status</u></b></h4>"; 
                            }
                            else {
                                echo "&nbsp;";
                            }
                            echo "</div>";
                            echo "</div>";
                    
                            $res = get_events();
                            $idx = 1;
                            while ($row = mysqli_fetch_array($res))
                            {
                                echo "<form action='volunteer_event.php' id='event_form" . $idx . "' role='form' method='post'>";
                                echo "<input type='hidden' name='event_id' value='" . $row["id"] . "' />";
                                echo "<div class='row'>";
                                echo "<div class='col-2'>" . $row['name'] . "</div>";
                                echo "<div class='col-4 text-left'>" . $row['location'] . "</div>";
                                echo "<div class='col-2'>&nbsp;</div>";
                                echo "<div class='col-2'><input type='submit' value='Volunteer' /></div>";
                                echo "<div class='col-2'>";
                                if( $authorized ){
                                    echo "<input type='button' onClick='show_event_status(" . $idx . ");' value='Status' />";
                                }
                                else {
                                    echo "&nbsp;";
                                }
                                echo "</div>";
                                echo "</div>";
                                echo "</form>";
                            }
                            ?>  
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

    function show_event_status( idx ){
        document.getElementById("event_form" + idx).action = "event_status.php";
        document.getElementById("event_form" + idx).submit();
    }
  </script>
</html>