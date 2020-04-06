<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<style>

</style>
<head>
    <title>Project 691 - Create Event</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script> 
        var signup_cnt = 1; 
        $(document).ready(function(){
            
            $("#add_signup").click(function(){
                if( signup_cnt > 100 ){
                    alert("A maximum of 100 signups are permitted per event");
                    return;
                }
            
                var append_str = '<tr>';
                append_str += '<td><input type="text" id="signup' + signup_cnt + '_nbr_people" name="signup' + signup_cnt + '_nbr_people" size="2" maxlength="2"></td>';
                append_str += '<td><input type="text" id="signup' + signup_cnt + '_description" name="signup' + signup_cnt + '_description"  size="50" maxlength="200"></td>';
                append_str += '<td>';
                append_str +=   '<table>';
                append_str +=       '<tr>';
                append_str +=           '<td><div class="input-group date" data-provide="datepicker">';
                append_str +=               '<input type="text" id="signup' + signup_cnt + '_start_date" name="signup' + signup_cnt + '_start_date" placeholder="Start Date" />';
                append_str +=               '<div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div></div></td>';
                append_str +=       '</tr>';
                append_str +=   '</table>';
                append_str += '</td>';
                append_str += '<td>';
                append_str +=   '<table>';
                append_str +=       '<tr>';
                append_str +=               '<td><input type="text" id="signup' + signup_cnt + '_start_hour" name="signup' + signup_cnt + '_start_hour" size="2" maxlength="2" /></td>';
                append_str +=               '<td><input type="text" id="signup' + signup_cnt + '_start_min" name="signup' + signup_cnt + '_start_min" size="2" maxlength="2" /></td>';
                append_str +=               '<td><select id="signup' + signup_cnt + '_start_ampm" name="signup' + signup_cnt + '_start_ampm" form="event_form"><option value="am">AM</option><option value="pm">PM</option></select></td>';
                append_str +=       '</tr>';
                append_str +=   '</table>';
                append_str += '</td>';
                append_str += '<td>';
                append_str +=   '<table>';
                append_str +=       '<tr>';
                append_str +=           '<td><input type="text" id="signup' + signup_cnt + '_stop_hour" name="signup' + signup_cnt + '_stop_hour" size="2" maxlength="2" /></td>';
                append_str +=           '<td><input type="text" id="signup' + signup_cnt + '_stop_min" name="signup' + signup_cnt + '_stop_min" size="2" maxlength="2" /></td>';
                append_str +=           '<td><select id="signup' + signup_cnt + '_stop_ampm" name="signup' + signup_cnt + '_stop_ampm" form="event_form"><option value="am">AM</option><option value="pm">PM</option></select></td>';
                append_str +=       '</tr>';
                append_str +=   '</table>';
                append_str += '</td>';
                append_str += '<td><input type="text" id="signup' + signup_cnt + '_reminder" name="signup' + signup_cnt + '_reminder" size="2" maxlength="2"></td>';
                append_str += '<td><input type="image" src="cancel.png" alt="Delete" width="32" height="32" onClick="del_signup(' + signup_cnt + '); return false;" ></td>';
                append_str += '</tr>';
                $('#signups_table').append( append_str );
                
                signup_cnt += 1;
            });

        });
        
        function del_signup( index ){
            document.getElementById("signups_table").deleteRow(index);
        }
    </script>
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
        		<div class="panel-heading">
                    <div class="row">
                        <div class="col">
                            <h3 class="panel-title">Create Event</h3>
                        </div>
                        <div class="col text-right"><input type='button' class="btn btn-primary" style="background-color:red;" onClick='window.history.back();' value='Back' /></div>
                    </div>
                 </div>
                 
                <div class="panel-body">
                    <form action="create_event_process.php" id="event_form" role="form" method="post">
                        <div class="row">
                        <div class="col-2">
                                <div class="form-group">
                                    <H4>Event Name</H4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="event_name" id="event_name" class="form-control input-sm" placeholder="Event Name" maxlength="100">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <H4>Event Location</H4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="event_location" id="event_location" class="form-control input-sm" placeholder="Location" maxlength="200">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <H4>Additional Details (Optional)</H4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <textarea id="event_details" name="event_details" rows="5" cols="100" maxlength="500"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="border border-dark">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <H4>Volunteer Signups</H4>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <div class="form-group">
                                        <input type="button" id="add_signup" value="Add Signup" class="btn btn-primary" style="background-color:red;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                    <table id="signups_table" class="signups_table" width="100%">
                                            <tr>
                                                <th width="10%">Number of People</th>
                                                <th width="40%">Task</th>
                                                <th width="10%">Start Date</th>
                                                <th width="10%">From</th>
                                                <th width="10%">To</th>
                                                <th width="10%">
                                                    <a href="#" data-toggle="tooltip" title="Number of days prior to event a reminder should be sent.">Reminder</a>
                                                </th>
                                                <th width="10%">Delete</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center text-bottom">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center text-bottom">
                                <input type="submit" value="Create Event" class="btn btn-primary" style="background-color:red;">
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