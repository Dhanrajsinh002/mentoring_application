<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["uname"];
    $phone = (int)$_POST["phone"];
    $mail = $_POST["email"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $pass = $_POST["cpass"];

    echo $name ."<br>";
    echo $phone."<br>";
    echo $mail ."<br>";

    function role($text) {
        preg_match_all("/@[\._a-zA-Z0-9-]+/i",$text,$matches);
        return $matches[0];
    }

    $role = role($mail);
    
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $db_name = "mentoring_application";
    
    $conn = mysqli_connect($server_name, $user_name, $password, $db_name);
    if(!$conn) {
        die("Connection Failed: ".mysqli_connect_error());
    } else {
        $sel = "SELECT me.first_name, me.mobile_no, me.email_id, mo.first_name, mo.mobile_no, mo.email_id, pa.first_name, pa.mobile_no, pa.email_id
                    FROM mentee_details me, mentor_details mo, parent_details pa 
                    WHERE me.first_name = '$name' OR me.mobile_no = '$phone' OR me.email_id = '$mail' OR
                            mo.first_name = '$name' OR mo.mobile_no = '$phone' OR mo.email_id = '$mail' OR
                            pa.first_name = '$name' OR pa.mobile_no = '$phone' OR pa.email_id = '$mail'";
        $exe = $conn->query($sel);

        if($role[0] == "@marwadiuniversity.ac.in") {
            $ins = "INSERT INTO mentee_details (first_name,email_id,mobile_no,dob,gender,password) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass')";
            header("Location:../signin.html");
            // insertData($name,$phone,$mail);
        }

        else if($role[0] == "@marwadieducation.edu.in") {
            $ins = "INSERT INTO mentor_details (first_name,email_id,mobile_no,dob,gender,password) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass')";
            header("Location:../signin.html");
            // insertData($name,$phone,$mail);
        }

        else {
            $ins = "INSERT INTO parent_details (first_name,email_id,mobile_no,dob,gender,password) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass')";
            header("Location:../signin.html");
            // insertData($name,$phone,$mail);
        }

        // function insertData($name,$phone,$mail) {
        //     $sel = "SELECT me.first_name, me.mobile_no, me.email_id, mo.first_name, mo.mobile_no, mo.email_id, pa.first_name, pa.mobile_no, pa.email_id
        //             FROM mentee_details me, mentor_details mo, parent_details pa 
        //             WHERE me.first_name = '$name' OR me.mobile_no = '$phone' OR me.email_id = '$mail' OR
        //                     mo.first_name = '$name' OR mo.mobile_no = '$phone' OR mo.email_id = '$mail' OR
        //                     pa.first_name = '$name' OR pa.mobile_no = '$phone' OR pa.email_id = '$mail'";
        //     $exe = $GLOBALS['conn']->query($sel);
    
        //     if($exe->num_rows > 0) {
        //         while($row = $exe->fetch_assoc()) {
        //             echo "<script type='text/javascript'>alert('User Already Exist with entered credentials!!');</script>";
        //             //echo "User ID: ". $row["uname"] ."<br>User Name: ". $row["uphone"] ."<br>User Email: ". $row["umail"];
        //         }
        //         // header("Location:../signup.html");
        //     }
        //     else {
        //         //echo "No Results Found!";
        //         //$ins = "INSERT INTO mentee_details (first_name,email_id,mobile_no,dob,gender,) VALUES ()";
        //     }
        // }
        
    }

    mysqli_close($conn);
} else {
    echo "Method is not post.";
}
?>