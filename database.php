<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
$servername = "localhost";
$db_username = "event_app";
$db_password = "0HM5XbzE5mHUmILI";
$dbname = "event";

// Create connection
$conn = new mysqli(get_db_servername(), get_db_username(), get_db_password(), get_db_name());

function user_exists( $email ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        $sql = "SELECT * FROM users where email = '" . $email . "'";
        $result = $conn->query($sql);
        $ret_val = $result->num_rows;
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;
}

function password_valid( $email, $password ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        $sql = "SELECT * FROM users where email = '" . $email . "'";
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            if( password_verify($password, $row["password"]) ){
                $ret_val = 1;
            }
        }
        else {
            $ret_val = 0;
        }
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;
}

function user_authorized( $email ){
    $ret_val = FALSE;
    
    global $conn;
    if( check_db_connection() ){
        $sql = "SELECT * FROM users where email = '" . $email . "'";
        $result = $conn->query($sql);
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            if( $row["role"] == "1" ){
                $ret_val = true;
                error_log("User " . $email . " is authorized!");
            }
            else {
                error_log("User " . $email . " is NOT authorized!");
            }
        }
        else {
            error_log("No rows returned for user " . $email . " when trying to validate authorization!");
        }
    } else {
        error_log("Database connection failed");
    }
    
    return $ret_val;
}

function add_user( $first_name, $last_name, $email, $password ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        $sql = sprintf("insert into users (first_name, last_name, email, password, role) values ('%s', '%s', '%s', '%s', 0)", 
            $first_name, $last_name, $email, $password);
        $result = $conn->query($sql);
        error_log("Result = " . $result);
        if( $result ){
            error_log("Success inserting user");
            $ret_val = 0;
        }
        else {
            error_log("Error inserting user");
            error_log($sql);
            error_log($conn->error);
        }
    } else {
        error_log("Database connection failed adding user");
    }
    
    return $ret_val;
}

function update_password( $email, $password ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        $sql = sprintf("update users set password = '%s' where email = '%s'", $password, $email);
        $result = $conn->query($sql);
        error_log("Result = " . $result);
        if( $result ){
            error_log("Success updating password.");
            $ret_val = 0;
        }
        else {
            error_log("Error updating password");
            error_log($sql);
            error_log($conn->error);
        }
    } else {
        error_log("Database connection failed updating password");
    }
    
    return $ret_val;
}

function event_exists( $name, $location, $date ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        $sql = "SELECT * FROM events where name = '" . $name . "' and location = '" . $location . "' and date = '" . $date . "'";
        $result = $conn->query($sql);
        $ret_val = $result->num_rows;
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;
}

function get_event_id( $name, $location, $date ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        error_log("Selecting event with name " . $name . ", location " . $location . ", and date " . $date);
        $sql = "SELECT * FROM events where name = '" . $name . "' and location = '" . $location . "' and date = STR_TO_DATE('" . $date . "', '%m/%d/%Y')";
        $result = $conn->query($sql);
        error_log("Selected " . $result->num_rows . " rows from events");
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $ret_val = $row["id"];
        }
        else {
            error_log("Did not find any events");
            $ret_val = 0;
        }
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;
}

function get_events(){
    $ret_val = null;
    global $conn;
    if( check_db_connection() ){
        error_log("Selecting * from events");
        $sql = "select * from events where id in (select event_id from signups where start_date >= curdate())";
        $result = $conn->query($sql);
        error_log("Selected " . $result->num_rows . " rows from events");
        $ret_val = $result;
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;    
}

function get_event( $event_id ){
    $ret_val = null;
    global $conn;
    if( check_db_connection() ){
        $sql = "SELECT * FROM events where id = '" . $event_id . "'";
        $result = $conn->query($sql);
        error_log("Selected " . $result->num_rows . " rows from events");
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $ret_val = $row;
        }
        else {
            error_log("Did not find any events");
        }
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;
}

function add_event( $event_name, $event_location, $event_date, $event_details, $start_hour, $start_min, $stop_hour, $stop_min ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        error_log("Inserting into events");
        $sql = sprintf("insert into events (name, location, date, start_hour, start_min, stop_hour, stop_min, details) values ('%s', '%s', STR_TO_DATE('%s', '%%m/%%d/%%Y'), '%s', '%s', '%s', '%s', '%s')", 
            $event_name, $event_location, $event_date, $start_hour, $start_min, $stop_hour, $stop_min, $event_details);
        $result = $conn->query($sql);
        error_log("Result = " . $result);
        if( $result ){
            error_log("Success inserting event");
            $ret_val = 0;
        }
        else {
            error_log("Error inserting event");
            error_log($sql);
            error_log($conn->error);
        }
    } else {
        error_log("Database connection failed adding event");
    }
    
    return $ret_val;
}

function add_signup( $event_id, $nbr_people, $description, $start_hour, $start_min, $stop_hour, $stop_min, $start_date, $reminder ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        error_log("Inserting into signups");
        $sql = sprintf("insert into signups (event_id, nbr_people, description, start_hour, start_min, stop_hour, stop_min, start_date, reminder) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', STR_TO_DATE('%s', '%%m/%%d/%%Y'), '%s')", 
            $event_id, $nbr_people, $description, $start_hour, $start_min, $stop_hour, $stop_min, $start_date, $reminder);
        $result = $conn->query($sql);
        error_log("Result = " . $result);
        if( $result ){
            error_log("Success inserting signup");
            $ret_val = 0;
        }
        else {
            error_log("Error inserting signup");
            error_log($sql);
            error_log($conn->error);
        }
    } else {
        error_log("Database connection failed adding signup");
    }
    
    return $ret_val;
}

