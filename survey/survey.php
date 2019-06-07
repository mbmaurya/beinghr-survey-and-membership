
<?php
    // error_reporting(0);

    require_once "E:\Mukesh\wamp64\bin\php\php7.2.18\pear\Mail.php";

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
                // echo "New record added successfully";
                $to_email = $email;
                $subject = 'Thanks for participating';    
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: noreply@mukeshmaurya.in'."\r\n".
                            'Reply-To: noreply@mukeshmaurya.in'."\r\n".
                            'X_Mailer: PHP/'.phpversion();

                $message1 = '<html><body>';
                $message1 .= '<h1 style="color:#f40;">Hi ' . $fullname .'!</h1>';
                $message1 .=  '<p style="color:#000;font-size:18px;">Thank your for participating in our survey</p>';
                $message1 .=  '<p style="color:#000;font-size:18px;"><a href="#">Click here</a> to fill the membership form.</p>';
                $message1 .= '<body></html>';

                $message2 = '<html><body>';
                $message2 .= '<h1 style="color:#f40;">Hi ' . $fullname .'!</h1>';
                $message2 .=  '<p style="color:#000;font-size:18px;">Thank your for participating in our survey</p>';
                $message2 .= '<body></html>';

                if($member == 'true') {
                    mail($to_email,$subject,$message1,$headers);
                    echo '<p style="text-align: center; margin: 40px 40px 10px;">Thank you, '.$fullname.' for your time.</p>';
                    echo '<p style="text-align: center; margin: 0px 0px 10px;"><a href="../membership/index.html">Click here</a> to fill the membership form</a>.</p>';
                } else {
                    mail($to_email,$subject,$message2,$headers);
                    echo '<p style="text-align: center; margin: 40px;">Thank you, '.$fullname.' for your time.</p>';
                }

                // if(mail($to_email,$subject,$message,$headers)){
                //     echo 'Your mail has been sent successfully.';
                // } else {
                //     echo 'Unable to send email. Please try again.';
                // }
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }

?>