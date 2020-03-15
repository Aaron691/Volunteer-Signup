<?php session_start(); 

    include_once '/home3/rbw317/public_html/settings.php';
    include_once '/home3/rbw317/public_html/database.php';
    include_once '/home3/rbw317/public_html/utilities.php';
    
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head></head>";
    echo "<body>";
    echo "Getting next day signups\n";
    $res = get_next_day_signups();
    while ($row = mysqli_fetch_array($res))
    {
        echo "Curr row: " . implode($row) . "\n";
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
        
        $subject = 'Project 691 - Event reminder!';
        $message = "
            <html>
                <head>
                    <title> Project 691 </title>
                </head>
                <body>
                    <a href='https://team691.org/'>
                    <img src='https://team691.org/wp-content/uploads/2018/08/full_logo_691.png' alt='Project 691 Robotics' id='logo' data-height-percentage='80' />
                    </a>
                    <br /><br /><h2>A friendly reminder about your upcoming volunteer event!
                    <br /><br />Event name: " . $row["name"] . "
                    <br />Event location: " . $row["location"] . "
                    <br />Volunteer Description: " . $row["description"] . "
                    <br />Volunteer Date: " . $row["start_date"] . "
                    <br />Start Time: " . sprintf("%d:%02d %s", $start_hour, intval($row["start_min"]), $start_ampm) . "
                    <br />Stop Time: " . sprintf("%d:%02d %s", $stop_hour, intval($row["stop_min"]), $stop_ampm) . "
                    <br />Number of Volunteers: " . $row["nbr_volunteers"] . "
                    <br /><br />Thanks for your support!
                </body>
            </html>";

        echo "Sending reminder email to " . $row["email"] . "\n";
        echo $message;
        send_events_email($row["email"], $subject, $message);  
        if( strlen($row["email2"]) > 1 ){
            send_events_email($row["email2"], $subject, $message);  
        }  
        echo "</body>";
        echo "</html>";
    }
?>

                    