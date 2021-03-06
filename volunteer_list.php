<?php session_start(); 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    $authorized = user_authorized($_SESSION['username']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Project 691 - Volunteers</title>
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
                                <h3 class="panel-title">Volunteers</h3>
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
                            
                            $row = get_signup($_POST["signup_id"]);
                            error_log(implode(", ", array_keys($row)));
                            error_log(implode(", ", $row));
                            if( $row ){
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
                                echo "<form action='signup_export.php' id='export_form" . $idx . "' role='form' method='post'>";
                                echo "<input type='hidden' name='signup_id' value='" . $_POST["signup_id"] . "' />";
                                echo "<div class='row'><div class='col-2'>Description:</div><div class='col'>" . $row['description'] . "</div>";
                                echo "<div class='col-2 align-self-end'><input type='submit' value='Export Signup' /></div>";
                                echo "</form></div>";
                                echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                                echo "<div class='row'><div class='col-2'>Spots Available:</div><div class='col'>" . $row['available'] . "</div></div>";
                                echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                                echo "<div class='row'><div class='col-2'>Start Date:</div><div class='col'>" . $row['start_date'] . "</div></div>";
                                echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                                echo "<div class='row'><div class='col-2'>Start Time:</div><div class='col'>" . $start_hour . ":" . sprintf("%02s",$row["start_min"]) . "&nbsp;" . $start_ampm . "</div></div>";
                                echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                                echo "<div class='row'><div class='col-2'>Stop Time:</div><div class='col'>" . $stop_hour . ":" . sprintf("%02s", $row["stop_min"]) . "&nbsp;" . $stop_ampm . "</div></div>";
                                echo "<div class='row'><div class='col'>&nbsp;</div></div>";
                                
                                echo "<div class='row'><div class='col'><h4>Volunteer Signups</h4></div></div>";
                            ?>
                            <div class='border border-dark'>
                            <h5>
                            <div class="row">
                                <div class="col-2">
                                    <h4><b><u>Name</u></b>
                                </div>
                                <div class="col-2">
                                    <h4><b><u>Phone</u></b>
                                </div>
                                <div class="col">
                                    <h4><b><u>Email</u></b>
                                </div>
                                <div class="col">
                                    <h4><b><u>Email 2</u></b>
                                </div>
                                <div class="col">
                                    <h4><b><u>Nbr Volunteers</u></b>
                                </div>
                            </div>
                            <?php
                                $res = get_volunteers($_POST['signup_id']);
                                while ($row = mysqli_fetch_array($res))
                                {
                                    error_log(implode(", ", array_keys($row)));
                                    error_log(implode(", ", $row));
                                    echo "<input type='hidden' name='signup_id' value='" . $row["id"] . "' />";
                                    echo "<div class='row'>";
                                    echo "<div class='col-2'>" . $row['first_name'] . " " . $row["last_name"] . "</div>";
                                    echo "<div class='col-2'>" . $row["phone"] . "</div>";
                                    echo "<div class='col'>" . $row['email'] . "</div>";
                                    echo "<div class='col'>" . $row['email2'] . "</div>";
                                    echo "<div class='col'>" . $row['nbr_volunteers'] . "</div>";
                                    
                                    echo "</div>";
                                }
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