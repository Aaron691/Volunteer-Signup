<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<style>

</style>
<head>
    <title>Project 691 - Add Signup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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
            include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities.php';

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

            $event_id = clean_input($_POST['event_id']);
            
            ?>
    </div>
</div>
<div class="container">
    <div class="row centered-form">
        <div class="col-md-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
                    <div class="row">
                        <div class="col">
                            <h3 class="panel-title">Add Signup</h3>
                        </div>
                        <div class="col text-right"><input type='button' class="btn btn-primary" style="background-color:red;" onClick='window.history.back();' value='Back' /></div>
                    </div>
                 </div>
                 <div class="panel-body">
                    <form action="add_signup_process.php" id="add_signup_form" role="form" method="post"> 
                        <?php
                            echo "<input type='hidden' name='event_id' value='" . $event_id . "' />";
                        ?>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <H4>Nbr of People</H4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="nbr_people" id="nbr_people" class="form-control input-sm" placeholder="Nbr of People" size="2" maxlength="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <H4>Description</H4>
                                </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" name="description" id="description" class="form-control input-sm" placeholder="Description" maxlength="100">
                                    </div>
                                </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <H4>Start Date</H4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" id="start_date" name="start_date" placeholder="Start Date" />
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <H4>Start Time</H4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" id="signup_start_hour" name="signup_start_hour" size="2" maxlength="2" /></td>
                                    <input type="text" id="signup_start_min" name="signup_start_min" size="2" maxlength="2" /></td>
                                    <select id="signup_start_ampm" name="signup_start_ampm" form="add_signup_form"><option value="am">AM</option><option value="pm">PM</option></select>      
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <H4>Stop Time</H4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" id="signup_stop_hour" name="signup_stop_hour" size="2" maxlength="2" /></td>
                                    <input type="text" id="signup_stop_min" name="signup_stop_min" size="2" maxlength="2" /></td>
                                    <select id="signup_stop_ampm" name="signup_stop_ampm" form="add_signup_form"><option value="am">AM</option><option value="pm">PM</option></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <H4><a href="#" data-toggle="tooltip" title="Number of days prior to event a reminder should be sent.">Reminder</a></H4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="nbr_people" id="nbr_people" class="form-control input-sm" placeholder="Nbr of People" size="2" maxlength="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center text-bottom">
                                <input type="submit" value="Add Signup" class="btn btn-primary" style="background-color:red;">
                            </div>
                        </div>
                    </form>
			    </div>
	    	</div>
    	</div>
    </div>
</div>
</body>
<script type="text/javascript">
    document.getElementById("change_password").onclick = function(){
        location.href = "change_password.php";
    };
    document.getElementById("logout").onclick = function () {
        location.href = "logout.php";
    };
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
  </script>
</html>