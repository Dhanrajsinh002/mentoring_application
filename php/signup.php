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

    $mrole = role($mail);
    
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $db_name = "mentoring_application";
    
    $conn = mysqli_connect($server_name, $user_name, $password, $db_name);
    if(!$conn) {
        die("Connection Failed: ".mysqli_connect_error());
    } else {
        $sel = "SELECT me.first_name AS mtfn, me.mobile_no AS mtmn, me.email_id AS mtei, 
                mo.first_name AS mrfn, mo.mobile_no AS mrmn, mo.email_id AS mrei, pa.first_name AS pafn, 
                pa.mobile_no AS pamn, pa.email_id AS paei FROM mentee_details me, mentor_details mo, 
                parent_details pa WHERE me.first_name = '$name' OR me.mobile_no = $phone OR me.email_id = '$mail'
                OR mo.first_name = '$name' OR mo.mobile_no = $phone OR mo.email_id = '$mail'
                OR pa.first_name = '$name' OR pa.mobile_no = $phone OR pa.email_id = '$mail'";
        $exe = $conn->query($sel);

        if($exe->num_rows > 0) {
            while($row = $exe->fetch_assoc()) {
                if(($row['mtfn'] == $name) || ($row['mrfn'] == $name) || ($row['pafn'] == $name) ||
                    ($row['mtmn'] == $phone) || ($row['mrmn'] == $phone) || ($row['pamn'] == $phone) ||
                    ($row['mtei'] == $mail) || ($row['mrei'] == $mail) || ($row['paei'] == $mail)) {
                        ?>
                        <script>
                            if(confirm("Entered Credintials already Exits!!\n
                                        Try with diffferent Credentials..") == true) {
                                window.location.href = "../signup.html";
                            } else {
                                window.location.href = "../signup.html";
                            }
                        </script>
                        <?php
                }
            }

        } else {
            if($mrole[0] == "@marwadiuniversity.ac.in") {
                $ins = "INSERT INTO mentee_details (first_name,email_id,mobile_no,dob,gender,password,in_group,status) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass',0,1)";
                $conn->query($ins);
                $sel = "SELECT mentee_id FROM mentee_details WHERE first_name = '$name'";
                if($exe = $conn->query($sel)) {
                    while($row = $exe->fetch_assoc()) {
                        $ins1 = "INSERT INTO relation (mentee_id) VALUE (".$row["mentee_id"].")";
                        $conn->query($ins1);
                    }
                }
                header("Location:../signin.html");
            }
    
            else if($mrole[0] == "@marwadieducation.edu.in") {
                $ins = "INSERT INTO mentor_details (first_name,email_id,mobile_no,dob,gender,password) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass')";
                $conn->query($ins);
                header("Location:../signin.html");
            }
    
            else if($mrole[0] == "@gmail.com") {
                $ins = "INSERT INTO parent_details (first_name,email_id,mobile_no,dob,gender,password) VALUES ('$name','$mail',$phone,'$dob','$gender','$pass')";
                $conn->query($ins);
                header("Location:../signin.html");
            }

            else {
                ?>
                <script>
                    if(confirm("Entered Email ID : - <?php echo $mail; ?> is not valid ID!!") == true) {
                        window.location.href = "./signup.html.html";
                    } else {
                        window.location.href = "./signup.html.html";
                    }
                </script>
                <?php
            }
        }        
    }

    mysqli_close($conn);
} else {
    echo "Method is not post.";
}
?>