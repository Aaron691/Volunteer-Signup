<?php
    session_start(); 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    $authorized = user_authorized($_SESSION['username']); 
    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=my_events_export.csv");

    print("Name, Location, Description, Date, Start Time, Stop Time\n");

    $email = clean_input($_POST["email"]);
    if( strlen($email) <= 0 ){
        error_return("Please enter a valid email address.");
    }

    $res = get_email_signups($email);
    while ($row = mysqli_fetch_array($res))
    {
        print( $row['name'] .  ", ");
        print( $row["location"] . ", ");
        print( $row['description'] . ", ");
        print( $row['start_date'] . ", ");
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
        print( $start_hour . ":" . sprintf("%02s",$row["start_min"]) . " " . $start_ampm . ", ");
        print( $stop_hour . ":" . sprintf("%02s", $row["stop_min"]) . " " . $stop_ampm . "\n");
    }
    
    print $content;
?>