function get_signups($event_id){
    $ret_val = null;
    global $conn;
    if( check_db_connection() ){
        error_log("Selecting * from signups");
        $sql = "select signups.id, signups.description, signups.start_date, signups.start_hour, signups.start_min, signups.stop_hour, signups.stop_min, ";
        $sql .= "(signups.nbr_people - COALESCE(A.available, 0)) as available ";
        $sql .= "from signups left join (select sum(nbr_volunteers) as available, signup_id from volunteers group by signup_id) A ";
        $sql .= "on signups.id = A.signup_id where signups.event_id = " . $event_id;
        $result = $conn->query($sql);
        error_log("Selected " . $result->num_rows . " rows from signups");
        $ret_val = $result;
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;    
}

function get_signup($signup_id){
    $ret_val = null;
    global $conn;
    if( check_db_connection() ){
        error_log("Selecting * from signups");
        $sql = "select signups.id, signups.description, signups.start_date, signups.start_hour, signups.start_min, signups.stop_hour, signups.stop_min, signups.nbr_people, ";
        $sql .= "(signups.nbr_people - COALESCE(A.available, 0)) as available ";
        $sql .= "from signups left join (select sum(nbr_volunteers) as available, signup_id from volunteers group by signup_id) A ";
        $sql .= "on signups.id = A.signup_id where signups.id = " . $signup_id;
        $result = $conn->query($sql);
        error_log("Selected " . $result->num_rows . " rows from signups");
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $ret_val = $row;
        }
        else {
            error_log("Did not find the signup " . $signup_id . ".");
        }
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;    
}

function get_volunteers($signup_id){
    $ret_val = null;
    global $conn;
    if( check_db_connection() ){
        error_log("Selecting * from volunteers where signup_id = " . $signup_id);
        $sql = "select * from volunteers where signup_id = " . $signup_id;
        $result = $conn->query($sql);
        error_log("Selected " . $result->num_rows . " rows from volunteers");
        $ret_val = $result;
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;    
}

function get_volunteer_count( $signup_id ){
    $ret_val = 0;
    global $conn;
    if( check_db_connection() ){
        error_log("Selecting volunteer count for signup " . $signup_id);
        $sql = "SELECT sum(nbr_volunteers) as cnt FROM volunteer where signup_id = '" . $signup_id . "'";
        $result = $conn->query($sql);
        error_log("Selected " . $result->num_rows . " rows from volunteers");
        if( $result->num_rows > 0 ){
            $row = $result->fetch_assoc();
            $ret_val = $row["cnt"];
        }
        else {
            error_log("Did not find any volunteers");
            $ret_val = 0;
        }
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;    
}

function get_remaining_volunteers( $signup_id ){
    $ret_val = -1;
    global $conn;
    error_log("Getting volunteers for signup id " . $signup_id);
    if( check_db_connection() ){
        $total_volunteers = get_volunteer_count( $signup_id );
        error_log("Volunteer count: " . $total_volunteers);
        $total_signups = 0;
        $signup = get_signup($signup_id);
        $total_signups = intval($signup["nbr_people"]);
        error_log("Total signups: " . $total_signups);
        $ret_val = $total_signups - $total_volunteers;
        error_log("Remaining volunteers: " . $ret_val);
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;    
}

function add_volunteer( $signup_id, $first_name, $last_name, $email, $phone, $nbr_volunteers, $email2 ){
    $ret_val = -1;
    global $conn;
    if( check_db_connection() ){
        error_log("Inserting into volunteers");
        $sql = sprintf("insert into volunteers (signup_id, first_name, last_name, email, phone, nbr_volunteers, email2) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s')", 
            $signup_id, $first_name, $last_name, $email, $phone, $nbr_volunteers, $email2);
        $result = $conn->query($sql);
        error_log("Result = " . $result);
        if( $result ){
            error_log("Success inserting volunteer");
            $ret_val = 0;
        }
        else {
            error_log("Error inserting volunteer");
            error_log($sql);
            error_log($conn->error);
        }
    } else {
        error_log("Database connection failed adding volunteer");
    }
    
    return $ret_val;
}

function get_email_signups( $email ){
    $ret_val = null;
    global $conn;
    if( check_db_connection() ){
        error_log("Selecting * from signups");
        $sql = "select volunteers.signup_id, volunteers.nbr_volunteers, signups.description, signups.event_id, signups.start_date, signups.start_hour, ";
        $sql .= "signups.start_min, signups.stop_hour, signups.stop_min, events.name, events.location from volunteers, signups, events "; 
        $sql .= "where (volunteers.email = '" . $email . "' or volunteers.email2 = '" . $email . "') and volunteers.signup_id = signups.id and ";
        $sql .= "signups.start_date >= curdate() and signups.event_id = events.id";
        $result = $conn->query($sql);
        $ret_val = $result;
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;    
}

function get_next_day_signups(){
    $ret_val = null;
    global $conn;
    if( check_db_connection() ){
        $sql = "select volunteers.email, volunteers.email2, volunteers.signup_id, volunteers.nbr_volunteers, signups.description, signups.event_id, signups.start_date, ";
        $sql .= "signups.start_hour, signups.start_min, signups.stop_hour, signups.stop_min, events.name, events.location, events.id "; 
        $sql .= "from signups, volunteers, events ";
        $sql .= "where signups.start_date = (CURDATE() + INTERVAL 1 DAY) and volunteers.signup_id = signups.id and signups.event_id = events.id";
        error_log($sql);
        $result = $conn->query($sql);
        $ret_val = $result;
    } else {
        error_log("Database connection failed");
    }
    return $ret_val;    
}

function check_db_connection(){
    global $conn;
    // Check connection
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        return false;
    }
    return true;
}

function close_database(){
    global $conn;
    $conn->close();
}
?>