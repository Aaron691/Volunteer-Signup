<?php
    session_start(); 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
    $authorized = user_authorized($_SESSION['username']); 
    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=signup_export.txt");

    print("Name, Phone, Email, Email2, Nbr of Volunteers\n");

    // do your Db stuff here to get the content into $content
    $res = get_volunteers($_POST['signup_id']);
    while ($row = mysqli_fetch_array($res))
    {
        print( $row['first_name'] . " " . $row["last_name"] .  ", ");
        print( $row["phone"] . ", ");
        print( $row['email'] . ", ");
        print( $row['email2'] . ", ");
        print( $row['nbr_volunteers'] . "\n");
    }
    
    print $content;
?>
