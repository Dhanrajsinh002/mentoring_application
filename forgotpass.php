<?php
session_start();
?>

<?php
if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["cpass"])) {
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $db_name = "mentoring_application";
    $pass = $_POST["cpass"];

    $unm = $_SESSION['uname'];
    $mail = $_SESSION["mail"];

    function role($text) {
        preg_match_all("/@[\._a-zA-Z0-9-]+/i",$text,$matches);
        return $matches[0];
    }
    $role = role($mail);

    $conn = mysqli_connect($server_name, $user_name, $password, $db_name);
    if(!$conn) {
        die("Connection Failed: ".mysqli_connect_error());
    }
    else {
        if($role[0] == "@marwadiuniversity.ac.in") {
            $upd = "UPDATE mentee_details SET password = '$pass' WHERE first_name = '$unm'";
            echo $upd;
            $exe = $conn->query($upd);
        }
        else if($role[0] == "@marwadieducation.edu.in") {
            $upd = "UPDATE mentor_details SET password = '$pass' WHERE first_name = '$unm'";
            echo $upd;
            $exe = $conn->query($upd);
        }
        else {
            $upd = "UPDATE parent_details SET password = '$pass' WHERE first_name = '$unm'";
            echo $upd;
            $exe = $conn->query($upd);
        }
        
    }
}
if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["passcode"])) {
    if($_POST['passcode'] == $_SESSION['tempcode']) {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>Create Password!</title>
            </head>
            <body>
                <div>
                    <form action="./forgotpass.php" method="post">
                        <table>
                            <tr>
                                <td>
                                    <input type="password" name="pass" id="pass" placeholder="Password" 
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}"
                                    title="Password must contain: at least one number, at least one uppercase and lowercase letter, at least 8 or more character" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="password" name="cpass" id="cpass" placeholder="Confirm Password" required oninput="check(this)">
                                    <script>
                                        function check(inp) {
                                            if(inp.value != document.getElementById("pass").value) {
                                                inp.setCustomValidity("Password must be match!!");
                                            } else {
                                                inp.setCustomValidity("");
                                            }
                                        }
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" value="Reset" id="">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </body>
        </html>
        <?php
    } else {
        echo "NOT SAME";
    }
} else {
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Forgot Password!</title>
        </head>
        <body>
            <div>
                <form action="./php/forpass.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <input type="text" name="email" id="" placeholder="Email ID" title="" oninput="checkmail(this)" required>
                                <script>
                                    function checkmail(mail) {
                                        if(!((mail.value).match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/))) {
                                            mail.setCustomValidity("Email ID format must be match!!");
                                        } else {
                                            mail.setCustomValidity("");
                                        }
                                    }
                                </script>
                            </td>
                            <td>
                                <input type="submit" value="Reset" id="">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </body>
    </html>
    <?php
}
?>