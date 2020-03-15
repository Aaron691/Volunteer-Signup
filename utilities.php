<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/settings.php';

function send_events_email( $to, $subject, $message ){
    error_log("Sending email to: " . $to . " with subject " . $subject . " and message " . $message);
    // Create email headers
    $headers = "From: " . get_sender_email() . "\r\n";
    $headers .= "Reply-To: " . get_sender_email() . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $res = mail($to, $subject, $message, $headers);    
    if( !$res ){
        error_log("There was an error sending an email.");
    }
    else{
        error_log("Sent email successfully.");
    }
}

function error_return($error_str){
    echo $error_str . "<br /><br />";
    echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
    close_database();
    exit;    
}

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>