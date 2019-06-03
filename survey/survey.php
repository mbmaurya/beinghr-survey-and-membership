
<?php

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $member = $_POST['becomeMember'];

    $host = 'localhost';
    $dbname = 'bhr_survey_membership';
    $username = 'root';
    $password = '';

    if(empty($fullname)) {
        echo "Please enter your fullname.";
    } else if(empty($email)) {
        echo "Please enter your email address.";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please enter a proper email address";
    } else if(empty($member)) {
        echo "Please select an option for membership";
    } else {
        echo $fullname." ".$email." ".$member.".";
        try {
            $conn = new PDO("mysql:host:$host;dbname=$dbname", $username, $password);
            echo "Connected to $dbname at $host successfully.";
            // $sql = "INSERT INTO survey(fullname, email, becomeMember)VALUES($fullname, $email, $member)";
        } catch (PDOException $pe) {
            die("Could not connect to the database $dbname :" . $pe->getMessage());
        }
    }

?>