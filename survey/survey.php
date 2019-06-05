
<?php
    // error_reporting(0);
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $member = $_POST['becomeMember'];

    $servername = 'localhost';
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
        // echo $fullname." ".$email." ".$member.".";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT email FROM survey");
            $stmt->execute();
            $array = $stmt->fetchAll(PDO::FETCH_COLUMN);
            if(in_array($email, $array)) {
                echo "Email already exists";
            } else {
                $sql = "INSERT INTO survey (fullname, email, member) VALUES ('$fullname', '$email', $member)";
                $conn->exec($sql);
                echo "New record added successfully";
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }

?>