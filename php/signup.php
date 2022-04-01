<?php

function role($text) {
    preg_match_all("/@[\._a-zA-Z0-9-]+/i",$text,$matches);
    return $matches[0];
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["uname"];
    $phone = (int)$_POST["phone"];
    $mail = $_POST["email"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $pass = $_POST["cpass"];

    echo "Username ".$name ."<br>";
    echo "Phone ".$phone."<br>";
    echo "EMAIL ".$mail."<br>";
    echo "DOB ".$dob."<br>";
    echo "GENDER ".$gender."<br>";
    echo "PASSWORD ".$pass."<br>";

    $mrole = role($mail);
    echo "ROLE ".$mrole[0];
    echo "ROLE TYPE ".gettype($mrole[0]);
    
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

        if($exe->num_rows > 0) {
            while($row = $exe->fetch_assoc()) {
                if(($row['me.first_name'] == $name) || ($row['mo.first_name'] == $name) || ($row['pa.first_name'] == $name)
                    ($row['me.mobile_no'] == $phone) || ($row['mo.mobile_no'] == $phone) || ($row['pa.mobile_no'] == $phone)
                    ($row['me.email_id'] == $mail) || ($row['me.email_id'] == $mail) || ($row['me.email_id'] == $mail)) {
                        ?>
                        <script>
                            if(confirm("Entered Credintials already Exits!!\nTry with diffferent Credentials..") == true) {
                                window.location.href = "../signup.html";
                            } else {
                                window.location.href = "../signup.html";
                            }
                        </script>
                        <?php
                } else {
                    if($mrole[0] == "@marwadiuniversity.ac.in") {
                        $ins = "INSERT INTO mentee_details (first_name,email_id,mobile_no,dob,gender,password,in_group,status) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass',0,1)";
                        $conn->query($ins);
                        header("Location:../signin.html");
                        // insertData($name,$phone,$mail);
                    }
            
                    else if($mrole[0] == "@marwadieducation.edu.in") {
                        $ins = "INSERT INTO mentor_details (first_name,email_id,mobile_no,dob,gender,password) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass')";
                        $conn->query($ins);
                        header("Location:../signin.html");
                        // insertData($name,$phone,$mail);
                    }
            
                    else {
                        $ins = "INSERT INTO parent_details (first_name,email_id,mobile_no,dob,gender,password) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass')";
                        $conn->query($ins);
                        header("Location:../signin.html");
                        // insertData($name,$phone,$mail);
                    }
                }
            }

        } else {
        }        
    }

    mysqli_close($conn);
} else {
    echo "Method is not post.";
}
?>