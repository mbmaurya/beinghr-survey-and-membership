<?php 
    $to_email = 'mmaurya@picommunications.in';
    $subject = 'Testing PHP Mail';
    $message = 'This mail is sent using the PHP mail function';
    $headers = 'From: noreply@mukeshmaurya.in';
    mail($to_email,$subject,$message,$headers);
?>