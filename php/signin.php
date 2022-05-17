<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST["email"];
    $pass = $_POST["pass"];

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

        if($role[0] == "@marwadiuniversity.ac.in") {
            $sel = "SELECT * FROM mentee_details where email_id = '$mail' AND status = 1";
            $exe = $conn->query($sel);

            if($exe->num_rows > 0) {
                while($row = $exe->fetch_assoc()) {
                    if($row["password"] == $pass) {
                        $_SESSION["role"] = "mentee_details";
                        $_SESSION["uid"] = $row["mentee_id"];
                        $_SESSION["uname"] = $row["first_name"];
                        header('Location:./home.php');
                    }
                    else {
                        ?>
                        <script>
                            if(confirm("Invalid Email ID or Password!!") == true) {
                                window.location.href = "../signin.html";
                            } else {
                                window.location.href = "../signin.html";
                            }
                        </script>
                        <?php
                    }
                }
            }
            else {
                echo "User not Exist";
            }
        }

        else if($role[0] == "@marwadieducation.edu.in") {
            $sel = "SELECT * FROM mentor_details where email_id = '$mail' AND status = 1";
            $exe = $conn->query($sel);

            if($exe->num_rows > 0) {
                while($row = $exe->fetch_assoc()) {
                    if($row["password"] == $pass) {
                        $_SESSION["role"] = "mentor_details";
                        $_SESSION["uid"] = $row["mentor_id"];
                        $_SESSION["uname"] = $row["first_name"];
                        header('Location:./home.php');
                    }
                    else {
                        ?>
                        <script>
                            if(confirm("Invalid Email ID or Password!!") == true) {
                                window.location.href = "../signin.html";
                            } else {
                                window.location.href = "../signin.html";
                            }
                        </script>
                        <?php
                    }
                }
            }
            else {
                echo "User not Exist";
            }
        }

        else {
            $sel = "SELECT * FROM parent_details where email_id = '$mail' AND status = 1";
            $exe = $conn->query($sel);

            if($exe->num_rows > 0) {
                while($row = $exe->fetch_assoc()) {
                    if($row["password"] == $pass) {
                        $_SESSION["role"] = "parent_details";
                        $_SESSION["uid"] = $row["parent_id"];
                        $_SESSION["uname"] = $row["first_name"];
                        header('Location:./home.php');
                    }
                    else {
                        ?>
                        <script>
                            if(confirm("Invalid Email ID or Password!!") == true) {
                                window.location.href = "../signin.html";
                            } else {
                                window.location.href = "../signin.html";
                            }
                        </script>
                        <?php
                    }
                }
            }
            else {
                echo "User not Exist";
            }
        }
        
    }

    mysqli_close($conn);
} else {
    echo "<br>Request Methos is not POST";
}
?>