<?php
    session_start(); 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    $authorized = user_authorized($_SESSION['username']); 
    if( !authorized ){
        error_return("You must be authorized to perform this action");
    }
    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=event_export.csv");

    $event_id = clean_input($_POST["event_id"]);
    if( strlen($event_id) <= 0 ){
        error_return("Please enter a valid event id.");
    }

    $row = get_event($event_id);

    print("Event Name, " . $row['name'] . "\n");
    print("Location, " . $row['location'] . "\n\n");
    print("Signups\n");
    print("Description, Start Date, Start Time, Stop Time, Available Signups\n");
    $signups = array();

    $res = get_signups($_POST['event_id']);
    while ($row = mysqli_fetch_array($res))
    {
        explode(", ", implode(", ", $row));
        array_push($signups, array_values($row));
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
        print($row['description'] . ", " . $row['start_date'] . ", ");
        
        print($start_hour . ":" . sprintf("%02s",$row["start_min"]) . " " . $start_ampm . ", ");
        print($stop_hour . ":" . sprintf("%02s", $row["stop_min"]) . " " . $stop_ampm . ", ");
        print($row['available'] . "\n");
    }
    
    print("\nVolunteers\n");
    foreach( $signups as $signup ){
        print("Signup, " . $signup[1] . "\n");
        print("Name, Phone, Email, Email2, Nbr of Volunteers\n");

        $res = get_volunteers($signup[0]);
        while ($row = mysqli_fetch_array($res))
        {
            print( $row['first_name'] . " " . $row["last_name"] .  ", ");
            print( $row["phone"] . ", ");
            print( $row['email'] . ", ");
            print( $row['email2'] . ", ");
            print( $row['nbr_volunteers'] . "\n");
        }    
    }
    print $content;
?>