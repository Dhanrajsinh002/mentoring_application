<?php
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $db_name = "mentoring_application";

    $conn = mysqli_connect($server_name, $user_name, $password, $db_name);
    if(isset($_GET["update"])) {
        $id = $_GET["update"];
        
        $sel = "SELECT mentee_id,first_name,email_id,mobile_no,dob,gender FROM mentee_details WHERE mentee_id = $id";
        $exe = $conn->query($sel);
        if($exe->num_rows > 0) {
            while($row = $exe->fetch_assoc()) {
                $id = $row["mentee_id"];
                $uname = $row["first_name"];
                $mail = $row["email_id"];
                $mobile = $row["mobile_no"];
                $dob = $row["dob"];
                $gen = $row["gender"];      
            }
        }
        else {
            echo "could not fetch";
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $uname = $_POST["uname"];
        $mail = $_POST["email"];
        $mobile = $_POST["phone"];
        $dob = $_POST["dob"];
        $gen = $_POST["gender"];
        $upd = "UPDATE mentee_details SET first_name='$uname', email_id = '$mail', mobile_no = '$mobile', dob = '$dob', gender = '$gen' WHERE mentee_id = $id";
        $conn->query($upd);
        echo "Updated Successfully";
    }
?>

<html>
    <head>
        <title>Update</title>
    </head>
    <body>
    <table>
            <tr>
                <td>
                    <form action="./update.php" method="POST">
                        <table >
                            <tr>
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <td colspan="2">
                                    <input type="text" name="uname" value="<?php echo $uname ?>" id="" placeholder="Username" pattern="[A-Za-z]{1,15}" title="Only lower characters are allowed." required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="email" value="<?php echo $mail ?>" id="" placeholder="Email ID" title="" oninput="checkmail(this)" required>
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
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="phone" value="<?php echo $mobile ?>" id="" placeholder="Mobile No" pattern="[0-9]{10}" title="only 10 numerical value allowed." required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Date of Birth: </label>
                                </td>
                                <td>
                                    <input type="date" name="dob" value="<?php echo $dob ?>" id="" title="select your borth date." required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Gender: </label>
                                </td>
                                <td>
                                    <input type="radio" name="gender" id="" value="male" <?php echo ($gen=='male')?'checked':'' ?> required>
                                    <label for="">Male</label>
                                    <input type="radio" name="gender" id="" value="female" <?php echo ($gen=='female')?'checked':'' ?>>
                                    <label for="">Female</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" value="Update" id="">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>