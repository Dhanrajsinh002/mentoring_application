<?php

session_start();

$fmail = "";
$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "mentoring_application";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $fmail = $_POST["email"];
    echo "Mail ID is setted " . $fmail;
}
else {
    echo "Request Method is not Post!";
}

function role($text) {
    preg_match_all("/@[\._a-zA-Z0-9-]+/i",$text,$matches);
    return $matches[0];
}
$role = role($fmail);

$rndmpass = rand(100000,999999);

$conn = mysqli_connect($server_name, $user_name, $password, $db_name);
if(!$conn) {
    die("Connection Failed: ".mysqli_connect_error());
}
else {
    if($role[0] == "@marwadiuniversity.ac.in") {
        $sel = "SELECT * FROM mentee_details where email_id = '$fmail' AND status = 1";
        $exe = $conn->query($sel);

        if($exe->num_rows > 0) {
            while($row = $exe->fetch_assoc()) {
                $_SESSION['mail'] = $row['email_id'];
                $_SESSION['uname'] = $row['first_name'];
                $_SESSION['tempcode'] = $rndmpass;
            }
            header('Location:./mailsend.php');
        }
        else {
            echo "User not Exist";
        }
    }

    else if($role[0] == "@marwadieducation.edu.in") {
        $sel = "SELECT * FROM mentor_details where email_id = '$fmail' AND status = 1";
        $exe = $conn->query($sel);

        if($exe->num_rows > 0) {
            while($row = $exe->fetch_assoc()) {
                $_SESSION['mail'] = $row['email_id'];
                $_SESSION['uname'] = $row['first_name'];
                $_SESSION['tempcode'] = $rndmpass;
            }
            header('Location:./mailsend.php');
        }
        else {
            echo "User not Exist";
        }
    }

    else {
        $sel = "SELECT * FROM parent_details where email_id = '$fmail' AND status = 1";
        $exe = $conn->query($sel);

        if($exe->num_rows > 0) {
            while($row = $exe->fetch_assoc()) {
                $_SESSION['mail'] = $row['email_id'];
                $_SESSION['uname'] = $row['first_name'];
                $_SESSION['tempcode'] = $rndmpass;
            }
            header('Location:./mailsend.php');
        }
        else {
            echo "User not Exist";
        }
    }
}
?>