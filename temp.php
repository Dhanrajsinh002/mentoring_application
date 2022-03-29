<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["uname"];
    $mail = $_POST["email"];
    $phone = (int)$_POST["phone"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $pass = $_POST["cpass"];

    echo gettype($dob);

    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $db_name = "mentoring_application";

    $conn = mysqli_connect($server_name, $user_name, $password, $db_name);
    if(!$conn) {
        die("Connection Failed: ".mysqli_connect_error());
    } else {
        $sel = "SELECT first_name, mobile_no, email_id FROM mentee_details WHERE first_name = '$name' OR mobile_no = '$phone' OR email_id = '$mail'";
        $exe = $conn->query($sel);

        if($exe->num_rows > 0) {
            while($row = $exe->fetch_assoc()) {
                echo "<script type='text/javascript'>alert('User Already Exist with entered credentials!!');</script>";
                //echo "User ID: ". $row["uname"] ."<br>User Name: ". $row["uphone"] ."<br>User Email: ". $row["umail"];
            }
            //header("Location:../signup.html");
        }
        else {
            $ins = "INSERT INTO mentee_details (first_name,email_id,mobile_no,dob,gender,password,status) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass',1)";
            if($conn->query($ins) === True) {
                echo "Record Successfully added!";
                header("Location:./temp.php");
            } else {
                echo "Error: ".$ins."<br>".$conn->error;
            }
        }
    }
} else {
    echo "Method is not post.";
}
?>